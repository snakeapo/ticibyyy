<?php

namespace Modules\Auction\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\AuctionBid;
use App\Models\AuctionItem;
use App\Models\AuctionOrder;
use App\Models\Address;
use App\Models\Cargos;
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
        $orders = AuctionOrder::with(['auction', 'item.product', 'cargo'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(20);

        return view('auction::front.orders', compact('orders'));
    }

    public function orderDetail(AuctionOrder $order)
    {
        abort_unless((int) $order->user_id === (int) Auth::id(), 403);
        $order->load(['auction', 'item.product', 'user', 'cargo']);
        return view('auction::front.order-detail', compact('order'));
    }

    public function checkout(AuctionOrder $order)
    {
        abort_unless((int) $order->user_id === (int) Auth::id(), 403);

        if ($order->isCheckoutCompleted()) {
            return redirect()->route('auction_live_order_detail', $order);
        }

        $order->load(['auction', 'item.product', 'cargo']);
        $address = Address::where('user_id', Auth::id())->get();
        $cargos = Cargos::where('status', 1)->orderBy('id')->get();
        if ($cargos->isEmpty()) {
            $cargos = Cargos::orderBy('id')->get();
        }

        return view('auction::front.checkout', compact('order', 'address', 'cargos'));
    }

    public function completeCheckout(Request $request, AuctionOrder $order)
    {
        abort_unless((int) $order->user_id === (int) Auth::id(), 403);
        $order->load('auction');

        $paymentRule = $order->auction && $order->auction->requires_balance ? 'nullable|in:balance' : 'required|in:bank_transfer,cash_on_delivery';
        $validated = $request->validate([
            'user_address' => ['nullable', 'integer', 'exists:address,id'],
            'address_title' => ['required_without:user_address', 'nullable', 'string', 'max:255'],
            'city' => ['required_without:user_address', 'nullable', 'string', 'max:255'],
            'town' => ['required_without:user_address', 'nullable', 'string', 'max:255'],
            'address' => ['required_without:user_address', 'nullable', 'string', 'max:1000'],
            'postal_code' => ['required_without:user_address', 'nullable', 'string', 'max:50'],
            'phone' => ['required_without:user_address', 'nullable', 'string', 'max:30'],
            'cargo' => ['required', 'integer', 'exists:cargos,id'],
            'payment_method' => $paymentRule,
        ]);

        $selectedAddress = null;
        if (!empty($validated['user_address'])) {
            $selectedAddress = Address::where('id', $validated['user_address'])->where('user_id', Auth::id())->firstOrFail();
        }

        if (!$selectedAddress) {
            $selectedAddress = Address::create([
                'address_title' => $validated['address_title'] ?? null,
                'city' => $validated['city'] ?? null,
                'town' => $validated['town'] ?? null,
                'address' => $validated['address'] ?? null,
                'postal_code' => $validated['postal_code'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'address_token' => date('His') * rand(999, 99999),
                'user_id' => Auth::id(),
            ]);
        }

        $cargo = Cargos::findOrFail($validated['cargo']);
        $order->update([
            'address_snapshot' => trim(($selectedAddress->city ?? '') . ' / ' . ($selectedAddress->town ?? '') . ' - ' . ($selectedAddress->address ?? '')),
            'cargo_id' => $cargo->id,
            'cargo_price' => (float) $cargo->cargo_price,
            'payment_method' => $order->auction && $order->auction->requires_balance ? 'balance' : $validated['payment_method'],
            'checkout_completed_at' => now(),
            'status' => 'processing',
        ]);

        return redirect()->route('auction_live_order_detail', $order)->with('success', 'Mezat siparişiniz tamamlandı.');
    }

    public function bid(Request $request, AuctionItem $item)
    {
        $request->validate(['amount' => 'required|numeric|min:0.01']);
        $item->loadMissing('auction');
        $requiresBalance = (bool) optional($item->auction)->requires_balance;

        if ($item->status !== 'live') {
            return back()->with('error', 'Bu ürün için mezat kapalı.');
        }

        $user = Auth::user();

        try {
            DB::transaction(function () use ($item, $user, $request, $requiresBalance) {
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

            $myActiveBids = $item->bids()
                ->where('status', 'active')
                ->where('user_id', $user->id)
                ->lockForUpdate()
                ->get();

            $refundAmount = (float) $myActiveBids->sum('amount');
            if ($requiresBalance && ((float) $user->balance + $refundAmount) < $amount) {
                throw ValidationException::withMessages(['amount' => 'Yetersiz bakiye.']);
            }

            if ($myActiveBids->isNotEmpty()) {
                if ($requiresBalance) {
                    $user->balance = (float) $user->balance + $refundAmount;
                }
                $myActiveBids->each->update(['status' => 'outbid_refunded']);
            }

            if ($highest && (int) $highest->user_id !== (int) $user->id) {
                $prevUser = $highest->user()->lockForUpdate()->first();
                if ($requiresBalance) {
                    $prevUser->balance = (float) $prevUser->balance + (float) $highest->amount;
                    $prevUser->save();
                }
                $highest->update(['status' => 'outbid_refunded']);
            }


            if ($requiresBalance) {
                $user->balance = (float) $user->balance - $amount;
                if ($user->balance < 0) {
                    throw ValidationException::withMessages(['amount' => 'Bakiye eksiye düşemez.']);
                }
                $user->save();
            }

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
        $item->loadMissing('auction');
        $requiresBalance = (bool) optional($item->auction)->requires_balance;

        DB::transaction(function () use ($item, $user, $requiresBalance) {
            $item = AuctionItem::with('auction')->lockForUpdate()->findOrFail($item->id);
            if ($item->status !== 'live') {
                abort(422, 'Bu ürün için mezat kapalı.');
            }

            $buyNowPrice = (float) $item->buy_now_price;

            $highest = $item->bids()->orderByDesc('amount')->first();
            if ($highest) {
                $prevUser = $highest->user()->lockForUpdate()->first();
                if ($requiresBalance && $highest->user_id !== $user->id) {
                    $prevUser->balance = (float) $prevUser->balance + (float) $highest->amount;
                    $prevUser->save();
                }
                $highest->update(['status' => 'outbid_refunded']);
            }

            if ($requiresBalance) {
                $alreadyHeld = $highest && (int) $highest->user_id === (int) $user->id ? (float) $highest->amount : 0.0;
                $deduct = max(0, $buyNowPrice - $alreadyHeld);
                if ((float) $user->balance < $deduct) {
                    abort(422, 'Yetersiz bakiye.');
                }
                $user->balance = (float) $user->balance - $deduct;
                if ($user->balance < 0) {
                    abort(422, 'Bakiye eksiye düşemez.');
                }
                $user->save();
            }

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

        $checkoutRedirectUrl = null;
        if (Auth::check()) {
            $checkoutOrder = AuctionOrder::where('auction_id', $auction->id)
                ->where('user_id', Auth::id())
                ->whereNull('checkout_completed_at')
                ->latest('id')
                ->first();
            $checkoutRedirectUrl = $checkoutOrder ? route('auction_live_checkout', $checkoutOrder) : null;
        }

        return response()->json([
            'auction' => $auction,
            'current' => $current,
            'bids' => $bids,
            'openingBid' => $openingBid,
            'nextMinBid' => $nextMinBid,
            'remainingSeconds' => $current ? $this->remainingSeconds($current) : null,
            'authBalance' => Auth::check() ? number_format((float) Auth::user()->balance, 2, '.', '') : null,
            'checkoutRedirectUrl' => $checkoutRedirectUrl,
        ]);
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
