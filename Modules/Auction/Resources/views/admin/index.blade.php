@extends('setting::backend.layout.default')
@section('content')
<div class="page-content" x-data="{ deleteAuctionAction: '', deleteAuctionTitle: '', openDeleteAuctionModal(action, title) { this.deleteAuctionAction = action; this.deleteAuctionTitle = title; this.$refs.deleteAuctionModal.classList.remove('d-none'); }, closeDeleteAuctionModal() { this.$refs.deleteAuctionModal.classList.add('d-none'); } }">
    <div class="container-fluid">
        <h4 class="mb-3">Canlı Mezat Yönetimi</h4>
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <a href="{{ route('auction_admin_orders') }}" class="btn btn-outline-primary">Mezat Siparişleri</a>
            <span class="text-muted small">En güncel mezatlar en üstte gösterilir.</span>
        </div>

        <form method="post" action="{{ route('auction_admin_store') }}" class="card p-3 mb-3">
            @csrf
            <div class="row g-2 align-items-end">
                <div class="col-md-8"><label>Mezat Başlığı</label><input class="form-control" name="title" required></div>
                <div class="col-md-4"><button class="btn btn-primary w-100">Mezat Oluştur</button></div>
            </div>
        </form>

        <div class="accordion" id="auctionAccordion">
            @foreach($auctions as $auction)
                <div class="accordion-item mb-3 border rounded" data-auction-card>
                    <h2 class="accordion-header" id="heading-{{ $auction->id }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $auction->id }}" aria-expanded="false" aria-controls="collapse-{{ $auction->id }}">
                            <div class="d-flex w-100 justify-content-between align-items-center me-3">
                                <h5 class="mb-0">{{ $auction->title }}</h5>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-secondary text-uppercase">{{ $auction->status }}</span>
                                    <span class="badge bg-light text-dark">{{ $auction->items->count() }} ürün</span>
                                </div>
                            </div>
                        </button>
                    </h2>
                    <div id="collapse-{{ $auction->id }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $auction->id }}" data-bs-parent="#auctionAccordion">
                        <div class="accordion-body">
                            <div class="d-flex gap-2 mb-3 flex-wrap">
                                @php
                                    $hasPendingItems = $auction->items->where('status', 'pending')->count() > 0;
                                @endphp
                                @if($auction->status === 'draft')
                                    <form method="post" action="{{ route('auction_admin_start', $auction) }}">@csrf<button class="btn btn-success">Başlat</button></form>
                                @elseif($auction->status === 'live')
                                    <form method="post" action="{{ route('auction_admin_next', $auction) }}">@csrf<button class="btn btn-warning">{{ $hasPendingItems ? 'Sonraki Ürün' : 'Bitir ve Mezatı Tamamla' }}</button></form>
                                @elseif($auction->status === 'completed')
                                    <span class="badge bg-success d-flex align-items-center px-3">Mezat Tamamlandı</span>
                                @endif
                                <a class="btn btn-info" href="{{ route('auction_live_show', $auction) }}" target="_blank">Canlı Sayfa</a>
                                <button type="button" class="btn btn-danger" @click="openDeleteAuctionModal('{{ route('auction_admin_destroy', $auction) }}', '{{ addslashes($auction->title) }}')">Mezatı Sil</button>
                            </div>

                            <form method="post" action="{{ route('auction_admin_add_item', $auction) }}" class="border rounded p-3 mt-3" enctype="multipart/form-data" data-auction-item-form>
                                @csrf
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <label>Hazır Ürün</label>
                                        <select name="product_id" class="form-control" data-product-select>
                                            <option value="">Özel ürün ekleyeceğim</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}">#{{ $product->id }} - {{ $product->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-12 rounded border p-2 bg-light" data-custom-inputs>
                                        <div class="row g-2">
                                            <div class="col-md-4"><label>Özel Başlık</label><input name="custom_title" class="form-control"></div>
                                            <div class="col-md-8"><label>Özel Açıklama</label><textarea name="custom_description" class="form-control" rows="2"></textarea></div>
                                            <div class="col-md-6"><label>Toplu Fotoğraf Yükle</label><input type="file" name="custom_images[]" class="form-control" accept="image/*" multiple></div>
                                            <div class="col-md-6"><label>Toplu Video Yükle</label><input type="file" name="custom_videos[]" class="form-control" accept="video/*" multiple></div>
                                        </div>
                                        <small class="text-muted">Hazır ürün seçiliyse bu alanlar gizlenir. Özel ürün için en az 1 fotoğraf yükleyin.</small>
                                    </div>

                                    <div class="col-md-3"><label>Açılış</label><input type="number" step="0.01" name="start_price" class="form-control" required></div>
                                    <div class="col-md-3"><label>Hemen Al</label><input type="number" step="0.01" name="buy_now_price" class="form-control" required></div>
                                    <div class="col-md-3"><label>Min Artış</label><input type="number" step="0.01" name="min_increment" class="form-control" value="100" required></div>
                                    <div class="col-md-3"><label>Teklif Geldiğinde Süre (sn)</label><input type="number" name="idle_timeout_seconds" class="form-control" value="180" required></div>
                                    <div class="col-md-3"><label>Hiç Teklif Yoksa Süre (sn)</label><input type="number" name="no_bid_timeout_seconds" class="form-control" value="120" required></div>
                                    <div class="col-md-12"><button class="btn btn-dark">Ürünü Mezata Ekle</button></div>
                                </div>
                            </form>

                            <div class="mt-3" @if($auction->status === 'live') data-auction-state-url="{{ route('auction_admin_state', $auction) }}" @endif>
                                <strong>Ürünler:</strong>
                                @if($auction->status === 'live')
                                    <div class="mb-2">Aktif ürün kalan süre: <b class="js-remaining-seconds">-</b> sn</div>
                                @endif
                                <div class="list-group">
                                    @foreach($auction->items as $item)
                                        <div class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                                                <div>
                                                    <div class="fw-semibold">#{{ $item->sort_order }} - {{ $item->custom_title ?: optional($item->product)->title }}</div>
                                                    <div class="small text-muted">Durum: {{ $item->status }}</div>
                                                </div>
                                                <div class="d-flex gap-2 align-items-center">
                                                    <span class="badge bg-primary">Açılış + min: {{ number_format($item->start_price + $item->min_increment, 2) }} TL</span>
                                                    @if($item->status === 'pending' && (int) $auction->current_item_id !== (int) $item->id)
                                                        <form method="post" action="{{ route('auction_admin_remove_item', [$auction, $item]) }}" onsubmit="return confirm('Bu ürünü mezattan silmek istiyor musunuz?')">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">Sil</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="small mt-2">
                                                Son teklif:
                                                @if($item->highestBid)
                                                    {{ $item->highestBid->user->name ?? 'Üye' }} {{ $item->highestBid->user->surname ?? '' }} - {{ number_format($item->highestBid->amount, 2) }} TL
                                                @else
                                                    -
                                                @endif
                                                | Kazanan teklif: {{ $item->winning_bid ?? '-' }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-3">
            {{ $auctions->links() }}
        </div>

        <div class="position-fixed top-0 start-0 w-100 h-100 d-none" style="z-index: 1055; background: rgba(0,0,0,.55);" x-ref="deleteAuctionModal">
            <div class="d-flex justify-content-center align-items-center h-100 p-3">
                <div class="card shadow-lg" style="max-width: 560px; width: 100%;">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-danger">Mezat Silme Uyarısı</h5>
                        <button type="button" class="btn-close" aria-label="Close" @click="closeDeleteAuctionModal()"></button>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><b x-text="deleteAuctionTitle"></b> mezatını tamamen silmek üzeresiniz.</p>
                        <p class="mb-0 text-muted">Bu işlem geri alınamaz. Mezatla ilişkili ürünler, teklifler ve sipariş kayıtları da silinecektir.</p>
                    </div>
                    <div class="card-footer d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-outline-secondary" @click="closeDeleteAuctionModal()">Vazgeç</button>
                        <form :action="deleteAuctionAction" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">Evet, Mezati Kalıcı Sil</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
document.querySelectorAll('[data-auction-state-url]').forEach((wrap) => {
    let countdown = null;
    const output = wrap.querySelector('.js-remaining-seconds');
    const setCountdown = (val) => {
        countdown = Number.isFinite(Number(val)) ? Math.max(0, parseInt(val, 10)) : null;
        if (output) output.innerText = countdown ?? '-';
    };

    setInterval(() => {
        if (countdown === null) return;
        countdown = Math.max(0, countdown - 1);
        if (output) output.innerText = countdown;
    }, 1000);

    setInterval(async () => {
        try {
            const res = await fetch(wrap.dataset.auctionStateUrl);
            const data = await res.json();
            setCountdown(data.remainingSeconds);
        } catch (e) {}
    }, 5000);
});

document.querySelectorAll('[data-auction-item-form]').forEach((form) => {
    const productSelect = form.querySelector('[data-product-select]');
    const customWrap = form.querySelector('[data-custom-inputs]');

    if (!productSelect || !customWrap) {
        return;
    }

    const syncVisibility = () => {
        const isCustomProduct = !productSelect.value;
        customWrap.classList.toggle('d-none', !isCustomProduct);
        customWrap.querySelectorAll('input, textarea').forEach((field) => {
            if (field.name === 'custom_title' || field.name === 'custom_description') {
                field.toggleAttribute('required', isCustomProduct);
            }
            if (field.name === 'custom_images[]') {
                field.toggleAttribute('required', isCustomProduct);
            }
        });
    };

    productSelect.addEventListener('change', syncVisibility);
    syncVisibility();
});
</script>
@endpush
