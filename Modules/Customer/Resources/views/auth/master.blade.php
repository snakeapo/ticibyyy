<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}" data-bs-theme="light" data-pwa="true">
<head>
    <meta charset="utf-8">

    <!-- Viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover">

    <!-- SEO Meta Tags -->
    <title>@yield('meta_title',$setting->meta_title)</title>
    <meta name="description" content="@yield('meta_desc',$setting->meta_desc)">
    <meta name="keywords" content="@yield('meta_keyw',$setting->meta_keyw)">
    <meta name="author" content="Ticiby">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="/upload/setting/{{ $setting->favicon }}">
    <script src="{{ asset('other/notyf/notyf.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('other/notyf/notyf.min.css') }}">
    <!-- Vector Maps css -->
    <!-- Theme switcher (color modes) -->
    <script src="{{ asset('/frontend/assets/js/theme-switcher.js') }}"></script>

    <!-- Preloaded local web font (Inter) -->
    <link rel="preload" href="{{ asset('/frontend/assets/fonts/inter-variable-latin.woff2') }} as="font" type="font/woff2" crossorigin>

    <!-- Font icons -->
    <link rel="preload" href="{{ asset('/frontend/assets/icons/cartzilla-icons.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="{{ asset('/frontend/assets/icons/cartzilla-icons.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- Vendor styles -->
    <link rel="stylesheet" href="{{ asset('/frontend/assets/vendor/swiper/swiper-bundle.min.css') }}">

    <!-- Bootstrap + Theme styles -->
    <link rel="preload" href="{{ asset('/frontend/assets/css/theme.min.css') }}" as="style">
    <link rel="preload" href="{{ asset('/frontend/assets/css/theme.rtl.min.css') }}" as="style">
    <link rel="stylesheet" href="{{ asset('/frontend/assets/css/theme.min.css') }}" id="theme-styles">


</head>


<!-- Body -->
<body>


<!-- Page content -->
<main class="content-wrapper w-100 px-3 ps-lg-5 pe-lg-4 mx-auto" style="max-width: 1920px">
    <div class="d-lg-flex">

        <!-- Login form + Footer -->
        <div class="d-flex flex-column min-vh-100 w-100 py-4 mx-auto me-lg-5" style="max-width: 416px">
            <div class="mb-2 mt-3">
                <a href="{{ route('home_index') }}" class="btn btn-dark btn-sm rounded-7"><i class="bi bi-arrow-left-short"></i> Geri dön</a>
            </div>
            <!-- Logo -->
            <header class="navbar px-0 pb-4 mt-n2 mt-sm-0 mb-2 mb-md-3 mb-lg-4">

                <a href="{{ route('home_index') }}" class="navbar-brand pt-0">
                    <img src="{{ asset('upload/setting/'.$setting->logo) }}" class="img-fluid" style="width: 180px" alt="">
                </a>
            </header>

            @yield('content')

            <!-- Divider -->
            <div class="d-flex align-items-center my-4">
                <hr class="w-100 m-0">
                <span class="text-body-emphasis fw-medium text-nowrap mx-4">veya şunlarla devam et</span>
                <hr class="w-100 m-0">
            </div>

            <!-- Social login -->
            <div class="d-flex flex-column flex-sm-row gap-3 pb-4 mb-3 mb-lg-4">
                <a href="{{ route('social.redirect', ['provider' => 'google']) }}" class="btn btn-lg btn-outline-secondary w-100 px-2">
                    <i class="ci-google ms-1 me-1"></i>
                    Google
                </a>
                <a href="{{ route('social.redirect', ['provider' => 'facebook']) }}" class="btn btn-lg btn-outline-secondary w-100 px-2">
                    <i class="ci-facebook ms-1 me-1"></i>
                    Facebook
                </a>
            </div>

            <!-- Footer -->
            <footer class="mt-auto">
                <div class="nav mb-4">
                    <a class="nav-link text-decoration-underline p-0" href="#">Yardıma ihtiyacım var</a>
                </div>
                <p class="fs-xs mb-0">
                    &copy; Tüm hakları saklıdır. Powered by <span class="animate-underline"><a class="animate-target text-dark-emphasis text-decoration-none" href="https://ticiby.com/" target="_blank" rel="noreferrer">Ticiby</a></span>
                </p>
            </footer>
        </div>

        <div class="offcanvas-lg offcanvas-end w-100 py-lg-4 ms-auto" id="benefits" style="max-width: 1034px">
            <div class="offcanvas-header justify-content-end position-relative z-2 p-3">
                <button type="button" class="btn btn-icon btn-outline-dark text-dark border-dark bg-transparent rounded-circle d-none-dark" data-bs-dismiss="offcanvas" data-bs-target="#benefits" aria-label="Close">
                    <i class="ci-close fs-lg"></i>
                </button>
                <button type="button" class="btn btn-icon btn-outline-dark text-light border-light bg-transparent rounded-circle d-none d-inline-flex-dark" data-bs-dismiss="offcanvas" data-bs-target="#benefits" aria-label="Close">
                    <i class="ci-close fs-lg"></i>
                </button>
            </div>
            <div class="position-absolute top-0 start-0 w-100 h-100 d-lg-none">
                <span class="position-absolute top-0 start-0 w-100 h-100 d-none-dark" style="background: linear-gradient(-90deg, #accbee 0%, #e7f0fd 100%)"></span>
                <span class="position-absolute top-0 start-0 w-100 h-100 d-none d-block-dark" style="background: linear-gradient(-90deg, #1b273a 0%, #1f2632 100%)"></span>
            </div>
            <div class="offcanvas-body position-relative z-2 d-lg-flex flex-column align-items-center justify-content-center h-100 pt-2 px-3 p-lg-0">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-none d-lg-block">
                    <span class="position-absolute top-0 start-0 w-100 h-100 rounded-5 d-none-dark" style="background: linear-gradient(-90deg, #accbee 0%, #e7f0fd 100%)"></span>
                    <span class="position-absolute top-0 start-0 w-100 h-100 rounded-5 d-none d-block-dark" style="background: linear-gradient(-90deg, #1b273a 0%, #1f2632 100%)"></span>
                </div>
                <div class="position-relative z-2 w-100 text-center px-md-2 p-lg-5">
                    <h2 class="h4 pb-3">{{ env('APP_NAME') }} avantajlarını keşfedin</h2>
                    <div class="mx-auto" style="max-width: 790px">
                        <div class="row row-cols-1 row-cols-sm-2 g-3 g-md-4 g-lg-3 g-xl-4">
                            @forelse(($authInfoCards ?? collect()) as $card)
                                <div class="col">
                                    <div class="card h-100 bg-transparent border-0">
                                        <span class="position-absolute top-0 start-0 w-100 h-100 bg-white bg-opacity-25 border border-white border-opacity-50 rounded-4 d-none-dark"></span>
                                        <span class="position-absolute top-0 start-0 w-100 h-100 bg-white border rounded-4 d-none d-block-dark" style="--cz-bg-opacity: .05"></span>
                                        <div class="card-body position-relative z-2">
                                            <div class="d-inline-flex position-relative text-info p-3">
                                                <span class="position-absolute top-0 start-0 w-100 h-100 bg-white rounded-pill d-none-dark"></span>
                                                <span class="position-absolute top-0 start-0 w-100 h-100 bg-body-secondary rounded-pill d-none d-block-dark"></span>
                                                <img src="{{ asset('upload/auth-info-card/'.$card->image) }}" class="position-relative z-2" style="width: 32px; height: 32px; object-fit: contain;" alt="{{ $card->title }}">
                                            </div>
                                            <h3 class="h6 pt-2 my-2">{{ $card->title }}</h3>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col">
                                    <div class="card h-100 bg-transparent border-0">
                                        <span class="position-absolute top-0 start-0 w-100 h-100 bg-white bg-opacity-25 border border-white border-opacity-50 rounded-4 d-none-dark"></span>
                                        <span class="position-absolute top-0 start-0 w-100 h-100 bg-white border rounded-4 d-none d-block-dark" style="--cz-bg-opacity: .05"></span>
                                        <div class="card-body position-relative z-2">
                                            <h3 class="h6 pt-2 my-2">Bilgi kartı eklemek için yönetim panelinden ayar yapın.</h3>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Benefits section that turns into offcanvas on screens < 992px wide (lg breakpoint) -->
    </div>
</main>


<script>
    const notyf = new Notyf({
        duration: 3000,
        position: {x: "right", y: "top"},
        dismissible: true
    });
    @if(Session::has('success'))
    notyf.success("{{ Session::get('success') }}");
    @endif
    @if(Session::has('error'))
    notyf.error("{{ Session::get('error') }}");
    @endif
    @if(Session::has('warning'))
    notyf.warning("{{ Session::get('warning') }}");
    @endif
    @if($errors->any())
    @foreach($errors->all() as $error)
    notyf.error("{{ $error }}");
    @endforeach
    @endif
</script>
<!-- Vendor scripts -->
<script src="{{ asset('/frontend/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

<!-- Bootstrap + Theme scripts -->
<script src="{{ asset('/frontend/assets/js/theme.min.js') }}"></script>

</body>
</html>
