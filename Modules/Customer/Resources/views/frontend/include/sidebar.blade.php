<aside class="col-lg-3">
    <div class="offcanvas-lg offcanvas-start pe-lg-0 pe-xl-4" id="accountSidebar">

        <!-- Header -->
        <div class="offcanvas-header d-lg-block py-3 p-lg-0">
            <div class="d-flex align-items-center">
                <div class="h5 d-flex justify-content-center align-items-center flex-shrink-0 text-primary bg-primary-subtle lh-1 rounded-circle mb-0" style="width: 3rem; height: 3rem">
                    <img src="{{ asset('upload/user/'.auth()->user()->avatar ) }}" class="img-fluid rounded-circle"  alt=""></div>
                <div class="min-w-0 ps-3">
                    <h5 class="h6 mb-1">{{ auth()->user()->full_name }}</h5>
                    <div class="nav flex-nowrap text-nowrap min-w-0">
                        <a class="nav-link animate-underline text-body p-0" href="#" data-bs-toggle="modal">
                            <span class="badge text-primary border border-primary d-inline-flex align-items-center">
                              <i class="ci-heart fs-sm me-1"></i>
                              Bakiye: {{ auth()->user()->balance }} ₺
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <button type="button" class="btn-close d-lg-none" data-bs-dismiss="offcanvas" data-bs-target="#accountSidebar" aria-label="Close"></button>
        </div>

        <!-- Body (Navigation) -->
        <div class="offcanvas-body d-block pt-2 pt-lg-4 pb-lg-0">
            <nav class="list-group border rounded list-group-borderless">
                <h6 class="pt-4 ps-2 ms-1">Sipariş</h6>
                <a class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('my_order') ? 'pe-none active' : '' }} " href="{{ route('my_order') }}">
                    <i class="ci-shopping-bag fs-base opacity-75 me-2"></i>
                    Siparişlerim
                </a>
                <a class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('favories_page') ? 'pe-none active' : '' }} " href="{{ route('favories_page') }}">
                    <i class="ci-heart fs-base opacity-75 me-2"></i>
                    Favorilerim
                </a>

                <a class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('my_coupon') ? 'pe-none active' : '' }} " href="{{ route('my_coupon') }}">
                    <i class="ci-ticket fs-base opacity-75 me-2"></i>
                    İndirim kuponlarım
                </a>
                <a class="list-group-item list-group-item-action d-flex align-items-center{{ request()->routeIs('my_comment') ? 'pe-none active' : '' }} " href="{{ route('my_comment') }}">
                    <i class="ci-star fs-base opacity-75 me-2"></i>
                   Değerlendirmelerim
                    <span class="badge bg-primary rounded-pill ms-auto">1</span>
                </a>
            </nav>

            <nav class="list-group border rounded mt-2 list-group-borderless">
                <h6 class="pt-4 ps-2 ms-1">Hesabım</h6>
                <a class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('user_panel') ? 'pe-none active' : '' }} " href="{{ route('user_panel') }}">
                    <i class="ci-user fs-base opacity-75 me-2"></i>
                    Kullanıcı bilgilerim
                </a>
                <a class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('my_address') ? 'pe-none active' : '' }} " href="{{ route('my_address') }}">
                    <i class="ci-map-pin fs-base opacity-75 me-2"></i>
                    Kayıtlı adreslerim
                </a>
                <a class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('password_change') ? 'pe-none active' : '' }} " href="{{ route('password_change') }}">
                    <i class="ci-lock fs-base opacity-75 mt-1 me-2"></i>
                    Şifre değiştir
                </a>
                <a class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('notice_setting') ? 'pe-none active' : '' }} " href="{{ route('notice_setting') }}">
                    <i class="ci-bell fs-base opacity-75 mt-1 me-2"></i>
                    Duyuru tercihlerim
                </a>
            </nav>

            <nav class="list-group border rounded mt-2 list-group-borderless">
                <h6 class="pt-4 ps-2 ms-1">Yardım</h6>
                <a class="list-group-item list-group-item-action d-flex align-items-center" href="help-topics-v1.html">
                    <i class="ci-help-circle fs-base opacity-75 me-2"></i>
                    Yardım
                </a>
                <a class="list-group-item list-group-item-action d-flex align-items-center" href="terms-and-conditions.html">
                    <i class="ci-info fs-base opacity-75 me-2"></i>
                    Hizmet şartları
                </a>
            </nav>
            <nav class="list-group border rounded mt-2 list-group-borderless">
                <a class="list-group-item list-group-item-action d-flex align-items-center" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="ci-log-out fs-base opacity-75 me-2"></i>
                    Çıkış yap
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </nav>
        </div>
    </div>
</aside>
<button type="button" class="fixed-bottom z-sticky w-100 btn btn-lg btn-primary border-0 border-top border-light border-opacity-10 rounded-0 pb-4 d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#accountSidebar" aria-controls="accountSidebar" data-bs-theme="light">
    <i class="ci-sidebar fs-base me-2"></i>
    Hesap menüsü
</button>
