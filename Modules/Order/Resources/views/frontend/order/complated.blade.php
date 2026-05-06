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
                                <img src="/extra/img/check-mark.png" width="150" class="img-fluid mb-3" alt="">
                                <p style="margin-bottom: 0px">#{{ $data->order_no }} - Numaralı Siparişiniz</p>
                                <p><b>@if($data->payment_system == 3) Ödenen @else Ödenecek @endif Tutar: {{ number_format($data->total,2) }} TL</b></p>
                            </div>
                            @if($data->payment_system == 1)
                            <div class="table-responsive">
                                <table class="table axil-product-table axil-wishlist-table">
                                    <thead>
                                        <tr>
                                            <th style="font-size:14px" scope="col">Banka Adı</th>
                                            <th style="font-size:14px" scope="col">Hesap Numarası</th>
                                            <th style="font-size:14px" scope="col">İban Numarası</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($banks as $key)
                                        <tr>
                                            <td style="font-size: 14px">{{ $key->title }}</td>
                                            <td style="font-size: 14px">{{ $key->account }}</td>
                                            <td style="font-size: 14px">{{ $key->iban }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="alert alert-info mt-5" role="alert">
                                <h4 class="alert-heading">Dikkat!</h4>
                                <p>Yukarıdaki tablodan herhangi bir hesap numarasına ödemenizi gerçekleştirebilirsiniz, dikkat etmeniz gereken husus, ödeme açıklamasına
                                    <b>"{{ $data->order_no }}"</b> Sipariş kodunu girmelisiniz.
                                </p>
                                <p><i class="fas fa-exclamation"></i> Sipariş Kodu Girilmeyen Ödemeler Geçersiz Sayılacaktır <i class="fas fa-exclamation"></i></p>
                            </div>
                            @elseif($data->payment_system == 2)

                            <div class="alert alert-info mt-5" role="alert">
                                <h4 class="alert-heading">Dikkat!</h4>
                                <p>
                                    <b>"{{ $data->order_no }}"</b> Sipariş kodunuz tarafınıza mail olarak gönderilmiş olup,
                                    sipariş takibi ve sipariş teslimi bu kod üzerinden gerçekleştirilecektir.
                                </p>
                                <p><i class="fas fa-exclamation"></i> Sipariş Kodunuzu Lütfen Kaybetmeyiniz. <i class="fas fa-exclamation"></i></p>
                            </div>
                            @elseif($data->payment_system == 3)
                            <p>Ödemeniz İçin Teşekkürler En Kısa Sürede Tarafınıza Bilgi Verilecektir.</p>
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

                                        @php
                                            // 🔥 variant parse
                                            $variantIds = $key->variant_token
                                                ? array_filter(explode('-', $key->variant_token))
                                                : [];

                                            $variants = \App\Models\Productvars::whereIn('id', $variantIds)->get();

                                            // 🔥 variant toplam
                                            $variantTotal = $variants->sum('variant_price');

                                            // 🔥 unit price
                                            $unitPrice = $key->quantity > 0
                                                ? ($key->total / $key->quantity)
                                                : 0;

                                            // 🔥 base price
                                            $basePrice = $unitPrice - $variantTotal;
                                        @endphp

                                        <tr class="order-product">

                                            {{-- ÜRÜN --}}
                                            <td>
                                                {{ $key->getProduct->title }}

                                                {{-- 🔥 VARYANTLAR --}}
                                                @if($variants->count())
                                                    <br>
                                                    @foreach($variants as $v)
                                                        <span style="font-size:12px; display:block;">
                        {{ $v->variant_type }}:
                        {{ $v->variant_name }}
                        (+{{ number_format($v->variant_price,2) }} TL)
                    </span>
                                                    @endforeach
                                                @endif

                                                <span class="quantity">x{{ $key->quantity }}</span>
                                            </td>

                                            {{-- FİYAT --}}
                                            <td style="font-size:13px">

                                                <div>Ürün: {{ number_format($basePrice,2) }} TL</div>

                                                @if($variantTotal > 0)
                                                    <div>Varyantlar: +{{ number_format($variantTotal,2) }} TL</div>
                                                @endif

                                                <div style="font-weight:600;">
                                                    Toplam: {{ number_format($unitPrice,2) }} TL x {{ $key->quantity }}
                                                </div>

                                                <div>
                                                    <strong>{{ number_format($key->total,2) }} TL</strong>
                                                </div>

                                            </td>

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
