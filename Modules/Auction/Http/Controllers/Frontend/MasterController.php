<?php

namespace Modules\Auction\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\AuctionBid;
use App\Models\AuctionItem;
use App\Models\AuctionOrder;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MasterController extends Controller
{
    public function index()
    {
        $auctions = Auction::with(['currentItem.product'])->whereIn('status', ['live', 'draft'])->latest()->get();

        return view('auction::front.index', compact('auctions'));
    }
    public function show(Auction $auction)
    {
        $auction->load(['items.product', 'currentItem.product']);
        $current = $auction->currentItem;
        $bids = $current ? AuctionBid::with('user:id,name,surname')->where('auction_item_id', $current->id)->latest()->take(30)->get() : collect();

        return view('auction::front.live', compact('auction', 'current', 'bids'));
    }

    public function myOrders()
    {
        $orders = AuctionOrder::with(['auction', 'item.product'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(20);

        return view('auction::front.orders', compact('orders'));
    }

    public function orderDetail(AuctionOrder $order)
    {
        abort_unless((int) $order->user_id === (int) Auth::id(), 403);
        $order->load(['auction', 'item.product', 'user']);
        return view('auction::front.order-detail', compact('order'));
    }

    public function bid(Request $request, AuctionItem $item)
    {
        $request->validate(['amount' => 'required|numeric|min:0.01']);

        if ($item->status !== 'live') {
            return back()->with('error', 'Bu ürün için mezat kapalı.');
        }

        $user = Auth::user();
        if (!$this->userHasAddress($user->id)) {
            return back()->with('error', 'Mezat için teklif vermeden önce kayıtlı adres eklemelisiniz.');
        }

        try {
            DB::transaction(function () use ($item, $user, $request) {
                $item = AuctionItem::lockForUpdate()->findOrFail($item->id);
                if ($item->status !== 'live') {
                    throw ValidationException::withMessages(['amount' => 'Bu ürün için mezat kapalı.']);
                }
            $highest = $item->bids()->where('status', 'active')->orderByDesc('amount')->first();
            $min = $highest ? ((float) $highest->amount + (float) $item->min_increment) : ((float) $item->start_price + (float) $item->min_increment);
            $amount = (float) $request->amount;

            if ($amount < $min) {
                throw ValidationException::withMessages(['amount' => 'Teklifiniz geç kaldı. Güncel minimum teklif: ' . number_format($min, 2)]);
            }
            if ($amount > (float) $item->buy_now_price) {
                throw ValidationException::withMessages(['amount' => 'Teklif, hemen al fiyatını geçemez.']);
            }

            if ((float) $user->balance < $amount) {
                throw ValidationException::withMessages(['amount' => 'Yetersiz bakiye.']);
            }

            $myActiveBids = $item->bids()
                ->where('status', 'active')
                ->where('user_id', $user->id)
                ->lockForUpdate()
                ->get();

            if ($myActiveBids->isNotEmpty()) {
                $refundAmount = (float) $myActiveBids->sum('amount');
                $user->balance = (float) $user->balance + $refundAmount;
                $myActiveBids->each->update(['status' => 'outbid_refunded']);
            }

            if ($highest && (int) $highest->user_id !== (int) $user->id) {
                $prevUser = $highest->user()->lockForUpdate()->first();
                $prevUser->balance = (float) $prevUser->balance + (float) $highest->amount;
                $prevUser->save();
                $highest->update(['status' => 'outbid_refunded']);
            }


            $user->balance = (float) $user->balance - $amount;
            if ($user->balance < 0) {
                throw ValidationException::withMessages(['amount' => 'Bakiye eksiye düşemez.']);
            }
            $user->save();

            AuctionBid::create([
                'auction_item_id' => $item->id,
                'user_id' => $user->id,
                'amount' => $amount,
                'status' => $amount >= (float) $item->buy_now_price ? 'winner' : 'active',
            ]);

            if ($amount >= (float) $item->buy_now_price) {
                $item->update([
                    'status' => 'sold',
                    'winner_user_id' => $user->id,
                    'winning_bid' => $amount,
                    'last_bid_at' => now(),
                    'ended_at' => now(),
                ]);
                if ($item->auction && (int) $item->auction->current_item_id === (int) $item->id) {
                    $item->auction->update(['current_item_id' => null]);
                }
                $this->createAuctionOrder($item, $user->id, $amount, 'auto_buy_now');
                return;
            }

            $item->update(['last_bid_at' => now()]);
            });
        } catch (ValidationException $e) {
            return back()->with('error', collect($e->errors())->flatten()->first())->withInput();
        }

        return back()->with('success', 'Teklifiniz alındı.');
    }

    public function buyNow(AuctionItem $item)
    {
        if ($item->status !== 'live') {
            return back()->with('error', 'Bu ürün için mezat kapalı.');
        }

        $user = Auth::user();
        if (!$this->userHasAddress($user->id)) {
            return back()->with('error', 'Hemen al için kayıtlı adres zorunludur.');
        }

        DB::transaction(function () use ($item, $user) {
            $item = AuctionItem::with('auction')->lockForUpdate()->findOrFail($item->id);
            if ($item->status !== 'live') {
                abort(422, 'Bu ürün için mezat kapalı.');
            }

            $buyNowPrice = (float) $item->buy_now_price;
            if ((float) $user->balance < $buyNowPrice) {
                abort(422, 'Yetersiz bakiye.');
            }

            $highest = $item->bids()->orderByDesc('amount')->first();
            if ($highest) {
                $prevUser = $highest->user()->lockForUpdate()->first();
                if ($highest->user_id !== $user->id) {
                    $prevUser->balance = (float) $prevUser->balance + (float) $highest->amount;
                    $prevUser->save();
                }
                $highest->update(['status' => 'outbid_refunded']);
            }

            $alreadyHeld = $highest && (int) $highest->user_id === (int) $user->id ? (float) $highest->amount : 0.0;
            $deduct = max(0, $buyNowPrice - $alreadyHeld);
            $user->balance = (float) $user->balance - $deduct;
            if ($user->balance < 0) {
                abort(422, 'Bakiye eksiye düşemez.');
            }
            $user->save();

            AuctionBid::create([
                'auction_item_id' => $item->id,
                'user_id' => $user->id,
                'amount' => $buyNowPrice,
                'status' => 'winner',
            ]);

            $item->update([
                'status' => 'sold',
                'winner_user_id' => $user->id,
                'winning_bid' => $buyNowPrice,
                'last_bid_at' => now(),
                'ended_at' => now(),
            ]);

            if ($item->auction && (int) $item->auction->current_item_id === (int) $item->id) {
                $item->auction->update(['current_item_id' => null]);
            }

            $this->createAuctionOrder($item, $user->id, $buyNowPrice, 'buy_now');
        });

        return back()->with('success', 'Ürün hemen al ile satın alındı.');
    }

    public function state(Auction $auction)
    {
        $auction->load(['items.product', 'currentItem.product']);
        $current = $auction->currentItem;
        if ($current && $current->status === 'live') {
            $this->maybeTimeout($current, $auction);
            $auction->refresh();
            $auction->load(['items.product', 'currentItem.product']);
            $current = $auction->currentItem;
        }
        $bids = $current ? AuctionBid::with('user:id,name,surname')->where('auction_item_id', $current->id)->latest()->take(30)->get() : [];
        $highest = $current ? $current->bids()->orderByDesc('amount')->first() : null;
        $openingBid = $current ? ((float) $current->start_price + (float) $current->min_increment) : null;
        $nextMinBid = $current ? ($highest ? ((float) $highest->amount + (float) $current->min_increment) : $openingBid) : null;

        return response()->json([
            'auction' => $auction,
            'current' => $current,
            'bids' => $bids,
            'openingBid' => $openingBid,
            'nextMinBid' => $nextMinBid,
            'remainingSeconds' => $current ? $this->remainingSeconds($current) : null,
            'authBalance' => Auth::check() ? number_format((float) Auth::user()->balance, 2, '.', '') : null,
        ]);
    }

    private function userHasAddress(int $userId): bool
    {
        return Address::where('user_id', $userId)->exists();
    }

    private function createAuctionOrder(AuctionItem $item, int $userId, float $amount, string $winType): void
    {
        if (AuctionOrder::where('auction_item_id', $item->id)->exists()) {
            return;
        }

        $address = Address::where('user_id', $userId)->latest('id')->first();
        if (!$address) {
            abort(422, 'Sipariş için kayıtlı adres bulunamadı.');
        }

        AuctionOrder::create([
            'auction_id' => $item->auction_id,
            'auction_item_id' => $item->id,
            'user_id' => $userId,
            'product_id' => $item->product_id,
            'order_no' => 'MZT-' . now()->format('YmdHis') . '-' . $item->id,
            'final_price' => $amount,
            'address_snapshot' => trim(($address->city ?? '') . ' / ' . ($address->town ?? '') . ' - ' . ($address->address ?? '')),
            'win_type' => $winType,
            'status' => 'pending',
        ]);
    }

    private function maybeTimeout(AuctionItem $item, Auction $auction): void
    {
        $refTime = $item->last_bid_at ?: $item->started_at;
        if (!$refTime) {
            return;
        }

        $timeout = $item->last_bid_at ? (int) $item->idle_timeout_seconds : (int) ($item->no_bid_timeout_seconds ?: $item->idle_timeout_seconds);
        if (now()->diffInSeconds($refTime) >= $timeout) {
            $this->finishItem($item);
            $this->advanceToNextPending($auction, $item);
        }
    }

    private function finishItem(AuctionItem $item): void
    {
        DB::transaction(function () use ($item) {
            $highest = $item->bids()->orderByDesc('amount')->first();
            if (!$highest) {
                $item->update(['status' => 'unsold', 'ended_at' => now()]);
                return;
            }

            if (!$this->userHasAddress((int) $highest->user_id)) {
                abort(422, 'Kazanan kullanıcının kayıtlı adresi bulunmuyor.');
            }

            $highest->update(['status' => 'winner']);
            $item->update([
                'status' => 'sold',
                'winner_user_id' => $highest->user_id,
                'winning_bid' => $highest->amount,
                'ended_at' => now(),
            ]);
            $this->createAuctionOrder($item, (int) $highest->user_id, (float) $highest->amount, 'bid');
        });
    }

    private function remainingSeconds(AuctionItem $item): int
    {
        $refTime = $item->last_bid_at ?: $item->started_at;
        if (!$refTime) {
            return 0;
        }

        $timeout = $item->last_bid_at ? (int) $item->idle_timeout_seconds : (int) ($item->no_bid_timeout_seconds ?: $item->idle_timeout_seconds);
        return max(0, $timeout - now()->diffInSeconds($refTime));
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
}
