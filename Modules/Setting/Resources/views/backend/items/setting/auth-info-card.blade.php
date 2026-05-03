@extends('setting::backend.layout.default')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-head d-flex align-items-center">
                <div class="flex-grow-1">
                    <h4 class="page-main-title m-0">Auth Bilgi Kartları</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="https://softby.net">Softby</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Kontrol Paneli</a></li>
                        <li class="breadcrumb-item active">Auth Bilgi Kartları</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="header-title">Kart Listesi</h4>
                        <div class="float-end">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#ekle" class="btn btn-primary">Kart Ekle</a>
                        </div>

                        <div class="modal fade" id="ekle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Yeni Kart Ekleyin</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('auth_info_card_setting_create') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-floating mb-3">
                                                <input type="text" required name="title" value="{{ old('title') }}" class="form-control" id="floatingInput" placeholder="">
                                                <label for="floatingInput">Başlık</label>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Resim</label>
                                                <input class="form-control" type="file" required name="image" id="inputGroupFile04">
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
                    </div>
                    <div class="card-body">
                        <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Eklenme Tarihi</th>
                                <th>Güncelleme Tarihi</th>
                                <th>Resim</th>
                                <th>Başlık</th>
                                <th>Düzenle</th>
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
                                    <td><img src="/upload/auth-info-card/{{ $key->image }}" class="img-fluid" width="40" alt=""></td>
                                    <td>{{ $key->title }}</td>
                                    <td><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit{{ $key->id }}" type="button">Düzenle</button></td>
                                    <td><a href="{{ route('auth_info_card_setting_delete',$key->id) }}" onclick="confirmation(event)" class="btn btn-danger">Sil</a></td>
                                </tr>

                                <div class="modal fade" id="edit{{ $key->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Kartı Düzenleyin</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('auth_info_card_setting_update',$key->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-floating mb-3">
                                                        <input type="text" required name="title" value="{{ $key->title }}" class="form-control" id="floatingInput" placeholder="">
                                                        <label for="floatingInput">Başlık</label>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label class="form-label">Resim</label>
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

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
