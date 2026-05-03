@extends('page::frontend.layout.master')
@section('content')
    <main class="main-wrapper">
        <div class="container py-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">Canlı Mezatlar</h3>
                @auth
                    <a href="{{ route('auction_live_my_orders') }}" class="axil-btn btn-bg-primary">Mezattan Kalan Siparişlerim</a>
                @endauth
            </div>
            <div class="row g-4">
                @forelse($auctions as $auction)
                    @php
                        $item = $auction->currentItem;
                        $title = $item ? ($item->custom_title ?: optional($item->product)->title) : 'Henüz ürün başlatılmadı';
                        $image = $item ? ($item->custom_image ?: optional($item->product)->image) : null;
                    @endphp
                    <div class="col-md-4">
                        <div class="card h-100">
                            @if($image)
                                <img src="/upload/product/{{ $image }}" style="height:220px;object-fit:cover" class="card-img-top" alt="{{ $title }}">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $auction->title }}</h5>
                                <p class="mb-2"><small>Durum: {{ $auction->status }}</small></p>
                                <p class="card-text">Aktif ürün: {{ $title }}</p>
                                @if($item)
                                    <p class="card-text mb-2">Açılış + min teklif: <b>{{ number_format($item->start_price + $item->min_increment, 2) }} TL</b></p>
                                @endif
                                <a href="{{ route('auction_live_show', $auction) }}" class="axil-btn btn-bg-primary">Mezata Gir</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">Şu anda listelenen mezat bulunmuyor.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
@endsection
