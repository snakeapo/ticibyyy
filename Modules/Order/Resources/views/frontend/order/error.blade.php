@extends('page::frontend.layout.master')
@section('content')
<main class="main-wrapper">

    <!-- Start Checkout Area  -->
    <div class="axil-checkout-area axil-section-gap">
        <div class="container">
                <div class="row">
                    <div class="col-lg-6">

                        <div class="axil-checkout-billing">
                            <h4 class="title mb--40">Siparişiniz İle İlgili</h4>
                            <div class="text-center mb-5">
                                <img src="/extra/img/error.png" width="150" class="img-fluid mb-3" alt="">
                                <p style="margin-bottom: 0px">#{{ $data->order_no }} - Numaralı Siparişiniz</p>
                                <p><b>Ödenecek Tutar: {{ number_format($data->total,2) }} TL</b></p>
                            </div>


                            <p>Ödemeniz Başarısız Oldu Lütfen Tekrar Deneyin veye Yönetici İle İletişime Geçin</p>


                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="axil-order-summery order-checkout-summery">
                            <h5 class="title mb--20">Detay</h5>
                            <div class="summery-table-wrap">
                                <table class="table summery-table">
                                    <thead>
                                        <tr>
                                            <th>Ürün</th>
                                            <th>Ara Toplam</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $key)
                                        <tr class="order-product">
                                            <td>{{ $key->getProduct->title }} <span class="quantity">x{{ $key->quantity }}</span></td>
                                            <td>{{ number_format($key->total,2) }} TL</td>
                                        </tr>
                                        @endforeach
                                        <tr class="order-shipping">
                                            <td colspan="2">
                                                <div class="shipping-amount">
                                                    <span class="title">{{ optional($data->getCargo)->cargo_title ?? 'Kargo bilgisi yok' }}</span>
                                                    <span class="amount">{{ number_format(optional($data->getCargo)->cargo_price ?? 0,2) }} TL</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="order-total">
                                            <td>Toplam</td>
                                            <td class="order-total-amount">{{ number_format($data->total,2) }} TL</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <h5 class="title mb--20">Ödeme Yöntemi</h5>
                            <div class="order-payment-method">
                                @if($data->payment_system == 1)
                                <div class="single-payment">
                                    <div class="input-group">
                                        <label for="radio4">Banka Havale & Eft</label>
                                    </div>
                                    <p>Ödemenizi doğrudan banka hesabımıza yapın. Lütfen ödeme referansı olarak Sipariş Kimliğinizi kullanın. Hesabımıza para geçene kadar siparişiniz gönderilmeyecektir.</p>
                                </div>
                                @elseif($data->payment_system == 2)
                                <div class="single-payment">
                                    <div class="input-group">
                                        <label for="radio5">Kapıda Ödeme</label>
                                    </div>
                                    <p>Kapıda ödeme seçeneği ile size verilen kod sayesinde kapıda ödeme yapabilirsiniz.</p>
                                </div>
                                @elseif($data->payment_system == 3)
                                <div class="single-payment">
                                    <div class="input-group justify-content-between align-items-center">
                                        <label for="radio6">Paytr</label>
                                        <img src="/extra/img/paytr.svg" width="60" alt="paytr payment">
                                    </div>
                                    <p>Paytr sanal pos ile ödemenizi anında yapın, ürün hemen hazırlanıp kargolansın</p>
                                </div>
                                @endif
                            </div>
                            <p><b>Sipariş Notunuz:</b> @if($data->order_note != null) {{ $data->order_note }} @else <i>Herhangi bir not bulunamadı.</i> @endif</p>
                        </div>
                    </div>
                </div>

        </div>
    </div>
    <!-- End Checkout Area  -->

</main>
@endsection
