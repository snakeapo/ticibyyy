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

                            @php
                                $statusMap = [
                                    0 => ['text' => 'Bekliyor', 'color' => 'orange'],
                                    1 => ['text' => 'Tamamlandı', 'color' => 'green'],
                                    2 => ['text' => 'Hazırlanıyor', 'color' => '#3ea3bd'],
                                    3 => ['text' => 'Kargolandı', 'color' => 'rgb(79, 79, 207)'],
                                    4 => ['text' => 'İptal Edildi', 'color' => 'rgb(182, 78, 78)'],
                                ];
                                $status = $statusMap[$data->status] ?? ['text' => 'Bilinmiyor', 'color' => '#666'];
                            @endphp

                            @if($data->status == 1)
                            @if($data->comment != 1)
                            <form action="{{ route('comment_insert') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="order" value="{{ $data->order_no }}">
                                @foreach ($items as $key)
                                <input type="hidden" name="product_token[]" value="{{ $key->product_token }}">
                                <p><b>{{ $key->getProduct->title }} - Ürünü İçin Değerlendirmeniz</b></p>
                                <div class="form-group">
                                    <label for="">Puan</label>
                                    <select name="point[]" id="" required>
                                        <option value="1">1 Puan</option>
                                        <option value="2">2 Puan</option>
                                        <option value="3">3 Puan</option>
                                        <option value="4">4 Puan</option>
                                        <option value="5">5 Puan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Yorumunuz</label>
                                    <textarea name="comment[]" id="" required class="form-control" cols="2" style="height: 50px" rows="2"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Resim Eklemek İster misiniz?</label>
                                    <input  name="image[]" type="file" id="formFile">
                                </div>


                            <p style="border-bottom: 1px solid #ddd;margin-bottom:30px"></p>
                            @endforeach
                            <button type="submit" class="axil-btn btn-bg-primary">Değerlendir</button>
                        </form>
                        @else
                        <div class="text-center mb-5">
                            <img src="/extra/img/check-mark.png" width="150" class="img-fluid mb-3" alt="">
                            <p style="margin-bottom: 0px">#{{ $data->order_no }} - Numaralı Siparişleriniz</p>
                            <p>Daha Önce Bu Ürünlere Değerlendirme Yaptınız, Teşekkürler!</p>
                        </div>
                        @endif
                            @else
                            <div class="text-center mb-5">
                                <img src="/extra/img/check-mark.png" width="150" class="img-fluid mb-3" alt="">
                                <p style="margin-bottom: 0px">#{{ $data->order_no }} - Numaralı Siparişiniz</p>
                                <p><b>Tutar: {{ number_format($data->total,2) }} TL</b></p>
                                <p><b>Sipariş Durumu: <span style="color: {{ $status['color'] }}">{{ $status['text'] }}</span></b></p>
                            </div>
                            @endif


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
                                            <td>{{ $key->getProduct->title }}   @if($key->getVariant)
                                    <br>
                                    {{ $key->getVariant->variant_name }} x {{ number_format($key->getVariant->variant_price,2) }} TL
                                @endif <span class="quantity">x{{ $key->quantity }}</span></td>
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
