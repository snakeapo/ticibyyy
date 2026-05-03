@extends('setting::backend.layout.default')
@section('content')


        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-head d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="page-main-title m-0">Kategoriler</h4>
                        </div>

                        <div class="text-end">
                            <ol class="breadcrumb m-0 py-0">
                                <li class="breadcrumb-item"><a href="https://softby.net">Softby</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Kontrol Paneli</a></li>
                                <li class="breadcrumb-item active">Kategori</li>
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
                                <h4 class="header-title">Kategori Listesi</h4>
                            </div>
                            <div class="card-body">
                                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>

                                        <tr>
                                            <th>#</th>
                                            <th>Eklenme Tarihi</th>
                                            <th>Güncelleme Tarihi</th>
                                            <th>Kategori Adı</th>
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
                                            <td>{{ $key->category_title }}</td>
                                            <td><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit{{ $key->id }}" type="button">Düzenle</button></td>
                                            <td><a href="{{ route('blog_category_delete',$key->id) }}" onclick="confirmation(event)" class="btn btn-danger">Sil</a></td>
                                        </tr>

                                        <!-- Modal -->
                                        <div class="modal fade" id="edit{{ $key->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $key->category_title }} - Kategorisini Düzenleyin</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('blog_category_update',$key->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-floating mb-3">
                                                            <input type="text" required name="category_title" value="{{ $key->category_title }}" class="form-control" id="floatingInput" placeholder="">
                                                            <label for="floatingInput">Kategori Adı</label>
                                                        </div>

                                                        <div class="col-md-12 mb-3">
                                                            <label for="form-label">Meta Başlık</label>
                                                            <input type="text" name="meta_title" value="{{ $key->meta_title }}" class="form-control" id="" placeholder="">
                                                        </div>
                                                        <div class="col-md-12 mb-3">
                                                            <label for="form-label">Meta Anahtar Kelime</label>
                                                            <input type="text" name="meta_keyw" value="{{ $key->meta_keyw }}" class="form-control" id="" placeholder="">
                                                        </div>
                                                        <div class="col-md-12 mb-3">
                                                            <label for="form-label">Meta Açıklama</label>
                                                            <input type="text" name="meta_desc" value="{{ $key->meta_desc }}" class="form-control" id="" placeholder="">
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
                                <h4 class="header-title">Yeni Kategori Oluştur</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('blog_category_insert') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-floating mb-3">
                                        <input type="text" required name="category_title" value="{{ old('category_title') }}" class="form-control" id="floatingInput" placeholder="">
                                        <label for="floatingInput">Kategori Adı</label>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="form-label">Meta Başlık</label>
                                        <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title') }}" id="" placeholder="">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="form-label">Meta Anahtar Kelime</label>
                                        <input type="text" name="meta_keyw" class="form-control" value="{{ old('meta_keyw') }}" id="" placeholder="">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="form-label">Meta Açıklama</label>
                                        <input type="text" name="meta_desc" class="form-control" value="{{ old('meta_desc') }}" id="" placeholder="">
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
