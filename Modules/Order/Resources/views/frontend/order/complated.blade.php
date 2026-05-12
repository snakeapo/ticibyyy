@extends('page::frontend.layout.master')
@section('content')
    <div class="row row-cols-1 row-cols-lg-2 g-0 mx-auto" style="max-width: 1920px">

        <!-- Tank you content column -->
        <div class="col d-flex flex-column justify-content-center py-5 px-xl-4 px-xxl-5">
            <div class="w-100 pt-sm-2 pt-md-3 pt-lg-4 pb-lg-4 pb-xl-5 px-3 px-sm-4 pe-lg-0 ps-lg-5 mx-auto ms-lg-auto me-lg-4" style="max-width: 740px">
                <div class="d-flex align-items-sm-center border-bottom pb-4 pb-md-5">
                    <div class="d-flex align-items-center justify-content-center bg-success text-white rounded-circle flex-shrink-0" style="width: 3rem; height: 3rem; margin-top: -.125rem">
                        <i class="ci-check fs-4"></i>
                    </div>
                    <div class="w-100 ps-3">
                        <div class="fs-sm mb-1">Sipariş: #{{ $data->order_no }}</div>
                        <div class="d-sm-flex align-items-center">
                            <h1 class="h4 mb-0 me-3">Siparişiniz için teşekkür ederiz!</h1>

                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column gap-4 pt-3 pb-5 mt-3">
                    <div>
                        <h3 class="h6 mb-2">Teslimat</h3>
                        <p class="fs-sm mb-0">{{ $data->getAddress->address }}, {{ $data->getAddress->postal_code }} {{ $data->getAddress->city }}/{{ $data->getAddress->town }}</p>
                    </div>
                    <div>
                        <h3 class="h6 mb-2">Sipariş tarihi</h3>
                        <p class="fs-sm mb-0">{{ $data->created_at->translatedFormat('d F Y, H:i') }}</p>
                    </div>
                    <div>
                        <h3 class="h6 mb-2">Ödeme yöntemi</h3>
                        @if($data->payment_system == 1)
                            <p class="fs-sm mb-0">Havale & Eft</p>
                        @elseif($data->payment_system == 2)
                            <p class="fs-sm mb-0">Kapıda ödeme</p>
                        @elseif($data->payment_system == 3)
                            <p class="fs-sm mb-0">Sanal pos ödemesi</p>
                        @endif
                    </div>
                    @if($data->payment_system == 1)
                        <div>
                            <h3 class="h6 mb-2">Yapılması gereken ödeme</h3>
                            <p class="fs-sm mb-0 text-danger">{{ number_format($data->total,2) }} TL</p>
                        </div>
                    @elseif($data->payment_system == 2)
                        <div>
                            <h3 class="h6 mb-2">Yapılması gereken ödeme</h3>
                            <p class="fs-sm mb-0 text-danger">{{ number_format($data->total,2) }} TL</p>
                        </div>
                    @elseif($data->payment_system == 3)
                        <div>
                            <h3 class="h6 mb-2">Yapılan ödeme</h3>
                            <p class="fs-sm mb-0 text-success">{{ number_format($data->total,2) }} TL</p>
                        </div>
                    @endif
                    <div>
                        <h3 class="h6 mb-2">Kargo</h3>
                        <p class="fs-sm mb-0">{{ optional($data->getCargo)->cargo_title ?? 'Kargo bilgisi yok' }} @if($data->total >= $setting->free_cargo) (Ücretsiz)@else ({{ number_format(optional($data->getCargo)->cargo_price ?? 0,2) }} TL) @endif</p>
                    </div>
                    <div>
                        <h3 class="h6 mb-2">Sipariş notunuz</h3>
                        <p class="fs-sm mb-0">@if($data->order_note != null) {{ $data->order_note }} @else <i>Herhangi bir not bulunamadı.</i> @endif</p>
                    </div>
                </div>
                <hr>
                @if($data->payment_system == 1)
                        <strong>Ödeme bilgileriniz:</strong>
                        <div class="py-3">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="font-size:14px" scope="col">Banka Adı</th>
                                        <th style="font-size:14px" scope="col">Ad Soyad</th>
                                        <th style="font-size:14px" scope="col">İban Numarası</th>
                                        <th style="font-size:14px" scope="col">Kopyala</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($banks as $key)
                                        <tr>
                                            <td style="font-size: 14px">{{ $key->title }}</td>
                                            <td style="font-size: 14px">{{ $key->account }}</td>

                                            <td style="font-size: 14px">
                                                <span id="iban-{{ $key->id }}">
                                                    {{ $key->iban }}
                                                </span>
                                            </td>

                                            <td style="font-size: 14px">
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-primary copy-iban-btn"
                                                    data-iban="{{ $key->iban }}"
                                                >
                                                    Kopyala
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            <div class="alert alert-warning mt-5" role="alert">
                                <h4 class="alert-heading">Dikkat!</h4>

                                <p>
                                   <strong> {{ number_format($data->total,2) }} TL</strong> olan ödemeniz için yukarıdaki tablodan herhangi bir hesap numarasına ödemenizi gerçekleştirebilirsiniz,
                                    dikkat etmeniz gereken husus, ödeme açıklamasına
                                    <b>"{{ $data->order_no }}"</b> Sipariş kodunu girmelisiniz.
                                </p>

                                <p>
                                    <i class="fas fa-exclamation"></i>
                                    Sipariş Kodu Girilmeyen Ödemeler Geçersiz Sayılacaktır!
                                </p>
                            </div>
                        </div>
                    </div>

                @elseif($data->payment_system == 2)
                    <div class="alert alert-info mt-5" role="alert">
                        <h4 class="alert-heading">Dikkat!</h4>
                       <p>
                            <b>"{{ $data->order_no }}"</b> Sipariş kodunuz tarafınıza mail olarak gönderilmiş olup,
                            sipariş takibi ve sipariş teslimi bu kod üzerinden gerçekleştirilecektir.
                        </p>
                        <p><i class="fas fa-exclamation"></i> Sipariş Kodunuzu Lütfen Kaybetmeyiniz. </p>
                    </div>
                @elseif($data->payment_system == 3)
                    <div class="alert alert-success mt-5" role="alert">
                        <h4 class="alert-heading">Teşekkürler!</h4>
                        <p>
                            <b>"{{ $data->order_no }}"</b> numaralı siparişinizin ödemesi tamamlanmıştır, gerekli bilgiler
                            size mail olarak iletilmiştir.
                        </p>
                        <p><i class="fas fa-exclamation"></i> Sipariş Kodunuzu Lütfen Kaybetmeyiniz.</p>
                    </div>
                @endif

                <p class="fs-sm pt-4 pt-md-5 mt-2 mt-sm-3 mt-md-0 mb-0"><a class="fw-medium ms-2" href="{{ route('contact_page') }}">Yardıma ihtiyacım var?</a></p>
            </div>
        </div>


        <!-- Related products -->
        <div class="col pt-sm-3 p-md-5 ps-lg-5 py-lg-4 pe-lg-4 p-xxl-5">
            <div class="position-relative d-flex align-items-center h-100 py-5 px-3 px-sm-4 px-xl-5">
                <span class="position-absolute top-0 start-0 w-100 h-100 bg-body-tertiary rounded-5 d-none d-md-block"></span>
                <span class="position-absolute top-0 start-0 w-100 h-100 bg-body-tertiary d-md-none"></span>
                <div class="position-relative w-100 z-2 mx-auto pb-2 pb-sm-3 pb-md-0" style="max-width: 636px">
                    <h2 class="h4 text-center pb-3">Ürünleriniz</h2>
                    <div class="row row-cols-2 g-3 g-sm-4 mb-4">
                        @foreach($items as $item)
                            @php
                                $variantIds = $item->variant_token ? array_filter(explode('-', $item->variant_token)) : [];
                                $variants = \App\Models\Productvars::whereIn('id', $variantIds)->get();
                                $unitPrice = $item->quantity > 0 ? $item->total / $item->quantity : 0;
                                $variantTotal = $variants->sum('variant_price');
                                $basePrice = $unitPrice - $variantTotal;
                                $firstVariant = $variants->first();
                                $product = $item->getProduct;
                            @endphp
                        <!-- Item -->
                        <div class="col">
                            <div class="product-card animate-underline hover-effect-opacity bg-body rounded shadow-none">
                                <div class="position-relative">


                                    <a class="d-block rounded-top overflow-hidden p-3 p-sm-4" href="{{ route('product_detail', $item->getProduct->slug . '-' . $item->getProduct->product_token) }}">
                                        <div class="ratio" style="--cz-aspect-ratio: calc(240 / 258 * 100%)">
                                            <img src="{{ asset('upload/product/'.$item->getProduct->image) }}" alt="iPhone 14">
                                        </div>
                                    </a>
                                </div>
                                <div class="w-100 min-w-0 px-2 pb-2 px-sm-3 pb-sm-3 mt-2">

                                    <h3 class="pb-1 mb-2">
                                        <a class="d-block fs-sm fw-medium text-truncate" href="{{ route('product_detail', $item->getProduct->slug . '-' . $item->getProduct->product_token) }}">
                                            <span class="animate-target">{{ $item->getProduct->title }}</span>
                                        </a>
                                    </h3>
                                    @foreach($variants as $variant)
                                        <div class="fs-xs text-body-secondary">{{ $variant->variant_type }}: {{ $variant->variant_name }} (+{{ number_format($variant->variant_price, 2) }} TL)</div>
                                    @endforeach
                                    <div class="h5 lh-1 mb-0 mt-2">{{ number_format($item->total, 2) }} TL </div>
                                </div>
                            </div>
                        </div>

                        @endforeach

                    </div>

                    <a class="btn btn-lg btn-primary w-100" href="{{ route('my_order') }}">
                        Tüm siparişleriniz
                        <i class="ci-chevron-right fs-lg ms-1 me-n1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@section('js')

    <script>
        document.querySelectorAll('.copy-iban-btn').forEach(button => {

            button.addEventListener('click', async function () {

                const iban = this.dataset.iban;
                const originalText = this.innerText;

                try {

                    await navigator.clipboard.writeText(iban);

                    this.innerText = 'Kopyalandı';
                    this.classList.remove('btn-primary');
                    this.classList.add('btn-success');

                    setTimeout(() => {
                        this.innerText = originalText;
                        this.classList.remove('btn-success');
                        this.classList.add('btn-primary');
                    }, 5000);

                } catch (err) {

                    alert('Kopyalama başarısız oldu.');

                }

            });

        });
    </script>
@endsection
@endsection
