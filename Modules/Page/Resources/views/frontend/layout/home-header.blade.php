<header class="navbar navbar-expand-lg navbar-dark bg-dark d-block z-fixed p-0" data-sticky-navbar='{"offset": 500}'>
    <div class="container d-block py-1 py-lg-3" data-bs-theme="dark">
        <div class="navbar-stuck-hide pt-1"></div>
        <div class="row flex-nowrap align-items-center g-0">
            <div class="col col-lg-3 d-flex align-items-center">

                <!-- Mobile offcanvas menu toggler (Hamburger) -->
                <button type="button" class="navbar-toggler me-4 me-lg-0" data-bs-toggle="offcanvas" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navbar brand (Logo) -->
                <a href="{{ route('home_index') }}" class="navbar-brand me-0">
                    <img src="{{ asset('upload/setting/'.$setting->logo) }}" class="img-fluid" width="150" alt="">
                </a>
            </div>
            <div class="col col-lg-9 d-flex align-items-center justify-content-end">

                <!-- Search visible on screens > 991px wide (lg breakpoint) -->
                <form action="{{ route('product_filter') }}" method="GET" class="position-relative flex-fill d-none d-lg-block pe-4 pe-xl-5">
                    <i class="ci-search position-absolute top-50 translate-middle-y d-flex fs-lg text-white ms-3"></i>
                    <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-lg form-icon-start border-white rounded-pill" placeholder="Ürün ara...">
                </form>


                <!-- Button group -->
                <div class="d-flex align-items-center">

                    <!-- Navbar stuck nav toggler -->
                    <button type="button" class="navbar-toggler d-none navbar-stuck-show me-3" data-bs-toggle="collapse" data-bs-target="#stuckNav" aria-controls="stuckNav" aria-expanded="false" aria-label="Toggle navigation in navbar stuck state">
                        <span class="navbar-toggler-icon"></span>
                    </button>



                    <!-- Search toggle button visible on screens < 992px wide (lg breakpoint) -->
                    <button type="button" class="btn btn-icon btn-lg fs-xl btn-outline-secondary border-0 rounded-circle animate-shake d-lg-none" data-bs-toggle="collapse" data-bs-target="#searchBar" aria-expanded="false" aria-controls="searchBar" aria-label="Toggle search bar">
                        <i class="ci-search animate-target"></i>
                    </button>

                    <!-- Account button visible on screens > 768px wide (md breakpoint) -->
                    <a class="btn btn-icon btn-lg fs-lg btn-outline-secondary border-0 rounded-circle animate-shake d-none d-md-inline-flex" href="@if(Auth::check()) {{ route('user_panel') }} @else {{ route('login') }}@endif">
                        <i class="ci-user animate-target"></i>
                        <span class="visually-hidden">@if(Auth::check()) Hesabım @else Giriş yap @endif</span>
                    </a>

                    <!-- Wishlist button visible on screens > 768px wide (md breakpoint) -->
                    <a class="btn btn-icon btn-lg fs-lg btn-outline-secondary border-0 rounded-circle animate-pulse d-none d-md-inline-flex" href="@if(Auth::check()) {{ route('favories_page') }} @else {{ route('login') }} @endif">
                        <i class="ci-heart animate-target"></i>
                        <span class="visually-hidden">Favoriler</span>
                    </a>

                    <!-- Cart button -->
                    <button type="button" class="btn btn-icon btn-lg btn-secondary position-relative rounded-circle ms-2" data-bs-toggle="offcanvas" data-bs-target="#shoppingCart" aria-controls="shoppingCart" aria-label="Shopping cart">
                        <span class="position-absolute top-0 start-100 mt-n1 ms-n3 badge text-bg-success border border-3 border-dark rounded-pill" style="--cz-badge-padding-y: .25em; --cz-badge-padding-x: .42em">3</span>
                        <span class="position-absolute top-0 start-0 d-flex align-items-center justify-content-center w-100 h-100 rounded-circle animate-slide-end fs-lg">
                  <i class="ci-shopping-cart animate-target ms-n1"></i>
                </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="navbar-stuck-hide pb-1"></div>
    </div>

    <!-- Search visible on screens < 992px wide (lg breakpoint). It is hidden inside collapse by default -->
    <div class="collapse position-absolute top-100 z-2 w-100 bg-dark d-lg-none" id="searchBar">
        <form action="{{ route('product_filter') }}" method="GET" class="container position-relative my-3" data-bs-theme="dark">
            <i class="ci-search position-absolute top-50 translate-middle-y d-flex fs-lg text-white ms-3"></i>
            <input type="search" name="q" value="{{ request('q') }}" class="form-control form-icon-start border-white rounded-pill" placeholder="Ürün ara..." data-autofocus="collapse">
        </form>
    </div>

    <!-- Main navigation that turns into offcanvas on screens < 992px wide (lg breakpoint) -->
    <div class="collapse navbar-stuck-hide" id="stuckNav">
        <nav class="offcanvas offcanvas-start" id="navbarNav" tabindex="-1" aria-labelledby="navbarNavLabel">
            <div class="offcanvas-header py-3">
                <img src="{{ asset('upload/setting/'.$setting->logo) }}" class="img-fluid" width="150" alt="">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body py-3 py-lg-0">
                <div class="container px-0 px-lg-3">
                    <div class="row">

                        <!-- Categories mega menu -->
                        <div class="col-lg-3">
                            <div class="navbar-nav">
                                <div class="dropdown w-100">

                                    <!-- Buttton visible on screens > 991px wide (lg breakpoint) -->
                                    <div class="cursor-pointer d-none d-lg-block" data-bs-toggle="dropdown" data-bs-trigger="hover" data-bs-theme="dark">
                                        <a class="position-absolute top-0 start-0 w-100 h-100" href="{{ route('kategori.index') }}">
                                            <span class="visually-hidden">Kategoriler</span>
                                        </a>
                                        <button type="button" class="btn btn-lg btn-secondary dropdown-toggle w-100 rounded-bottom-0 justify-content-start pe-none">
                                            <i class="ci-grid fs-lg"></i>
                                            <span class="ms-2 me-auto">Kategoriler</span>
                                        </button>
                                    </div>

                                    <!-- Buttton visible on screens < 992px wide (lg breakpoint) -->
                                    <button type="button" class="btn btn-lg btn-secondary dropdown-toggle w-100 justify-content-start d-lg-none mb-2" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                        <i class="ci-grid fs-lg"></i>
                                        <span class="ms-2 me-auto">Kategoriler</span>
                                    </button>

                                    <!-- Mega menu -->
                                    <ul class="dropdown-menu {{ request()->is('/') ? 'dropdown-menu-static' : '' }} w-100 rounded-top-0 rounded-bottom-4 py-1 p-lg-1" style="--cz-dropdown-spacer: 0; --cz-dropdown-item-padding-y: .625rem; --cz-dropdown-item-spacer: 0">
                                        <li class="d-lg-none pt-2">
                                            <a class="dropdown-item fw-medium" href="{{ route('kategori.index') }}">
                                                <i class="ci-grid fs-xl opacity-60 pe-1 me-2"></i>
                                                Tüm kategoriler
                                                <i class="ci-chevron-right fs-base ms-auto me-n1"></i>
                                            </a>
                                        </li>
                                        @foreach(\App\Models\Categories::orderBy('id','ASC')->limit(10)->get() as $topCategory)
                                            <li class="dropend position-static mega-menu-item">
                                                <div class="position-relative rounded pt-2 pb-1 px-lg-2" data-bs-toggle="dropdown" data-bs-trigger="hover">
                                                    <a class="dropdown-item fw-medium stretched-link d-none d-lg-flex" href="{{ route('top_category_detail',$topCategory->category_slug) }}">
                                                        <i class="ci-computer fs-xl opacity-60 pe-1 me-2"></i>
                                                        <span class="text-truncate">{{ $topCategory->category_title }}</span>
                                                        @if(\App\Models\Subcategories::where('top_category',$topCategory->id)->count() != 0)
                                                            <i class="ci-chevron-right fs-base ms-auto me-n1"></i>
                                                        @endif
                                                    </a>
                                                    <div class="dropdown-item fw-medium text-wrap stretched-link d-lg-none">
                                                        <i class="ci-computer fs-xl opacity-60 pe-1 me-2"></i>
                                                        {{ $topCategory->category_title }}
                                                        @if(\App\Models\Subcategories::where('top_category',$topCategory->id)->count() != 0)
                                                            <i class="ci-chevron-down fs-base ms-auto me-n1"></i>
                                                        @endif
                                                    </div>
                                                </div>
                                                @if(\App\Models\Subcategories::where('top_category',$topCategory->id)->count() != 0)
                                                    <div class="dropdown-menu rounded-4 p-4" style="width:700px;top: 1rem; min-height: 500px; --cz-dropdown-spacer: .3125rem; animation: none;">
                                                        <div class="row ">
                                                            @foreach(\App\Models\Subcategories::where('top_category',$topCategory->id)->whereNull('parent_id')->get() as $subCategory)

                                                                <div class="col-md-4 mb-2 menu-col">
                                                                    <div class="d-flex w-100">
                                                                        <a class="animate-underline animate-target d-inline h6 text-dark-emphasis text-decoration-none text-truncate" href="{{ route('sub_parent_category_detail', [$topCategory->category_slug,$subCategory->sub_slug]) }}">{{ $subCategory->sub_title }}</a>
                                                                    </div>
                                                                    <ul class="nav flex-column gap-2 mt-n2">
                                                                        @foreach(\App\Models\Subcategories::where('parent_id',$subCategory->id)->get() as $subSubCategory)
                                                                            <li class="d-flex w-100">
                                                                                <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="{{ route('sub_category_detail', [$topCategory->category_slug,$subCategory->sub_slug,$subSubCategory->sub_slug]) }}">{{ $subSubCategory->sub_title }}</a>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>

                                                            @endforeach


                                                        </div>
                                                    </div>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Navbar nav -->
                        <div class="col-lg-9 d-lg-flex pt-3 pt-lg-0 ps-lg-0">
                            <ul class="navbar-nav position-relative">
                                <li class="nav-item dropdown me-lg-n1 me-xl-0">
                                    <a class="nav-link" aria-current="page" href="{{ route('home_index') }}" >{{ __('Home') }}</a>
                                </li>

                                <li class="nav-item dropdown me-lg-n1 me-xl-0">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" data-bs-trigger="hover" data-bs-auto-close="outside" aria-expanded="false">{{ __('Pages') }}</a>
                                    <ul class="dropdown-menu">
                                        @foreach(\App\Models\Pages::all() as $key)
                                        <li><a class="dropdown-item" href="{{ route('page_detail',$key->page_slug) }}">{{ $key->page_title }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li class="nav-item me-lg-n2 me-xl-0">
                                    <a class="nav-link" href="{{ route('blog_page') }}">{{ __('Blog') }}</a>
                                </li>
                                <li class="nav-item me-lg-n2 me-xl-0">
                                    <a class="nav-link" href="{{ route('auction_live_index') }}">{{ __('Live auction') }}</a>
                                </li>
                                <li class="nav-item me-lg-n2 me-xl-0">
                                    <a class="nav-link" href="{{ route('contact_page') }}">{{ __('Contact') }}</a>
                                </li>
                            </ul>
                            <hr class="d-lg-none my-3">
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item dropdown me-lg-n2 me-xl-n1">
                                    @php
                                        $frontendLanguages = \App\Models\Languages::query()->orderBy('language_name')->get();
                                        $activeFrontendLanguage = $frontendLanguages->firstWhere('language_code', app()->getLocale()) ?? $frontendLanguages->first();
                                    @endphp
                                    <a class="nav-link dropdown-toggle fs-sm px-3" href="#!" role="button" data-bs-toggle="dropdown" data-bs-trigger="hover" aria-expanded="false">{{ strtoupper(optional($activeFrontendLanguage)->language_code ?? app()->getLocale()) }}</a>
                                    <ul class="dropdown-menu fs-sm" style="--cz-dropdown-min-width: 7.5rem; --cz-dropdown-spacer: .25rem">
                                        @foreach($frontendLanguages as $language)
                                            <li><a class="dropdown-item" href="{{ route('locale.switch', $language->language_code) }}">{{ $language->language_name }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li class="nav-item dropdown me-lg-n1">
                                    <a class="nav-link dropdown-toggle fs-sm px-3" href="#!" role="button" data-bs-toggle="dropdown" data-bs-trigger="hover" aria-expanded="false">USD ($)</a>
                                    <ul class="dropdown-menu dropdown-menu-end fs-sm" style="--cz-dropdown-min-width: 7rem; --cz-dropdown-spacer: .25rem">
                                        <li><a class="dropdown-item" href="#!">€ EUR</a></li>
                                        <li><a class="dropdown-item" href="#!">£ UKP</a></li>
                                        <li><a class="dropdown-item" href="#!">¥ JPY</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="offcanvas-header border-top px-0 py-3 mt-3 d-md-none">
                <div class="nav nav-justified w-100">
                    <a class="nav-link border-end" href="@if(Auth::check()) {{ route('user_panel') }} @else {{ route('login') }}@endif">
                        <i class="ci-user fs-lg opacity-60 me-2"></i>
                        Hesabım
                    </a>
                    <a class="nav-link" href="@if(Auth::check()) {{ route('favories_page') }} @else {{ route('login') }} @endif">
                        <i class="ci-heart fs-lg opacity-60 me-2"></i>
                        Favoriler
                    </a>
                </div>
            </div>
        </nav>
    </div>
</header>
