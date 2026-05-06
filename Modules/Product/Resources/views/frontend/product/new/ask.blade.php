<!-- Breadcrumb -->
<nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="home-electronics.html">Anasayfa</a></li>
        <li class="breadcrumb-item"><a href="shop-catalog-electronics.html">Ürünler</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $data->title }}</li>
    </ol>
</nav>
@php
    $price = $data->price;
    $sale = $data->sale_price;
    $hasDiscount = $sale && $sale > 0 && $sale < $price;

    $saving = $hasDiscount ? ($price - $sale) : 0;
@endphp


    <!-- Page title -->
<h1 class="h3 container mb-4">{{ $data->title }}</h1>


<!-- Nav links -->
<section class="container position-relative z-2 pb-4 pb-md-5 mb-2 mb-md-0">
    <div class="border-bottom">
        <ul class="nav nav-underline flex-nowrap gap-4">
            <li class="nav-item me-sm-2">
                <a class="nav-link " href="{{ route('product_detail', $data->slug . '-' . $data->product_token) }}">Ürün hakkında</a>
            </li>
            <li class="nav-item me-sm-2">
                <a class="nav-link  pe-none active" href="{{ route('product_detail_ask', $data->slug . '-' . $data->product_token) }}">Soru & cevap ({{ \App\Models\Askques::where('status',1)->where('product_token',$data->product_token)->count() }})</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('product_detail_comment', $data->slug . '-' . $data->product_token) }}">Yorumlar ({{ \App\Models\Productcoms::where('status',1)->where('product_token',$data->product_token)->count() }})</a>
            </li>
        </ul>
    </div>
</section>


<!-- Product details + Sticky sidebar -->
<section class="container pb-5 mb-2 mb-md-3 mb-lg-4 mb-xl-5">
    <div class="row">
        <!-- Sticky product preview -->
        <aside class="col-md-5 col-xl-4 offset-xl-1 order-md-2 mb-5 mb-md-0" id="scrollPastPoint" style="margin-top: -100px">
            <div class="position-sticky top-0 ps-md-3 ps-lg-4 ps-xl-0" style="padding-top: 100px">
                <div class="border rounded p-3 p-lg-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="ratio ratio-1x1 flex-shrink-0" style="width: 110px">
                            <img width="110px" style="height: 100%;" src="/upload/product/{{ $data->image }}"
                                 onerror="this.src='/extra/img/photo.png'"
                                 alt="{{ $data->title }}">
                        </div>
                        <div class="w-100 min-w-0 ps-2 ps-sm-3">
                            {{-- Yıldızlar (sen doldur) --}}
                            <div class="d-flex align-items-center gap-2 mt-2 mb-2">
                                <div class="d-flex gap-1 fs-xs">
                                    @php
                                        $averageRating = Modules\Product\Http\Controllers\Frontend\MasterController::calculateAverageRating($data->id);
                                    @endphp
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $averageRating)
                                            <i class="ci-star-filled text-warning"></i>
                                        @else
                                            <i class="ci-star text-warning"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-body-tertiary fs-xs">({{ \App\Models\Productcoms::where('status',1)->where('product_token',$data->product_token)->count() }})</span>
                            </div>
                            <h4 class="fs-sm fw-medium mb-2">{{ $data->title }}</h4>
                            @if($hasDiscount)
                                <div class="d-flex align-items-center gap-2">

                                    {{-- İndirimli fiyat --}}
                                    <span class="text-danger fw-semibold">
                                        {{ number_format($sale, 2, ',', '.') }} ₺
                                    </span>

                                    {{-- Eski fiyat --}}
                                    <span class="text-muted text-decoration-line-through fs-sm">
                                        {{ number_format($price, 2, ',', '.') }} ₺
                                    </span>

                                    {{-- DB’den gelen indirim oranı --}}
                                    <span class="badge bg-danger-subtle text-danger">
                                        %{{ $data->difference }}
                                    </span>

                                </div>
                            @else
                                {{-- Normal fiyat --}}
                                <span class="fw-semibold">
                                    {{ number_format($price, 2, ',', '.') }} ₺
                                </span>
                            @endif

                        </div>
                    </div>

                </div>
            </div>
        </aside>


        <!-- Sticky product preview + Add to cart CTA -->
        <section class="sticky-product-banner sticky-top d-md-none start-0 ms-n4" data-sticky-element>
            <div class="sticky-product-banner-inner start-0 pt-5">
                <div class="vw-100 bg-body border-bottom border-light border-opacity-10 shadow pt-4 pb-2">
                    <div class="container d-flex align-items-center">
                        <div class="d-flex align-items-center min-w-0 ms-n2 me-3">
                            <div class="ratio ratio-1x1 flex-shrink-0" style="width: 50px">
                                <img width="110px" style="height: 100%;" src="/upload/product/{{ $data->image }}"
                                     onerror="this.src='/extra/img/photo.png'"
                                     alt="{{ $data->title }}">
                            </div>
                            <div class="w-100 min-w-0 ps-2">
                                <h4 class="fs-sm fw-medium text-truncate mb-1">{{ $data->title }}</h4>
                                @if($hasDiscount)
                                    <div class="d-flex align-items-center gap-2">

                                        {{-- İndirimli fiyat --}}
                                        <span class="text-danger fw-semibold">
                                        {{ number_format($sale, 2, ',', '.') }} ₺
                                    </span>

                                        {{-- Eski fiyat --}}
                                        <span class="text-muted text-decoration-line-through fs-sm">
                                        {{ number_format($price, 2, ',', '.') }} ₺
                                    </span>

                                        {{-- DB’den gelen indirim oranı --}}
                                        <span class="badge bg-danger-subtle text-danger">
                                        %{{ $data->difference }}
                                    </span>

                                    </div>
                                @else
                                    {{-- Normal fiyat --}}
                                    <span class="fw-semibold">
                                    {{ number_format($price, 2, ',', '.') }} ₺
                                </span>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Product reviews -->
        <div class="col-md-7 order-md-1">
            <div class="d-flex align-items-center mb-4">
                <h2 class="h3 mb-0">Soru & cevaplar</h2>
                @if(Auth::check())
                <button type="button" class="btn btn-secondary ms-auto"  data-bs-toggle="modal" data-bs-target="#askques">
                    <i class="ci-edit-3 fs-base ms-n1 me-2"></i>
                    Bir soru sor
                </button>
                @endif
            </div>


            @forelse($dataAsk as $takeAsk)

            <!-- Review -->
            <div class="border-bottom py-3 mb-3">
                <div class="d-flex align-items-center mb-3">
                    @php
                        $name = $takeAsk->getUser->name ?? '';
                        $surname = $takeAsk->getUser->surname ?? '';

                        $maskedName = mb_substr($name, 0, 1) . str_repeat('*', max(mb_strlen($name) - 1, 0));
                        $maskedSurname = mb_substr($surname, 0, 1) . str_repeat('*', max(mb_strlen($surname) - 1, 0));
                    @endphp

                    <div class="text-nowrap me-3">
                        <span class="h6 mb-0">{{ $maskedName }} {{ $maskedSurname }}</span>
                    </div>
                    <span class="text-body-secondary fs-sm ms-auto">{{ \Carbon\Carbon::parse($takeAsk->created_at)->diffForHumans() }}</span>
                </div>

                <p class="fs-sm">{{ $takeAsk->ask }}</p>
                @if($takeAsk->answer != null)
                <!-- Reply -->
                <div class="ps-3 pb-2">
                    <div class="d-flex align-items-center pt-3 pb-2 mb-1">
                        <span class="badge bg-primary me-2">Cevap</span>
                        <span class="h6 mb-0 me-4">{{ env('APP_NAME') }}</span>
                        <span class="text-body-secondary fs-sm">{{ \Carbon\Carbon::parse($takeAsk->answer_time)->diffForHumans() }}</span>
                    </div>
                    <p class="fs-sm mb-0">{{ $takeAsk->answer }}</p>
                </div>
                @endif
            </div>
            @empty
                <div class="alert d-flex alert-dark" role="alert">
                    <i class="ci-message-circle fs-lg pe-1 mt-1 me-2"></i>
                    <div>Bu ürüne herhangi bir soru sorulmamış.</div>
                </div>

            @endforelse

            <!-- Pagination -->
            <nav class="mt-3 pt-2 pt-md-3" aria-label="Reviews pagination">
                <ul class="pagination">
                    {{ $dataAsk->links() }}
                </ul>
            </nav>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="askques" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Bu ürün hakkında bir soru sor</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('ask_question_post',$data->id) }}" method="POST">
                    @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Sorunuz</label>
                        <textarea name="ask" class="form-control" required="required" id="" cols="30" rows="5"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary">Gönder</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</section>

