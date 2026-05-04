<!-- Breadcrumb -->
<nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="home-electronics.html">Anasayfa</a></li>
        <li class="breadcrumb-item"><a href="shop-catalog-electronics.html">Ürünler</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $data->title }}</li>
    </ol>
</nav>


<!-- Page title -->
<h1 class="h3 container mb-4">{{ $data->title }}</h1>


<!-- Nav links + Reviews -->
<section class="container pb-2 pb-lg-4">
    <div class="d-flex align-items-center border-bottom">
        <ul class="nav nav-underline flex-nowrap gap-4">
            <li class="nav-item me-sm-2">
                <a class="nav-link pe-none active" href="#!">Ürün hakkında</a>
            </li>
            <li class="nav-item me-sm-2">
                <a class="nav-link" href="shop-product-details-electronics.html">Soru & cevap ({{ \App\Models\Askques::where('status',1)->where('product_token',$data->product_token)->count() }})</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="shop-product-reviews-electronics.html">Yorumlar ({{ \App\Models\Productcoms::where('status',1)->where('product_token',$data->product_token)->count() }})</a>
            </li>
        </ul>
        <a class="d-none d-md-flex align-items-center gap-2 text-decoration-none ms-auto mb-1" href="#reviews">
            <div class="d-flex gap-1 fs-sm">
                @php
                    $averageRating = Modules\Product\Http\Controllers\Frontend\MasterController::calculateAverageRating($data->id);
                @endphp
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= $averageRating)
                        <i class="ci-star-filled text-warning"></i>
                    @else
                        <i class="ci-star text-warning"></i>
                    @endif
                @endfor

            </div>
            <span class="text-body-tertiary fs-xs">{{ \App\Models\Productcoms::where('status',1)->where('product_token',$data->product_token)->count() }} yorum</span>
        </a>
    </div>
</section>


<!-- Gallery + Product options -->
<section class="container pb-5 mb-1 mb-sm-2 mb-md-3 mb-lg-4 mb-xl-5">
    <div class="row">

        <!-- Product gallery -->
        <div class="col-md-6">

            <!-- Preview (Large image) -->
            <div class="swiper" data-swiper='{
      "loop": true,
      "navigation": {
        "prevEl": ".btn-prev",
        "nextEl": ".btn-next"
      },
      "thumbs": {
        "swiper": "#thumbs"
      }
    }'>
                <div class="swiper-wrapper">

                    {{-- GENEL GÖRSELLER --}}
                    @foreach ($galleryImages as $image)
                        <div class="swiper-slide"
                             data-image-source="general">
                            <div class="ratio ratio-1x1">
                                <img src="/upload/product/{{ $image }}"
                                     data-zoom="/upload/product/{{ $image }}"
                                     onerror="this.src='/extra/img/photo.png'"
                                     alt="{{ $data->title }}">
                            </div>
                        </div>
                    @endforeach

                    {{-- VARYANT GÖRSELLER --}}
                    @foreach ($variantGalleryItems as $variant)
                        <div class="swiper-slide"
                             data-image-source="variant"
                             data-variant-id="{{ $variant->id }}"
                             data-variant-type="{{ $variant->variant_type ?: 'Genel' }}">
                            <div class="ratio ratio-1x1">
                                <img src="/upload/product/{{ $variant->variant_image }}"
                                     data-zoom="/upload/product/{{ $variant->variant_image }}"
                                     onerror="this.src='/extra/img/photo.png'"
                                     alt="{{ $variant->variant_name ?: $data->title }}">
                            </div>
                        </div>
                    @endforeach

                </div>

                <!-- Prev -->
                <div class="position-absolute top-50 start-0 z-2 translate-middle-y ms-3">
                    <button type="button" class="btn btn-prev btn-icon btn-outline-secondary bg-body rounded-circle">
                        <i class="ci-chevron-left"></i>
                    </button>
                </div>

                <!-- Next -->
                <div class="position-absolute top-50 end-0 z-2 translate-middle-y me-3">
                    <button type="button" class="btn btn-next btn-icon btn-outline-secondary bg-body rounded-circle">
                        <i class="ci-chevron-right"></i>
                    </button>
                </div>
            </div>

            <!-- Thumbnails -->
            <div class="swiper swiper-thumbs pt-2 mt-1" id="thumbs" data-swiper='{
      "loop": true,
      "spaceBetween": 12,
      "slidesPerView": 4,
      "watchSlidesProgress": true,
      "breakpoints": {
        "500": { "slidesPerView": 5 },
        "768": { "slidesPerView": 4 },
        "992": { "slidesPerView": 5 },
        "1200": { "slidesPerView": 6 }
      }
    }'>
                <div class="swiper-wrapper">

                    {{-- GENEL THUMB --}}
                    @foreach ($galleryImages as $image)
                        <div class="swiper-slide swiper-thumb"
                             data-image-source="general">
                            <div class="ratio ratio-1x1" style="max-width: 94px">
                                <img src="/upload/product/{{ $image }}"
                                     class="swiper-thumb-img"
                                     onerror="this.src='/extra/img/photo.png'"
                                     alt="{{ $data->title }}">
                            </div>
                        </div>
                    @endforeach

                    {{-- VARYANT THUMB --}}
                    @foreach ($variantGalleryItems as $variant)
                        <div class="swiper-slide swiper-thumb"
                             data-image-source="variant"
                             data-variant-id="{{ $variant->id }}"
                             data-variant-type="{{ $variant->variant_type ?: 'Genel' }}">
                            <div class="ratio ratio-1x1" style="max-width: 94px">
                                <img src="/upload/product/{{ $variant->variant_image }}"
                                     class="swiper-thumb-img"
                                     onerror="this.src='/extra/img/photo.png'"
                                     alt="{{ $variant->variant_name ?: $data->title }}">
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

        </div>


        <!-- Product options -->
        <div class="col-md-6 col-xl-5 offset-xl-1 pt-4">
            <div class="ps-md-4 ps-xl-0">
                <div class="position-relative" id="zoomPane">

                    <form action="{{ route('cart_insert',$data->product_token) }}" method="POST">
                        @csrf
                    <!-- Model -->
                        @if($variantGroups->count() > 0)

                            @foreach($variantGroups as $groupName => $groupVariants)

                                @php
                                    $isColor = $groupVariants->contains('is_color', 1);
                                @endphp
                                <div class="product-variation mb-2">
                                    <h6 class="title">{{ $groupName }}:</h6>

                                    {{-- 🎨 RENK ise --}}
                                    @if($isColor)
                                        {{-- gizli select (JS için) --}}
                                        <select class="variant-group-select d-none" data-variant-type="{{ $groupName }}">
                                            <option value="">Seçiniz</option>
                                            @foreach ($groupVariants as $key)
                                                <option value="{{ $key->id }}"
                                                        data-stock="{{ (int) $key->variant_stock }}"
                                                        data-variant-name="{{ $key->variant_name }}"
                                                        data-parent-variant-type="{{ $key->parent_variant_type }}"
                                                        data-parent-variant-name="{{ $key->parent_variant_name }}">
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="color-options">
                                            @foreach ($groupVariants as $key)
                                                <label class="color-item">
                                                    <input type="radio"
                                                           name="variant_{{ $groupName }}"
                                                           value="{{ $key->id }}"
                                                           data-stock="{{ (int) $key->variant_stock }}"
                                                           data-variant-name="{{ $key->variant_name }}"
                                                           data-parent-variant-type="{{ $key->parent_variant_type }}"
                                                           data-parent-variant-name="{{ $key->parent_variant_name }}"
                                                        {{ (int) $key->variant_stock <= 0 ? 'disabled' : '' }}>

                                                    <span class="color-box"
                                                          style="background-color: {{ $key->color_code ?? '#ccc' }}">
                    </span>

                                                    <small>

                                                        @if((int) $key->variant_stock <= 0)
                                                            (Stokta yok)
                                                        @endif
                                                    </small>
                                                </label>
                                            @endforeach
                                        </div>

                                        {{-- 🔽 NORMAL SELECT --}}
                                    @else

                                        <select class="form-select variant-group-select" data-variant-type="{{ $groupName }}">
                                            <option value="">Lütfen {{ $groupName }} Seçiniz</option>

                                            @foreach ($groupVariants as $key)

                                                <option value="{{ $key->id }}"
                                                        data-stock="{{ (int) $key->variant_stock }}"
                                                        data-variant-name="{{ $key->variant_name }}"
                                                        data-parent-variant-type="{{ $key->parent_variant_type }}"
                                                        data-parent-variant-name="{{ $key->parent_variant_name }}"
                                                    {{ (int) $key->variant_stock <= 0 ? 'disabled' : '' }}>

                                                    {{ $key->variant_name }} - {{ number_format($key->variant_price,2) }} TL

                                                    @if((int) $key->variant_stock <= 0)
                                                        (Stokta yok)
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>

                                    @endif

                                </div>

                            @endforeach

                            <input type="hidden" name="variant" id="variantSelect" value="">
                            <div id="variantStockWarning" class="alert alert-warning fs-sm  mt-2 d-none"></div>

                        @endif

                    <!-- Price -->
                    <div class="d-flex flex-wrap align-items-center mb-3">
                        @php
                            $price = $data->price;
                            $sale = $data->sale_price;
                            $hasDiscount = $sale && $sale > 0;
                        @endphp

                        <div class="h4 mb-0 me-3">

                            @if($hasDiscount)
                                <div class="d-flex align-items-center gap-2">

                                    {{-- İndirimli fiyat --}}
                                    <span class="text-danger fw-semibold">
                                        {{ number_format($sale, 2, ',', '.') }} ₺
                                    </span>

                                        {{-- Eski fiyat --}}
                                         <span class="text-muted text-decoration-line-through fs-sm">
                                        {{ number_format($price, 2, ',', '.') }} ₺
                                    </span>

                                          {{-- DB’den gelen indirim oranı --}}
                                          <span class="badge bg-danger-subtle text-danger">
                                        %{{ $data->difference }}
                                    </span>

                                     </div>
                                    @else
                                        {{-- Normal fiyat --}}
                                        <span class="fw-semibold">
                                    {{ number_format($price, 2, ',', '.') }} ₺
                                </span>
                            @endif

                        </div>
                        @php
                            $stock = $data->stock;
                        @endphp

                        <div class="d-flex align-items-center fs-sm ms-auto
                                @if($stock > 10) text-success
                                @elseif($stock > 3) text-warning
                                @elseif($stock > 0) text-danger
                                @else text-muted
                                @endif
                            ">

                            @if($stock > 10)
                                <i class="ci-check-circle fs-base me-2"></i>
                                Stokta var

                            @elseif($stock > 3)
                                <i class="ci-alert-circle fs-base me-2"></i>
                                Tükeniyor

                            @elseif($stock > 0)
                                <i class="ci-alert-triangle fs-base me-2"></i>
                                Son {{ $stock }} ürün

                            @else
                                <i class="ci-close-circle fs-base me-2"></i>
                                Stokta yok
                            @endif

                        </div>
                    </div>

                    <div class="d-flex flex-wrap flex-sm-nowrap flex-md-wrap flex-lg-nowrap gap-3 gap-lg-2 gap-xl-3 mb-4">
                        <div class="count-input flex-shrink-0 order-sm-1">
                            <button type="button" class="btn btn-icon btn-lg" data-decrement aria-label="Decrement quantity">
                                <i class="ci-minus"></i>
                            </button>
                            <input type="number" class="form-control form-control-lg" name="quantity" value="1" min="1" max="{{$data->stock}}" readonly>
                            <button type="button" class="btn btn-icon btn-lg" data-increment aria-label="Increment quantity">
                                <i class="ci-plus"></i>
                            </button>
                        </div>

                        <a href="{{route('product_favories',$data->product_token)}}" class="btn btn-icon btn-lg btn-secondary animate-pulse order-sm-3 order-md-2 order-lg-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-sm" data-bs-title="Favorilere ekle" aria-label="Add to Wishlist">
                            @if(\App\Models\Favories::isSave($data->product_token))
                                <i class="ci-heart text-danger animate-target"></i>
                            @else
                                <i class="ci-heart animate-target"></i>
                            @endif
                        </a>

                        <button type="submit" class="btn btn-lg btn-primary w-100 animate-slide-end order-sm-2 order-md-4 order-lg-2">
                            <i class="ci-shopping-cart fs-lg animate-target ms-n1 me-2"></i>
                            Sepete ekle
                        </button>
                    </div>
                        <!-- Features -->
                        <div class="d-flex flex-wrap gap-3 gap-xl-3 pb-2 pb-lg-3 mb-2 mb-lg-0">
                            @php
                                $price = $data->price;
                                $sale = $data->sale_price;
                                $hasDiscount = $sale && $sale > 0 && $sale < $price;

                                $saving = $hasDiscount ? ($price - $sale) : 0;
                            @endphp

                            @if($hasDiscount)

                                {{-- KAZANÇ --}}
                                <div class="d-flex align-items-center fs-sm">
                                    <svg class="text-warning me-2" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"><path d="M1.333 9.667H7.5V16h-5c-.64 0-1.167-.527-1.167-1.167V9.667zm13.334 0v5.167c0 .64-.527 1.167-1.167 1.167h-5V9.667h6.167zM0 5.833V7.5c0 .64.527 1.167 1.167 1.167h.167H7.5v-1-3H1.167C.527 4.667 0 5.193 0 5.833zm14.833-1.166H8.5v3 1h6.167.167C15.473 8.667 16 8.14 16 7.5V5.833c0-.64-.527-1.167-1.167-1.167z"/><path d="M8 5.363a.5.5 0 0 1-.495-.573C7.752 3.123 9.054-.03 12.219-.03c1.807.001 2.447.977 2.447 1.813 0 1.486-2.069 3.58-6.667 3.58zM12.219.971c-2.388 0-3.295 2.27-3.595 3.377 1.884-.088 3.072-.565 3.756-.971.949-.563 1.287-1.193 1.287-1.595 0-.599-.747-.811-1.447-.811z"/><path d="M8.001 5.363c-4.598 0-6.667-2.094-6.667-3.58 0-.836.641-1.812 2.448-1.812 3.165 0 4.467 3.153 4.713 4.819a.5.5 0 0 1-.495.573zM3.782.971c-.7 0-1.448.213-1.448.812 0 .851 1.489 2.403 5.042 2.566C7.076 3.241 6.169.971 3.782.971z"/></svg>
                                    <div class="text-body-emphasis text-nowrap">
            <span class="fw-semibold">
                {{ number_format($saving, 2, ',', '.') }} ₺
            </span>
                                        kazancınız var
                                    </div>
                                </div>

                                {{-- İNDİRİM BİLGİSİ --}}
                                <div class="d-flex align-items-center fs-sm">
                                    <svg class="text-primary me-2" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"><path d="M15.264 8.001l.702-1.831a.5.5 0 0 0-.152-.568l-1.522-1.234-.308-1.937a.5.5 0 0 0-.416-.415l-1.937-.308L10.399.185a.5.5 0 0 0-.567-.152L8 .736 6.169.034a.5.5 0 0 0-.567.152L4.368 1.709l-1.937.308a.5.5 0 0 0-.415.415l-.308 1.937L.185 5.603a.5.5 0 0 0-.152.567l.702 1.831-.702 1.831a.5.5 0 0 0 .152.567l1.523 1.233.308 1.937a.5.5 0 0 0 .415.416l1.937.308 1.234 1.522c.137.17.366.23.568.152L8 15.265l1.831.702a.5.5 0 0 0 .568-.153l1.233-1.522 1.937-.308a.5.5 0 0 0 .416-.416l.308-1.937 1.522-1.233a.5.5 0 0 0 .152-.567l-.702-1.831z" fill="currentColor"/><path d="M6.5 7.001a1.5 1.5 0 1 1 0-3 1.5 1.5 0 1 1 0 3zm0-2a.5.5 0 1 0 0 1 .5.5 0 1 0 0-1zM9.5 12a1.5 1.5 0 1 1 0-3 1.5 1.5 0 1 1 0 3zm0-2a.5.5 0 1 0 0 1 .5.5 0 1 0 0-1zm-4 2c-.101 0-.202-.03-.29-.093a.5.5 0 0 1-.116-.698l5-7a.5.5 0 1 1 .814.581l-5 7A.5.5 0 0 1 5.5 12z" fill="white"/></svg>
                                    <div class="text-body-emphasis text-nowrap">
            <span class="fw-semibold text-danger">
                %{{ $data->difference }}
            </span>
                                        indirimli ürün
                                    </div>
                                </div>

                            @endif

                        </div>
                        <div class="mb-5">
                            <h6 class="title">Kuponunuz var mı?</h6>
                            <div class="form-group">
                                <input type="text" name="coupon" class="form-control" id="" placeholder="Varsa ürün kupon kodu giriniz.">
                            </div>
                        </div>
                    </form>


                </div>

                <!-- Shipping options -->
                <div class="d-flex align-items-center pb-2">
                    <h3 class="h6 mb-0">Kargo seçenekleri</h3>

                </div>
                <table class="table table-borderless fs-sm mb-2">
                    <tbody>
                    @foreach($cargo as $takeCargo)
                        <tr>
                            <td class="py-2 ps-0">{{ $takeCargo->cargo_title }}</td>
                            <td class="py-2">{{ $takeCargo->cargo_time }} Günde ulaşım</td>
                            <td class="text-body-emphasis fw-semibold text-end py-2 pe-0">@if($setting->free_cargo > $finalPrice)) {{ $takeCargo->cargo_price }} TL @else Ücretsiz @endif</td>
                        </tr>
                    @endforeach


                    </tbody>
                </table>

                <!-- Warranty + Payment info accordion -->
                <div class="accordion" id="infoAccordion">
                    @if($data->feature != null)
                    <div class="accordion-item border-top">
                        <h3 class="accordion-header" id="headingWarranty">
                            <button type="button" class="accordion-button animate-underline collapsed" data-bs-toggle="collapse" data-bs-target="#warranty" aria-expanded="false" aria-controls="warranty">
                                <span class="animate-target me-2">Özellikler</span>
                            </button>
                        </h3>
                        <div class="accordion-collapse collapse" id="warranty" aria-labelledby="headingWarranty" data-bs-parent="#infoAccordion">
                            <div class="accordion-body">

                                <p class="mb-0"> {{ $data->feature }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                        @if($data->installment != null)

                    <div class="accordion-item">
                        <h3 class="accordion-header" id="headingPayment">
                            <button type="button" class="accordion-button animate-underline collapsed" data-bs-toggle="collapse" data-bs-target="#payment" aria-expanded="false" aria-controls="payment">
                                <span class="animate-target me-2">Taksitlendirme</span>
                            </button>
                        </h3>
                        <div class="accordion-collapse collapse" id="payment" aria-labelledby="headingPayment" data-bs-parent="#infoAccordion">
                            <div class="accordion-body"> {{ $data->installment }}</div>
                        </div>
                    </div>
                        @endif
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Sticky product preview + Add to cart CTA -->
<section class="sticky-product-banner sticky-top d-md-none" data-sticky-element>
    <div class="sticky-product-banner-inner pt-5">
        <div class="bg-body border-bottom border-light border-opacity-10 shadow pt-4 pb-2">
            <div class="container d-flex align-items-center">
                <div class="d-flex align-items-center min-w-0 ms-n2 me-3">
                    <div class="ratio ratio-1x1 flex-shrink-0" style="width: 50px">
                        <img src="assets/img/shop/electronics/thumbs/10.png" alt="iPhone 14">
                    </div>
                    <div class="w-100 min-w-0 ps-2">
                        <h4 class="fs-sm fw-medium text-truncate mb-1">Apple iPhone 14 Plus 128GB Blue</h4>
                        <div class="h6 mb-0">$940.00</div>
                    </div>
                </div>
                <div class="d-flex gap-2 ms-auto">
                    <button type="button" class="btn btn-icon btn-secondary animate-pulse" aria-label="Add to Wishlist">
                        <i class="ci-heart fs-base animate-target"></i>
                    </button>
                    <button type="button" class="btn btn-primary animate-slide-end d-none d-sm-inline-flex">
                        <i class="ci-shopping-cart fs-base animate-target ms-n1 me-2"></i>
                        Add to cart
                    </button>
                    <button type="button" class="btn btn-icon btn-primary animate-slide-end d-sm-none" aria-label="Add to Cart">
                        <i class="ci-shopping-cart fs-lg animate-target"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Bundle discount (Cheaper together) -->






<!-- Product details and Reviews shared container -->
<section class="container pb-5 mb-2 mb-md-3 mb-lg-4 mb-xl-5">
    <div class="row">
        <div class="col-md-7">

            <!-- Product details -->
            <h2 class="h3 pb-2 pb-md-3">Ürün açıklaması</h2>
           <p>{{ $data->description }}</p>



            @include('product::frontend.product.new.include.comment')
        </div>


        <!-- Sticky product preview visible on screens > 991px wide (lg breakpoint) -->
        <aside class="col-md-5 col-xl-4 offset-xl-1 d-none d-md-block" style="margin-top: -100px">
            <div class="position-sticky top-0 ps-3 ps-lg-4 ps-xl-0" style="padding-top: 100px">
                <div class="border rounded p-3 p-lg-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="ratio ratio-1x1 flex-shrink-0" style="width: 110px">
                            <img src="assets/img/shop/electronics/thumbs/10.png" width="110" alt="iPhone 14">
                        </div>
                        <div class="w-100 min-w-0 ps-2 ps-sm-3">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="d-flex gap-1 fs-xs">
                                    <i class="ci-star-filled text-warning"></i>
                                    <i class="ci-star-filled text-warning"></i>
                                    <i class="ci-star-filled text-warning"></i>
                                    <i class="ci-star-filled text-warning"></i>
                                    <i class="ci-star text-body-tertiary opacity-75"></i>
                                </div>
                                <span class="text-body-tertiary fs-xs">68</span>
                            </div>
                            <h4 class="fs-sm fw-medium mb-2">Apple iPhone 14 Plus 128GB Blue</h4>
                            <div class="h5 mb-0">$940.00</div>
                        </div>
                    </div>
                    <div class="d-flex gap-2 gap-lg-3">
                        <button type="button" class="btn btn-primary w-100 animate-slide-end">
                            <i class="ci-shopping-cart fs-base animate-target ms-n1 me-2"></i>
                            Add to cart
                        </button>
                        <button type="button" class="btn btn-icon btn-secondary animate-pulse" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-sm" data-bs-title="Add to Wishlist" aria-label="Add to Wishlist">
                            <i class="ci-heart fs-base animate-target"></i>
                        </button>
                        <button type="button" class="btn btn-icon btn-secondary animate-rotate" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-sm" data-bs-title="Compare" aria-label="Compare">
                            <i class="ci-refresh-cw fs-base animate-target"></i>
                        </button>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</section>


<!-- Viewed products (Carousel) -->
<section class="container pb-4 pb-md-5 mb-2 mb-sm-0 mb-lg-2 mb-xl-4">
    <h2 class="h3 border-bottom pb-4 mb-0">Viewed products</h2>

    <!-- Product carousel -->
    <div class="position-relative mx-md-1">

        <!-- External slider prev/next buttons visible on screens > 500px wide (sm breakpoint) -->
        <button type="button" class="viewed-prev btn btn-prev btn-icon btn-outline-secondary bg-body rounded-circle animate-slide-start position-absolute top-50 start-0 z-2 translate-middle-y ms-n1 d-none d-sm-inline-flex" aria-label="Prev">
            <i class="ci-chevron-left fs-lg animate-target"></i>
        </button>
        <button type="button" class="viewed-next btn btn-next btn-icon btn-outline-secondary bg-body rounded-circle animate-slide-end position-absolute top-50 end-0 z-2 translate-middle-y me-n1 d-none d-sm-inline-flex" aria-label="Next">
            <i class="ci-chevron-right fs-lg animate-target"></i>
        </button>

        <!-- Slider -->
        <div class="swiper py-4 px-sm-3" data-swiper='{
            "slidesPerView": 2,
            "spaceBetween": 24,
            "loop": true,
            "navigation": {
              "prevEl": ".viewed-prev",
              "nextEl": ".viewed-next"
            },
            "breakpoints": {
              "768": {
                "slidesPerView": 3
              },
              "992": {
                "slidesPerView": 4
              }
            }
          }'>
            <div class="swiper-wrapper">

                <!-- Item -->
                <div class="swiper-slide">
                    <div class="product-card animate-underline hover-effect-opacity bg-body rounded">
                        <div class="position-relative">
                            <div class="position-absolute top-0 end-0 z-2 hover-effect-target opacity-0 mt-3 me-3">
                                <div class="d-flex flex-column gap-2">
                                    <button type="button" class="btn btn-icon btn-secondary animate-pulse d-none d-lg-inline-flex" aria-label="Add to Wishlist">
                                        <i class="ci-heart fs-base animate-target"></i>
                                    </button>
                                    <button type="button" class="btn btn-icon btn-secondary animate-rotate d-none d-lg-inline-flex" aria-label="Compare">
                                        <i class="ci-refresh-cw fs-base animate-target"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="dropdown d-lg-none position-absolute top-0 end-0 z-2 mt-2 me-2">
                                <button type="button" class="btn btn-icon btn-sm btn-secondary bg-body" data-bs-toggle="dropdown" aria-expanded="false" aria-label="More actions">
                                    <i class="ci-more-vertical fs-lg"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end fs-xs p-2" style="min-width: auto">
                                    <li>
                                        <a class="dropdown-item" href="#!">
                                            <i class="ci-heart fs-sm ms-n1 me-2"></i>
                                            Add to Wishlist
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#!">
                                            <i class="ci-refresh-cw fs-sm ms-n1 me-2"></i>
                                            Compare
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <a class="d-block rounded-top overflow-hidden p-3 p-sm-4" href="#!">
                                <div class="ratio" style="--cz-aspect-ratio: calc(240 / 258 * 100%)">
                                    <img src="assets/img/shop/electronics/13.png" alt="Dualsense Edge">
                                </div>
                            </a>
                        </div>
                        <div class="w-100 min-w-0 px-1 pb-2 px-sm-3 pb-sm-3">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="d-flex gap-1 fs-xs">
                                    <i class="ci-star-filled text-warning"></i>
                                    <i class="ci-star-filled text-warning"></i>
                                    <i class="ci-star-filled text-warning"></i>
                                    <i class="ci-star-filled text-warning"></i>
                                    <i class="ci-star-filled text-warning"></i>
                                </div>
                                <span class="text-body-tertiary fs-xs">(187)</span>
                            </div>
                            <h3 class="pb-1 mb-2">
                                <a class="d-block fs-sm fw-medium text-truncate" href="#!">
                                    <span class="animate-target">Sony Dualsense Edge Controller</span>
                                </a>
                            </h3>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="h5 lh-1 mb-0">$200.00</div>
                                <button type="button" class="product-card-button btn btn-icon btn-secondary animate-slide-end ms-2" aria-label="Add to Cart">
                                    <i class="ci-shopping-cart fs-base animate-target"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Item -->
                <div class="swiper-slide">
                    <div class="product-card animate-underline hover-effect-opacity bg-body rounded">
                        <div class="position-relative">
                            <div class="position-absolute top-0 end-0 z-2 hover-effect-target opacity-0 mt-3 me-3">
                                <div class="d-flex flex-column gap-2">
                                    <button type="button" class="btn btn-icon btn-secondary animate-pulse d-none d-lg-inline-flex" aria-label="Add to Wishlist">
                                        <i class="ci-heart fs-base animate-target"></i>
                                    </button>
                                    <button type="button" class="btn btn-icon btn-secondary animate-rotate d-none d-lg-inline-flex" aria-label="Compare">
                                        <i class="ci-refresh-cw fs-base animate-target"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="dropdown d-lg-none position-absolute top-0 end-0 z-2 mt-2 me-2">
                                <button type="button" class="btn btn-icon btn-sm btn-secondary bg-body" data-bs-toggle="dropdown" aria-expanded="false" aria-label="More actions">
                                    <i class="ci-more-vertical fs-lg"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end fs-xs p-2" style="min-width: auto">
                                    <li>
                                        <a class="dropdown-item" href="#!">
                                            <i class="ci-heart fs-sm ms-n1 me-2"></i>
                                            Add to Wishlist
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#!">
                                            <i class="ci-refresh-cw fs-sm ms-n1 me-2"></i>
                                            Compare
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <a class="d-block rounded-top overflow-hidden p-3 p-sm-4" href="#!">
                                <span class="badge bg-danger position-absolute top-0 start-0 mt-2 ms-2 mt-lg-3 ms-lg-3">-17%</span>
                                <div class="ratio" style="--cz-aspect-ratio: calc(240 / 258 * 100%)">
                                    <img src="assets/img/shop/electronics/11.png" alt="Nikon Camera">
                                </div>
                            </a>
                        </div>
                        <div class="w-100 min-w-0 px-1 pb-2 px-sm-3 pb-sm-3">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="d-flex gap-1 fs-xs">
                                    <i class="ci-star-filled text-warning"></i>
                                    <i class="ci-star-filled text-warning"></i>
                                    <i class="ci-star-filled text-warning"></i>
                                    <i class="ci-star-filled text-warning"></i>
                                    <i class="ci-star-filled text-warning"></i>
                                </div>
                                <span class="text-body-tertiary fs-xs">(14)</span>
                            </div>
                            <h3 class="pb-1 mb-2">
                                <a class="d-block fs-sm fw-medium text-truncate" href="#!">
                                    <span class="animate-target">VRB01 Camera Nikon Max</span>
                                </a>
                            </h3>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="h5 lh-1 mb-0">$652.00 <del class="text-body-tertiary fs-sm fw-normal">$785.00</del></div>
                                <button type="button" class="product-card-button btn btn-icon btn-secondary animate-slide-end ms-2" aria-label="Add to Cart">
                                    <i class="ci-shopping-cart fs-base animate-target"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Item -->
                <div class="swiper-slide">
                    <div class="product-card animate-underline hover-effect-opacity bg-body rounded">
                        <div class="position-relative">
                            <div class="position-absolute top-0 end-0 z-2 hover-effect-target opacity-0 mt-3 me-3">
                                <div class="d-flex flex-column gap-2">
                                    <button type="button" class="btn btn-icon btn-secondary animate-pulse d-none d-lg-inline-flex" aria-label="Add to Wishlist">
                                        <i class="ci-heart fs-base animate-target"></i>
                                    </button>
                                    <button type="button" class="btn btn-icon btn-secondary animate-rotate d-none d-lg-inline-flex" aria-label="Compare">
                                        <i class="ci-refresh-cw fs-base animate-target"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="dropdown d-lg-none position-absolute top-0 end-0 z-2 mt-2 me-2">
                                <button type="button" class="btn btn-icon btn-sm btn-secondary bg-body" data-bs-toggle="dropdown" aria-expanded="false" aria-label="More actions">
                                    <i class="ci-more-vertical fs-lg"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end fs-xs p-2" style="min-width: auto">
                                    <li>
                                        <a class="dropdown-item" href="#!">
                                            <i class="ci-heart fs-sm ms-n1 me-2"></i>
                                            Add to Wishlist
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#!">
                                            <i class="ci-refresh-cw fs-sm ms-n1 me-2"></i>
                                            Compare
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <a class="d-block rounded-top overflow-hidden p-3 p-sm-4" href="#!">
                                <div class="ratio" style="--cz-aspect-ratio: calc(240 / 258 * 100%)">
                                    <img src="assets/img/shop/electronics/10.png" alt="iPhone 14">
                                </div>
                            </a>
                        </div>
                        <div class="w-100 min-w-0 px-1 pb-2 px-sm-3 pb-sm-3">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="d-flex gap-1 fs-xs">
                                    <i class="ci-star-filled text-warning"></i>
                                    <i class="ci-star-filled text-warning"></i>
                                    <i class="ci-star-filled text-warning"></i>
                                    <i class="ci-star-filled text-warning"></i>
                                    <i class="ci-star-half text-warning"></i>
                                </div>
                                <span class="text-body-tertiary fs-xs">(335)</span>
                            </div>
                            <h3 class="pb-1 mb-2">
                                <a class="d-block fs-sm fw-medium text-truncate" href="#!">
                                    <span class="animate-target">Apple iPhone 14 128GB Blue</span>
                                </a>
                            </h3>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="h5 lh-1 mb-0">$899.00</div>
                                <button type="button" class="product-card-button btn btn-icon btn-secondary animate-slide-end ms-2" aria-label="Add to Cart">
                                    <i class="ci-shopping-cart fs-base animate-target"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Item -->
                <div class="swiper-slide">
                    <div class="product-card animate-underline hover-effect-opacity bg-body rounded">
                        <div class="posittion-relative">
                            <div class="position-absolute top-0 end-0 z-2 hover-effect-target opacity-0 mt-3 me-3">
                                <div class="d-flex flex-column gap-2">
                                    <button type="button" class="btn btn-icon btn-secondary animate-pulse d-none d-lg-inline-flex" aria-label="Add to Wishlist">
                                        <i class="ci-heart fs-base animate-target"></i>
                                    </button>
                                    <button type="button" class="btn btn-icon btn-secondary animate-rotate d-none d-lg-inline-flex" aria-label="Compare">
                                        <i class="ci-refresh-cw fs-base animate-target"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="dropdown d-lg-none position-absolute top-0 end-0 z-2 mt-2 me-2">
                                <button type="button" class="btn btn-icon btn-sm btn-secondary bg-body" data-bs-toggle="dropdown" aria-expanded="false" aria-label="More actions">
                                    <i class="ci-more-vertical fs-lg"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end fs-xs p-2" style="min-width: auto">
                                    <li>
                                        <a class="dropdown-item" href="#!">
                                            <i class="ci-heart fs-sm ms-n1 me-2"></i>
                                            Add to Wishlist
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#!">
                                            <i class="ci-refresh-cw fs-sm ms-n1 me-2"></i>
                                            Compare
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <a class="d-block rounded-top overflow-hidden p-3 p-sm-4" href="#!">
                                <div class="ratio" style="--cz-aspect-ratio: calc(240 / 258 * 100%)">
                                    <img src="assets/img/shop/electronics/07.png" alt="iPad Pro">
                                </div>
                            </a>
                        </div>
                        <div class="w-100 min-w-0 px-1 pb-2 px-sm-3 pb-sm-3">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="d-flex gap-1 fs-xs">
                                    <i class="ci-star-filled text-warning"></i>
                                    <i class="ci-star-filled text-warning"></i>
                                    <i class="ci-star-filled text-warning"></i>
                                    <i class="ci-star-filled text-warning"></i>
                                    <i class="ci-star-half text-warning"></i>
                                </div>
                                <span class="text-body-tertiary fs-xs">(49)</span>
                            </div>
                            <h3 class="pb-1 mb-2">
                                <a class="d-block fs-sm fw-medium text-truncate" href="#!">
                                    <span class="animate-target">Tablet Apple iPad Pro M1</span>
                                </a>
                            </h3>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="h5 lh-1 mb-0">$739.00</div>
                                <button type="button" class="product-card-button btn btn-icon btn-secondary animate-slide-end ms-2" aria-label="Add to Cart">
                                    <i class="ci-shopping-cart fs-base animate-target"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Item -->
                <div class="swiper-slide">
                    <div class="product-card animate-underline hover-effect-opacity bg-body rounded">
                        <div class="position-relative">
                            <div class="position-absolute top-0 end-0 z-2 hover-effect-target opacity-0 mt-3 me-3">
                                <div class="d-flex flex-column gap-2">
                                    <button type="button" class="btn btn-icon btn-secondary animate-pulse d-none d-lg-inline-flex" aria-label="Add to Wishlist">
                                        <i class="ci-heart fs-base animate-target"></i>
                                    </button>
                                    <button type="button" class="btn btn-icon btn-secondary animate-rotate d-none d-lg-inline-flex" aria-label="Compare">
                                        <i class="ci-refresh-cw fs-base animate-target"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="dropdown d-lg-none position-absolute top-0 end-0 z-2 mt-2 me-2">
                                <button type="button" class="btn btn-icon btn-sm btn-secondary bg-body" data-bs-toggle="dropdown" aria-expanded="false" aria-label="More actions">
                                    <i class="ci-more-vertical fs-lg"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end fs-xs p-2" style="min-width: auto">
                                    <li>
                                        <a class="dropdown-item" href="#!">
                                            <i class="ci-heart fs-sm ms-n1 me-2"></i>
                                            Add to Wishlist
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#!">
                                            <i class="ci-refresh-cw fs-sm ms-n1 me-2"></i>
                                            Compare
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <a class="d-block rounded-top overflow-hidden p-3 p-sm-4" href="#!">
                                <div class="ratio" style="--cz-aspect-ratio: calc(240 / 258 * 100%)">
                                    <img src="assets/img/shop/electronics/06.png" alt="AirPods 2">
                                </div>
                            </a>
                        </div>
                        <div class="w-100 min-w-0 px-1 pb-2 px-sm-3 pb-sm-3">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="d-flex gap-1 fs-xs">
                                    <i class="ci-star-filled text-warning"></i>
                                    <i class="ci-star-filled text-warning"></i>
                                    <i class="ci-star-filled text-warning"></i>
                                    <i class="ci-star-filled text-warning"></i>
                                    <i class="ci-star text-body-tertiary opacity-75"></i>
                                </div>
                                <span class="text-body-tertiary fs-xs">(78)</span>
                            </div>
                            <h3 class="pb-1 mb-2">
                                <a class="d-block fs-sm fw-medium text-truncate" href="#!">
                                    <span class="animate-target">Headphones Apple AirPods 2 Pro</span>
                                </a>
                            </h3>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="h5 lh-1 mb-0">$224.00</div>
                                <button type="button" class="product-card-button btn btn-icon btn-secondary animate-slide-end ms-2" aria-label="Add to Cart">
                                    <i class="ci-shopping-cart fs-base animate-target"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- External slider prev/next buttons visible on screens < 500px wide (sm breakpoint) -->
        <div class="d-flex justify-content-center gap-2 mt-n2 mb-3 pb-1 d-sm-none">
            <button type="button" class="viewed-prev btn btn-prev btn-icon btn-outline-secondary bg-body rounded-circle animate-slide-start me-1" aria-label="Prev">
                <i class="ci-chevron-left fs-lg animate-target"></i>
            </button>
            <button type="button" class="viewed-next btn btn-next btn-icon btn-outline-secondary bg-body rounded-circle animate-slide-end" aria-label="Next">
                <i class="ci-chevron-right fs-lg animate-target"></i>
            </button>
        </div>
    </div>
</section>
