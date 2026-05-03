@extends('setting::backend.layout.default')
@section('content')



        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-head d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="page-main-title m-0">Web Ayarları</h4>
                        </div>

                        <div class="text-end">
                            <ol class="breadcrumb m-0 py-0">
                                <li class="breadcrumb-item"><a href="https://softby.net">Softby</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Kontrol Paneli</a></li>
                                <li class="breadcrumb-item active">Web Ayarları</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">

                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="header-title">Tüm Ayarlarınız Burada</h4>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-pills bg-nav-pills nav-justified mb-3" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a href="#genel" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0 active" aria-selected="false" tabindex="-1" role="tab">
                                        Genel
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="#sosyal" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0 " aria-selected="true" role="tab">
                                        Sosyal Medya
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="#resim" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0" aria-selected="false" tabindex="-1" role="tab">
                                        Resim
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="#iletisim" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0" aria-selected="false" tabindex="-1" role="tab">
                                        İletişim
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="#modul" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0" aria-selected="false" tabindex="-1" role="tab">
                                        Modül Ayarları
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane show active" id="genel" role="tabpanel">
                                    <form action="{{ route('general_update',$data->id) }}" method="POST">
                                        @csrf
                                        <div class="form-floating mb-3">
                                            <input type="text" required name="meta_title" value="{{ $data->meta_title }}" class="form-control" id="floatingInput" placeholder="">
                                            <label for="floatingInput">Meta Başlık</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" required name="meta_keyw" value="{{ $data->meta_keyw }}" class="form-control" id="floatingInput" placeholder="">
                                            <label for="floatingInput">Meta Anahtar Kelime</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" required name="meta_desc" value="{{ $data->meta_desc }}" class="form-control" id="floatingInput" placeholder="">
                                            <label for="floatingInput">Meta Açıklama</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" required name="footer" value="{{ $data->footer }}" class="form-control" id="floatingInput" placeholder="">
                                            <label for="floatingInput">Footer</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <textarea name="footer_desc" class="form-control" required id="" cols="30" rows="10">{{ $data->footer_desc }}</textarea>
                                            <label for="floatingInput">Meta Açıklama</label>
                                        </div>

                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary">Kaydet</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="sosyal" role="tabpanel">
                                    <form action="{{ route('social_update',$data->id) }}" method="POST">
                                        @csrf
                                        <div class="form-floating mb-3">
                                            <input type="text" name="facebook" value="{{ $data->facebook }}" class="form-control" id="floatingInput" placeholder="">
                                            <label for="floatingInput">Facebook</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" name="twitter" value="{{ $data->twitter }}" class="form-control" id="floatingInput" placeholder="">
                                            <label for="floatingInput">Twitter</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" name="youtube" value="{{ $data->youtube }}" class="form-control" id="floatingInput" placeholder="">
                                            <label for="floatingInput">Youtube</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" name="instagram" value="{{ $data->instagram }}" class="form-control" id="floatingInput" placeholder="">
                                            <label for="floatingInput">Instagram</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" name="linkedin" value="{{ $data->linkedin }}" class="form-control" id="floatingInput" placeholder="">
                                            <label for="floatingInput">Linkedin</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" name="pinterest" value="{{ $data->pinterest }}" class="form-control" id="floatingInput" placeholder="">
                                            <label for="floatingInput">Pinterest</label>
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary">Kaydet</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="resim" role="tabpanel">
                                    <form action="{{ route('image_update',$data->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <img src="/upload/setting/{{ $data->logo }}" class="img-fluid mb-3" width="100" onerror="this.src='/upload/setting/logo.png'" alt="">
                                        <div class="form-floating mb-3">
                                            <input type="file" name="logo" class="form-control" id="floatingInput" placeholder="">
                                            <label for="floatingInput">Logo</label>
                                        </div>
                                        <img src="/upload/setting/{{ $data->light_logo }}" class="img-fluid mb-3 bg-dark" width="100" onerror="this.src='/upload/setting/beyaz.png'" alt="">
                                        <div class="form-floating mb-3">
                                            <input type="file" name="light_logo" class="form-control" id="floatingInput" placeholder="">
                                            <label for="floatingInput">Dişi Logo</label>
                                        </div>
                                        <img src="/upload/setting/{{ $data->favicon }}" class="img-fluid mb-3" width="48" onerror="this.src='/upload/setting/icon.png'" alt="">
                                        <div class="form-floating mb-3">
                                            <input type="file" name="favicon" class="form-control" id="floatingInput" placeholder="">
                                            <label for="floatingInput">Favicon</label>
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary">Kaydet</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="iletisim" role="tabpanel">
                                    <form action="{{ route('contact_update',$data->id) }}" method="POST">
                                        @csrf
                                        <div class="form-floating mb-3">
                                            <input type="text" name="mail_address" value="{{ $data->mail_address }}" class="form-control" id="floatingInput" placeholder="">
                                            <label for="floatingInput">Email</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" name="phone" value="{{ $data->phone }}" class="form-control" id="floatingInput" placeholder="">
                                            <label for="floatingInput">Telefon</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" name="whatsapp" value="{{ $data->whatsapp }}" class="form-control" id="floatingInput" placeholder="">
                                            <label for="floatingInput">WhatsApp</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <textarea name="address" class="form-control" id="" cols="30" rows="10">{{ $data->address }}</textarea>
                                            <label for="floatingInput">Adres</label>
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary">Kaydet</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="modul" role="tabpanel">
                                    <form action="{{ route('module_update',$data->id) }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text" name="google_play" value="{{ $data->google_play }}" class="form-control" id="floatingInput" placeholder="">
                                                    <label for="floatingInput">Google Play Uygulama</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text" name="app_store" value="{{ $data->app_store }}" class="form-control" id="floatingInput" placeholder="">
                                                    <label for="floatingInput">App Store Uygulama</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text" name="google_place_id" value="{{ $data->google_place_id }}" class="form-control" id="floatingInput" placeholder="">
                                                    <label for="floatingInput">Google Place ID</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text" name="google_api_key" value="{{ $data->google_api_key }}" class="form-control" id="floatingInput" placeholder="">
                                                    <label for="floatingInput">Google Api Key</label>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="border rounded p-3 mb-3">
                                                    <h5 class="mb-3">Google Login Ayarları</h5>
                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="google_client_id" value="{{ $data->google_client_id }}" class="form-control" id="googleClientId" placeholder="">
                                                        <label for="googleClientId">Google Client ID</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="google_client_secret" value="{{ $data->google_client_secret }}" class="form-control" id="googleClientSecret" placeholder="">
                                                        <label for="googleClientSecret">Google Client Secret</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="google_redirect_uri" value="{{ $data->google_redirect_uri }}" class="form-control" id="googleRedirectUri" placeholder="">
                                                        <label for="googleRedirectUri">Google Redirect URL</label>
                                                    </div>
                                                    <small class="text-muted">
                                                        API bilgilerini
                                                        <a href="https://console.cloud.google.com/apis/credentials" target="_blank" rel="noopener noreferrer">Google Cloud Console</a>
                                                        üzerinden alabilirsiniz.
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="border rounded p-3 mb-3">
                                                    <h5 class="mb-3">Facebook Login Ayarları</h5>
                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="facebook_client_id" value="{{ $data->facebook_client_id }}" class="form-control" id="facebookClientId" placeholder="">
                                                        <label for="facebookClientId">Facebook App ID</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="facebook_client_secret" value="{{ $data->facebook_client_secret }}" class="form-control" id="facebookClientSecret" placeholder="">
                                                        <label for="facebookClientSecret">Facebook App Secret</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="facebook_redirect_uri" value="{{ $data->facebook_redirect_uri }}" class="form-control" id="facebookRedirectUri" placeholder="">
                                                        <label for="facebookRedirectUri">Facebook Redirect URL</label>
                                                    </div>
                                                    <small class="text-muted">
                                                        API bilgilerini
                                                        <a href="https://developers.facebook.com/apps/" target="_blank" rel="noopener noreferrer">Meta for Developers</a>
                                                        üzerinden alabilirsiniz.
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="number" name="referance_earning" value="{{ $data->referance_earning }}" class="form-control" id="floatingInput" placeholder="">
                                                    <label for="floatingInput">Referans Kazanç Oranı</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="number" name="min_widthdraw" value="{{ $data->min_widthdraw }}" class="form-control" id="floatingInput" placeholder="">
                                                    <label for="floatingInput">Referans Minimum Çekim Tutarı</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="number" name="free_cargo" value="{{ $data->free_cargo }}" class="form-control" id="floatingInput" placeholder="">
                                            <label for="floatingInput">Ücretsiz Kargo</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <textarea name="live_support" class="form-control" id="" cols="30" style="height: 300px" rows="30">{{ $data->live_support }}</textarea>
                                            <label for="floatingInput">Canlı Destek</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <textarea name="google_analystics" class="form-control" id="" cols="30" style="height: 300px" rows="10">{{ $data->google_analystics }}</textarea>
                                            <label for="floatingInput">Google Analytics</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <textarea name="google_maps" class="form-control" id="" cols="30" style="height: 300px" rows="10">{{ $data->google_maps }}</textarea>
                                            <label for="floatingInput">Google Map</label>
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary">Kaydet</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> <!-- end card-body -->
                    </div>
                </div>

            </div>

        </div>
        <!-- container -->



@endsection
