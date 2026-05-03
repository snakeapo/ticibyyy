@extends('setting::backend.layout.default')
@section('content')
        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-head d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="page-main-title m-0">Ürün Yorumları</h4>
                        </div>

                        <div class="text-end">
                            <ol class="breadcrumb m-0 py-0">
                                <li class="breadcrumb-item"><a href="https://softby.net">Softby</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Kontrol Paneli</a></li>
                                <li class="breadcrumb-item active">Yorumlar</li>
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
                            <h4 class="header-title">Ürün Yorum Listesi</h4>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>

                                        <tr>
                                            <th>#</th>
                                            <th>Yorum Tarihi</th>
                                            <th>Cevap Tarihi</th>
                                            <th>Kullanıcı</th>
                                            <th>Ürün</th>
                                            <th>Durum</th>
                                            <th>Detay</th>
                                            <th>Cevap</th>
                                            <th>Sil</th>
                                        </tr>
                                    </thead>


                                    <tbody>
                                        @php $i = 1; @endphp
                                        @foreach ($data as $key)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $key->created_at }}</td>
                                            <td>@if($key->answer != 0) {{ $key->answer_time }} @else <i>Cevap Yok!</i> @endif</td>
                                            <td>
                                                <p>{{ $key->getUser->email }}</p>
                                            </td>

                                            <td>{{ Str::limit($key->getProduct->title,20) }}</td>
                                            <td>
                                                @if($key->status == 1)
                                                <p style="color: rgb(65, 160, 65)">Yayında</p>
                                                @elseif($key->status == 2)
                                                <p style="color: rgb(228, 95, 95)">Yayında Değil</p>
                                                @else
                                                <p style="color: orange">Bekliyor</p>
                                                @endif
                                            </td>
                                            <td><a class="btn btn-success" href="#" data-bs-toggle="modal" data-bs-target="#detay{{ $key->id }}">Detay</a></td>
                                            <td><a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#duzenle{{ $key->id }}">Cevap</a></td>
                                            <td><a href="{{ route('comment_delete',$key->id) }}" onclick="confirmation(event)" class="btn btn-danger">Sil</a></td>
                                        </tr>
                                        <!-- Detay -->
                                        <div class="modal fade" id="detay{{ $key->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Yorum Detayı</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label for="">Ürün</label>
                                                            <input type="text" class="form-control" disabled value="{{ $key->getProduct->title }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="">Puan</label>
                                                            <input type="text" class="form-control" disabled value="{{ $key->point }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="">Yorum</label>
                                                          <textarea name="" disabled  class="form-control" cols="30" rows="10">{{ $key->comment }}</textarea>
                                                        </div>

                                                    </div><!-- end col -->
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="{{ route('comment_reject',$key->id) }}" class="btn btn-danger">Reddet</a>
                                                    <a href="{{ route('comment_okay',$key->id) }}" class="btn btn-primary">Onayla</a>
                                                </div>

                                            </div>
                                            </div>
                                        </div>
                                        <!-- Cevap -->
                                        <div class="modal fade" id="duzenle{{ $key->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Yorum Cevabı</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                <form action="{{ route('comment_update',$key->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="">Cevap</label>
                                                      <textarea name="answer"  class="form-control" cols="30" rows="10">{{ $key->answer }}</textarea>
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
