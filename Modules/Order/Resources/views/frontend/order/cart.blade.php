@extends('page::frontend.layout.master')
@section('content')
<main class="main-wrapper">

    <!-- Start Cart Area  -->
    <div class="axil-product-cart-area axil-section-gap">
        <div class="container">
            <div class="axil-product-cart-wrap">
                <div class="row">
                    <div class="col-md-8">
                        <div class="product-table-heading">
                            <h4 class="title">Sepetiniz</h4>
                        </div>
                        <div class="table-responsive">
                            @if($data->isNotEmpty())
                            <table class="table axil-product-table axil-cart-table mb--40">
                                <thead>
                                    <tr>
                                        <th scope="col" class="product-remove"></th>
                                        <th scope="col" class="product-thumbnail">Ürün</th>
                                        <th scope="col" class="product-title"></th>
                                        <th scope="col" class="product-price">Birim Fiyat</th>
                                        <th scope="col" class="product-quantity">Adet</th>
                                        <th scope="col" class="product-subtotal">Ara Toplam</th>
                                    </tr>
                                </thead>
                                <tbody>
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
                                        <td class="product-remove">
                                            <a href="{{ route('cart_delete_product',$key->id) }}" class="remove-wishlist">
                                                <i class="fal fa-times"></i>
                                            </a>
                                        </td>

                                        {{-- 🔥 RESİM --}}
                                        <td class="product-thumbnail">
                                            <a href="{{ route('product_detail', $key->getProduct->slug . '-' . $key->getProduct->product_token) }}">
                                                @if($firstVariant && $firstVariant->variant_image)
                                                    <img src="/upload/product/{{ $firstVariant->variant_image }}"
                                                         onerror="this.src='/extra/img/photo.png'">
                                                @else
                                                    <img src="/upload/product/{{ $key->getProduct->image }}"
                                                         onerror="this.src='/extra/img/photo.png'">
                                                @endif
                                            </a>
                                        </td>

                                        {{-- 🔥 BAŞLIK + VARYANTLAR --}}
                                        <td class="product-title">
                                            <a style="font-size: 14px"
                                               href="{{ route('product_detail', $key->getProduct->slug . '-' . $key->getProduct->product_token) }}">

                                                {{ $key->getProduct->title }}

                                                {{-- 🔥 TÜM VARYANTLARI GÖSTER --}}
                                                @if($variants->count())
                                                    <br>
                                                    @foreach($variants as $v)
                                                        <span style="font-size:12px; display:block;">
                                                            {{ $v->variant_type }}: {{ $v->variant_name }}
                                                        </span>
                                                    @endforeach
                                                @endif

                                                {{-- COUPON --}}
                                                @if($key->coupon != null)
                                                    <br>
                                                    {{ $key->getCoupon->coupon_code }}
                                                @endif
                                            </a>
                                        </td>

                                        {{-- FİYAT --}}
                                        <td class="product-price" style="font-size: 14px">
                                            {{ number_format($unitPrice,2) }} TL
                                        </td>

                                        {{-- ADET --}}
                                        <td class="product-quantity">
                                            @if($key->coupon != null)
                                                <div>
                                                    <i style="font-size: 14px">{{ $key->quantity }}</i>
                                                </div>
                                            @else
                                                <div>
                                                    <a href="{{ route('cart_decrease',$key->id) }}"><span class="dec qtybtn">-</span></a>
                                                    <i style="font-size: 14px">{{ $key->quantity }}</i>
                                                    <a href="{{ route('cart_increase',$key->id) }}"><span class="inc qtybtn">+</span></a>
                                                </div>
                                            @endif
                                        </td>

                                        {{-- TOPLAM --}}
                                        <td class="product-subtotal" style="font-size: 14px">
                                            {{ number_format($key->total,2) }} TL
                                        </td>
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                            @else
                            <div class="text-center">
                                <img src="/extra/img/empty-cart.png" class="img-fluid" width="100" alt="Sepet boş">
                                <h5>Sepetiniz Boş!</h5>
                            </div>
                            @endif

                        </div>
                    </div>


                    <div class="col-md-4 ">
                        <div class="axil-order-summery">
                            <h5 class="title mb--20">Sipariş Detayları</h5>

                            <div class="mb-3">
                                <form action="{{ route('cart_apply_coupon') }}" method="POST">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" name="coupon" class="form-control" placeholder="Sepet kupon kodu">
                                        <button type="submit" class="btn btn-primary">Uygula</button>
                                    </div>
                                </form>
                            </div>

                            @if($cartCoupon)
                            <div class="alert alert-success py-2">
                                <div><strong>Aktif Kupon:</strong> {{ $cartCoupon->coupon_code }}</div>
                                <div><small>{{ $cartCoupon->type_label }} - {{ $cartCoupon->coupon_ratio }}{{ $cartCoupon->discount_type === 'percent' ? '%' : ' TL' }}</small></div>
                                <form action="{{ route('cart_remove_coupon') }}" method="POST" class="mt-2">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Kuponu Kaldır</button>
                                </form>
                            </div>
                            @endif

                            <div class="summery-table-wrap">
                                <table class="table summery-table mb--30">
                                    <tbody>
                                        <tr class="order-subtotal">
                                            <td>Ara Toplam</td>
                                            <td>{{ number_format($subTotal,2) }} TL</td>
                                        </tr>
                                        @if($setting->free_cargo > $grandTotal)

                                        <tr>
                                            <td>Kargo</td>
                                            <td>Ücretsiz</td>
                                        </tr>
                                        @else
                                            <tr>
                                                <td>Kargo</td>
                                                <td>Ücretli</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td>Sepet Kupon İndirimi</td>
                                            <td>-{{ number_format($cartDiscount,2) }} TL</td>
                                        </tr>
                                        <tr class="order-total">
                                            <td>Toplam</td>
                                            <td class="order-total-amount">{{ number_format($grandTotal,2) }} TL</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            @if($data->isNotEmpty())
                            <form action="{{ route('cart_approval') }}" method="POST">
                                @csrf
                                <button type="submit" class="axil-btn btn-bg-primary checkout-btn">Sepeti Onayla</button>
                            </form>
                            @else
                            <button type="button" class="axil-btn btn-bg-primary checkout-btn" disabled>Sepetiniz Boş!</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Cart Area  -->

</main>
@endsection
