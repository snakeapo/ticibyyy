@extends('setting::backend.layout.default')
@section('content')


        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-head d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="page-main-title m-0">Sipariş Listesi</h4>
                        </div>

                        <div class="text-end">
                            <ol class="breadcrumb m-0 py-0">
                                <li class="breadcrumb-item"><a href="https://softby.net">Softby</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Kontrol Paneli</a></li>
                                <li class="breadcrumb-item active">Sipariş Listesi</li>
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
                                <h4 class="header-title">Hazırlanan Siparişler</h4>

                            </div>
                            <div class="card-body">
                                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>#No</th>
                                            <th>Sipariş Tarihi</th>
                                            <th>Müşteri Email</th>
                                            <th>Müşteri Ad Soyad</th>
                                            <th>Ürün</th>
                                            <th>Toplam</th>
                                            <th>Detay</th>
                                            <th>Fatura</th>
                                            <th>Sil</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key)
                                        <tr>
                                            <td>#{{ $key->order_no }}</td>
                                            <td>{{ $key->created_at }}</td>
                                            <td>{{ $key->getUser->email }}</td>
                                            <td>{{ $key->getUser->name }} {{ $key->getUser->surname }}</td>
                                            <td>{{ \App\Models\Orderitems::where('order_token',$key->order_no)->count()  }} Adet Ürün</td>
                                            <td>{{ number_format($key->total,2) }} TL</td>


                                            <td><a href="{{ route('order_detail',$key->id) }}" class="btn btn-primary">Detay</a></td>
                                            <td><a href="{{ route('invoice',$key->order_no) }}" target="_blank" class="btn btn-pink">Fatura</a></td>
                                            <td><a href="{{ route('order_delete',$key->id) }}" onclick="confirmation(event)" class="btn btn-danger">Sil</a></td>
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
