<div class="sidenav-menu">
    <!-- Brand Logo -->
    <a href="index.html" class="logo">
        <span class="logo logo-light">
            <span class="logo-lg"><img src="{{ asset('other/logo.webp') }}" alt="logo" /></span>
            <span class="logo-sm"><img src="{{ asset('other/icon.webp')  }}" alt="small logo" /></span>
        </span>

        <span class="logo logo-dark">
            <span class="logo-lg"><img src="{{ asset('other/logo.webp') }}" alt="dark logo" /></span>
            <span class="logo-sm"><img src="{{ asset('other/icon.webp')  }}" alt="small logo" /></span>
        </span>
    </a>

    <!-- Sidebar Hover Menu Toggle Button -->
    <button class="button-on-hover">
        <i class="ri ri-circle-line align-middle"></i>
    </button>

    <!-- Full Sidebar Menu Close Button -->
    <button class="button-close-offcanvas">
        <i class="ri ri-menu-line align-middle"></i>
    </button>

    <div class="scrollbar" data-simplebar="">
        <div id="user-profile-condensed" class="sidenav-user">
            <div class="dropdown">
                <a class="dropdown-toggle drop-arrow-none link-reset sidenav-user-set-icon" data-bs-toggle="dropdown" data-bs-offset="0,12" href="#!" aria-haspopup="false" aria-expanded="false">
                    <span class="d-flex align-items-center gap-2">
                        <img src="{{ asset('upload/user/'.Auth::user()->avatar)  }}" alt="user-image" class="rounded-circle avatar-md" />
                        <span>
                            <span class="sidenav-user-name fw-bold">{{ Auth::user()->name }} {{ Auth::user()->surname }}</span>
                            <span class="fs-12 fw-semibold" data-lang="user-role">{{ greeting() }}</span>
                        </span>
                        <i class="ri ri-arrow-down-s-line align-middle ms-auto"></i>
                    </span>
                </a>

                <div class="dropdown-menu">
                    <!-- Header -->
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Hoşgeldiniz!</h6>
                    </div>

                    <!-- My Profile -->
                    <a href="#!" class="dropdown-item">
                        <i class="ri ri-user-line me-1 fs-lg align-middle"></i>
                        <span class="align-middle">Profil</span>
                    </a>

                    <!-- Logout -->
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item text-primary fw-semibold">
                        <i class="ri ri-logout-box-line me-1 fs-lg align-middle"></i>
                        <span class="align-middle">Çıkış yap</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>

        <!--- Sidenav Menu -->
        <div id="sidenav-menu">
            <ul class="side-nav">
                <li class="side-nav-title mt-2" data-lang="main">Main</li>
                <li class="side-nav-item">
                    <a href="{{ route('panel_home') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ri ri-dashboard-2-line"></i></span>
                        <span class="menu-text" data-lang="index">Gösterge paneli</span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <a href="{{ route('product_list') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ri ri-group-2-line"></i></span>
                        <span class="menu-text" data-lang="apps-team-board">Ürün Listesi</span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#invoice" aria-expanded="false" aria-controls="invoice" class="side-nav-link">
                        <span class="menu-icon"><i class="ri ri-receipt-line"></i></span>
                        <span class="menu-text" data-lang="invoice">Kategori</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="invoice">
                        <ul class="sub-menu">
                            <li class="side-nav-item">
                                <a href="{{ route('category_list') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-invoice-list">Ana kategoriler</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('subcategory_list') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-invoice-details">Alt kategoriler</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('brand_list') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-invoice-create">Markalar</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('auction_admin_index') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ri ri-auction-line"></i></span>
                        <span class="menu-text">Canlı mezat</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('coupon_list') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ri ri-group-2-line"></i></span>
                        <span class="menu-text" data-lang="apps-team-board">Kuponlar</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('question_list') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ri ri-group-2-line"></i></span>
                        <span class="menu-text" data-lang="apps-team-board">Ürün soru & cevap</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('comment_list') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ri ri-group-2-line"></i></span>
                        <span class="menu-text" data-lang="apps-team-board">Ürün yorumları</span>
                    </a>
                </li>
                <li class="side-nav-title mt-2" data-lang="custom-pages">Sipariş</li>
                <li class="side-nav-item">
                    <a href="{{ route('pending_order') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ri ri-group-2-line"></i></span>
                        <span class="menu-text" data-lang="apps-team-board">Bekleyen siparişler</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('completed_order') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ri ri-group-2-line"></i></span>
                        <span class="menu-text" data-lang="apps-team-board">Tamamlanan siparişler</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('prepared_order') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ri ri-group-2-line"></i></span>
                        <span class="menu-text" data-lang="apps-team-board">Hazırlanan siparişler</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('shipped_order') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ri ri-group-2-line"></i></span>
                        <span class="menu-text" data-lang="apps-team-board">Kargolanan siparişler</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('cancel_order') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ri ri-group-2-line"></i></span>
                        <span class="menu-text" data-lang="apps-team-board">İptal edilen siparişler</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('cancel_order') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ri ri-group-2-line"></i></span>
                        <span class="menu-text" data-lang="apps-team-board">İade edilen siparişler</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('pending_order') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ri ri-group-2-line"></i></span>
                        <span class="menu-text" data-lang="apps-team-board">Tüm faturalar</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('live_basket') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ri ri-group-2-line"></i></span>
                        <span class="menu-text" data-lang="apps-team-board">Canlı sepet</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('auction_admin_orders') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ri ri-auction-line"></i></span>
                        <span class="menu-text">Mezat siparişleri</span>
                    </a>
                </li>
                <li class="side-nav-title mt-2" data-lang="custom-pages">Müşteri</li>
                <li class="side-nav-item">
                    <a href="{{ route('user_list') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ri ri-group-2-line"></i></span>
                        <span class="menu-text" data-lang="apps-team-board">Tüm üyeler</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('admin_list') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ri ri-group-2-line"></i></span>
                        <span class="menu-text" data-lang="apps-team-board">Yöneticiler</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('stock_notify') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ri ri-group-2-line"></i></span>
                        <span class="menu-text" data-lang="apps-team-board">Gelince bildir</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('customer_comment_list') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ri ri-group-2-line"></i></span>
                        <span class="menu-text" data-lang="apps-team-board">Müşteri görüşleri</span>
                    </a>
                </li>

                <li class="side-nav-title mt-2" data-lang="custom-pages">İçerik & Seo</li>
                <li class="side-nav-item">
                    <a href="{{ route('blog_list') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ri ri-group-2-line"></i></span>
                        <span class="menu-text" data-lang="apps-team-board">Makaleler</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('blog_category_list') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ri ri-group-2-line"></i></span>
                        <span class="menu-text" data-lang="apps-team-board">Makale kategorileri</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('page_list') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ri ri-group-2-line"></i></span>
                        <span class="menu-text" data-lang="apps-team-board">Sayfalar</span>
                    </a>
                </li>

                <li class="side-nav-title mt-2" data-lang="custom-pages">İletişim</li>
                <li class="side-nav-item">
                    <a href="{{ route('message_list') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ri ri-group-2-line"></i></span>
                        <span class="menu-text" data-lang="apps-team-board">Mesajlar</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('annons_list') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ri ri-group-2-line"></i></span>
                        <span class="menu-text" data-lang="apps-team-board">Duyurular & Bildirimler</span>
                    </a>
                </li>
                <li class="side-nav-title mt-2" data-lang="custom-pages">Ayarlar</li>
                <li class="side-nav-item">
                    <a href="{{ route('web_setting') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ri ri-group-2-line"></i></span>
                        <span class="menu-text" data-lang="apps-team-board">Site ayarları</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('theme_setting') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ri ri-group-2-line"></i></span>
                        <span class="menu-text" data-lang="apps-team-board">Tema ayarları</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('info_setting') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ri ri-group-2-line"></i></span>
                        <span class="menu-text" data-lang="apps-team-board">Bilgi ayarları</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('auth_info_card_setting') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ri ri-group-2-line"></i></span>
                        <span class="menu-text" data-lang="apps-team-board">Avantajlar</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('bank_setting') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ri ri-group-2-line"></i></span>
                        <span class="menu-text" data-lang="apps-team-board">Ödeme ayarları</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('cargo_setting') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ri ri-group-2-line"></i></span>
                        <span class="menu-text" data-lang="apps-team-board">Kargo ayarları</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('language_setting') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ri ri-group-2-line"></i></span>
                        <span class="menu-text" data-lang="apps-team-board">Dil ayarları</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
