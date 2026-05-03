@extends('setting::backend.layout.default')
@section('content')


        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-head d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="page-main-title m-0">Admin Listesi</h4>
                        </div>

                        <div class="text-end">
                            <ol class="breadcrumb m-0 py-0">
                                <li class="breadcrumb-item"><a href="https://softby.net">Softby</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Kontrol Paneli</a></li>
                                <li class="breadcrumb-item active">Admin Listesi</li>
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
                                <h4 class="header-title">Tüm Adminler</h4>
                                <div class="float-end">
                                    <a href="{{ route('user_insert') }}" class="btn btn-primary">Kullanıcı Ekle</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Kimlik</th>
                                            <th>Kayıt Tarihi</th>
                                            <th>Güncelleme Tarihi</th>
                                            <th>Ad Soyad</th>
                                            <th>Email</th>
                                            <th>Cinsiyet</th>
                                            <th>Düzenle</th>
                                            <th>Sil</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i = 1; @endphp
                                        @foreach ($data as $key)
                                        <tr>
                                            <td>{{ $key->identy }}</td>
                                            <td>{{ $key->created_at }}</td>
                                            <td>{{ $key->updated_at }}</td>
                                            <td>{{ $key->name }} {{ $key->surname }}</td>
                                            <td>{{ $key->email }}</td>
                                            <td>
                                                @if($key->sex == "male")
                                                Erkek
                                                @elseif($key->sex == "female")
                                                Kadın
                                                @endif
                                            </td>
                                            <td><a href="{{ route('user_edit',$key->id) }}" class="btn btn-primary">Düzenle</a></td>
                                            <td><a href="{{ route('user_delete',$key->id) }}" onclick="confirmation(event)" class="btn btn-danger">Sil</a></td>
                                        </tr>
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
