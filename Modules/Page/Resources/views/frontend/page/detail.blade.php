@extends('page::frontend.layout.master')
@section('meta_title'){{ $data->meta_title }}@endsection
@section('meta_desc'){{ $data->meta_desc }}@endsection
@section('meta_keyw'){{ $data->meta_keyw }}@endsection
@section('content')

<main class="main-wrapper">
    <!-- Start Breadcrumb Area  -->
    <div class="axil-breadcrumb-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-8">
                    <div class="inner">
                        <ul class="axil-breadcrumb">
                            <li class="axil-breadcrumb-item"><a href="{{ route('home_index') }}">Anasayfa</a></li>
                            <li class="separator"></li>
                            <li class="axil-breadcrumb-item active" aria-current="page">{{ $data->page_title }}</li>
                        </ul>
                        <h1 class="title">{{ $data->page_title }}</h1>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- End Breadcrumb Area  -->

    <!-- Start About Area  -->
    <div class="axil-about-area about-style-1 axil-section-gap ">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-12 col-lg-12">
                    <div class="about-content content-right">

                        <div class="row">
                            <div class="col-xl-12">
                                {!! $data->page_desc !!}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End About Area  -->

@if($data->id == 1)
    <!-- Start Testimonila Area  -->
    <div class="axil-testimoial-area axil-section-gap bg-vista-white mb-5">
        <div class="container">
            <div class="section-title-wrapper">
                <span class="title-highlighter highlighter-secondary"> <i class="fal fa-quote-left"></i>Yorumlar</span>
                <h2 class="title">Müşterilerimizin Memnuniyet Yorumları</h2>
            </div>
            <!-- End .section-title -->
            <div class="testimonial-slick-activation testimonial-style-one-wrapper slick-layout-wrapper--20 axil-slick-arrow arrow-top-slide">
               @foreach (\App\Models\Customers::all() as $key)
                <div class="slick-single-layout testimonial-style-one">
                    <div class="review-speech">
                        <p>“ {{$key->comment}} “</p>
                    </div>
                    <div class="media">
                        <div class="thumbnail">
                            <img src="/upload/customer/{{ $key->image }}" onerror="this.src='/extra/img/photo.png'" class="img-fluid" width="48" alt="softby customer">
                        </div>
                        <div class="media-body">
                            <span class="designation">{{ $key->role }}</span>
                            <h6 class="title">{{ $key->name_surname }}</h6>
                        </div>
                    </div>
                    <!-- End .thumbnail -->
                </div>
                @endforeach

            </div>
        </div>
    </div>
    <!-- End Testimonila Area  -->
@endif


</main>

@endsection
