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
                                        $basePrice = $key->getProduct->sale_price != 0 ? (float) $key->getProduct->sale_price : (float) $key->getProduct->price;
                                        $variantPrice = $key->getVariant ? (float) $key->getVariant->variant_price : 0;
                                        $unitPrice = $basePrice + $variantPrice;
                                    @endphp
                                    <tr>
                                        <td class="product-remove"><a href="{{ route('cart_delete_product',$key->id) }}" class="remove-wishlist" aria-label="Ürünü sepetten kaldır"><i class="fal fa-times"></i></a></td>
                                        @if($key->getVariant)
                                        <td class="product-thumbnail"><a href="{{ route('product_detail', $key->getProduct->slug . '-' . $key->getProduct->product_token) }}"><img src="/upload/product/{{ $key->getVariant->variant_image }}" onerror="this.src='/extra/img/photo.png'" alt="{{ $key->getVariant->variant_name }}"></a></td>
                                        @else
                                        <td class="product-thumbnail"><a href="{{ route('product_detail', $key->getProduct->slug . '-' . $key->getProduct->product_token) }}"><img src="/upload/product/{{ $key->getProduct->image }}" onerror="this.src='/extra/img/photo.png'" alt="{{ $key->getProduct->title }}"></a></td>
                                        @endif
                                        <td class="product-title">
                                            <a style="font-size: 14px" href="{{ route('product_detail', $key->getProduct->slug . '-' . $key->getProduct->product_token) }}">{{ $key->getProduct->title }}
                                                @if($key->getVariant)
                                                <br>
                                                {{ $key->getVariant->variant_name }}
                                                @endif

                                                @if($key->coupon != null)
                                                <br>
                                                {{ $key->getCoupon->coupon_code }}
                                                @endif
                                            </a>
                                        </td>
                                        <td class="product-price" style="font-size: 14px" data-title="Price">{{ number_format($unitPrice,2) }} TL</td>
                                        <td class="product-quantity" data-title="Qty">
                                            @if($key->coupon != null)
                                            <div class="">
                                                <i style="font-size: 14px">{{ $key->quantity }}</i>
                                            </div>
                                            @else
                                            <div class="">
                                                <a href="{{ route('cart_decrease',$key->id) }}" aria-label="Adedi azalt"><span class="dec qtybtn">-</span></a>
                                                <i style="font-size: 14px">{{ $key->quantity }}</i>
                                                <a href="{{ route('cart_increase',$key->id) }}" aria-label="Adedi artır"><span class="inc qtybtn">+</span></a>
                                            </div>
                                            @endif
                                        </td>
                                        <td class="product-subtotal" style="font-size: 14px" data-title="Subtotal">{{ number_format($key->total,2) }} TL</td>
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
