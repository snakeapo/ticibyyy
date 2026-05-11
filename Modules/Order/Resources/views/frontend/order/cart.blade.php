@extends('page::frontend.layout.master')
@section('content')
    <!-- Breadcrumb -->
    <nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home_index') }}">Anasayfa</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sepet</li>
        </ol>
    </nav>


    <!-- Items in the cart + Order summary -->
    <section class="container pb-5 mb-2 mb-md-3 mb-lg-4 mb-xl-5">
        <h1 class="h3 mb-4">Sepetim</h1>
        <div class="row">

            <!-- Items list -->
            <div class="col-lg-8">
                <div class="pe-lg-2 pe-xl-3 me-xl-3">
                    <div class="offcanvas-header flex-column align-items-start py-3 pt-lg-4">


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

                    @if($data->isNotEmpty())
                    <table class="table position-relative z-2 mb-4">
                        <thead>
                        <tr>
                            <th scope="col" class="fs-sm fw-normal py-3 ps-0">
                                <span class="text-body">Ürün</span>
                            </th>

                            <th scope="col" class="text-body fs-sm fw-normal py-3 d-none d-md-table-cell">
                                <span class="text-body">Adet</span>
                            </th>
                            <th scope="col" class="text-body fs-sm fw-normal py-3 d-none d-md-table-cell">
                                <span class="text-body">Toplam</span>
                            </th>
                            <th scope="col" class="py-0 px-0">
                                #
                            </th>
                        </tr>
                        </thead>
                        <tbody class="align-middle">

                        @foreach ($data as $key)

                            @php
                                $basePrice = $key->getProduct->sale_price != 0
                                    ? (float) $key->getProduct->sale_price
                                    : (float) $key->getProduct->price;

                                // 🔥 MULTI VARIANT AL
                                $variantIds = $key->variant ? explode('-', $key->variant) : [];
                                $variants = \App\Models\Productvars::whereIn('id', $variantIds)->get();

                                $variantPrice = $variants->sum('variant_price');
                                $unitPrice = $basePrice + $variantPrice;

                                $firstVariant = $variants->first();
                            @endphp
                        <tr>
                            <td class="py-3 ps-0">
                                <div class="d-flex align-items-center">
                                    <a class="flex-shrink-0" href="{{ route('product_detail', $key->getProduct->slug . '-' . $key->getProduct->product_token) }}">
                                        @if($firstVariant && $firstVariant->variant_image)
                                            <img width="110px" src="{{ asset('/upload/product/'.$firstVariant->variant_image) }}"
                                                 onerror="this.src='/extra/img/photo.png'">
                                        @else
                                            <img width="110px" src="{{ asset('/upload/product/'.$key->getProduct->image) }}"
                                                 onerror="this.src='/extra/img/photo.png'">
                                        @endif
                                    </a>
                                    <div class="w-100 min-w-0 ps-2 ps-xl-3">
                                        <h5 class="d-flex animate-underline mb-2">
                                            <a class="d-block fs-sm fw-medium text-truncate animate-target" href="{{ route('product_detail', $key->getProduct->slug . '-' . $key->getProduct->product_token) }}">{{ Str::limit($key->getProduct->title,30) }}</a>
                                        </h5>
                                        <ul class="list-unstyled gap-1 fs-xs mb-0">
                                            @if($variants->count())
                                                @foreach($variants as $v)
                                            <li><span class="text-body-secondary">{{ $v->variant_type }}:</span> <span class="text-dark-emphasis fw-medium">{{ $v->variant_name }}</span></li>

                                                @endforeach
                                            @endif
                                                @if($key->coupon != null)
                                            <li><span class="text-body-secondary">Kupon:</span> <span class="text-dark-emphasis fw-medium"> {{ $key->getCoupon->coupon_code }}</span></li>
                                                @endif
                                            <li class="d-xl-none"><span class="text-body-secondary">Toplam:</span> <span class="text-dark-emphasis fw-medium">{{ number_format($key->total,2) }} TL</span></li>
                                        </ul>
                                        <div class="count-input rounded-2 d-md-none mt-3">
                                            <a href="{{ route('cart_decrease',$key->id) }}" class="btn btn-sm btn-icon" data-decrement aria-label="Decrement quantity">
                                                <i class="ci-minus"></i>
                                            </a>
                                            <input type="number" class="form-control form-control-sm" value="{{ $key->quantity }}" readonly>
                                            <a href="{{ route('cart_increase',$key->id) }}" class="btn btn-sm btn-icon" data-increment aria-label="Increment quantity">
                                                <i class="ci-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="py-3 d-none d-md-table-cell">
                                <div class="count-input">
                                    <a href="{{ route('cart_decrease',$key->id) }}" class="btn btn-icon" data-decrement aria-label="Decrement quantity">
                                        <i class="ci-minus"></i>
                                    </a>
                                    <input type="number" class="form-control" value="{{ $key->quantity }}" readonly>
                                    <a href="{{ route('cart_increase',$key->id) }}" class="btn btn-icon" data-increment aria-label="Increment quantity">
                                        <i class="ci-plus"></i>
                                    </a>
                                </div>
                            </td>
                            <td class="h6 py-3 d-none d-md-table-cell">{{ number_format($key->total,2) }} TL</td>
                            <td class="text-end py-3 px-0">
                                <a href="{{ route('cart_delete_product',$key->id) }}" class="btn-close fs-sm" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-sm" data-bs-title="Remove" aria-label="Remove from cart"></a>
                            </td>
                        </tr>
                        @endforeach


                        </tbody>
                    </table>
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
                                Sepetiniz boş.
                            </h5>


                        </div>
                    @endif

                    <div class="nav position-relative z-2 mb-4 mb-lg-0">
                        <a class="nav-link animate-underline px-0" href="{{ route('product_filter') }}">
                            <i class="ci-chevron-left fs-lg me-1"></i>
                            <span class="animate-target">Alışverişe devam et</span>
                        </a>
                    </div>
                </div>
            </div>


            <!-- Order summary (sticky sidebar) -->
            <aside class="col-lg-4" style="margin-top: -100px">
                <div class="position-sticky top-0" style="padding-top: 100px">
                    <div class="bg-body-tertiary rounded-5 p-4 mb-3">
                        <div class="p-sm-2 p-lg-0 p-xl-2">
                            <h5 class="border-bottom pb-4 mb-4">Sepet özeti</h5>
                            <ul class="list-unstyled fs-sm gap-3 mb-0">
                                <li class="d-flex justify-content-between">
                                    Ara toplam ({{ $data->count() }} ürün):
                                    <span class="text-dark-emphasis fw-medium">{{ number_format($subTotal,2) }} TL</span>
                                </li>
                                <li class="d-flex justify-content-between">
                                    İndirim:
                                    <span class="text-danger fw-medium">-{{ number_format($cartDiscount,2) }} TL</span>
                                </li>
                                @if($cartCoupon)
                                    <li class="alert alert-success justify-content-between py-2">
                                        <div><strong>Aktif Kupon:</strong> {{ $cartCoupon->coupon_code }}</div>
                                        <div><small>{{ $cartCoupon->type_label }} - {{ $cartCoupon->coupon_ratio }}{{ $cartCoupon->discount_type === 'percent' ? '%' : ' TL' }}</small></div>
                                        <form action="{{ route('cart_remove_coupon') }}" method="POST" class="mt-2">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger">Kuponu Kaldır</button>
                                        </form>
                                    </li>
                                @endif


                                <li class="d-flex justify-content-between">
                                    Kargo
                                    @if($grandTotal >= $setting->free_cargo)
                                    <span class="text-dark-emphasis fw-medium">Ücretsiz</span>
                                    @else
                                        <span class="text-dark-emphasis fw-medium">Ücretli</span>
                                    @endif
                                </li>

                            </ul>
                            <div class="border-top pt-4 mt-4">
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="fs-sm">Toplam:</span>
                                    <span class="h5 mb-0">{{ number_format($grandTotal,2) }} TL</span>
                                </div>
                                @if($data->isNotEmpty())
                                    <form action="{{ route('cart_approval') }}" method="POST">
                                        @csrf
                                <button type="submit" class="btn btn-lg btn-primary w-100">
                                    Sepeti onayla
                                    <i class="ci-chevron-right fs-lg ms-1 me-n1"></i>
                                </button>
                                    </form>
                                @else
                                    <button type="button" class="btn btn-lg btn-primary w-100" disabled>
                                        Sepetiniz boş
                                        <i class="ci-chevron-right fs-lg ms-1 me-n1"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if($cartCoupon)
                        @else
                    <div class="accordion bg-body-tertiary rounded-5 p-4">
                        <div class="accordion-item border-0">
                            <h3 class="accordion-header" id="promoCodeHeading">
                                <button type="button" class="accordion-button animate-underline collapsed py-0 ps-sm-2 ps-lg-0 ps-xl-2" data-bs-toggle="collapse" data-bs-target="#promoCode" aria-expanded="false" aria-controls="promoCode">
                                    <i class="ci-percent fs-xl me-2"></i>
                                    <span class="animate-target me-2">Kupon kullan</span>
                                </button>
                            </h3>
                            <div class="accordion-collapse collapse" id="promoCode" aria-labelledby="promoCodeHeading">
                                <div class="accordion-body pt-3 pb-2 ps-sm-2 px-lg-0 px-xl-2">
                                    <form action="{{ route('cart_apply_coupon') }}" method="POST" class="needs-validation d-flex gap-2" novalidate>
                                       @csrf
                                        <div class="position-relative w-100">
                                            <input type="text" class="form-control" name="coupon" placeholder="Sepete özel kupon kodunuz" required>
                                        </div>
                                        <button type="submit" class="btn btn-dark">Uygula</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                        @endif
                </div>
            </aside>
        </div>
    </section>
@endsection
