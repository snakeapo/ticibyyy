@extends('page::frontend.layout.master')
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
                            <li class="axil-breadcrumb-item active" aria-current="page">İletişim</li>
                        </ul>
                        <h1 class="title">İletişim</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb Area  -->

    <!-- Start Contact Area  -->
    <div class="axil-contact-page-area axil-section-gap">
        <div class="container">
            <div class="axil-contact-page">
                <div class="row row--30">
                    <div class="col-lg-8">
                        <div class="contact-form">
                            <h3 class="title mb--10">Sizden mesaj almayı çok isteriz.</h3>
                            <p>Yaptığınız veya bizimle çalışmak istediğiniz harika ürünleriniz varsa bize bir telefon bırakın.</p>
                            <form method="POST" action="{{ route('contact_post') }}" class="">
                              @csrf
                                <div class="row row--10">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="contact-name">Adınız <span>*</span></label>
                                            <input type="text" required name="name" value="{{ old('name') }}" id="contact-name">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="contact-name">Soyadınız <span>*</span></label>
                                            <input type="text" required name="surname" value="{{ old('surname') }}" id="contact-name">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="contact-phone">Telefon <span>*</span></label>
                                            <input type="text" required name="phone" value="{{ old('phone') }}" id="contact-phone">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="contact-email">E-mail <span>*</span></label>
                                            <input type="email" required name="email" value="{{ old('email') }}" id="contact-email">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="contact-message">Mesajınız</label>
                                            <textarea name="message" required id="contact-message" cols="1" rows="2">{{ old('message') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb--0">
                                            <button type="submit" class="axil-btn btn-bg-primary">Mesajı Gönderin</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="contact-location mb--40">
                            <h4 class="title mb--20">İletişim Bilgileri</h4>
                            <span class="address mb--20">{{ $setting->address }}</span>
                            <span class="phone">Telefon: {{ $setting->phone }}</span>
                            <span class="phone">WhatsApp: {{ $setting->whatsapp }}</span>
                            <span class="email">Email: {{ $setting->mail_address }}</span>
                        </div>
                        <div class="contact-career mb--40">
                            <img src="/extra/img/message.jpg" width="300" class="img-fluid" alt="">
                        </div>

                    </div>
                </div>
            </div>
            <!-- Start Google Map Area  -->
            <div class="axil-google-map-wrap axil-section-gap pb--0">
                <div class="mapouter">
                    <div class="gmap_canvas">
                        <iframe width="1080" height="500" id="gmap_canvas" src="{{ $setting->google_maps }}"></iframe>
                    </div>
                </div>
            </div>
            <!-- End Google Map Area  -->
        </div>
    </div>
    <!-- End Contact Area  -->
</main>
@endsection
