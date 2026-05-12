@extends('page::frontend.layout.master')
@section('content')
<main class="main-wrapper">
<div class="container py-5" id="auctionApp" data-state-url="{{ route('auction_live_state', $auction) }}" data-current-item-id="{{ optional($current)->id }}" data-auction-status="{{ $auction->status }}">
    <h3>{{ $auction->title }}</h3>
    @php
        $auctionPaymentText = $cashOnDeliveryEnabled
            ? 'Bu mezatta teklif için bakiye şartı yoktur. Kazanınca Havale/EFT veya Kapıda Ödeme ile siparişi tamamlayabilirsiniz.'
            : 'Bu mezatta teklif için bakiye şartı yoktur. Kazanınca Havale/EFT ile siparişi tamamlayabilirsiniz.';
    @endphp
    <div class="alert {{ $auction->requires_balance ? 'alert-success' : 'alert-warning' }} py-2">
        {{ $auction->requires_balance ? 'Bu mezatta teklifler bakiye üzerinden alınır. Kazanınca adres ve kargo bilgisiyle siparişi tamamlamanız gerekir.' : $auctionPaymentText }}
    </div>
    @php
        $isBidOpen = $current && $current->status === 'live';
    @endphp
    @if($current)
        @php
            $displayTitle = $current->custom_title ?: optional($current->product)->title;
            $customImages = collect($current->custom_images ?? [])->filter()->values();
            $customVideos = collect($current->custom_videos ?? [])->filter()->values();
            $displayImage = $current->custom_image ?: $customImages->first() ?: optional($current->product)->image;
            $imagePath = $displayImage ? '/upload/product/' . ltrim($displayImage, '/') : 'https://placehold.co/1200x800?text=Urun+Gorseli+Yok';
        @endphp
        <div class="row">
            <div class="col-md-7">
                <img src="{{ $imagePath }}" alt="{{ $displayTitle ?: 'Ürün görseli' }}" style="width:100%;max-height:500px;object-fit:cover" loading="lazy">
                @if($customImages->count())
                    <div class="mt-3">
                        <h6>Fotoğraflar ({{ $customImages->count() }})</h6>
                        <div class="d-flex gap-2 flex-wrap">
                            @foreach($customImages as $image)
                                <img src="{{ '/upload/product/' . ltrim($image, '/') }}" alt="Ürün fotoğrafı" style="width:120px;height:120px;object-fit:cover;border:1px solid #ddd">
                            @endforeach
                        </div>
                    </div>
                @endif
                @if($customVideos->count())
                    <div class="mt-3">
                        <h6>Videolar ({{ $customVideos->count() }})</h6>
                        <div class="d-flex gap-2 flex-wrap">
                            @foreach($customVideos as $video)
                                <video controls preload="metadata" style="width:220px;max-height:180px;border:1px solid #ddd">
                                    <source src="{{ '/upload/product/' . ltrim($video, '/') }}">
                                    Tarayıcınız video etiketini desteklemiyor.
                                </video>
                            @endforeach
                        </div>
                    </div>
                @endif
                <h4 class="mt-2" id="itemTitle">{{ $displayTitle }}</h4>
                <p id="itemDescription">{{ $current->custom_description ?: optional($current->product)->description }}</p>
                <p><b>Min artış:</b> <span id="minIncrement">{{ number_format($current->min_increment,2) }}</span> TL</p>
                <p><b>Açılış + min teklif:</b> <span id="openingBid">{{ number_format($current->start_price + $current->min_increment,2) }}</span> TL</p>
                <p><b>Son teklife göre min:</b> <span id="nextMinBid">{{ number_format(($bids->first()->amount ?? $current->start_price) + $current->min_increment,2) }}</span> TL</p>
                <p><b>Hemen al:</b> <span id="buyNowPrice">{{ number_format($current->buy_now_price,2) }}</span> TL</p>
                <p><b>Kalan süre:</b> <span id="remainingSeconds">-</span> sn</p>
            </div>
            <div class="col-md-5">
                @auth
                    @if($auction->requires_balance)
                        <p>Bakiye: <b id="authBalance">{{ number_format(Auth::user()->balance,2) }}</b> TL</p>
                    @else
                        <p class="text-muted">Bakiyesiz mezat: teklif verirken bakiyenizden düşüm yapılmaz.</p>
                    @endif
                    @if($isBidOpen)
                        <form id="bidForm" action="{{ route('auction_live_bid', $current) }}" method="post" class="d-flex gap-2 mb-3">
                            @csrf
                            <input id="bidAmountInput" class="form-control" type="number" step="0.01" name="amount" max="{{ number_format($current->buy_now_price,2,'.','') }}" min="{{ number_format(($bids->first()->amount ?? $current->start_price) + $current->min_increment,2,'.','') }}" placeholder="Teklif tutarı" required>
                            <button id="bidSubmitButton" class="axil-btn btn-bg-primary" type="submit" data-default-text="Teklif Ver" data-loading-text="Teklif gönderiliyor...">Teklif Ver</button>
                        </form>
                        <div id="bidFeedback" class="alert d-none py-2 mb-3" role="alert"></div>
                        <form action="{{ route('auction_live_buy_now', $current) }}" method="post" class="mb-3">
                            @csrf
                            <button class="axil-btn btn-bg-secondary w-100">Hemen Al ({{ number_format($current->buy_now_price,2) }} TL)</button>
                        </form>
                        <small class="text-muted d-block mb-2">Teklif, hemen al fiyatını geçemez. Hemen al fiyatına ulaşıldığında ürün otomatik kazanılır.</small>
                    @else
                        <div class="alert alert-info">Mezat henüz başlamadı. Ürün bilgileri görüntülenebilir, teklif verme mezat başlayınca açılır.</div>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="axil-btn btn-bg-secondary">Teklif için giriş yap</a>
                @endauth

                <h5>Anlık Teklifler</h5>
                <div id="bids" style="max-height:420px;overflow:auto">
                    @forelse($bids as $bid)
                        <div class="border p-2 mb-2">{{ $bid->user->name }} {{ $bid->user->surname }} - <b>{{ number_format($bid->amount,2) }} TL</b></div>
                    @empty
                        <div class="text-muted" id="bidsEmptyState">Henüz teklif verilmedi.</div>
                    @endforelse
                </div>
            </div>
        </div>
        <hr>
        <h5>Ürün Akışı</h5>
        <div class="d-flex gap-3">
            @foreach($auction->items as $item)
                <div class="border p-2">{{ $item->custom_title ?: optional($item->product)->title }} ({{ $item->status }})</div>
            @endforeach
        </div>
    @else
        <p class="text-muted">Şu an canlı ürün yok. Mezat ürün akışını aşağıdan inceleyebilirsiniz.</p>
        <hr>
        <h5>Ürün Akışı</h5>
        <div class="d-flex gap-3 flex-wrap">
            @foreach($auction->items as $item)
                <div class="border p-2">{{ $item->custom_title ?: optional($item->product)->title }} ({{ $item->status }})</div>
            @endforeach
        </div>
    @endif
</div>
</main>
<script>
const root = document.getElementById('auctionApp');
if (root) {
    const POLL_INTERVAL_MS = 5000;
    let countdown = null;
    let isPolling = false;

    const formatMoney = (value) => {
        const numeric = Number(value);
        return Number.isFinite(numeric) ? numeric.toFixed(2) : '0.00';
    };

    const renderBids = (list) => {
        const bidsContainer = document.getElementById('bids');
        if (!bidsContainer) {
            return;
        }

        bidsContainer.innerHTML = '';

        if (!Array.isArray(list) || list.length === 0) {
            const empty = document.createElement('div');
            empty.className = 'text-muted';
            empty.id = 'bidsEmptyState';
            empty.textContent = 'Henüz teklif verilmedi.';
            bidsContainer.appendChild(empty);
            return;
        }

        const fragment = document.createDocumentFragment();
        list.forEach((bid) => {
            const row = document.createElement('div');
            row.className = 'border p-2 mb-2';

            const userName = `${bid?.user?.name ?? ''} ${bid?.user?.surname ?? ''}`.trim();
            const amount = formatMoney(bid?.amount);

            row.textContent = `${userName || 'Bilinmeyen kullanıcı'} - ${amount} TL`;
            fragment.appendChild(row);
        });

        bidsContainer.appendChild(fragment);
    };

    const setCountdown = (val) => {
        const parsed = Number.parseInt(val, 10);
        countdown = Number.isFinite(parsed) ? Math.max(0, parsed) : null;
        const node = document.getElementById('remainingSeconds');
        if (node) node.textContent = countdown ?? '-';
    };

    const setText = (id, value) => {
        const node = document.getElementById(id);
        if (node && typeof value !== 'undefined' && value !== null) {
            node.textContent = value;
        }
    };

    const setBidFeedback = (message, type = 'success') => {
        const feedback = document.getElementById('bidFeedback');
        if (!feedback) {
            return;
        }

        feedback.className = `alert alert-${type} py-2 mb-3`;
        feedback.textContent = message;
    };

    const setBidSubmitting = (isSubmitting) => {
        const button = document.getElementById('bidSubmitButton');
        const input = document.getElementById('bidAmountInput');
        if (button) {
            button.disabled = isSubmitting;
            button.textContent = isSubmitting ? (button.dataset.loadingText || 'Gönderiliyor...') : (button.dataset.defaultText || 'Teklif Ver');
        }
        if (input) {
            input.readOnly = isSubmitting;
        }
    };

    const applyAuctionState = (data, { allowReload = true } = {}) => {
        if (!data) {
            return;
        }

        if (data.checkoutRedirectUrl) {
            window.location.href = data.checkoutRedirectUrl;
            return;
        }

        const latestCurrentId = data?.current?.id ? String(data.current.id) : '';
        const latestAuctionStatus = data?.auction?.status ? String(data.auction.status) : '';
        if (allowReload && (latestCurrentId !== (root.dataset.currentItemId || '') || latestAuctionStatus !== (root.dataset.auctionStatus || ''))) {
            window.location.reload();
            return;
        }

        renderBids(data?.bids);

        const authBalanceNode = document.getElementById('authBalance');
        if (authBalanceNode && data?.authBalance !== null && typeof data?.authBalance !== 'undefined') {
            authBalanceNode.textContent = formatMoney(data.authBalance);
        }

        if (typeof data?.remainingSeconds !== 'undefined') {
            setCountdown(data.remainingSeconds);
        }

        setText('itemTitle', data?.current?.display_title);
        setText('itemDescription', data?.current?.display_description);

        const minIncrementNode = document.getElementById('minIncrement');
        if (minIncrementNode && typeof data?.current?.min_increment !== 'undefined') {
            minIncrementNode.textContent = formatMoney(data.current.min_increment);
        }

        const openingBidNode = document.getElementById('openingBid');
        if (openingBidNode && typeof data?.openingBid !== 'undefined') {
            openingBidNode.textContent = formatMoney(data.openingBid);
        }

        const nextMinBidNode = document.getElementById('nextMinBid');
        if (nextMinBidNode && typeof data?.nextMinBid !== 'undefined') {
            nextMinBidNode.textContent = formatMoney(data.nextMinBid);
        }

        const bidAmountInput = document.getElementById('bidAmountInput');
        if (bidAmountInput && typeof data?.nextMinBid !== 'undefined') {
            bidAmountInput.setAttribute('min', formatMoney(data.nextMinBid));
        }

        const buyNowPriceNode = document.getElementById('buyNowPrice');
        if (buyNowPriceNode && typeof data?.current?.buy_now_price !== 'undefined') {
            const buyNowPriceFormatted = formatMoney(data.current.buy_now_price);
            buyNowPriceNode.textContent = buyNowPriceFormatted;
            if (bidAmountInput) {
                bidAmountInput.setAttribute('max', buyNowPriceFormatted);
            }
        }
    };

    setInterval(() => {
        if (countdown === null) return;
        countdown = Math.max(0, countdown - 1);
        const node = document.getElementById('remainingSeconds');
        if (node) node.textContent = countdown;
    }, 1000);

    setInterval(async () => {
        if (isPolling) {
            return;
        }

        isPolling = true;
        try {
            const res = await fetch(root.dataset.stateUrl, {
                headers: {
                    'Accept': 'application/json'
                }
            });

            if (!res.ok) {
                throw new Error(`state endpoint failed: ${res.status}`);
            }

            applyAuctionState(await res.json());
        } catch (e) {
            console.warn('Auction state polling failed', e);
        } finally {
            isPolling = false;
        }
    }, POLL_INTERVAL_MS);

    const bidForm = document.getElementById('bidForm');
    if (bidForm) {
        bidForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            const button = document.getElementById('bidSubmitButton');
            if (button?.disabled) {
                return;
            }

            setBidSubmitting(true);
            try {
                const res = await fetch(bidForm.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: new FormData(bidForm)
                });
                const data = await res.json().catch(() => ({}));

                if (!res.ok || data?.ok === false) {
                    applyAuctionState(data?.state, { allowReload: false });
                    setBidFeedback(data?.message || 'Teklif gönderilemedi. Lütfen tekrar deneyin.', 'danger');
                    return;
                }

                applyAuctionState(data?.state, { allowReload: false });
                setBidFeedback(data?.message || 'Teklifiniz alındı.', 'success');
            } catch (e) {
                console.warn('Auction bid failed', e);
                setBidFeedback('Bağlantı hatası. Lütfen tekrar deneyin.', 'danger');
            } finally {
                setBidSubmitting(false);
            }
        });
    }

}
</script>
@endsection
