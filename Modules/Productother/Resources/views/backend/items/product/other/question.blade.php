@extends('setting::backend.layout.default')
@section('content')
        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-head d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="page-main-title m-0">Ürün Soru & Cevap</h4>
                        </div>

                        <div class="text-end">
                            <ol class="breadcrumb m-0 py-0">
                                <li class="breadcrumb-item"><a href="https://softby.net">Softby</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Kontrol Paneli</a></li>
                                <li class="breadcrumb-item active">Sorular</li>
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
                            <h4 class="header-title">Tüm Soru & Cevaplar</h4>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>

                                        <tr>
                                            <th>#</th>
                                            <th>Eklenme Tarihi</th>
                                            <th>Güncelleme Tarihi</th>
                                            <th>Kullanıcı</th>
                                            <th>Ürün</th>
                                            <th>Soru</th>
                                            <th>Durum</th>
                                            <th>Cevapla</th>
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

                                            <td>
                                                <p>{{ $key->getUser->email }}</p>
                                            </td>

                                            <td>{{ Str::limit($key->getProduct->title,20) }}</td>
                                            <td>{{ $key->ask }}</td>
                                            <td>
                                                @if($key->status == 1)
                                                <p style="color: rgb(65, 160, 65)">Cevaplandı</p>
                                                @else
                                                <p style="color: orange">Bekliyor</p>
                                                @endif
                                            </td>

                                            <td><a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#duzenle{{ $key->id }}">Cevap</a></td>
                                            <td><a href="{{ route('question_delete',$key->id) }}" onclick="confirmation(event)" class="btn btn-danger">Sil</a></td>
                                        </tr>
                                        <!-- Cevap -->
                                        <div class="modal fade" id="duzenle{{ $key->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Soru Cevabı</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                <form action="{{ route('question_answer',$key->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="">Cevap</label>
                                                      <textarea name="answer" class="form-control" cols="30" rows="10">{{ $key->answer }}</textarea>
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
