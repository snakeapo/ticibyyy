<main class="main-wrapper">

    <!-- Start Checkout Area  -->
    <div class="axil-checkout-area axil-section-gap">
        <div class="container">
            <form action="{{ route('order_post',$data->order_no) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-6">

                        <div class="axil-checkout-billing">
                            <h4 class="title mb--40">Gerekli Bilgiler</h4>

                            <div class="form-group">
                                <label>Adres Başlığı</label>
                                <input type="text" required name="address_title" value="{{ old('address_title') }}" placeholder="Ev adresim.." id="address-title">
                            </div>

                            <div class="form-group">
                                <label>Adresiniz <span>*</span></label>
                                <input type="text" value="{{ old('address') }}" id="address" required class="mb--15" placeholder="Mahalle,sokak,cadde,no:1/1" name="address">
                            </div>
                            <div class="form-group">
                                <label>İl <span>*</span></label>
                                <input type="text" id="city" placeholder="Kargo ili" required name="city" value="{{ old('city') }}">
                            </div>
                            <div class="form-group">
                                <label>İlçe <span>*</span></label>
                                <input type="text" id="town" placeholder="Kargo ilçesi" required name="town" value="{{ old('town') }}">
                            </div>
                            <div class="form-group">
                                <label>Telefon <span>*</span></label>
                                <input type="tel" name="phone" placeholder="Alıcı telefonu" required id="phone" value="{{ old('phone') }}">
                            </div>
                            <div class="form-group">
                                <label>Posta Kodu <span>*</span></label>
                                <input type="text" name="postal_code" required id="postal_code" value="{{ old('postal_code') }}">
                            </div>

                            <div class="form-group">
                                <label>Sipariş Notu (opsiyonel)</label>
                                <textarea id="notes" rows="2" name="order_note" placeholder="">{{ old('order_note') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="axil-order-summery order-checkout-summery">
                            <h5 class="title mb--20">Siparişiniz</h5>

                            <div class="summery-table-wrap">
                                <table class="table summery-table">
                                    <thead>
                                    <tr>
                                        <th>Ürün</th>
                                        <th>Ara Fiyat</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach ($items as $key)

                                        @php
                                            $variantIds = $key->variant_token
                                                ? array_filter(explode('-', $key->variant_token))
                                                : [];

                                            $variants = \App\Models\Productvars::whereIn('id', $variantIds)->get();

                                            // 🔥 BASE PRICE (ürün fiyatı)
                                            $baseTotal = 0;

                                            if ($key->quantity > 0) {
                                                $unitPrice = $key->total / $key->quantity;
                                            } else {
                                                $unitPrice = 0;
                                            }

                                            // 🔥 varyant toplamı
                                            $variantTotal = $variants->sum('variant_price');

                                            // 🔥 base price hesapla (unit - variant)
                                            $basePrice = $unitPrice - $variantTotal;
                                        @endphp

                                        <tr class="order-product">

                                            {{-- ÜRÜN --}}
                                            <td>
                                                {{ optional($key->getProduct)->title ?? 'Ürün bulunamadı' }}

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

                                            {{-- FİYAT DETAY --}}
                                            <td style="font-size:13px">

                                                {{-- ÜRÜN FİYATI --}}
                                                <div>
                                                    Ürün:
                                                    {{ number_format($basePrice,2) }} TL
                                                </div>

                                                {{-- VARYANT --}}
                                                @if($variantTotal > 0)
                                                    <div>
                                                        Varyantlar:
                                                        +{{ number_format($variantTotal,2) }} TL
                                                    </div>
                                                @endif

                                                {{-- TOPLAM --}}
                                                <div style="font-weight:600; margin-top:4px;">
                                                    Toplam:
                                                    {{ number_format($unitPrice,2) }} TL
                                                    x {{ $key->quantity }}
                                                </div>

                                                <div>
                                                    <strong>{{ number_format($key->total,2) }} TL</strong>
                                                </div>

                                            </td>

                                        </tr>

                                    @endforeach

                                    {{-- KARGO --}}
                                    <tr class="order-shipping">
                                        <td colspan="2">
                                            <div class="shipping-amount">
                                                <span class="title">Kargolama</span>
                                            </div>

                                            <div id="cargo-options">
                                                @forelse ($cargos as $key)
                                                    <div class="input-group">
                                                        <input type="radio"
                                                               id="cargo{{ $key->id }}"
                                                               value="{{ $key->id }}"
                                                               required
                                                               name="cargo"
                                                               data-price="{{ $key->cargo_price }}">

                                                        <label for="cargo{{ $key->id }}">
                                                            {{ $key->cargo_title }}
                                                            x {{ number_format($key->cargo_price,2) }} TL
                                                        </label>
                                                    </div>
                                                @empty
                                                    <p class="text-danger mb-0">
                                                        Şu an kullanılabilir kargo seçeneği yok.
                                                    </p>
                                                @endforelse
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- TOPLAM --}}
                                    <tr class="order-total">
                                        <td>Toplam</td>
                                        <td class="order-total-amount"
                                            data-base-total="{{ number_format((float) $data->total, 2, '.', '') }}">
                                            {{ number_format($data->total,2) }} TL
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>

                            {{-- ÖDEME --}}
                            <div class="order-payment-method">

                                <div class="single-payment">
                                    <div class="input-group">
                                        <input type="radio" id="radio4" value="1" name="payment_system" required>
                                        <label for="radio4">Banka Havale & Eft</label>
                                    </div>
                                </div>

                                <div class="single-payment">
                                    <div class="input-group">
                                        <input type="radio" id="radio5" value="2" name="payment_system" required>
                                        <label for="radio5">Kapıda Ödeme</label>
                                    </div>
                                </div>

                                <div class="single-payment">
                                    <div class="input-group justify-content-between align-items-center">
                                        <input type="radio" id="radio6" value="3" name="payment_system" required>
                                        <label for="radio6">Paytr</label>
                                        <img src="/extra/img/paytr.svg" width="60">
                                    </div>
                                </div>

                            </div>

                            <button type="submit"
                                    class="axil-btn btn-bg-primary"
                                    @if($cargos->isEmpty()) disabled @endif>
                                Siparişi Onayla
                            </button>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End Checkout Area  -->

</main>
