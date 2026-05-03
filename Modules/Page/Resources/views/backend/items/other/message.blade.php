@extends('setting::backend.layout.default')
@section('content')



        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-head d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="page-main-title m-0">Mesajlar</h4>
                        </div>

                        <div class="text-end">
                            <ol class="breadcrumb m-0 py-0">
                                <li class="breadcrumb-item"><a href="https://softby.net">Softby</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Kontrol Paneli</a></li>
                                <li class="breadcrumb-item active">Mesajlar</li>
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
                                <h4 class="header-title">Gelen Mesaj Listesi</h4>
                            </div>
                            <div class="card-body">
                                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>

                                        <tr>
                                            <th>#</th>
                                            <th>Eklenme Tarihi</th>
                                            <th>Güncelleme Tarihi</th>
                                            <th>Ad Soyad</th>
                                            <th>Email</th>
                                            <th>Telefon</th>
                                            <th>Durum</th>
                                            <th>Detay</th>
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
                                            <td>{{ $key->name }} {{ $key->surname }}</td>
                                            <td>{{ $key->email }}</td>
                                            <td>{{ $key->phone }}</td>
                                            <td>
                                                @if($key->status == 1)
                                                <p style="color: rgb(60, 177, 60)">Okunmuş</p>
                                                @else
                                                <p style="color: orange">Bekliyor</p>
                                                @endif
                                            </td>
                                            <td><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit{{ $key->id }}" type="button">Detay</button></td>
                                            <td><a href="{{ route('message_delete',$key->id) }}" onclick="confirmation(event)" class="btn btn-danger">Sil</a></td>
                                        </tr>

                                        <!-- Modal -->
                                        <div class="modal fade" id="edit{{ $key->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Mesaj Detayı</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-floating mb-3">
                                                        <textarea name="description" class="form-control" style="height: 300px" disabled id="" cols="30" rows="10">{{ $key->message }}</textarea>
                                                        <label for="floatingInput">Mesaj İçeriği</label>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="{{ route('message_read',$key->id) }}" class="btn btn-success">Okundu</a>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div><!-- end col-->

                </div> <!-- end row-->


            </div>

        </div>
        <!-- container -->



@endsection
