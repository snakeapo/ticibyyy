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

    <!-- Vendor styles -->
    <link rel="stylesheet" href="{{ asset('/frontend/assets/vendor/swiper/swiper-bundle.min.css') }}">
    @yield('css')
    <!-- Bootstrap + Theme styles -->
    <link rel="preload" href="{{ asset('/frontend/assets/css/theme.min.css') }}" as="style">
    <link rel="preload" href="{{ asset('/frontend/assets/css/theme.rtl.min.css') }}" as="style">
    <link rel="stylesheet" href="{{ asset('/frontend/assets/css/theme.min.css') }}" id="theme-styles">
    <link rel="stylesheet" href="{{ asset('other/custom.css') }}">

</head>


<!-- Body -->
<body>


<!-- Shopping cart offcanvas -->
<div class="offcanvas offcanvas-end pb-sm-2 px-sm-2" id="shoppingCart" tabindex="-1" aria-labelledby="shoppingCartLabel" style="width: 500px">

    <!-- Header -->
    <div class="offcanvas-header flex-column align-items-start py-3 pt-lg-4">
        <div class="d-flex align-items-center justify-content-between w-100 mb-3 mb-lg-4">
            <h4 class="offcanvas-title" id="shoppingCartLabel">Sepetim</h4>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <p class="fs-sm">Buy <span class="text-dark-emphasis fw-semibold">$183</span> more to get <span class="text-dark-emphasis fw-semibold">Free Shipping</span></p>
        <div class="progress w-100" role="progressbar" aria-label="Free shipping progress" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="height: 4px">
            <div class="progress-bar bg-warning rounded-pill" style="width: 75%"></div>
        </div>
    </div>

    <!-- Items -->
    <div class="offcanvas-body d-flex flex-column gap-4 pt-2">

        <!-- Item -->
        <div class="d-flex align-items-center">
            <a class="flex-shrink-0" href="shop-product-general-electronics.html">
                <img src="assets/img/shop/electronics/thumbs/08.png" width="110" alt="iPhone 14">
            </a>
            <div class="w-100 min-w-0 ps-2 ps-sm-3">
                <h5 class="d-flex animate-underline mb-2">
                    <a class="d-block fs-sm fw-medium text-truncate animate-target" href="shop-product-general-electronics.html">Apple iPhone 14 128GB White</a>
                </h5>
                <div class="h6 pb-1 mb-2">$899.00</div>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="count-input rounded-2">
                        <button type="button" class="btn btn-icon btn-sm" data-decrement aria-label="Decrement quantity">
                            <i class="ci-minus"></i>
                        </button>
                        <input type="number" class="form-control form-control-sm" value="1" readonly>
                        <button type="button" class="btn btn-icon btn-sm" data-increment aria-label="Increment quantity">
                            <i class="ci-plus"></i>
                        </button>
                    </div>
                    <button type="button" class="btn-close fs-sm" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-sm" data-bs-title="Remove" aria-label="Remove from cart"></button>
                </div>
            </div>
        </div>

        <!-- Item -->
        <div class="d-flex align-items-center">
            <a class="position-relative flex-shrink-0" href="shop-product-general-electronics.html">
                <span class="badge text-bg-danger position-absolute top-0 start-0">-10%</span>
                <img src="assets/img/shop/electronics/thumbs/09.png" width="110" alt="iPad Pro">
            </a>
            <div class="w-100 min-w-0 ps-2 ps-sm-3">
                <h5 class="d-flex animate-underline mb-2">
                    <a class="d-block fs-sm fw-medium text-truncate animate-target" href="shop-product-general-electronics.html">Tablet Apple iPad Pro M2</a>
                </h5>
                <div class="h6 pb-1 mb-2">$989.00 <del class="text-body-tertiary fs-xs fw-normal">$1,099.00</del></div>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="count-input rounded-2">
                        <button type="button" class="btn btn-icon btn-sm" data-decrement aria-label="Decrement quantity">
                            <i class="ci-minus"></i>
                        </button>
                        <input type="number" class="form-control form-control-sm" value="1" readonly>
                        <button type="button" class="btn btn-icon btn-sm" data-increment aria-label="Increment quantity">
                            <i class="ci-plus"></i>
                        </button>
                    </div>
                    <button type="button" class="btn-close fs-sm" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-sm" data-bs-title="Remove" aria-label="Remove from cart"></button>
                </div>
            </div>
        </div>

        <!-- Item -->
        <div class="d-flex align-items-center">
            <a class="flex-shrink-0" href="shop-product-general-electronics.html">
                <img src="assets/img/shop/electronics/thumbs/01.png" width="110" alt="Smart Watch">
            </a>
            <div class="w-100 min-w-0 ps-2 ps-sm-3">
                <h5 class="d-flex animate-underline mb-2">
                    <a class="d-block fs-sm fw-medium text-truncate animate-target" href="shop-product-general-electronics.html">Smart Watch Series 7, White</a>
                </h5>
                <div class="h6 pb-1 mb-2">$429.00</div>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="count-input rounded-2">
                        <button type="button" class="btn btn-icon btn-sm" data-decrement aria-label="Decrement quantity">
                            <i class="ci-minus"></i>
                        </button>
                        <input type="number" class="form-control form-control-sm" value="1" readonly>
                        <button type="button" class="btn btn-icon btn-sm" data-increment aria-label="Increment quantity">
                            <i class="ci-plus"></i>
                        </button>
                    </div>
                    <button type="button" class="btn-close fs-sm" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-sm" data-bs-title="Remove" aria-label="Remove from cart"></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="offcanvas-header flex-column align-items-start">
        <div class="d-flex align-items-center justify-content-between w-100 mb-3 mb-md-4">
            <span class="text-light-emphasis">Subtotal:</span>
            <span class="h6 mb-0">$2,317.00</span>
        </div>
        <div class="d-flex w-100 gap-3">
            <a class="btn btn-lg btn-secondary w-100" href="checkout-v1-cart.html">View cart</a>
            <a class="btn btn-lg btn-primary w-100" href="checkout-v1-delivery-1.html">Checkout</a>
        </div>
    </div>
</div>


<!-- Navigation bar (Page header) -->
@include('page::frontend.layout.home-header')

<!-- Page content -->
<main class="content-wrapper">

    @yield('content')

</main>


<!-- Page footer -->
<footer class="footer position-relative bg-dark">
    <span class="position-absolute top-0 start-0 w-100 h-100 bg-body d-none d-block-dark"></span>
    <div class="container position-relative z-1 pt-sm-2 pt-md-3 pt-lg-4" data-bs-theme="dark">

        <!-- Columns with links that are turned into accordion on screens < 500px wide (sm breakpoint) -->
        <div class="accordion py-5" id="footerLinks">
            <div class="row">
                <div class="col-md-4 d-sm-flex flex-md-column align-items-center align-items-md-start pb-3 mb-sm-4">
                    <h4 class="mb-sm-0 mb-md-4 me-4">
                        <a class="text-dark-emphasis text-decoration-none" href="index.html">Cartzilla</a>
                    </h4>
                    <p class="text-body fs-sm text-sm-end text-md-start mb-sm-0 mb-md-3 ms-0 ms-sm-auto ms-md-0 me-4">Got questions? Contact us 24/7</p>
                    <div class="dropdown" style="max-width: 250px">
                        <button type="button" class="btn btn-secondary dropdown-toggle justify-content-between w-100" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Help and consultation
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#!">Help center &amp; FAQ</a></li>
                            <li><a class="dropdown-item" href="#!">Support chat</a></li>
                            <li><a class="dropdown-item" href="#!">Open support ticket</a></li>
                            <li><a class="dropdown-item" href="#!">Call center</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row row-cols-1 row-cols-sm-3 gx-3 gx-md-4">
                        <div class="accordion-item col border-0">
                            <h6 class="accordion-header" id="companyHeading">
                                <span class="text-dark-emphasis d-none d-sm-block">Company</span>
                                <button type="button" class="accordion-button collapsed py-3 d-sm-none" data-bs-toggle="collapse" data-bs-target="#companyLinks" aria-expanded="false" aria-controls="companyLinks">Company</button>
                            </h6>
                            <div class="accordion-collapse collapse d-sm-block" id="companyLinks" aria-labelledby="companyHeading" data-bs-parent="#footerLinks">
                                <ul class="nav flex-column gap-2 pt-sm-3 pb-3 mt-n1 mb-1">
                                    <li class="d-flex w-100 pt-1">
                                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">About company</a>
                                    </li>
                                    <li class="d-flex w-100 pt-1">
                                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Our team</a>
                                    </li>
                                    <li class="d-flex w-100 pt-1">
                                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Careers</a>
                                    </li>
                                    <li class="d-flex w-100 pt-1">
                                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Contact us</a>
                                    </li>
                                    <li class="d-flex w-100 pt-1">
                                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">News</a>
                                    </li>
                                </ul>
                            </div>
                            <hr class="d-sm-none my-0">
                        </div>
                        <div class="accordion-item col border-0">
                            <h6 class="accordion-header" id="accountHeading">
                                <span class="text-dark-emphasis d-none d-sm-block">Account</span>
                                <button type="button" class="accordion-button collapsed py-3 d-sm-none" data-bs-toggle="collapse" data-bs-target="#accountLinks" aria-expanded="false" aria-controls="accountLinks">Account</button>
                            </h6>
                            <div class="accordion-collapse collapse d-sm-block" id="accountLinks" aria-labelledby="accountHeading" data-bs-parent="#footerLinks">
                                <ul class="nav flex-column gap-2 pt-sm-3 pb-3 mt-n1 mb-1">
                                    <li class="d-flex w-100 pt-1">
                                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Your account</a>
                                    </li>
                                    <li class="d-flex w-100 pt-1">
                                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Shipping rates &amp; policies</a>
                                    </li>
                                    <li class="d-flex w-100 pt-1">
                                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Refunds &amp; replacements</a>
                                    </li>
                                    <li class="d-flex w-100 pt-1">
                                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Delivery info</a>
                                    </li>
                                    <li class="d-flex w-100 pt-1">
                                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Order tracking</a>
                                    </li>
                                    <li class="d-flex w-100 pt-1">
                                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Taxes &amp; fees</a>
                                    </li>
                                </ul>
                            </div>
                            <hr class="d-sm-none my-0">
                        </div>
                        <div class="accordion-item col border-0">
                            <h6 class="accordion-header" id="customerHeading">
                                <span class="text-dark-emphasis d-none d-sm-block">Customer service</span>
                                <button type="button" class="accordion-button collapsed py-3 d-sm-none" data-bs-toggle="collapse" data-bs-target="#customerLinks" aria-expanded="false" aria-controls="customerLinks">Customer service</button>
                            </h6>
                            <div class="accordion-collapse collapse d-sm-block" id="customerLinks" aria-labelledby="customerHeading" data-bs-parent="#footerLinks">
                                <ul class="nav flex-column gap-2 pt-sm-3 pb-3 mt-n1 mb-1">
                                    <li class="d-flex w-100 pt-1">
                                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Payment methods</a>
                                    </li>
                                    <li class="d-flex w-100 pt-1">
                                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Money back guarantee</a>
                                    </li>
                                    <li class="d-flex w-100 pt-1">
                                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Product returns</a>
                                    </li>
                                    <li class="d-flex w-100 pt-1">
                                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Support center</a>
                                    </li>
                                    <li class="d-flex w-100 pt-1">
                                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Shipping</a>
                                    </li>
                                    <li class="d-flex w-100 pt-1">
                                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Terms &amp; conditions</a>
                                    </li>
                                </ul>
                            </div>
                            <hr class="d-sm-none my-0">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category / tag links -->
        <div class="d-flex flex-column gap-3 pb-3 pb-md-4 pb-lg-5 mt-n2 mt-sm-n4 mt-lg-0 mb-4">
            <ul class="nav align-items-center text-body-tertiary gap-2">
                <li class="animate-underline">
                    <a class="nav-link fw-normal p-0 animate-target" href="#!">Computers</a>
                </li>
                <li class="px-1">/</li>
                <li class="animate-underline">
                    <a class="nav-link fw-normal p-0 animate-target" href="#!">Smartphones</a>
                </li>
                <li class="px-1">/</li>
                <li class="animate-underline">
                    <a class="nav-link fw-normal p-0 animate-target" href="#!">TV, Video</a>
                </li>
                <li class="px-1">/</li>
                <li class="animate-underline">
                    <a class="nav-link fw-normal p-0 animate-target" href="#!">Speakers</a>
                </li>
                <li class="px-1">/</li>
                <li class="animate-underline">
                    <a class="nav-link fw-normal p-0 animate-target" href="#!">Cameras</a>
                </li>
                <li class="px-1">/</li>
                <li class="animate-underline">
                    <a class="nav-link fw-normal p-0 animate-target" href="#!">Printers</a>
                </li>
                <li class="px-1">/</li>
                <li class="animate-underline">
                    <a class="nav-link fw-normal p-0 animate-target" href="#!">Video Games</a>
                </li>
                <li class="px-1">/</li>
                <li class="animate-underline">
                    <a class="nav-link fw-normal p-0 animate-target" href="#!">Headphones</a>
                </li>
                <li class="px-1">/</li>
                <li class="animate-underline">
                    <a class="nav-link fw-normal p-0 animate-target" href="#!">Wearable</a>
                </li>
                <li class="px-1">/</li>
                <li class="animate-underline">
                    <a class="nav-link fw-normal p-0 animate-target" href="#!">HDD/SSD</a>
                </li>
                <li class="px-1">/</li>
                <li class="animate-underline">
                    <a class="nav-link fw-normal p-0 animate-target" href="#!">Smart Home</a>
                </li>
                <li class="px-1">/</li>
                <li class="animate-underline">
                    <a class="nav-link fw-normal p-0 animate-target" href="#!">Apple Devices</a>
                </li>
                <li class="px-1">/</li>
                <li class="animate-underline">
                    <a class="nav-link fw-normal p-0 animate-target" href="#!">Tablets</a>
                </li>
            </ul>
            <ul class="nav align-items-center text-body-tertiary gap-2">
                <li class="animate-underline">
                    <a class="nav-link fw-normal p-0 animate-target" href="#!">Monitors</a>
                </li>
                <li class="px-1">/</li>
                <li class="animate-underline">
                    <a class="nav-link fw-normal p-0 animate-target" href="#!">Scanners</a>
                </li>
                <li class="px-1">/</li>
                <li class="animate-underline">
                    <a class="nav-link fw-normal p-0 animate-target" href="#!">Servers</a>
                </li>
                <li class="px-1">/</li>
                <li class="animate-underline">
                    <a class="nav-link fw-normal p-0 animate-target" href="#!">Heating and Cooling</a>
                </li>
                <li class="px-1">/</li>
                <li class="animate-underline">
                    <a class="nav-link fw-normal p-0 animate-target" href="#!">E-readers</a>
                </li>
                <li class="px-1">/</li>
                <li class="animate-underline">
                    <a class="nav-link fw-normal p-0 animate-target" href="#!">Data Storage</a>
                </li>
                <li class="px-1">/</li>
                <li class="animate-underline">
                    <a class="nav-link fw-normal p-0 animate-target" href="#!">Networking</a>
                </li>
                <li class="px-1">/</li>
                <li class="animate-underline">
                    <a class="nav-link fw-normal p-0 animate-target" href="#!">Power Strips</a>
                </li>
                <li class="px-1">/</li>
                <li class="animate-underline">
                    <a class="nav-link fw-normal p-0 animate-target" href="#!">Plugs and Outlets</a>
                </li>
                <li class="px-1">/</li>
                <li class="animate-underline">
                    <a class="nav-link fw-normal p-0 animate-target" href="#!">Detectors and Sensors</a>
                </li>
                <li class="px-1">/</li>
                <li class="animate-underline">
                    <a class="nav-link fw-normal p-0 animate-target" href="#!">Accessories</a>
                </li>
            </ul>
        </div>

        <!-- Copyright + Payment methods -->
        <div class="d-md-flex align-items-center border-top py-4">
            <div class="d-flex gap-2 gap-sm-3 justify-content-center ms-md-auto mb-4 mb-md-0 order-md-2">
                <div>
                    <img src="{{ asset('frontend/assets/img/payment-methods/visa-dark-mode.svg') }}" alt="Visa">
                </div>
                <div>
                    <img src="{{ asset('frontend/assets/img/payment-methods/mastercard.svg') }}" alt="Mastercard">
                </div>
                <div>
                    <img src="{{ asset('frontend/assets/img/payment-methods/paypal-dark-mode.svg') }}" alt="PayPal">
                </div>

            </div>
            <p class="text-body fs-xs text-center text-md-start mb-0 me-4 order-md-1">&copy; All rights reserved. Made by <span class="animate-underline"><a class="animate-target text-dark-emphasis fw-medium text-decoration-none" href="https://coderthemes.com/" target="_blank" rel="noreferrer">Coderthemes</a></span></p>
        </div>
    </div>
</footer>


<!-- Back to top button -->
<div class="floating-buttons position-fixed top-50 end-0 z-sticky me-3 me-xl-4 pb-4">
    <a class="btn-scroll-top btn btn-sm bg-body border-0 rounded-pill shadow animate-slide-end" href="#top">
        Çık
        <i class="ci-arrow-right fs-base ms-1 me-n1 animate-target"></i>
        <span class="position-absolute top-0 start-0 w-100 h-100 border rounded-pill z-0"></span>
        <svg class="position-absolute top-0 start-0 w-100 h-100 z-1" viewBox="0 0 62 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x=".75" y=".75" width="60.5" height="30.5" rx="15.25" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"/>
        </svg>
    </a>

</div>

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
<script src="{{ asset('frontend/assets/vendor/drift-zoom/dist/Drift.min.js') }}"></script>
<script src="{{ asset('frontend/assets/vendor/simplebar/dist/simplebar.min.js') }}"></script>
<script src="{{ asset('frontend/assets/vendor/choices.js/public/assets/scripts/choices.min.js') }}"></script>
<!-- Bootstrap + Theme scripts -->
<script src="{{ asset('/frontend/assets/js/theme.min.js') }}"></script>
<script>
    function handleMegaMenu() {

        document.querySelectorAll('.mega-menu-item').forEach(wrapper => {

            const menu = wrapper.querySelector('.dropdown-menu');
            const container = menu.querySelector('.row, .menu-flex');
            const cols = menu.querySelectorAll('.menu-col, [class*="col-"]');

            if (window.innerWidth < 992) {

                // width reset
                menu.style.setProperty('width', 'auto', 'important');

                // row -> flex
                if (container) {
                    container.classList.remove('row');
                    container.classList.add('menu-flex', 'd-flex', 'flex-column', 'gap-4');
                }

                // cols
                cols.forEach(col => {
                    col.classList.remove('col-md-4');
                    col.classList.add('menu-col');
                    col.style.minWidth = '194px';
                });

            } else {

                // width geri
                menu.style.setProperty('width', '700px', 'important');

                // flex -> row
                if (container) {
                    container.classList.add('row');
                    container.classList.remove('menu-flex', 'd-flex', 'flex-column', 'gap-4');
                }

                // cols geri
                cols.forEach(col => {
                    col.classList.add('col-md-4');
                    col.classList.remove('menu-col');
                    col.style.minWidth = '';
                });
            }

        });
    }

    // init
    handleMegaMenu();

    // resize
    window.addEventListener('resize', handleMegaMenu);
</script>
@yield('js')
</body>
</html>
