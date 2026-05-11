@extends('page::frontend.layout.master')
@section('content')

    <!-- Hero slider -->
    <section class="container pt-4">
        <div class="row">
            <div class="col-lg-9 offset-lg-3">
                <div class="position-relative">
                    <span class="position-absolute top-0 start-0 w-100 h-100 rounded-5 d-none-dark rtl-flip" style="background: linear-gradient(90deg, #accbee 0%, #e7f0fd 100%)"></span>
                    <span class="position-absolute top-0 start-0 w-100 h-100 rounded-5 d-none d-block-dark rtl-flip" style="background: linear-gradient(90deg, #1b273a 0%, #1f2632 100%)"></span>
                    <div class="row justify-content-center position-relative z-2">
                        <div class="col-xl-5 col-xxl-4 offset-xxl-1 d-flex align-items-center mt-xl-n3">

                            <!-- Text content master slider -->
                            <div class="swiper px-5 pe-xl-0 ps-xxl-0 me-xl-n5" data-swiper='{
                    "spaceBetween": 64,
                    "loop": true,
                    "speed": 400,
                    "controlSlider": "#sliderImages",
                    "autoplay": {
                      "delay": 5500,
                      "disableOnInteraction": false
                    },
                    "scrollbar": {
                      "el": ".swiper-scrollbar"
                    }
                  }'>
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide text-center text-xl-start pt-5 py-xl-5">
                                        <p class="text-body">Feel the real quality sound</p>
                                        <h2 class="display-4 pb-2 pb-xl-4">Headphones ProMax</h2>
                                        <a class="btn btn-lg btn-primary" href="shop-product-general-electronics.html">
                                            Shop now
                                            <i class="ci-arrow-up-right fs-lg ms-2 me-n1"></i>
                                        </a>
                                    </div>
                                    <div class="swiper-slide text-center text-xl-start pt-5 py-xl-5">
                                        <p class="text-body">Deal of the week</p>
                                        <h2 class="display-4 pb-2 pb-xl-4">Powerful iPad Pro M2</h2>
                                        <a class="btn btn-lg btn-primary" href="shop-product-general-electronics.html">
                                            Shop now
                                            <i class="ci-arrow-up-right fs-lg ms-2 me-n1"></i>
                                        </a>
                                    </div>
                                    <div class="swiper-slide text-center text-xl-start pt-5 py-xl-5">
                                        <p class="text-body">Virtual reality glasses</p>
                                        <h2 class="display-4 pb-2 pb-xl-4">Experience New Reality</h2>
                                        <a class="btn btn-lg btn-primary" href="shop-catalog-electronics.html">
                                            Shop now
                                            <i class="ci-arrow-up-right fs-lg ms-2 me-n1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-9 col-sm-7 col-md-6 col-lg-5 col-xl-7">

                            <!-- Binded images (controlled slider) -->
                            <div class="swiper user-select-none" id="sliderImages" data-swiper='{
                                    "allowTouchMove": false,
                                    "loop": true,
                                    "effect": "fade",
                                    "fadeEffect": {
                                      "crossFade": true
                                    }
                                  }'>
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide d-flex justify-content-end">
                                        <div class="ratio rtl-flip" style="max-width: 495px; --cz-aspect-ratio: calc(537 / 495 * 100%)">
                                            <img src="{{ asset('frontend/assets/img/home/electronics/hero-slider/01.png') }}" alt="Image">
                                        </div>
                                    </div>
                                    <div class="swiper-slide d-flex justify-content-end">
                                        <div class="ratio rtl-flip" style="max-width: 495px; --cz-aspect-ratio: calc(537 / 495 * 100%)">
                                            <img src="{{ asset('frontend/assets/img/home/electronics/hero-slider/02.png') }}" alt="Image">
                                        </div>
                                    </div>
                                    <div class="swiper-slide d-flex justify-content-end">
                                        <div class="ratio rtl-flip" style="max-width: 495px; --cz-aspect-ratio: calc(537 / 495 * 100%)">
                                            <img src="{{ asset('frontend/assets/img/home/electronics/hero-slider/03.png') }}" alt="Image">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Scrollbar -->
                    <div class="row justify-content-center" data-bs-theme="dark">
                        <div class="col-xxl-10">
                            <div class="position-relative mx-5 mx-xxl-0">
                                <div class="swiper-scrollbar mb-4"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>







    <!-- Trending products (Grid) -->
    <section class="container pt-5 mt-2 mt-sm-3 mt-lg-4">

        <!-- Heading -->
        <div class="d-flex align-items-center justify-content-between border-bottom pb-3 pb-md-4">
            <h2 class="h3 mb-0">Öne çıkan ürünler</h2>

        </div>

        <!-- Product grid -->
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4 pt-4">
        @foreach($trendProduct as $take)
                @include('page::frontend.product.card')

        @endforeach


        </div>
    </section>






    <!-- Brands -->
    <section class="container pt-4 pt-md-5 pb-5 mt-sm-2 mb-2 mb-sm-3 mb-md-4 mb-lg-5">
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-3 g-md-4 g-lg-3 g-xl-4">
            @foreach($brand as $key)
                <div class="col">
                    <a class="btn btn-outline-secondary w-100 rounded-4 p-3" href="{{ route('brand_detail',$key->brand_slug) }}">
                        <img src="{{ asset('upload/brand/'.$key->brand_image) }}" class="d-none-dark" alt="Apple">
                    </a>
                </div>
            @endforeach

            <div class="col">
                <a class="btn btn-outline-secondary w-100 h-100 rounded-4 p-3" href="{{ route('all_brand') }}">
                    Tüm markalar
                    <i class="ci-plus-circle fs-base ms-2"></i>
                </a>
            </div>
        </div>
    </section>
    <!-- Trending products (Grid) -->
    <section class="container pt-5 mt-2 mt-sm-3 mt-lg-4">

        <!-- Heading -->
        <div class="d-flex align-items-center justify-content-between border-bottom pb-3 pb-md-4">
            <h2 class="h3 mb-0">Bizim seçimlerimiz</h2>

        </div>

        <!-- Product grid -->
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4 pt-4">
            @foreach($ourProduct as $take)
                @include('page::frontend.product.card')

            @endforeach


        </div>
    </section>

    <!-- Features -->
    <section class="container pt-5 mt-1 mt-sm-3 mt-lg-4 mb-5">
        <div class="row row-cols-2 row-cols-md-4 g-4">
            @foreach ($info as $key)
                <!-- Item -->
                <div class="col">
                    <div class="d-flex flex-column flex-xxl-row align-items-center">
                        <div class="d-flex text-dark-emphasis bg-body-tertiary rounded-circle p-4 mb-3 mb-xxl-0">
                            <img src="/upload/info/{{ $key->image }}" width="32px" alt="{{$key->title}}">
                        </div>
                        <div class="text-center text-xxl-start ps-xxl-3">
                            <h3 class="h6 mb-1">{{ $key->title }}</h3>
                            <p class="fs-sm mb-0">{{ $key->description }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

@endsection
