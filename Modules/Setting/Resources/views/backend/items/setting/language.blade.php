@extends('setting::backend.layout.default')
@section('content')



        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-head d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="page-main-title m-0">Dil Ayarları</h4>
                        </div>

                        <div class="text-end">
                            <ol class="breadcrumb m-0 py-0">
                                <li class="breadcrumb-item"><a href="https://softby.net">Softby</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Kontrol Paneli</a></li>
                                <li class="breadcrumb-item active">Dil Ayarları</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">

                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                        <div class="alert alert-warning" role="alert">
                            <i class="ri-alert-line me-1 align-middle fs-16"></i>
                            <strong>! UYARI !</strong> Eğer Tablonun Devamı Görünmüyorsa #İlk Sırada ki Numaradan Açabilirsiniz Devamını.
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="header-title">Dil Ayarları</h4>
                            </div>
                            <div class="card-body">
                                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>

                                        <tr>
                                            <th>#</th>
                                            <th>Eklenme Tarihi</th>
                                            <th>Güncelleme Tarihi</th>
                                            <th>Resim</th>
                                            <th>Dil Adı</th>
                                            <th>Dil Kodu</th>
                                            <th>Düzenle</th>
                                            <th>Çeviri</th>
                                            <th>Sil</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i = 1; @endphp
                                        @foreach ($data as $key)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $key->created_at }}</td>
                                            <td>{{ $key->updated_at }}</td>
                                            <td><img src="/upload/language/{{ $key->image }}" class="img-fluid" width="32" alt=""></td>
                                            <td>{{ $key->language_name }}</td>
                                            <td>{{ $key->language_code }}</td>
                                            <td><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit{{ $key->id }}" type="button">Düzenle</button></td>
                                            <td><a href="{{ route('language_setting_translate',$key->id) }}" class="btn btn-warning">Çeviri</a></td>
                                            <td><a href="{{ route('language_setting_delete',$key->id) }}" onclick="confirmation(event)" class="btn btn-danger">Sil</a></td>
                                        </tr>
                                        <!-- Modal -->
                                        <div class="modal fade" id="edit{{ $key->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Bilgiyi Düzenleyin</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('language_setting_update',$key->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-floating mb-3">
                                                            <input type="text" required name="language_name" value="{{ $key->language_name }}" class="form-control" id="floatingInput" placeholder="">
                                                            <label for="floatingInput">Dil Adı</label>
                                                        </div>
                                                        <div class="form-floating mb-3">
                                                            <input type="text" required name="language_code" value="{{ $key->language_code }}" class="form-control" id="floatingInput" placeholder="">
                                                            <label for="floatingInput">Dil Kodu</label>
                                                        </div>
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label">Resim & İcon</label>
                                                            <input class="form-control" type="file" name="image" id="inputGroupFile04">
                                                        </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                                                    <button type="submit" class="btn btn-primary">Kaydet</button>
                                                </div>
                                            </form>
                                            </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div><!-- end col-->
                    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="header-title">Yeni Dil Oluştur</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('language_setting_create') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-floating mb-3">
                                        <input type="text" required name="language_name" class="form-control" id="floatingInput" placeholder="">
                                        <label for="floatingInput">Dil Adı</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" required name="language_code" class="form-control" id="floatingInput" placeholder="">
                                        <label for="floatingInput">Dil Kodu</label>
                                        <small style="color: red">* Örnek: tr,fr,gr Şeklinde Olmalı *</small>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Resim & İcon</label>
                                        <input class="form-control" type="file" name="image" id="inputGroupFile04">
                                    </div>

                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary w-100">Kaydet</button>
                                    </div>
                                </form>

                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div>
                </div> <!-- end row-->


            </div>

        </div>
        <!-- container -->



@endsection
