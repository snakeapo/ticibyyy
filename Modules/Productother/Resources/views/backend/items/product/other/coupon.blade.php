@extends('setting::backend.layout.default')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-head d-flex align-items-center">
                <div class="flex-grow-1">
                    <h4 class="page-main-title m-0">Kupon Listesi</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="https://softby.net">Softby</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Kontrol Paneli</a></li>
                        <li class="breadcrumb-item active">Kupon Listesi</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="header-title mb-0">Kupon Listesi</h4>
                    <a href="{{ route('coupon_create_page') }}" class="btn btn-primary">Kupon Ekle</a>
                </div>

                <div class="card-body">
                    <div class="row">
                        <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kupon Adı</th>
                                    <th>Tip</th>
                                    <th>Alan</th>
                                    <th>Kalan Adet</th>
                                    <th>Kupon Kodu</th>
                                    <th>Kupon Kodu</th>
                                    <th>Düzenle</th>
                                    <th>Sil</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($data as $key)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $key->coupon_name }}</td>
                                    <td>{{ $key->discount_type === 'percent' ? 'Yüzde' : 'Sabit TL' }} ({{ $key->coupon_ratio }})</td>
                                    <td>{{ [
                                        'both' => 'Ürün + Sepet',
                                        'product' => 'Sadece Ürün',
                                        'cart' => 'Sadece Sepet',
                                    ][$key->coupon_scope] ?? '-' }}</td>
                                    <td>{{ $key->coupon_quantity }}</td>
                                    @if($key->hide == 1)  <td>Herkese açık</td> @else <td>Özel</td> @endif
                                    <td onclick="copyCouponCode('{{ $key->coupon_code }}')">{{ $key->coupon_code }}</td>
                                    <td><a href="{{ route('coupon_edit_page',$key->id) }}" class="btn btn-primary">Düzenle</a></td>
                                    <td><a href="{{ route('coupon_delete',$key->id) }}" onclick="confirmation(event)" class="btn btn-danger">Sil</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@section('js')
<script>
    function copyCouponCode(code) {
      var tempInput = document.createElement("input");
      tempInput.value = code;
      document.body.appendChild(tempInput);
      tempInput.select();
      document.execCommand("copy");
      document.body.removeChild(tempInput);
      alert("Kupon kodu kopyalandı: " + code);
    }
</script>
@endsection
@endsection
