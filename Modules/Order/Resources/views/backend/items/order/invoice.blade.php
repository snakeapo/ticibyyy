<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="/invoice/images/favicon.png" rel="icon">
<title>Sipariş Faturası</title>
<meta name="author" content="Softby">

<!-- Stylesheet
======================= -->
<link rel="stylesheet" type="text/css" href="/invoice/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/invoice/vendor/font-awesome/css/all.min.css">
<link rel="stylesheet" type="text/css" href="/invoice/css/stylesheet.css">
</head>
<body>
<!-- Container -->
<div class="container-fluid invoice-container">
  <!-- Header -->
  <header>
	  <div class="row align-items-center gy-3">
		<div class="col-sm-7 text-center text-sm-start">
		  <img id="logo" src="/invoice/images/logo.png" width="200" title="softby" alt="softby">
		</div>
		<div class="col-sm-5 text-center text-sm-end">
		  <h4 class="text-7 mb-0">Fatura</h4>
		</div>
	  </div>
	  <hr>
  </header>

  <!-- Main Content -->
  <main>
	  <div class="row">
		<div class="col-sm-6"><strong>Tarih:</strong> {{ \Carbon\Carbon::parse($data->created_at)->toDateString() }}</div>
		<div class="col-sm-6 text-sm-end"> <strong>Sipariş No:</strong> {{ $data->order_no }}</div>

	  </div>
	  <hr>
	  <div class="row">
		<div class="col-sm-6 text-sm-end order-sm-1"> <strong>Müşteri:</strong>
		  <address>
		  {{$address->address}},
          <br>
          {{ $address->city }} / {{ $address->town }}
          <br>
		{{ $address->phone }}
		  </address>
		</div>
		<div class="col-sm-6 order-sm-0"> <strong>Satıcı:</strong>
            <br>
          {{ env('APP_NAME') }}
            <br>
		  <address>
		  {{ $setting->address }}
          <br>
            {{ $setting->phone }}
		  </address>
		</div>
	  </div>
		<div class="table-responsive">
		<table class="table border mb-0">
			<thead>
			  <tr class="bg-light">
				<td class="col-3"><strong>Hizmet</strong></td>
				<td class="col-4"><strong>Açıklama</strong></td>
				<td class="col-2 text-center"><strong>Birim</strong></td>
				<td class="col-1 text-center"><strong>Adet</strong></td>
				<td class="col-2 text-end"><strong>Ara Tutar</strong></td>
			  </tr>
			</thead>
			<tbody>
                @foreach ($items as $key)
				<tr>
				  <td class="col-3">Ürün</td>
				  <td class="col-4 text-1">{{ $key->getProduct->title }}</td>
				  <td class="col-2 text-center">@if($key->getProduct->sale_price != 0) {{ number_format($key->getProduct->sale_price,2) }} TL @else {{ number_format($key->getProduct->price,2) }} TL @endif</td>
				  <td class="col-1 text-center">{{ $key->quantity }}</td>
				  <td class="col-2 text-end">{{ number_format($key->total,2) }} TL</td>
				</tr>
                @endforeach
			</tbody>
		</table>
		</div>
		<div class="table-responsive">
			<table class="table border border-top-0 mb-0">

				<tr class="bg-light">
				  <td class="text-end"><strong>Total:</strong></td>
				  <td class="col-sm-2 text-end">{{ number_format($data->total,2) }} TL</td>
				</tr>
			</table>
		</div>
  </main>
  <!-- Footer -->
  <footer class="text-center mt-4">
  <p class="text-1"><strong>NOT :</strong> Bu, sistem tarafından oluşturulan makbuzdur ve fiziksel imza gerektirmez.</p>
  <div class="btn-group btn-group-sm d-print-none"> <a href="javascript:window.print()" class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-print"></i> Yazdır</a> </div>
  </footer>
</div>
</body>
</html>
