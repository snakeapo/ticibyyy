@extends('setting::backend.layout.default')
@section('content')



        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-head d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="page-main-title m-0">Slider Ayarları</h4>
                        </div>

                        <div class="text-end">
                            <ol class="breadcrumb m-0 py-0">
                                <li class="breadcrumb-item"><a href="https://softby.net">Softby</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Kontrol Paneli</a></li>
                                <li class="breadcrumb-item active">Slider Ayarları</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="header-title">Slider Ayarları</h4>
                                <div class="float-end">
                                    <a data-bs-toggle="offcanvas" href="#theme-slider-offcanvas" class="btn btn-primary">Yeni Slider Ekle</a>
                                </div>
                            </div>

                        <!-- Theme Settings -->
                        <div class="offcanvas offcanvas-end" tabindex="-1" id="theme-slider-offcanvas">
                            <div class="d-flex align-items-center bg-primary p-3 offcanvas-header">
                                <h5 class="text-white m-0">Yeni Slider Oluştur</h5>
                                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('slider_create') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                            <div class="offcanvas-body p-0">
                                <div data-simplebar class="h-100" style="overflow: scroll">
                                    <div class="p-3">
                                        <div class="form-floating mb-3">
                                            <input type="text" required name="slider_title" class="form-control" id="floatingInput" placeholder="">
                                            <label for="floatingInput">Slider Başlığı</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" required name="slider_desc" class="form-control" id="floatingInput" placeholder="">
                                            <label for="floatingInput">Slider Açıklama</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" required name="slider_button"  class="form-control" id="floatingInput" placeholder="">
                                            <label for="floatingInput">Slider Buton Adı</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" required name="slider_link"  class="form-control" id="floatingInput" placeholder="">
                                            <label for="floatingInput">Slider Link</label>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Slider Resim</label>
                                            <input class="form-control" type="file" name="slider_image" id="inputGroupFile04">
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-select" required name="status" id="floatingSelect" aria-label="">
                                                <option value="1">Aktif</option>
                                                <option value="0">Pasif</option>
                                            </select>
                                            <label for="floatingSelect">Durum</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="offcanvas-footer border-top p-3 text-center">
                                <div class="row">

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary w-100">Kaydet</button>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                            <div class="card-body">
                                <div class="row">
                                    @if($data->count() != 0)
                                     @foreach ($data as $key)
                                        <div class="col-lg-6">
                                            <div class="card @if($key->status == 1) bg-light-success @else bg-light-danger @endif">
                                                <div class="card-header">
                                                    <h4 class="header-title">
                                                        @if($key->status == 0)
                                                        <span class="badge rounded-pill text-bg-danger" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-custom-class="danger-tooltip" data-bs-title="Slider Pasif Durumdadır!"><i class="ri-error-warning-line"></i></span>
                                                        @endif
                                                        {{ $key->slider_title }}</h4>
                                                    <p class="text-muted mb-0">
                                                       {{ $key->slider_desc }}
                                                    </p>

                                                </div>
                                                <div class="card-body">
                                                    <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                                                        <div class="carousel-inner" role="listbox">
                                                            <div class="">
                                                                <img class="d-block img-fluid" src="/upload/slider/{{ $key->slider_image }}" alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-3 mb-3">
                                                        <a data-bs-toggle="offcanvas" href="#theme-sliderDuzenle{{ $key->id }}-offcanvas" class="btn btn-primary">Düzenle</a>
                                                    <a href="{{ route('slider_delete',$key->id) }}" onclick="confirmation(event)" class="btn btn-danger">Sil</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                       @endforeach
                                       @else
                                        <div class="text-center">
                                            <img src="/extra/img/no-result.png" class="img-fluid" width="100" alt="">
                                            <h5>Sonuç Bulunamadı!</h5>
                                        </div>
                                       @endif
                                </div>
                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div><!-- end col-->

                </div> <!-- end row-->


            </div>

        </div>
        <!-- container -->


    @foreach ($data as $key)
        <!-- Theme Settings -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="theme-sliderDuzenle{{ $key->id }}-offcanvas">
         <div class="d-flex align-items-center bg-primary p-3 offcanvas-header">
             <h5 class="text-white m-0">Slider Düzenle</h5>
             <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="offcanvas" aria-label="Close"></button>
         </div>
         <form action="{{ route('slider_update',$key->id) }}" method="POST" enctype="multipart/form-data">
             @csrf

             <div class="offcanvas-body p-0">
                <div data-simplebar class="h-100" style="overflow: scroll">
                    <div class="p-3">
                        <div class="form-floating mb-3">
                            <input type="text" required name="slider_title" value="{{ $key->slider_title }}" class="form-control" id="floatingInput" placeholder="">
                            <label for="floatingInput">Slider Başlığı</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" required name="slider_desc" class="form-control" value="{{ $key->slider_desc }}" id="floatingInput" placeholder="">
                            <label for="floatingInput">Slider Açıklama</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" required name="slider_button"  class="form-control" value="{{ $key->slider_button }}" id="floatingInput" placeholder="">
                            <label for="floatingInput">Slider Buton Adı</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" required name="slider_link"  class="form-control" value="{{ $key->slider_link }}" id="floatingInput" placeholder="">
                            <label for="floatingInput">Slider Link</label>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Slider Resim</label>
                            <input class="form-control" type="file" name="slider_image" id="inputGroupFile04">
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" required name="status" id="floatingSelect" aria-label="">
                                <option value="1" @selected($key->status == 1)>Aktif</option>
                                <option value="0" @selected($key->status == 0)>Pasif</option>
                            </select>
                            <label for="floatingSelect">Durum</label>
                        </div>
                    </div>
                </div>
            </div>
         <div class="offcanvas-footer border-top p-3 text-center">
             <div class="row">

                 <div class="col-12">
                     <button type="submit" class="btn btn-primary w-100">Kaydet</button>
                 </div>
             </div>
         </div>
         </form>
     </div>
    @endforeach
@endsection
