<!-- Shopping cart offcanvas -->
<div class="offcanvas offcanvas-end pb-sm-2 px-sm-2"
     id="shoppingCart"
     tabindex="-1"
     aria-labelledby="shoppingCartLabel"
     style="width: 500px">
    @if(Auth::check())
    @php
        $userId = Auth::id();
    $data = \App\Models\Basketitems::where('user_id', $userId)->get();
    $basket = \App\Models\Baskets::where('user_id', $userId)->first();

    $subTotal = (float) $data->sum(fn ($item) => (float) $item->total);
    $cartCoupon = $basket?->coupon;
    $cartDiscount = 0;

    if ($cartCoupon && $cartCoupon->status == 1) {
        $cartDiscount = $cartCoupon->getDiscountAmount($subTotal);
    }

    $grandTotal = max($subTotal - $cartDiscount, 0);
    @endphp
    {{-- HEADER --}}
    <div class="offcanvas-header flex-column align-items-start py-3 pt-lg-4">

        <div class="d-flex align-items-center justify-content-between w-100 mb-3 mb-lg-4">
            <h4 class="offcanvas-title" id="shoppingCartLabel">
                Sepetim
            </h4>

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="offcanvas">
            </button>
        </div>

        @php
            $remainingForFreeCargo = max($setting->free_cargo - $grandTotal, 0);

            $cargoPercent = 0;

            if($setting->free_cargo > 0){
                $cargoPercent = min(($grandTotal / $setting->free_cargo) * 100, 100);
            }
        @endphp

        @if($remainingForFreeCargo > 0)
            <p class="fs-sm">
                Ücretsiz kargo için
                <span class="fw-semibold text-dark">
                    {{ number_format($remainingForFreeCargo,2) }} TL
                </span>
                daha ekleyin
            </p>
        @else
            <p class="fs-sm text-success fw-semibold">
                Ücretsiz kargo kazandınız 🎉
            </p>
        @endif

        <div class="progress w-100"
             style="height:4px">

            <div class="progress-bar bg-warning rounded-pill"
                 style="width: {{ $cargoPercent }}%">
            </div>
        </div>
    </div>

    {{-- BODY --}}
    <div class="offcanvas-body d-flex flex-column gap-4 pt-2">

        @forelse($data as $key)

            @php

                $basePrice = $key->getProduct->sale_price != 0
                    ? (float) $key->getProduct->sale_price
                    : (float) $key->getProduct->price;

                $variantIds = $key->variant
                    ? explode('-', $key->variant)
                    : [];

                $variants = \App\Models\Productvars::whereIn('id', $variantIds)->get();

                $variantPrice = $variants->sum('variant_price');

                $unitPrice = $basePrice + $variantPrice;

                $firstVariant = $variants->first();

            @endphp

            <div class="d-flex align-items-center">

                {{-- IMAGE --}}
                <a class="flex-shrink-0"
                   href="{{ route('product_detail', $key->getProduct->slug . '-' . $key->getProduct->product_token) }}">

                    @if($firstVariant && $firstVariant->variant_image)

                        <img src="/upload/product/{{ $firstVariant->variant_image }}"
                             width="110"
                             onerror="this.src='/extra/img/photo.png'">

                    @else

                        <img src="/upload/product/{{ $key->getProduct->image }}"
                             width="110"
                             onerror="this.src='/extra/img/photo.png'">

                    @endif
                </a>

                {{-- CONTENT --}}
                <div class="w-100 min-w-0 ps-2 ps-sm-3">

                    <h5 class="mb-2">

                        <a class="fs-sm fw-medium"
                           style="
        display:-webkit-box;
        -webkit-line-clamp:2;
        -webkit-box-orient:vertical;
        overflow:hidden;
        white-space:normal;
   "
                           href="{{ route('product_detail', $key->getProduct->slug . '-' . $key->getProduct->product_token) }}">

                            {{ $key->getProduct->title }}

                        </a>

                    </h5>

                    {{-- VARIANTS --}}
                    @if($variants->count())

                        <div class="mb-2">

                            @foreach($variants as $v)

                                <small class="d-block text-muted">
                                    {{ $v->variant_type }} :
                                    {{ $v->variant_name }}
                                </small>

                            @endforeach

                        </div>

                    @endif

                    {{-- PRICE --}}
                    <div class="h6 pb-1 mb-2">
                        {{ number_format($unitPrice,2) }} TL
                    </div>

                    {{-- QUANTITY --}}
                    <div class="d-flex align-items-center justify-content-between">

                        <div class="count-input rounded-2 d-flex align-items-center">

                            @if($key->coupon == null)

                                <a href="{{ route('cart_decrease',$key->id) }}"
                                   class="btn btn-icon btn-sm">
                                    -
                                </a>

                            @endif

                            <input type="text"
                                   class="form-control form-control-sm text-center"
                                   value="{{ $key->quantity }}"
                                   readonly>

                            @if($key->coupon == null)

                                <a href="{{ route('cart_increase',$key->id) }}"
                                   class="btn btn-icon btn-sm">
                                    +
                                </a>

                            @endif

                        </div>

                        {{-- DELETE --}}
                        <a href="{{ route('cart_delete_product',$key->id) }}"
                           class="btn-close fs-sm">
                        </a>

                    </div>

                </div>

            </div>

        @empty

            <div class="text-center py-5">

                <img src="/extra/img/empty-cart.png"
                     width="90"
                     class="mb-3">

                <h6>Sepetiniz boş</h6>

            </div>

        @endforelse

    </div>

    {{-- FOOTER --}}
    <div class="offcanvas-header flex-column align-items-start">

        <div class="d-flex align-items-center justify-content-between w-100 mb-3 mb-md-4">

            <span class="text-light-emphasis">
                Toplam:
            </span>

            <span class="h5 mb-0">
                {{ number_format($grandTotal,2) }} TL
            </span>

        </div>

        <div class="d-flex w-100 gap-3">

            <a class="btn btn-lg btn-secondary w-100"
               href="{{ route('shopping_cart') }}">

                Sepete Git

            </a>

            @if($data->isNotEmpty())

                <form action="{{ route('cart_approval') }}"
                      method="POST"
                      class="w-100">

                    @csrf

                    <button class="btn btn-lg btn-primary w-100">
                        Onayla
                    </button>

                </form>

            @endif

        </div>

    </div>
    @else
        {{-- HEADER --}}
        <div class="offcanvas-header flex-column align-items-start py-3 pt-lg-4">

            <div class="d-flex align-items-center justify-content-between w-100 mb-3 mb-lg-4">
                <h4 class="offcanvas-title" id="shoppingCartLabel">
                    Sepetim
                </h4>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="offcanvas">
                </button>
            </div>

        </div>
        <div class="text-center py-5">

            <img src="/extra/img/empty-cart.png"
                 width="90"
                 class="mb-3">

            <h6>Lütfen önce giriş yapınız.</h6>

        </div>

    @endif
</div>
