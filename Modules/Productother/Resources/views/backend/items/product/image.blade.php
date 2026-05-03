@extends('setting::backend.layout.default')
@section('content')
        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-head d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="page-main-title m-0">Resim Listesi</h4>
                        </div>

                        <div class="text-end">
                            <ol class="breadcrumb m-0 py-0">
                                <li class="breadcrumb-item"><a href="https://softby.net">Softby</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Kontrol Paneli</a></li>
                                <li class="breadcrumb-item active">Resim Listesi</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="header-title">Ürün İç Resimleri</h4>
                            <div class="float-start">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#ekle" class="btn btn-primary">Resim Ekle</a>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="ekle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Yeni Resim Ekle</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                <form action="{{ route('product_image_create',$data->product_token) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-12">
                                        <div class="form-floating mb-3">
                                            <input type="file" required name="image" class="form-control" placeholder="">
                                            <label>Resim</label>
                                        </div>
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

                        <div class="card-body">
                            <div id="">
                            <div class="row">
                                @foreach ($image as $key)

                                <div class="col-sm-6 col-lg-3">

                                    <!-- Simple card -->
                                    <div class="card d-block">
                                        <img class="card-img-top" src="/upload/product/{{ $key->image }}" alt="softby urun resim">
                                        <div class="card-body">

                                            <a href="#" data-bs-toggle="modal" data-bs-target="#duzenle{{ $key->id }}" class="btn btn-primary">Düzenle</a>
                                            <a href="{{ route('product_image_delete',$key->id) }}" onclick="confirmation(event)" class="btn btn-danger">Sil</a>
                                        </div> <!-- end card-body-->
                                    </div> <!-- end card-->
                                </div><!-- end col -->

                                    <!-- Modal -->
                                    <div class="modal fade" id="duzenle{{ $key->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Resim Düzenle</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                            <form action="{{ route('product_image_update',$key->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="col-md-12">
                                                    <div class="form-floating mb-3">
                                                        <input type="file" required name="image" class="form-control" placeholder="">
                                                        <label>Resim</label>
                                                    </div>
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
                            </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


        </div>


@endsection
