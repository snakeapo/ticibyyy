@extends('page::frontend.layout.master')
@section('content')
    <nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home_index') }}">Anasayfa</a></li>
            <li class="breadcrumb-item active" aria-current="page">İletişim</li>
        </ol>
    </nav>
    <!-- Contact forms -->
    <section class="bg-body-tertiary pb-1 pb-sm-3 pb-md-4 pb-lg-5" style="margin-top: -110px; padding-top: 110px">
        <div class="container py-5 mb-xxl-3">

            <!-- Page title -->
            <h1 class="text-center pb-2 pb-sm-3 mt-lg-3 mt-xl-4">Bizimle iletişime geçin</h1>


            <!-- Forms wrapper -->
            <div class="row justify-content-center">
                <div class="col-md-11 col-lg-9 col-xl-8">
                    <div class="tab-content bg-body rounded-5 py-3 py-sm-4 px-4 px-sm-5">
                        <p class="text-center py-3 mx-auto" style="max-width: 450px">Formu doldurup gönderdiğinizde en kısa sürede sizinle tekrar iletişime geçeceğiz.</p>

                        <!-- Customers form -->
                        <div class="tab-pane fade show active" id="customers" role="tabpanel" aria-labelledby="customers-tab">
                            <form class="needs-validation" action="{{ route('contact_post') }}" method="POST">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-md-6 position-relative">
                                        <label for="fn" class="form-label">Adınız *</label>
                                        <input type="text" name="name" class="form-control form-control-lg rounded-pill" id="fn" required>
                                    </div>
                                    <div class="col-md-6 position-relative">
                                        <label for="ln" class="form-label">Soyadınız *</label>
                                        <input type="text" name="surname" class="form-control form-control-lg rounded-pill" id="ln" required>
                                    </div>
                                    <div class="col-md-6 position-relative">
                                        <label for="email" class="form-label">Email *</label>
                                        <input type="email" name="email" class="form-control form-control-lg rounded-pill" id="email" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Telefon *</label>
                                        <input type="number" name="phone" class="form-control form-control-lg rounded-pill" id="phone"  placeholder="+90 ___ ___ __ __">
                                    </div>

                                    <div class="col-12 position-relative">
                                        <label for="message" class="form-label">Mesajınız *</label>
                                        <textarea class="form-control form-control-lg rounded-6" id="message" name="message" rows="5" required></textarea>
                                    </div>
                                    <div class="col-12 text-center pt-2 pb-3">
                                        <button type="submit" class="btn btn-lg btn-dark rounded-pill">Mesajı gönder</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Retailers form -->
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="container pt-5 mt-xxl-3">
        <div class="row row-cols-1 row-cols-sm-3 gy-4 gy-sm-0 pt-1 pt-sm-2 pt-md-3 pt-lg-4 pt-xl-5">
            <div class="col text-center mb-2 mb-sm-0">
                <i class="ci-phone-outgoing bg-dark text-white fs-4 rounded-circle p-3 mb-3 d-inline-flex d-none-dark"></i>
                <i class="ci-phone-outgoing bg-body-secondary text-white fs-4 rounded-circle p-3 mb-3 d-none d-inline-flex-dark"></i>
                <h3 class="text-body fs-sm fw-normal mb-2">Telefon</h3>
                <div class="nav animate-underline justify-content-center">
                    <a class="nav-link animate-target text-dark-emphasis fs-base p-0" href="tel:{{ $setting->phone }}">{{ $setting->phone }}</a>
                </div>
            </div>
            <div class="col text-center mb-2 mb-sm-0">
                <i class="ci-mail bg-dark text-white fs-4 rounded-circle p-3 mb-3 d-inline-flex d-none-dark"></i>
                <i class="ci-mail bg-body-secondary text-white fs-4 rounded-circle p-3 mb-3 d-none d-inline-flex-dark"></i>
                <h3 class="text-body fs-sm fw-normal mb-2">Email</h3>
                <div class="nav animate-underline justify-content-center">
                    <a class="nav-link animate-target text-dark-emphasis fs-base p-0" href="mailto:{{ $setting->mail_address }}">{{ $setting->mail_address }}</a>
                </div>
            </div>
            <div class="col text-center">
                <i class="ci-whatsapp bg-dark text-white fs-4 rounded-circle p-3 mb-3 d-inline-flex d-none-dark"></i>
                <i class="ci-whatsapp bg-body-secondary text-white fs-4 rounded-circle p-3 mb-3 d-none d-inline-flex-dark"></i>
                <h3 class="text-body fs-sm fw-normal mb-2">WhatsApp</h3>
                <div class="nav animate-underline justify-content-center">
                    <a class="nav-link animate-target text-dark-emphasis fs-base p-0" href="#!">{{ $setting->whatsapp }}</a>
                </div>
            </div>
        </div>
    </section>


    <!-- Store locations + Map in lightbox -->
    <section class="container py-1 py-sm-2 py-md-3 py-lg-4 py-xl-5 my-xxl-3">
        <div class="row row-cols-1 row-cols-md-2 g-0 overflow-hidden rounded-5 my-5">

            <!-- Map -->
            <div class="col position-relative">
                <div class="ratio ratio-4x3"></div>
                <img src="{{ asset('frontend/assets/img/about/v1/hero.jpg') }}" class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover" alt="Image">
            </div>

            <!-- Contact details -->
            <div class="col bg-body-tertiary order-md-1 py-5 px-4 px-xl-5">
                <div class="py-md-4 py-lg-5 px-md-4 px-lg-5">
                    <h1 class="pb-2 pb-sm-3 pb-lg-0 mb-md-4 mb-lg-5">Ofisimiz</h1>
                    <ul class="list-unstyled pb-sm-2 mb-0">
                        <li class="lh-lg">{{ $setting->address }}</li>

                    </ul>

                </div>
            </div>
        </div>
    </section>


@endsection
