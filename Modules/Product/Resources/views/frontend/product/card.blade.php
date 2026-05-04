@if($product->count() != 0)
@foreach ($product as $take)
    @php
        $price = $take->price;
        $sale = $take->sale_price;
        $stock = $take->stock;

        $hasDiscount = $sale && $sale > 0 && $sale < $price;
        $finalPrice = $hasDiscount ? $sale : $price;

        // stok yüzdesi (max 100 varsaydık)
        $stockPercent = min(($stock / 100) * 100, 100);
    @endphp

    <div class="col-6 col-md-3">
        <div class="product-card animate-underline hover-effect-opacity bg-body rounded">

            <div class="position-relative">

                {{-- Wishlist --}}
                <div class="position-absolute top-0 end-0 z-2 mt-3 me-3">
                    <a href="{{route('product_favories',$take->product_token)}}"
                       class="btn btn-icon btn-secondary">

                        @if(\App\Models\Favories::isSave($take->product_token))
                            <i class="ci-heart text-danger"></i>
                        @else
                            <i class="ci-heart"></i>
                        @endif

                    </a>
                </div>

                {{-- İndirim badge --}}
                @if($hasDiscount)
                    <div class="position-absolute top-0 start-0 z-2 mt-3 ms-3">
                    <span class="badge bg-danger">
                        %{{ $take->difference }}
                    </span>
                    </div>
                @endif

                {{-- Image --}}
                <a class="d-block rounded-top overflow-hidden p-3 p-sm-4"
                   href="{{ route('product_detail', $take->slug . '-' . $take->product_token) }}">

                    <div class="ratio" style="--cz-aspect-ratio: calc(240 / 258 * 100%)">
                        <img src="/upload/product/{{ $take->image }}"
                             onerror="this.src='/extra/img/photo.png'"
                             alt="{{ $take->title }}">
                    </div>
                </a>
            </div>

            <div class="w-100 min-w-0 px-2 pb-3">

                {{-- Yıldızlar (sen doldur) --}}
                <div class="d-flex align-items-center gap-2 mt-2 mb-2">
                    <div class="d-flex gap-1 fs-xs">
                        @php
                            $averageRating = Modules\Product\Http\Controllers\Frontend\MasterController::calculateAverageRating($take->id);
                        @endphp
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $averageRating)
                                <i class="ci-star-filled text-warning"></i>
                            @else
                                <i class="ci-star text-warning"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="text-body-tertiary fs-xs">({{ \App\Models\Productcoms::where('status',1)->where('product_token',$take->product_token)->count() }})</span>
                </div>

                {{-- Title --}}
                <h3 class="mb-2">
                    <a class="d-block fs-sm fw-medium text-truncate"
                       href="{{ route('product_detail', $take->slug . '-' . $take->product_token) }}">
                        {{ $take->title }}
                    </a>
                </h3>

                <div class="d-flex align-items-center justify-content-between mb-2">

                    <div class="h5 mb-0">

                        @if($hasDiscount)

                            {{-- Eski fiyat ÜSTTE --}}
                            <div class="text-muted fs-xs text-decoration-line-through">
                                {{ number_format($price, 2, ',', '.') }} ₺
                            </div>

                            {{-- Yeni fiyat --}}
                            <div class="text-danger fs-sm fw-semibold">
                                {{ number_format($sale, 2, ',', '.') }} ₺
                            </div>

                        @else
                            <span class="fw-semibold fs-sm">
                {{ number_format($price, 2, ',', '.') }} ₺
            </span>
                        @endif

                    </div>

                    {{-- Sepete ekle --}}
                    <a href="{{ route('product_detail', $take->slug . '-' . $take->product_token) }}"
                       class="product-card-button btn btn-icon btn-secondary">
                        <i class="ci-eye"></i>
                    </a>

                </div>
                {{-- Stok Progress --}}
                @php
                    if($stock > 10){
                        $stockText = "Stokta var";
                        $stockClass = "bg-success";
                    } elseif($stock > 3){
                        $stockText = "Tükeniyor";
                        $stockClass = "bg-warning";
                    } elseif($stock > 0){
                        $stockText = "Son $stock adet";
                        $stockClass = "bg-danger";
                    } else {
                        $stockText = "Stokta yok";
                        $stockClass = "bg-secondary";
                    }
                @endphp

                <div class="progress mb-1" style="height: 4px">
                    <div class="progress-bar {{ $stockClass }}"
                         style="width: {{ $stockPercent }}%">
                    </div>
                </div>

                <div class="text-body-secondary fs-xs">
                    {{ $stockText }}
                </div>

            </div>
        </div>
    </div>


<!-- End Single Product  -->
@endforeach
@else
    <div class="text-center py-5 mx-auto">

        {{-- SVG ICON --}}
        <div class="mb-3">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14.5776 14.5419C15.5805 13.53 16.2 12.1373 16.2 10.6C16.2 7.50721 13.6928 5 10.6 5C7.50721 5 5 7.50721 5 10.6C5 13.6928 7.50721 16.2 10.6 16.2C12.1555 16.2 13.5628 15.5658 14.5776 14.5419ZM14.5776 14.5419L19 19M8.5 8.5L12.5 12.5M12.5 8.5L8.5 12.5" stroke="#464455" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>

        {{-- TITLE --}}
        <h5 class="mb-2 fw-semibold">
            Ürün bulunamadı
        </h5>

        {{-- DESCRIPTION --}}
        <p class="text-body-secondary mb-3 small">
            Aramanızı daraltmayı deneyin veya farklı bir kategori seçin
        </p>

        {{-- ACTION --}}
        <button wire:click="clearAll"
                class="btn btn-outline-secondary btn-sm">
            Filtreleri temizle
        </button>

    </div>
@endif
