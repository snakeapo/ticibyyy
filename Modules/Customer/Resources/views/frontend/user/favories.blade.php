@extends('page::frontend.layout.master')
@section('content')
<main class="main-wrapper">

    <!-- Start Wishlist Area  -->
    <div class="axil-wishlist-area axil-section-gap">
        <div class="container">
            <div class="product-table-heading">
                <h4 class="title">Favori Ürünlerim</h4>
            </div>
            <div class="table-responsive">
                <table class="table axil-product-table axil-wishlist-table">
                    <thead>
                        <tr>
                            <th scope="col" class="product-remove"></th>
                            <th scope="col" class="product-thumbnail">Ürün</th>
                            <th scope="col" class="product-title"></th>
                            <th scope="col" class="product-price">Fiyat</th>
                            <th scope="col" class="product-stock-status">Stok</th>
                            <th scope="col" class="product-add-cart"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (\App\Models\Favories::where('user_id',Auth::user()->id)->get() as $key)
                        <tr>
                            <td class="product-remove"><a href="{{ route('favories_delete',$key->id) }}" class="remove-wishlist"><i class="fal fa-times"></i></a></td>
                            <td class="product-thumbnail"><a href="{{ route('product_detail', $key->getProduct->slug . '-' . $key->getProduct->product_token) }}"><img src="/upload/product/{{ $key->getProduct->image }}" onerror="this.src='/extra/img/photo.png'" alt="{{ $key->title }}"></a></td>
                            <td class="product-title"><a href="{{ route('product_detail', $key->getProduct->slug . '-' . $key->getProduct->product_token) }}">{{ $key->getProduct->title }}</a></td>
                            <td class="product-price" data-title="Price">{{ number_format($key->getProduct->price,2) }} TL</td>
                            <td class="product-stock-status" data-title="Status">@if($key->getProduct->stock > 1) Stokta Var @else Stokta Yok @endif</td>
                            <td class="product-add-cart"><a href="{{ route('product_detail', $key->getProduct->slug . '-' . $key->getProduct->product_token) }}" class="axil-btn btn-outline">Ürünü Gör</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- End Wishlist Area  -->
</main>
@endsection
