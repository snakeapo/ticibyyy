<header class="app-topbar">
    <div class="container-fluid topbar-menu">
        <div class="d-flex align-items-center gap-2">


            <!-- Sidebar Menu Toggle Button -->
            <button class="sidenav-toggle-button btn btn-soft-primary btn-icon">
                <i class="ri ri-menu-line"></i>
            </button>

            <!-- Horizontal Menu Toggle Button -->
            <button class="topnav-toggle-button px-2" data-bs-toggle="collapse" data-bs-target="#topnav-menu">
                <i class="ri ri-menu-line"></i>
            </button>

            <div id="search-box-adornment" class="app-search-pill input-group d-none d-xl-flex">
                <input type="search" class="form-control topbar-search" name="search" placeholder="Quick Search..." />
                <button class="btn btn-soft-secondary btn-icon" type="button">
                    <i class="ri ri-search-line"></i>
                </button>
            </div>


        </div>

        <div class="d-flex align-items-center gap-2">
            <div class="topbar-item d-none d-sm-flex">
                <button class="topbar-link" data-bs-toggle="offcanvas" data-bs-target="#theme-settings-offcanvas" type="button">
                    <i class="ri ri-settings-2-line topbar-link-icon"></i>
                </button>
            </div>

            <div id="theme-toggler" class="topbar-item d-sm-flex">
                <button class="topbar-link" id="light-dark-mode" type="button">
                    <i class="ri ri-moon-line topbar-link-icon mode-light-moon"></i>
                    <i class="ri ri-sun-line topbar-link-icon mode-light-sun"></i>
                </button>
            </div>

            <div id="language-selector-rounded" class="topbar-item">
                @php
                    $panelLanguages = \App\Models\Languages::query()->orderBy('language_name')->get();
                    $activePanelLanguage = $panelLanguages->firstWhere('language_code', app()->getLocale()) ?? $panelLanguages->first();
                @endphp
                <div class="dropdown">
                    <button class="topbar-link fw-bold" data-bs-toggle="dropdown" type="button" aria-haspopup="false" aria-expanded="false">
                        @if($activePanelLanguage && $activePanelLanguage->image)
                            <img src="{{ asset('upload/language/'.$activePanelLanguage->image) }}" alt="{{ $activePanelLanguage->language_name }}" class="rounded-circle me-2" height="18" id="selected-language-image" />
                        @endif
                        <span id="selected-language-code">{{ strtoupper(app()->getLocale()) }}</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        @foreach($panelLanguages as $language)
                            <a href="{{ route('locale.switch', $language->language_code) }}" class="dropdown-item" title="{{ $language->language_name }}">
                                @if($language->image)
                                    <img src="{{ asset('upload/language/'.$language->image) }}" alt="{{ $language->language_name }}" class="me-1 rounded-circle" height="18" />
                                @endif
                                <span class="align-middle">{{ $language->language_name }}</span>
                            </a>
                        @endforeach
                    </div>
                    <!-- end dropdown-menu-->
                </div>
                <!-- end dropdown-->
            </div>

            <div id="notification-dropdown-people" class="topbar-item">
                <div class="dropdown">
                    <button class="topbar-link dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown" type="button" data-bs-auto-close="outside" aria-haspopup="false" aria-expanded="false">
                        <i class="ri ri-notification-3-line topbar-link-icon animate-ring"></i>
                        <span class="badge text-bg-danger badge-circle topbar-badge">{{ \App\Models\Orders::where('status',0)->count() }}</span>
                    </button>

                    <div class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg">
                        <div class="px-3 py-2 border-bottom">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="m-0 fs-md fw-semibold">Bildirimler</h6>
                                </div>
                                <div class="col text-end">
                                    <a href="#!" class="badge badge-soft-success badge-label py-1">{{ \App\Models\Orders::where('status',0)->count() }} Bildirim</a>
                                </div>
                            </div>
                        </div>

                        <div style="max-height: 300px" data-simplebar="">
                            @forelse (\App\Models\Orders::orderBy('id','desc')->where('status',0)->limit(5)->get() as $key)
                            <div class="dropdown-item notification-item py-2 text-wrap" id="message-{{$key->id}}">
                                <span class="d-flex align-items-center gap-3">
                                    <span class="flex-shrink-0 position-relative">
                                        <img src="{{ asset('panel/assets/images/users/user-4.jpg') }}" class="avatar-md rounded-circle" alt="User Avatar" />
                                        <span class="position-absolute rounded-pill bg-success notification-badge">
                                            <i class="ri ri-notification-3-line align-middle"></i>
                                            <span class="visually-hidden">unread notification</span>
                                        </span>
                                    </span>
                                    <span class="flex-grow-1 text-muted">
                                        <span class="fw-medium text-body">{{ $key->getUser->name }} {{ $key->getUser->surname }}</span>
                                        Yeni Bir Sipariş!

                                        <br />
                                        <span class="fs-xs">{{ \Carbon\Carbon::parse($key->created_at)->diffForHumans(); }}</span>
                                    </span>
                                    <button type="button" class="flex-shrink-0 text-muted btn btn-link p-0 position-absolute end-0 me-2 d-none noti-close-btn" data-dismissible="#message-1">
                                        <i class="ri ri-close-circle-line fs-xxl"></i>
                                    </button>
                                </span>
                            </div>
                            @empty
                                <div class="text-center mt-2">
                                    <p><svg height="48" width="48" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            viewBox="0 0 512 512" xml:space="preserve">
<path style="fill:#FF8A1E;" d="M174.74,430.93c0,44.878,36.382,81.07,81.26,81.07l22.261-103.331L174.74,430.93z"/>
                                            <path style="fill:#FF562B;" d="M256,512c44.878,0,81.26-36.192,81.26-81.07L256,408.669V512L256,512z"/>
                                            <polygon style="fill:#FFA418;" points="34.846,364.142 34.846,430.93 256,430.93 278.261,341.881 "/>
                                            <path style="fill:#FFBE11;" d="M256,0C176.159,0,111.837,59.674,99.965,136.479c-5.683,36.763-25.84,146.535-25.84,146.535
	l204.137,22.261L256,0z"/>
                                            <g>
                                                <path style="fill:#FF8A1E;" d="M437.877,283.016c0,0-20.158-109.774-25.842-146.537C400.162,59.674,335.841,0,256,0v305.277
		L437.877,283.016z"/>
                                                <polygon style="fill:#FF8A1E;" points="256,341.881 256,430.93 477.154,430.93 477.154,364.142 	"/>
                                            </g>
                                            <path style="fill:#FFD460;" d="M256,283.016H74.123c-23.905,18.925-39.277,48.417-39.277,81.126H256l22.261-40.563L256,283.016z"/>
                                            <path style="fill:#FFA418;" d="M437.877,283.016H256v81.126h221.154C477.154,331.433,461.781,301.941,437.877,283.016z"/>
</svg></p>
                                    <p class="badge badge-soft-danger rounded-pill">Bildirim bulunamadı!</p>
                                </div>
                            @endforelse

                        </div>

                        <!-- All-->
                        <a href="{{ route('order_list',['slug'=>'pending']) }}" class="dropdown-item text-center text-reset text-decoration-underline link-offset-2 fw-bold notify-item border-top border-light py-2">Tümünü gör</a>
                    </div>
                    <!-- End dropdown-menu -->
                </div>
                <!-- end dropdown-->
            </div>

            <div id="fullscreen-toggler" class="topbar-item d-none d-sm-flex">
                <button class="topbar-link" type="button" data-toggle="fullscreen">
                    <i class="ri ri-fullscreen-line topbar-link-icon"></i>
                    <i class="ri ri-fullscreen-exit-line topbar-link-icon d-none"></i>
                </button>
            </div>

            <div id="simple-user-dropdown" class="topbar-item nav-user">
                <div class="dropdown">
                    <a class="topbar-link dropdown-toggle drop-arrow-none px-2" data-bs-toggle="dropdown" href="#!" aria-haspopup="false" aria-expanded="false">
                        <img src="{{ asset('upload/user/'.Auth::user()->avatar)  }}" width="32" class="rounded-circle me-lg-2 d-flex" alt="user-image" />
                        <div class="d-lg-flex align-items-center gap-1 d-none">
                            <h5 class="my-0">{{ Auth::user()->name }} {{ Auth::user()->surname }}</h5>
                            <i class="ri ri-arrow-down-s-line align-middle"></i>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- Header -->
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">{{ greeting() }}</h6>
                        </div>

                        <!-- My Profile -->
                        <a href="#!" class="dropdown-item">
                            <i class="ri ri-user-line me-1 fs-lg align-middle"></i>
                            <span class="align-middle">Profil</span>
                        </a>

                        <!-- Notifications -->
                        <a href="javascript:void(0);" class="dropdown-item">
                            <i class="ri ri-notification-3-line me-1 fs-lg align-middle"></i>
                            <span class="align-middle">Ayarlar</span>
                        </a>

                        <!-- Wallet -->
                        <a href="javascript:void(0);" class="dropdown-item">
                            <i class="ri ri-bank-card-line me-1 fs-lg align-middle"></i>
                            <span class="align-middle">
                                Bugün:
                                <span class="fw-semibold">985.25 TL</span>
                            </span>
                        </a>

                        <!-- Support -->
                        <a href="javascript:void(0);" class="dropdown-item">
                            <i class="ri ri-customer-service-line me-1 fs-lg align-middle"></i>
                            <span class="align-middle">Yardım merkezi</span>
                        </a>

                        <!-- Divider -->
                        <div class="dropdown-divider"></div>


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
        </div>
    </div>
</header>
