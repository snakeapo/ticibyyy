@extends('setting::backend.layout.default')
@section('content')


        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-head d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="page-main-title m-0">Canlı Sepet Listesi</h4>
                        </div>

                        <div class="text-end">
                            <ol class="breadcrumb m-0 py-0">
                                <li class="breadcrumb-item"><a href="https://softby.net">Softby</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Kontrol Paneli</a></li>
                                <li class="breadcrumb-item active">Canlı Sepet</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="header-title">Aktif Sepetler</h4>
                        </div>
                        <div class="card-body">
                            <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Sepet No</th>
                                        <th>Müşteri</th>
                                        <th>Ürünler</th>
                                        <th>Toplam Tutar</th>
                                        <th>Oluşturma Tarihi</th>
                                        <th>Güncelleme Tarihi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $basket)
                                        @php
                                            $basketTotal = $basket->items->sum(function ($item) {
                                                return (float) $item->total;
                                            });
                                        @endphp
                                        <tr>
                                            <td>#{{ $basket->basket_token }}</td>
                                            <td>
                                                @if($basket->user)
                                                    {{ $basket->user->name }} {{ $basket->user->surname }}
                                                    <br>
                                                    <small>{{ $basket->user->email }}</small>
                                                @else
                                                    <span class="text-danger">Kullanıcı bulunamadı</span>
                                                @endif
                                            </td>
                                            <td>
                                                <ul class="mb-0 ps-3">
                                                    @foreach ($basket->items as $item)
                                                        <li>
                                                            {{ $item->getProduct->title ?? 'Silinmiş ürün' }}
                                                            (Adet: {{ (int) $item->quantity }})
                                                            - {{ number_format((float) $item->total, 2) }} TL
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>{{ number_format($basketTotal, 2) }} TL</td>
                                            <td>{{ $basket->created_at }}</td>
                                            <td>{{ $basket->updated_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->

            </div> <!-- end row-->


        </div>
        <!-- container -->


@endsection
