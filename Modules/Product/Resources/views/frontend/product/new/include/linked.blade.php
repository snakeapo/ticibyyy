<section class="container pb-5 mb-1 mb-sm-2 mb-md-3 mb-lg-4 mb-xl-5">
    <div class="bg-body-tertiary rounded-5 pt-5">
        <h2 class="h3 text-center pb-2 py-lg-3">Bu ürünle iyi gider</h2>
        <div class="row justify-content-center px-4 px-md-0">
            <div class="col-md-10">
                <div class="overflow-auto" data-simplebar data-simplebar-auto-hide="false">
                    <div class="d-flex align-items-center justify-content-between pb-4 mb-2" >
                        @foreach($relatedProduct as $takeRelatedProduct)

                            @php
                                $price = $takeRelatedProduct->getProduct->price;
                                $sale = $takeRelatedProduct->getProduct->sale_price;
                                $stock = $takeRelatedProduct->getProduct->stock;

                                $hasDiscount = $sale && $sale > 0 && $sale < $price;
                                $finalPrice = $hasDiscount ? $sale : $price;

                                // stok yüzdesi (max 100 varsaydık)
                                $stockPercent = min(($stock / 100) * 100, 100);
                            @endphp

                            <div class="col-6 col-md-3">
                                <div class="product-card animate-underline hover-effect-opacity bg-body rounded">

                                    <div class="position-relative">


                                        {{-- İndirim badge --}}
                                        @if($hasDiscount)
                                            <div class="position-absolute top-0 start-0 z-2 mt-3 ms-3">
                                                <span class="badge bg-danger">
                                                    %{{ $takeRelatedProduct->getProduct->difference }}
                                                </span>
                                            </div>
                                        @endif

                                        {{-- Image --}}
                                        <a class="d-block rounded-top overflow-hidden p-3 p-sm-4"
                                           href="{{ route('product_detail', $takeRelatedProduct->getProduct->slug . '-' . $takeRelatedProduct->getProduct->product_token) }}">

                                            <div class="ratio" style="--cz-aspect-ratio: calc(240 / 258 * 100%)">
                                                <img src="/upload/product/{{ $takeRelatedProduct->getProduct->image }}"
                                                     onerror="this.src='/extra/img/photo.png'"
                                                     alt="{{ $takeRelatedProduct->getProduct->title }}">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="w-100 min-w-0 px-2 pb-3">

                                        {{-- Yıldızlar (sen doldur) --}}
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <div class="d-flex gap-1 fs-xs">
                                                @php
                                                    $averageRating = Modules\Product\Http\Controllers\Frontend\MasterController::calculateAverageRating($takeRelatedProduct->getProduct->id);
                                                @endphp
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $averageRating)
                                                        <i class="ci-star-filled text-warning"></i>
                                                    @else
                                                        <i class="ci-star text-warning"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span class="text-body-tertiary fs-xs">({{ \App\Models\Productcoms::where('status',1)->where('product_token',$takeRelatedProduct->getProduct->product_token)->count() }})</span>
                                        </div>

                                        {{-- Title --}}
                                        <h3 class="mb-2">
                                            <a class="d-block fs-sm fw-medium text-truncate"
                                               href="{{ route('product_detail', $takeRelatedProduct->getProduct->slug . '-' . $takeRelatedProduct->getProduct->product_token) }}">
                                                {{ $takeRelatedProduct->getProduct->title }}
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
                                            <a href="{{ route('product_detail', $takeRelatedProduct->getProduct->slug . '-' . $takeRelatedProduct->getProduct->product_token) }}"
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


                            {{-- SON ELEMAN DEĞİLSE + GÖSTER --}}
                            @if(!$loop->last)
                                <div class="ci-plus fs-4 mt-n5 mx-3 mx-lg-4"></div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
