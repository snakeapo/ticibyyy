@extends('setting::backend.layout.default')
@section('content')


        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-head d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="page-main-title m-0">Stok Bildirim Listesi</h4>
                        </div>

                        <div class="text-end">
                            <ol class="breadcrumb m-0 py-0">
                                <li class="breadcrumb-item"><a href="https://softby.net">Softby</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Kontrol Paneli</a></li>
                                <li class="breadcrumb-item active">İstek Listesi</li>
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
                                <h4 class="header-title">İstek Listesi</h4>
                            </div>
                            <div class="card-body">
                                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Oluşturma Tarihi</th>
                                            <th>Güncelleme Tarihi</th>
                                            <th>Ürün</th>
                                            <th>Email</th>
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
                                            <td>{{ $key->getProduct->title }}</td>
                                            <td>{{ $key->email }}</td>
                                            <td><a href="{{ route('stock_notify_delete',$key->id) }}" onclick="confirmation(event)" class="btn btn-danger">Sil</a></td>
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
