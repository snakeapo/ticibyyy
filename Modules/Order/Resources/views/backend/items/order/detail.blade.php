@extends('setting::backend.layout.default')
@section('content')


        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-head d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="page-main-title m-0">Sipariş Ürün Detayları</h4>
                        </div>

                        <div class="text-end">
                            <ol class="breadcrumb m-0 py-0">
                                <li class="breadcrumb-item"><a href="https://softby.net">Softby</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Kontrol Paneli</a></li>
                                <li class="breadcrumb-item active">Sipariş Ürün Detayları</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
        <address>
		  <div class="alert alert-info">Gönderilecek adres: <b>{{$address->address}}</b> - İl/İlçe: <b>{{ $address->city }} / {{ $address->town }}</b> - Telefon: <b>{{ $address->phone }}</b></div>
		  </address>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="header-title">#{{ $data->order_no }} Nolu Sipariş Detay</h4>
                                <div class="float-start">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#siparis" class="btn btn-primary">Sipariş İşlemleri</a>
                                </div>

                            <!-- Modal -->
                            <div class="modal fade" id="siparis" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Sipariş İşlemi</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    <form method="POST" action="{{ route('order_status',$data->order_no) }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="">Sipariş Durumu</label>
                                            <select name="status" class="form-control" required id="">
                                                <option value="0" @selected($data->status == 0)>İşlem Bekliyor</option>
                                                <option value="1" @selected($data->status == 1)>Teslim Edildi</option>
                                                <option value="2" @selected($data->status == 2)>Hazırlanıyor</option>
                                                <option value="3" @selected($data->status == 3)>Kargolandı</option>
                                                <option value="4" @selected($data->status == 4)>İptal Edildi</option>
                                            </select>
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

                            </div>
                            <div class="card-body">
                                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>#No</th>
                                            <th>Resim</th>
                                            <th>Ürün Adı</th>
                                            <th>Birim Fiyat</th>
                                            <th>Toplam</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $key)
                                        <tr>
                                            <td>#{{ $key->order_no }}</td>
                                            @if($key->getVariant) <td><img src="/upload/product/{{ $key->getVariant->variant_image }}" class="img-fluid" width="48" alt=""></td> @else <td><img src="/upload/product/{{ $key->getProduct->image }}" class="img-fluid" width="48" alt=""></td> @endif
                                            <td>{{ $key->getProduct->title }} @if($key->getVariant)
                                    <br>
                                   - {{ $key->getVariant->variant_name }} x {{ number_format($key->getVariant->variant_price,2) }} TL
                                @endif</td>
                                            <td>{{ number_format($key->getProduct->price,2) }} TL</td>
                                            <td>{{ number_format($key->total,2) }} TL</td>
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
