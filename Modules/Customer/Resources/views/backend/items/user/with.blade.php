@extends('setting::backend.layout.default')
@section('content')


        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-head d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="page-main-title m-0">Çekim Talepleri</h4>
                        </div>

                        <div class="text-end">
                            <ol class="breadcrumb m-0 py-0">
                                <li class="breadcrumb-item"><a href="https://softby.net">Softby</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Kontrol Paneli</a></li>
                                <li class="breadcrumb-item active">Çekim Talepleri</li>
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
                                <h4 class="header-title">Çekim Talep Listesi</h4>
                            </div>
                            <div class="card-body">
                                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Oluşturma Tarihi</th>
                                            <th>Ad Soyad</th>
                                            <th>Hesap Numarası</th>
                                            <th>İban Numarası</th>
                                            <th>Banka Numarası</th>
                                            <th>Kullanıcı</th>
                                            <th>Tutar</th>
                                            <th>Durum</th>
                                            <th>Sil</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i = 1; @endphp
                                        @foreach ($data as $key)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $key->created_at }}</td>
                                            <td>{{ $key->name_surname }}</td>
                                            <td>{{ $key->account }}</td>
                                            <td>{{ $key->iban }}</td>
                                            <td>{{ $key->bank_name }}</td>
                                            <td>{{ $key->getUser->email }}</td>
                                            <td>{{ number_format($key->total,2) }} TL</td>
                                            <td>
                                                @if($key->status == 1)
                                                <p style="color: rgb(65, 160, 65)">Onaylandı</p>
                                                @elseif($key->status == 2)
                                                <p style="color: rgb(228, 95, 95)">Reddedildi</p>
                                                @else
                                                <p style="color: orange">Bekliyor</p>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('withdraw_okay',$key->id) }}" class="btn btn-primary btn-sm">Onayla</a>
                                                <a href="{{ route('withdraw_reject',$key->id) }}" class="btn btn-danger btn-sm">Reddet</a>
                                                <a href="{{ route('withdraw_delete',$key->id) }}" onclick="confirmation(event)" class="btn btn-danger btn-sm">Sil</a>
                                            </td>
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
