@extends('page::frontend.layout.master')
@section('content')
    @php
        $hasAddresses = $address->isNotEmpty();
        $showNewAddress = !$hasAddresses || old('address_title') || old('address') || old('city') || old('town') || old('phone') || old('postal_code');
        $selectedAddressId = $showNewAddress ? null : old('user_address', optional($address->first())->id);
        $baseTotal = (float) $data->total;
    @endphp

    <div class="container py-5">
        <form action="{{ route('order_post', $data->order_no) }}" method="POST" id="checkout-form">
            @csrf
            <div class="row pt-1 pt-sm-3 pt-lg-4 pb-2 pb-md-3 pb-lg-4 pb-xl-5">
                <div class="col-lg-8 col-xl-7 mb-5 mb-lg-0">
                    <div class="accordion d-flex flex-column gap-5 pe-lg-4 pe-xl-0" id="checkout">

                        <!-- Registered addresses -->
                        <div class="accordion-item d-flex align-items-start border-0">
                            <div class="d-flex align-items-center justify-content-center bg-body-secondary text-body-secondary rounded-circle flex-shrink-0" style="width: 2rem; height: 2rem; margin-top: -.125rem">
                                <i class="ci-check fs-base"></i>
                            </div>
                            <div class="w-100 ps-3 ps-md-4">
                                <div class="d-flex align-items-center justify-content-between gap-3">
                                    <h2 class="accordion-header h5 mb-0 me-3" id="deliveryInfoHeading">
                                        <span class="d-none d-lg-inline">Kayıtlı adreslerim</span>
                                        <button type="button" class="accordion-button collapsed fs-5 d-lg-none py-1" data-bs-toggle="collapse" data-bs-target="#deliveryInfo" aria-expanded="false" aria-controls="deliveryInfo">
                                            <span class="me-2">Kayıtlı adreslerim</span>
                                        </button>
                                    </h2>
                                    @if($hasAddresses)
                                        <button type="button" class="btn btn-sm btn-outline-primary" id="new-address-toggle">Yeni adres gir</button>
                                    @endif
                                </div>
                                <div class="accordion-collapse collapse d-lg-block" id="deliveryInfo" aria-labelledby="deliveryInfoHeading" data-bs-parent="#checkout">
                                    <div class="accordion-body p-0 pt-3 pt-md-4">
                                        @forelse($address as $take)
                                            <div class="checkout-address-card border rounded-4 p-3 mb-3 {{ $selectedAddressId == $take->id ? 'border-primary' : '' }}" data-address-card>
                                                <div class="nav flex-nowrap align-items-start justify-content-between gap-3">
                                                    <div class="me-4">
                                                        <h3 class="h6 mb-2">{{ $take->address_title }}</h3>
                                                        <ul class="list-unstyled fs-sm mb-0 text-body-secondary">
                                                            <li>{{ $take->town }} / {{ $take->city }}, {{ $take->postal_code }}</li>
                                                            <li>{{ $take->address }}</li>
                                                            <li>{{ $take->phone }}</li>
                                                        </ul>
                                                    </div>
                                                    <button type="button"
                                                            class="btn btn-sm {{ $selectedAddressId == $take->id ? 'btn-primary' : 'btn-outline-primary' }} flex-shrink-0"
                                                            data-address-select
                                                            data-address-id="{{ $take->id }}">
                                                        {{ $selectedAddressId == $take->id ? 'Seçildi' : 'Seç' }}
                                                    </button>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="alert alert-info mb-0">
                                                Kayıtlı adresiniz bulunmuyor. Siparişi tamamlamak için aşağıdaki adres bilgisi alanını doldurun.
                                            </div>
                                        @endforelse
                                        <input type="hidden" name="user_address" id="selected-address-id" value="{{ $selectedAddressId }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping address form -->
                        <div class="d-flex align-items-start {{ $showNewAddress ? '' : 'd-none' }}" id="new-address-section">
                            <div class="d-flex align-items-center justify-content-center bg-body-secondary text-body-secondary rounded-circle fs-sm fw-semibold lh-1 flex-shrink-0" style="width: 2rem; height: 2rem; margin-top: -.125rem">
                                <i class="ci-check fs-base"></i>
                            </div>
                            <div class="w-100 ps-3 ps-md-4">
                                <h2 class="h5 mb-md-4">Adres bilgisi</h2>
                                <div class="row">
                                    <div class="col-lg-6 mb-2">
                                        <label class="form-label">Adres başlığı</label>
                                        <input type="text" class="form-control" placeholder="Ev, Ofis.." name="address_title" value="{{ old('address_title') }}" data-new-address-field {{ $showNewAddress ? 'required' : 'disabled' }}>
                                    </div>
                                    <div class="col-lg-6 mb-2">
                                        <label class="form-label">Telefon <small class="text-warning">(Başında 0 olmadan giriniz.)</small></label>
                                        <input type="tel" class="form-control" placeholder="Alıcı telefonu" name="phone" value="{{ old('phone') }}" data-new-address-field {{ $showNewAddress ? 'required' : 'disabled' }}>
                                    </div>
                                    <div class="col-lg-6 mb-2">
                                        <label class="form-label">İl</label>
                                        <input type="text" class="form-control" placeholder="Kargo ili" name="city" value="{{ old('city') }}" data-new-address-field {{ $showNewAddress ? 'required' : 'disabled' }}>
                                    </div>
                                    <div class="col-lg-6 mb-2">
                                        <label class="form-label">İlçe</label>
                                        <input type="text" class="form-control" placeholder="Kargo ilçesi" name="town" value="{{ old('town') }}" data-new-address-field {{ $showNewAddress ? 'required' : 'disabled' }}>
                                    </div>
                                    <div class="col-lg-4 mb-2">
                                        <label class="form-label">Posta kodu</label>
                                        <input type="text" class="form-control" name="postal_code" value="{{ old('postal_code') }}" data-new-address-field {{ $showNewAddress ? 'required' : 'disabled' }}>
                                    </div>
                                    <div class="col-lg-8 mb-2">
                                        <label class="form-label">Adres</label>
                                        <input type="text" class="form-control" placeholder="Mahalle, sokak, cadde, no:1/1" name="address" value="{{ old('address') }}" data-new-address-field {{ $showNewAddress ? 'required' : 'disabled' }}>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment -->
                        <div class="d-flex align-items-start">
                            <div class="d-flex align-items-center justify-content-center bg-body-secondary text-body-secondary rounded-circle fs-sm fw-semibold lh-1 flex-shrink-0" style="width: 2rem; height: 2rem; margin-top: -.125rem">
                                <i class="ci-check fs-base"></i>
                            </div>
                            <div class="w-100 ps-3 ps-md-4">
                                <h2 class="h5 mb-0">Ödeme</h2>
                                <div class="mb-4" id="paymentMethod" role="list">
                                    <div class="mt-4">
                                        <label class="form-check-label w-100 text-dark-emphasis fw-semibold">
                                            <input type="radio" class="form-check-input fs-base me-2 me-sm-3" value="1" name="payment_system" required @checked(old('payment_system') == 1)>
                                            Banka Havale & Eft
                                        </label>
                                    </div>
                                    <div class="mt-4">
                                        <label class="form-check-label w-100 text-dark-emphasis fw-semibold">
                                            <input type="radio" class="form-check-input fs-base me-2 me-sm-3" value="2" name="payment_system" required @checked(old('payment_system') == 2)>
                                            Kapıda Ödeme
                                        </label>
                                    </div>
                                    <div class="mt-4">
                                        <label class="form-check-label d-flex align-items-center text-dark-emphasis fw-semibold">
                                            <input type="radio" class="form-check-input fs-base me-2 me-sm-3" value="3" name="payment_system" required @checked(old('payment_system') == 3)>
                                            Paytr
                                            <img src="/extra/img/paytr.svg" class="ms-3" width="60" alt="Paytr">
                                        </label>
                                    </div>
                                </div>

                                <h2 class="h5 mb-0">Kargo</h2>
                                <div class="mb-4" id="cargo-options" role="list">
                                    @forelse ($cargos as $cargo)
                                        <div class="mt-4">
                                            <label class="form-check-label d-flex align-items-center justify-content-between gap-3 text-dark-emphasis fw-semibold">
                                                <span>
                                                    <input type="radio"
                                                           class="form-check-input fs-base me-2 me-sm-3"
                                                           id="cargo{{ $cargo->id }}"
                                                           value="{{ $cargo->id }}"
                                                           name="cargo"
                                                           data-price="{{ $cargo->cargo_price }}"
                                                           required
                                                           @checked(old('cargo') == $cargo->id)>
                                                    {{ $cargo->cargo_title }}
                                                </span>
                                                <span class="text-body-secondary">{{ number_format($cargo->cargo_price, 2) }} TL</span>
                                            </label>
                                        </div>
                                    @empty
                                        <p class="text-danger mt-4 mb-0">Şu an kullanılabilir kargo seçeneği yok.</p>
                                    @endforelse
                                </div>

                                <textarea class="form-control form-control-lg mb-4" rows="3" name="order_note" placeholder="Sipariş notu (opsiyonel)">{{ old('order_note') }}</textarea>

                                <button type="submit" class="btn btn-lg btn-primary w-100 d-none d-lg-flex justify-content-center" @if($cargos->isEmpty()) disabled @endif>
                                    Siparişi Onayla
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order summary (sticky sidebar) -->
                <aside class="col-lg-4 offset-xl-1" style="margin-top: -100px">
                    <div class="position-sticky top-0" style="padding-top: 100px">
                        <div class="bg-body-tertiary rounded-5 p-4 mb-3">
                            <div class="p-sm-2 p-lg-0 p-xl-2">
                                <div class="border-bottom pb-4 mb-4">
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <h5 class="mb-0">Siparişiniz</h5>

                                    </div>
                                    <div class="d-flex flex-column gap-3">
                                        @foreach ($items as $item)
                                            @php
                                                $variantIds = $item->variant_token ? array_filter(explode('-', $item->variant_token)) : [];
                                                $variants = \App\Models\Productvars::whereIn('id', $variantIds)->get();
                                                $unitPrice = $item->quantity > 0 ? $item->total / $item->quantity : 0;
                                                $variantTotal = $variants->sum('variant_price');
                                                $basePrice = $unitPrice - $variantTotal;
                                                $firstVariant = $variants->first();
                                                $product = $item->getProduct;
                                            @endphp
                                            <div class="d-flex gap-3">
                                                <div class="ratio ratio-1x1 flex-shrink-0" style="max-width: 72px">
                                                    @if($firstVariant && $firstVariant->variant_image)
                                                        <img src="{{ asset('/upload/product/'.$firstVariant->variant_image) }}" class="d-block rounded-3 object-fit-cover" alt="{{ optional($product)->title ?? 'Ürün' }}" onerror="this.src='/extra/img/photo.png'">
                                                    @else
                                                        <img src="{{ asset('/upload/product/'.optional($product)->image) }}" class="d-block rounded-3 object-fit-cover" alt="{{ optional($product)->title ?? 'Ürün' }}" onerror="this.src='/extra/img/photo.png'">
                                                    @endif
                                                </div>
                                                <div class="w-100 min-w-0">
                                                    <div class="d-flex justify-content-between gap-2">
                                                        <h6 class="fs-sm mb-1">{{ optional($product)->title ? \Illuminate\Support\Str::limit($product->title, 45) : 'Ürün bulunamadı' }}</h6>
                                                        <span class="fs-sm fw-semibold text-nowrap">{{ number_format($item->total, 2) }} TL</span>
                                                    </div>
                                                    <div class="fs-xs text-body-secondary">Ürün: {{ number_format($basePrice, 2) }} TL x {{ $item->quantity }}</div>
                                                    @foreach($variants as $variant)
                                                        <div class="fs-xs text-body-secondary">{{ $variant->variant_type }}: {{ $variant->variant_name }} (+{{ number_format($variant->variant_price, 2) }} TL)</div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <ul class="list-unstyled fs-sm gap-3 mb-0">
                                    <li class="d-flex justify-content-between">
                                        Ara toplam:
                                        <span class="text-dark-emphasis fw-medium">{{ number_format($baseTotal, 2) }} TL</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        Kargo:
                                        <span class="text-dark-emphasis fw-medium" id="selected-cargo-amount">0,00 TL</span>
                                    </li>
                                </ul>
                                <div class="border-top pt-4 mt-4">
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="fs-sm">Toplam:</span>
                                        <span class="h5 mb-0 order-total-amount" data-base-total="{{ number_format($baseTotal, 2, '.', '') }}">{{ number_format($baseTotal, 2) }} TL</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-lg btn-primary w-100 d-lg-none" @if($cargos->isEmpty()) disabled @endif>
                            Siparişi Onayla
                        </button>
                    </div>
                </aside>
            </div>
        </form>
    </div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectedAddressInput = document.getElementById('selected-address-id');
        const addressButtons = document.querySelectorAll('[data-address-select]');
        const addressCards = document.querySelectorAll('[data-address-card]');
        const newAddressSection = document.getElementById('new-address-section');
        const newAddressToggle = document.getElementById('new-address-toggle');
        const newAddressFields = document.querySelectorAll('[data-new-address-field]');
        const cargoRadios = document.querySelectorAll('input[name="cargo"]');
        const totalNode = document.querySelector('.order-total-amount');
        const cargoAmountNode = document.getElementById('selected-cargo-amount');

        const formatter = new Intl.NumberFormat('tr-TR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        });

        function toggleNewAddress(show) {
            if (!newAddressSection) {
                return;
            }

            newAddressSection.classList.toggle('d-none', !show);
            newAddressFields.forEach((field) => {
                field.disabled = !show;
                field.required = show;
            });

            if (show && selectedAddressInput) {
                selectedAddressInput.value = '';
                addressButtons.forEach((button) => {
                    button.classList.remove('btn-primary');
                    button.classList.add('btn-outline-primary');
                    button.textContent = 'Seç';
                });
                addressCards.forEach((card) => card.classList.remove('border-primary'));
            }
        }

        addressButtons.forEach((button) => {
            button.addEventListener('click', function () {
                if (selectedAddressInput) {
                    selectedAddressInput.value = this.dataset.addressId;
                }

                addressButtons.forEach((item) => {
                    item.classList.remove('btn-primary');
                    item.classList.add('btn-outline-primary');
                    item.textContent = 'Seç';
                });
                addressCards.forEach((card) => card.classList.remove('border-primary'));

                this.classList.remove('btn-outline-primary');
                this.classList.add('btn-primary');
                this.textContent = 'Seçildi';
                this.closest('[data-address-card]')?.classList.add('border-primary');
                toggleNewAddress(false);
            });
        });

        if (newAddressToggle) {
            newAddressToggle.addEventListener('click', function () {
                toggleNewAddress(true);
            });
        }

        if (selectedAddressInput && selectedAddressInput.value) {
            toggleNewAddress(false);
        }

        function updateTotal(selectedCargo) {
            if (!totalNode) {
                return;
            }

            const baseTotal = Number.parseFloat(totalNode.dataset.baseTotal || '0');
            const cargoPrice = Number.parseFloat(selectedCargo?.dataset.price || '0');
            const safeCargoPrice = Number.isFinite(cargoPrice) ? cargoPrice : 0;
            totalNode.textContent = `${formatter.format(baseTotal + safeCargoPrice)} TL`;

            if (cargoAmountNode) {
                cargoAmountNode.textContent = `${formatter.format(safeCargoPrice)} TL`;
            }
        }

        cargoRadios.forEach((radio) => {
            radio.addEventListener('change', function () {
                updateTotal(this);
            });

            if (radio.checked) {
                updateTotal(radio);
            }
        });
    });
</script>
@endsection
