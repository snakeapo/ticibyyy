@extends('page::frontend.layout.master')
@section('content')

    <div class="container py-5">
        <div class="row pt-1 pt-sm-3 pt-lg-4 pb-2 pb-md-3 pb-lg-4 pb-xl-5">
            <div class="col-lg-8 col-xl-7 mb-5 mb-lg-0">
                <div class="accordion d-flex flex-column gap-5 pe-lg-4 pe-xl-0" id="checkout">

                    <!-- Delivery info overview + Edit button -->
                    <div class="accordion-item d-flex align-items-start border-0">
                        <div class="d-flex align-items-center justify-content-center bg-body-secondary text-body-secondary rounded-circle flex-shrink-0" style="width: 2rem; height: 2rem; margin-top: -.125rem">
                            <i class="ci-check fs-base"></i>
                        </div>
                        <div class="w-100 ps-3 ps-md-4">
                            <div class="d-flex align-items-center">
                                <h2 class="accordion-header h5 mb-0 me-3" id="deliveryInfoHeading">
                                    <span class="d-none d-lg-inline">Kayıtlı adreslerim</span>
                                    <button type="button" class="accordion-button collapsed fs-5 d-lg-none py-1" data-bs-toggle="collapse" data-bs-target="#deliveryInfo" aria-expanded="false" aria-controls="deliveryInfo">
                                        <span class="me-2">Kayıtlı adreslerim</span>
                                    </button>
                                </h2>

                            </div>
                            <div class="accordion-collapse collapse d-lg-block" id="deliveryInfo" aria-labelledby="deliveryInfoHeading" data-bs-parent="#checkout">
                                <div class="accordion-body p-0 pt-3 pt-md-4">
                                    @forelse($address as $take)


                                        <!-- Primary shipping address -->
                                        <div class="border-bottom py-4">
                                            <div class="nav flex-nowrap align-items-center justify-content-between pb-1 mb-3">
                                                <div class="d-flex align-items-center gap-3 me-4">
                                                    <h2 class="h6 mb-0">{{ $take->address_title }}</h2>
                                           
                                                </div>
                                                <div class="d-flex align-items-center gap-3">
                                                    <a class="nav-link hiding-collapse-toggle text-decoration-underline p-0 collapsed" href="#primaryAddress{{ $take->id }}" data-bs-toggle="collapse" aria-expanded="false" aria-controls="primaryAddressPreview primaryAddressEdit">Düzenle</a>
                                                        <button type="submit" class="btn btn-link nav-link text-danger text-decoration-underline p-0">Seç</button>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Shipping address form -->
                    <div class="d-flex align-items-start">
                        <div class="d-flex align-items-center justify-content-center bg-body-secondary text-body-secondary rounded-circle fs-sm fw-semibold lh-1 flex-shrink-0" style="width: 2rem; height: 2rem; margin-top: -.125rem">
                            <i class="ci-check fs-base"></i>
                        </div>
                        <div class="w-100 ps-3 ps-md-4">
                            <h1 class="h5 mb-md-4">Adres bilgisi</h1>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <div class="position-relative">
                                        <label class="form-label">Adres başlığı</label>
                                        <input type="text" class="form-control" placeholder="Ev,Ofis.." name="address_title" required>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <div class="position-relative">
                                        <label class="form-label">Telefon <small class="text-warning">(Başında 0 olmadan giriniz.)</small></label>
                                        <input type="number" class="form-control" name="phone" required>
                                    </div>
                                </div>

                                <div class="col-lg-6 mb-2">
                                    <div class="position-relative">
                                        <label class="form-label">İl</label>
                                        <input type="text" class="form-control" name="city" required>
                                    </div>
                                </div>

                                <div class="col-lg-6 mb-2">
                                    <div class="position-relative">
                                        <label class="form-label">İl</label>
                                        <input type="text" class="form-control" name="town" required>
                                    </div>
                                </div>
                                <div class="col-lg-4 mb-2">
                                    <div class="position-relative">
                                        <label for="add-zip" class="form-label">Posta kodu</label>
                                        <input type="text" class="form-control" name="postal_code">
                                    </div>
                                </div>
                                <div class="col-lg-8 mb-2">
                                    <div class="position-relative">
                                        <label for="add-address" class="form-label">Adres</label>
                                        <input type="text" class="form-control" name="address" required>
                                    </div>
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

                                <!-- Cash on delivery -->
                                <div class="mt-4">
                                    <div class="form-check mb-0" role="listitem" data-bs-toggle="collapse" data-bs-target="#cash" aria-expanded="false" aria-controls="cash">
                                        <label class="form-check-label w-100 text-dark-emphasis fw-semibold">
                                            <input type="radio" class="form-check-input fs-base me-2 me-sm-3" name="payment-method">
                                            Cash on delivery
                                        </label>
                                    </div>
                                    <div class="collapse" id="cash" data-bs-parent="#paymentMethod">
                                        <div class="d-sm-flex align-items-center pt-3 pt-sm-4 pb-2 ps-3 ms-2 ms-sm-3">
                                            <span class="fs-sm me-3">I would require a change from:</span>
                                            <div class="input-group mt-2 mt-sm-0" style="max-width: 150px">
                            <span class="input-group-text">
                              <i class="ci-dollar-sign"></i>
                            </span>
                                                <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Credit card -->
                                <div class="mt-4">
                                    <div class="form-check mb-0" role="listitem" data-bs-toggle="collapse" data-bs-target="#card" aria-expanded="true" aria-controls="card">
                                        <label class="form-check-label d-flex align-items-center text-dark-emphasis fw-semibold">
                                            <input type="radio" class="form-check-input fs-base me-2 me-sm-3" name="payment-method" checked="">
                                            Credit or debit card
                                            <span class="d-none d-sm-flex gap-2 ms-3">
                                                <img src="assets/img/payment-methods/amex.svg" class="d-block bg-info rounded-1" width="36" alt="Amex">
                                                <img src="assets/img/payment-methods/visa-light-mode.svg" class="d-none-dark" width="36" alt="Visa">
                                                <img src="assets/img/payment-methods/visa-dark-mode.svg" class="d-none d-block-dark" width="36" alt="Visa">
                                                <img src="assets/img/payment-methods/mastercard.svg" width="36" alt="Mastercard">
                                                <img src="assets/img/payment-methods/maestro.svg" width="36" alt="Maestro">
                                              </span>
                                        </label>
                                    </div>
                                    <div class="collapse show" id="card" data-bs-parent="#paymentMethod">
                                        <form class="needs-validation pt-4 pb-2 ps-3 ms-2 ms-sm-3" novalidate="">
                                            <div class="position-relative mb-3 mb-sm-4" data-input-format="{&quot;creditCard&quot;: true}">
                                                <input type="text" class="form-control form-control-lg form-icon-end" placeholder="Card number" required="">
                                                <span class="position-absolute d-flex top-50 end-0 translate-middle-y fs-5 text-body-tertiary me-3" data-card-icon=""><svg width="1em" height="1em" viewBox="0 0 24 24" fill="currentColor"><path d="M21 3H3C1.3 3 0 4.3 0 6v12c0 1.7 1.3 3 3 3h18c1.7 0 3-1.3 3-3V6c0-1.7-1.3-3-3-3zm1.2 15c0 .7-.6 1.2-1.2 1.2H3c-.7 0-1.2-.6-1.2-1.2V6c0-.7.6-1.2 1.2-1.2h18c.7 0 1.2.6 1.2 1.2v12z"></path><path d="M7 16.1H4c-.5 0-.9.4-.9.9s.4.9.9.9h3c.5 0 .9-.4.9-.9s-.4-.9-.9-.9zm13-9H4c-.5 0-.9.4-.9.9s.4.9.9.9h16c.5 0 .9-.4.9-.9s-.4-.9-.9-.9z"></path></svg></span>
                                            </div>
                                            <div class="row row-cols-1 row-cols-sm-2 g-3 g-sm-4">
                                                <div class="col">
                                                    <input type="text" class="form-control form-control-lg" data-input-format="{&quot;date&quot;: true, &quot;datePattern&quot;: [&quot;m&quot;, &quot;y&quot;]}" placeholder="MM/YY">
                                                </div>
                                                <div class="col">
                                                    <input type="text" class="form-control form-control-lg" maxlength="4" data-input-format="{&quot;numeral&quot;: true, &quot;numeralPositiveOnly&quot;: true, &quot;numeralThousandsGroupStyle&quot;: &quot;none&quot;}" placeholder="CVC">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- PayPal -->
                                <div class="mt-4">
                                    <div class="form-check mb-0" role="listitem" data-bs-toggle="collapse" data-bs-target="#paypal" aria-expanded="false" aria-controls="paypal">
                                        <label class="form-check-label d-flex align-items-center text-dark-emphasis fw-semibold">
                                            <input type="radio" class="form-check-input fs-base me-2 me-sm-3" name="payment-method">
                                            PayPal
                                            <img src="assets/img/payment-methods/paypal-icon.svg" class="ms-3" width="16" alt="PayPal">
                                        </label>
                                    </div>
                                    <div class="collapse" id="paypal" data-bs-parent="#paymentMethod"></div>
                                </div>

                                <!-- Google Pay -->
                                <div class="mt-4">
                                    <div class="form-check mb-0" role="listitem" data-bs-toggle="collapse" data-bs-target="#googlepay" aria-expanded="false" aria-controls="googlepay">
                                        <label class="form-check-label d-flex align-items-center text-dark-emphasis fw-semibold">
                                            <input type="radio" class="form-check-input fs-base me-2 me-sm-3" name="payment-method">
                                            Google Pay
                                            <img src="assets/img/payment-methods/google-icon.svg" class="ms-3" width="20" alt="Google Pay">
                                        </label>
                                    </div>
                                    <div class="collapse" id="googlepay" data-bs-parent="#paymentMethod"></div>
                                </div>
                            </div>

                            <!-- Add promo code button -->
                            <div class="nav pb-3 mb-2 mb-sm-3">
                                <a class="nav-link animate-underline p-0" href="#!">
                                    <i class="ci-plus-circle fs-xl ms-a me-2"></i>
                                    <span class="animate-target">Add a promo code or a gift card</span>
                                </a>
                            </div>

                            <!-- Additional comments -->
                            <textarea class="form-control form-control-lg mb-4" rows="3" placeholder="Additional comments"></textarea>

                            <div class="form-check mb-lg-4">
                                <input type="checkbox" class="form-check-input" id="accept-terms">
                                <label for="accept-terms" class="form-check-label nav align-items-center">
                                    I accept the
                                    <a class="nav-link text-decoration-underline fw-normal ms-1 p-0" href="terms-and-conditions.html">Terms and Conditions</a>
                                </label>
                            </div>

                            <!-- Pay button visible on screens > 991px wide (lg breakpoint) -->
                            <a class="btn btn-lg btn-primary w-100 d-none d-lg-flex" href="checkout-v1-thankyou.html">Pay $2,406.90</a>
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
                                    <h5 class="mb-0">Order summary</h5>
                                    <div class="nav">
                                        <a class="nav-link text-decoration-underline p-0" href="checkout-v1-cart.html">Edit</a>
                                    </div>
                                </div>
                                <a class="d-flex align-items-center gap-2 text-decoration-none" href="#orderPreview" data-bs-toggle="offcanvas">
                                    <div class="ratio ratio-1x1" style="max-width: 64px">
                                        <img src="assets/img/shop/electronics/thumbs/08.png" class="d-block p-1" alt="iPhone">
                                    </div>
                                    <div class="ratio ratio-1x1" style="max-width: 64px">
                                        <img src="assets/img/shop/electronics/thumbs/09.png" class="d-block p-1" alt="iPad Pro">
                                    </div>
                                    <div class="ratio ratio-1x1" style="max-width: 64px">
                                        <img src="assets/img/shop/electronics/thumbs/01.png" class="d-block p-1" alt="Smart Watch">
                                    </div>
                                    <i class="ci-chevron-right text-body fs-xl p-0 ms-auto"></i>
                                </a>
                            </div>
                            <ul class="list-unstyled fs-sm gap-3 mb-0">
                                <li class="d-flex justify-content-between">
                                    Subtotal (3 items):
                                    <span class="text-dark-emphasis fw-medium">$2,427.00</span>
                                </li>
                                <li class="d-flex justify-content-between">
                                    Saving:
                                    <span class="text-danger fw-medium">-$110.00</span>
                                </li>
                                <li class="d-flex justify-content-between">
                                    Tax collected:
                                    <span class="text-dark-emphasis fw-medium">$73.40</span>
                                </li>
                                <li class="d-flex justify-content-between">
                                    Shipping:
                                    <span class="text-dark-emphasis fw-medium">$16.50</span>
                                </li>
                            </ul>
                            <div class="border-top pt-4 mt-4">
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="fs-sm">Estimated total:</span>
                                    <span class="h5 mb-0">$2,406.90</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-body-tertiary rounded-5 p-4">
                        <div class="d-flex align-items-center px-sm-2 px-lg-0 px-xl-2">
                            <svg class="text-warning flex-shrink-0" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"><path d="M1.333 9.667H7.5V16h-5c-.64 0-1.167-.527-1.167-1.167V9.667zm13.334 0v5.167c0 .64-.527 1.167-1.167 1.167h-5V9.667h6.167zM0 5.833V7.5c0 .64.527 1.167 1.167 1.167h.167H7.5v-1-3H1.167C.527 4.667 0 5.193 0 5.833zm14.833-1.166H8.5v3 1h6.167.167C15.473 8.667 16 8.14 16 7.5V5.833c0-.64-.527-1.167-1.167-1.167z"/><path d="M8 5.363a.5.5 0 0 1-.495-.573C7.752 3.123 9.054-.03 12.219-.03c1.807.001 2.447.977 2.447 1.813 0 1.486-2.069 3.58-6.667 3.58zM12.219.971c-2.388 0-3.295 2.27-3.595 3.377 1.884-.088 3.072-.565 3.756-.971.949-.563 1.287-1.193 1.287-1.595 0-.599-.747-.811-1.447-.811z"/><path d="M8.001 5.363c-4.598 0-6.667-2.094-6.667-3.58 0-.836.641-1.812 2.448-1.812 3.165 0 4.467 3.153 4.713 4.819a.5.5 0 0 1-.495.573zM3.782.971c-.7 0-1.448.213-1.448.812 0 .851 1.489 2.403 5.042 2.566C7.076 3.241 6.169.971 3.782.971z"/></svg>
                            <div class="text-dark-emphasis fs-sm ps-2 ms-1">Congratulations! You have earned <span class="fw-semibold">240 bonuses</span></div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const radios = document.querySelectorAll('input[name="cargo"]');
        const totalNode = document.querySelector('.order-total-amount');
        if (!totalNode || radios.length === 0) {
            return;
        }

        const formatter = new Intl.NumberFormat('tr-TR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        });

        const baseTotal = Number.parseFloat(totalNode.dataset.baseTotal || '0');
        radios.forEach((radio) => {
            radio.addEventListener('change', function () {
                const cargoPrice = Number.parseFloat(this.dataset.price || '0');
                const total = baseTotal + (Number.isFinite(cargoPrice) ? cargoPrice : 0);
                totalNode.textContent = `${formatter.format(total)} TL`;
            });
        });
    });
</script>

@endsection
@endsection
