@extends('page::frontend.layout.master')
@section('content')
<main class="main-wrapper">

    <!-- Start Cart Area  -->
    <div class="axil-product-cart-area axil-section-gap">
        <div class="container">
            <div class="axil-product-cart-wrap">
                <div class="row">
                    <div class="col-md-12">
                        <div class="product-table-heading">
                            <h4 class="title">Ödeme İşlemi</h4>
                        </div>
                        <iframe src="https://www.paytr.com/odeme/guvenli/{{$token}}" id="paytriframe" frameborder="0" scrolling="no" style="width: 100%;"></iframe>

                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- End Cart Area  -->

</main>
@section('js')
<script src="https://www.paytr.com/js/iframeResizer.min.js"></script>

<script>iFrameResize({},'#paytriframe');</script>
@endsection
@endsection
