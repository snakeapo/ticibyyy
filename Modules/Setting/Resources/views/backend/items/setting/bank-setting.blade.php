@extends('setting::backend.layout.default')
@section('content')



        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-head d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="page-main-title m-0">Banka Ayarları</h4>
                        </div>

                        <div class="text-end">
                            <ol class="breadcrumb m-0 py-0">
                                <li class="breadcrumb-item"><a href="https://softby.net">Softby</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Kontrol Paneli</a></li>
                                <li class="breadcrumb-item active">Banka Ayarları</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">

                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-12 col-12">

                        <div class="card">
                            <div class="card-header">
                                <h4 class="header-title">Banka Ayarları</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>

                                        <tr>
                                            <th>#</th>
                                            <th>Eklenme Tarihi</th>
                                            <th>Güncelleme Tarihi</th>
                                            <th>Banka Adı</th>
                                            <th>İban No</th>
                                            <th>Ad Soyad</th>
                                            <th>Durum</th>
                                            <th>Düzenle</th>
                                            <th>Sil</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i = 1; @endphp
                                        @foreach ($data as $key)
                                        <tr>
                                            <td>{{ $i++ }}
                                                <i class="ri-arrow-down-s-fill"></i>
                                            </td>
                                            <td>{{ $key->created_at }}</td>
                                            <td>{{ $key->updated_at }}</td>
                                            <td>{{ $key->title }}</td>
                                            <td>{{ $key->iban }}</td>
                                            <td>{{ $key->account }}</td>
                                            <td>
                                                @if($key->status == 1)
                                                <p style="color: rgb(55, 156, 55)">Aktif</p>
                                                @else
                                                <p style="color: rgb(196, 69, 69)">Deaktif</p>
                                                @endif
                                            </td>
                                            <td><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit{{ $key->id }}" type="button">Düzenle</button></td>
                                            <td><a href="{{ route('bank_setting_delete',$key->id) }}" onclick="confirmation(event)" class="btn btn-danger">Sil</a></td>
                                        </tr>
                                        <!-- Modal -->
                                        <div class="modal fade" id="edit{{ $key->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Kargoyu Düzenleyin</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('bank_setting_update',$key->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-floating mb-3">
                                                            <input type="text" required name="title" value="{{ $key->title }}" class="form-control" id="floatingInput" placeholder="">
                                                            <label for="floatingInput">Banka Adı</label>
                                                        </div>
                                                        <div class="form-floating mb-3">
                                                            <input type="text" required name="iban" value="{{ $key->iban }}" class="form-control" id="floatingInput" placeholder="">
                                                            <label for="floatingInput">İban Numarası</label>
                                                        </div>
                                                        <div class="form-floating mb-3">
                                                            <input type="text" required name="account" value="{{ $key->account }}" class="form-control" id="floatingInput" placeholder="">
                                                            <label for="floatingInput">Ad Soyad</label>
                                                        </div>
                                                        <div class="form-floating mb-3">
                                                            <select class="form-select" required name="status" id="floatingSelect" aria-label="">
                                                                <option value="1" @selected($key->status == 1)>Aktif</option>
                                                                <option value="0" @selected($key->status == 0)>Deaktif</option>
                                                            </select>
                                                            <label for="floatingSelect">Durum Seçiniz</label>
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
                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div><!-- end col-->
                    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="header-title">Yeni Banka Bilgisi Oluşturun</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('bank_setting_create') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-floating mb-3">
                                        <input type="text" required name="title" class="form-control" id="floatingInput" placeholder="">
                                        <label for="floatingInput">Banka Adı</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" required name="iban" class="form-control" id="floatingInput" placeholder="">
                                        <label for="floatingInput">İban Numarası</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" required name="account" class="form-control" id="floatingInput" placeholder="">
                                        <label for="floatingInput">Ad Soyad</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <select class="form-select" required name="status" id="floatingSelect" aria-label="">
                                            <option value="1">Aktif</option>
                                            <option value="0">Deaktif</option>
                                        </select>
                                        <label for="floatingSelect">Durum Seçiniz</label>
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
