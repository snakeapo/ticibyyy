<?php

namespace Modules\Auction\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\AuctionBid;
use App\Models\AuctionItem;
use App\Models\AuctionOrder;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SystemController extends Controller
{
    public function index()
    {
        $auctions = Auction::with(['items.product', 'items.highestBid.user', 'currentItem'])->latest()->paginate(10);
        $products = Products::where('status', 1)->latest()->take(200)->get();

        return view('auction::admin.index', compact('auctions', 'products'));
    }

    public function orders()
    {
        $orders = AuctionOrder::with(['auction', 'item.product', 'user', 'cargo'])
            ->latest()
            ->paginate(50);

        return view('auction::admin.orders', compact('orders'));
    }

    public function showOrder(AuctionOrder $order)
    {
        $order->load(['auction', 'item.product', 'user', 'cargo']);
        return view('auction::admin.order-detail', compact('order'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'requires_balance' => 'required|boolean',
        ]);

        Auction::create([
            'title' => $validated['title'],
            'requires_balance' => (bool) $validated['requires_balance'],
            'created_by' => Auth::id(),
        ]);
        return back()->with('success', 'Mezat oluşturuldu.');
    }

    public function destroy(Auction $auction)
    {
        DB::transaction(function () use ($auction) {
            $itemIds = $auction->items()->pluck('id');

            AuctionBid::whereIn('auction_item_id', $itemIds)->delete();
            AuctionOrder::where('auction_id', $auction->id)->orWhereIn('auction_item_id', $itemIds)->delete();
            AuctionItem::where('auction_id', $auction->id)->delete();
            $auction->delete();
        });

        return back()->with('success', 'Mezat ve bağlı kayıtları silindi.');
    }

    public function addItem(Request $request, Auction $auction)
    {
        $isCustomProduct = !$request->filled('product_id');
        $request->validate([
            'product_id' => 'nullable|exists:products,id',
            'custom_title' => $isCustomProduct ? 'required|string|max:255' : 'nullable|string|max:255',
            'custom_description' => $isCustomProduct ? 'required|string' : 'nullable|string',
            'custom_images' => $isCustomProduct ? 'required|array|min:1' : 'nullable|array',
            'custom_images.*' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
            'custom_videos' => $isCustomProduct ? 'nullable|array' : 'nullable|array',
            'custom_videos.*' => 'nullable|file|mimes:mp4,mov,avi,webm,mkv|max:51200',
            'buy_now_price' => 'required|numeric|min:1',
            'start_price' => 'required|numeric|min:1',
            'min_increment' => 'required|numeric|min:1',
            'idle_timeout_seconds' => 'required|integer|min:30',
            'no_bid_timeout_seconds' => 'required|integer|min:30',
        ]);

        $customImages = [];
        $customVideos = [];
        if ($isCustomProduct) {
            $uploadPath = public_path('upload/product/auction');
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            foreach (Arr::wrap($request->file('custom_images')) as $imageFile) {
                if (!$imageFile) {
                    continue;
                }

                $filename = uniqid('auction_img_', true) . '.' . $imageFile->getClientOriginalExtension();
                $imageFile->move($uploadPath, $filename);
                $customImages[] = 'auction/' . $filename;
            }

            foreach (Arr::wrap($request->file('custom_videos')) as $videoFile) {
                if (!$videoFile) {
                    continue;
                }

                $filename = uniqid('auction_vid_', true) . '.' . $videoFile->getClientOriginalExtension();
                $videoFile->move($uploadPath, $filename);
                $customVideos[] = 'auction/' . $filename;
            }
        }

        $auction->items()->create([
            'product_id' => $request->product_id,
            'custom_title' => $isCustomProduct ? $request->custom_title : null,
            'custom_description' => $isCustomProduct ? $request->custom_description : null,
            'custom_image' => $customImages[0] ?? null,
            'custom_images' => $customImages ?: null,
            'custom_videos' => $customVideos ?: null,
            'buy_now_price' => $request->buy_now_price,
            'start_price' => $request->start_price,
            'min_increment' => $request->min_increment,
            'idle_timeout_seconds' => $request->idle_timeout_seconds,
            'no_bid_timeout_seconds' => $request->no_bid_timeout_seconds,
            'sort_order' => ((int) $auction->items()->max('sort_order')) + 1,
        ]);

        return back()->with('success', 'Mezat ürünü eklendi.');
    }

    public function start(Auction $auction)
    {
        $firstPending = $auction->items()->where('status', 'pending')->orderBy('sort_order')->first();
        if (!$firstPending) {
            return back()->with('error', 'Başlatılacak ürün yok.');
        }

        $auction->update(['status' => 'live', 'current_item_id' => $firstPending->id]);
        $firstPending->update(['status' => 'live', 'started_at' => now()]);

        return back()->with('success', 'Mezat başlatıldı.');
    }

    public function removeItem(Auction $auction, AuctionItem $item)
    {
        if ((int) $item->auction_id !== (int) $auction->id) {
            abort(404);
        }

        $isCurrentItem = (int) $auction->current_item_id === (int) $item->id;
        if ($isCurrentItem || $item->status !== 'pending') {
            return back()->with('error', 'Sadece sırada olmayan ve henüz başlamamış ürünler silinebilir.');
        }

        $item->delete();

        return back()->with('success', 'Mezat ürünü silindi.');
    }

    public function next(Auction $auction)
    {
        $current = $auction->currentItem;
        if ($current && $current->status === 'live') {
            $this->finishItem($current);
        }

        $next = $auction->items()->where('status', 'pending')->orderBy('sort_order')->first();
        if (!$next) {
            $auction->update(['status' => 'completed', 'current_item_id' => null]);
            return back()->with('success', 'Mezat tamamlandı.');
        }

        $next->update(['status' => 'live', 'started_at' => now()]);
        $auction->update(['current_item_id' => $next->id, 'status' => 'live']);

        return back()->with('success', 'Sonraki ürüne geçildi.');
    }

    public function state(Auction $auction)
    {
        $item = $auction->currentItem;
        if ($item && $item->status === 'live') {
            $this->maybeTimeout($item, $auction);
            $item->refresh();
        }

        return response()->json([
            'auction' => $auction->fresh(['currentItem', 'items']),
            'currentBids' => $item ? AuctionBid::with('user:id,name,surname')->where('auction_item_id', $item->id)->latest()->take(20)->get() : [],
            'remainingSeconds' => $item ? $this->remainingSeconds($item) : null,
        ]);
    }

    private function maybeTimeout(AuctionItem $item, Auction $auction): void
    {
        $refTime = $item->last_bid_at ?: $item->started_at;
        if (!$refTime) return;

        $timeout = $item->last_bid_at ? (int) $item->idle_timeout_seconds : (int) ($item->no_bid_timeout_seconds ?: $item->idle_timeout_seconds);
        if (now()->diffInSeconds($refTime) >= $timeout) {
            $this->finishItem($item);
            $this->advanceToNextPending($auction, $item);
        }
    }

    private function remainingSeconds(AuctionItem $item): int
    {
        $refTime = $item->last_bid_at ?: $item->started_at;
        if (!$refTime) {
            return 0;
        }

        $timeout = $item->last_bid_at ? (int) $item->idle_timeout_seconds : (int) ($item->no_bid_timeout_seconds ?: $item->idle_timeout_seconds);
        $elapsed = now()->diffInSeconds($refTime);
        return max(0, $timeout - $elapsed);
    }

    private function finishItem(AuctionItem $item): void
    {
        DB::transaction(function () use ($item) {
            $highest = $item->bids()->orderByDesc('amount')->first();
            if ($highest) {
                $highest->update(['status' => 'winner']);
                $item->update([
                    'status' => 'sold',
                    'winner_user_id' => $highest->user_id,
                    'winning_bid' => $highest->amount,
                    'ended_at' => now(),
                ]);
                $this->createAuctionOrder($item, (int) $highest->user_id, (float) $highest->amount, 'bid');
            } else {
                $item->update(['status' => 'unsold', 'ended_at' => now()]);
            }
        });
    }

    private function advanceToNextPending(Auction $auction, AuctionItem $finishedItem): void
    {
        if ((int) $auction->current_item_id !== (int) $finishedItem->id) {
            return;
        }

        $next = $auction->items()->where('status', 'pending')->orderBy('sort_order')->first();
        if (!$next) {
            $auction->update(['status' => 'completed', 'current_item_id' => null]);
            return;
        }

        $next->update(['status' => 'live', 'started_at' => now()]);
        $auction->update(['current_item_id' => $next->id, 'status' => 'live']);
    }

    private function createAuctionOrder(AuctionItem $item, int $userId, float $amount, string $winType): void
    {
        if (AuctionOrder::where('auction_item_id', $item->id)->exists()) {
            return;
        }

        AuctionOrder::create([
            'auction_id' => $item->auction_id,
            'auction_item_id' => $item->id,
            'user_id' => $userId,
            'product_id' => $item->product_id,
            'order_no' => 'MZT-' . now()->format('YmdHis') . '-' . $item->id,
            'final_price' => $amount,
            'address_snapshot' => '',
            'win_type' => $winType,
            'status' => 'pending',
        ]);
    }
}
