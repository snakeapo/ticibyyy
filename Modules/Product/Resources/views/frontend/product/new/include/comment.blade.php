<!-- Reviews -->
<div class="d-flex align-items-center pt-5 mb-4 mt-2 mt-md-3 mt-lg-4" id="reviews" style="scroll-margin-top: 80px">
    <h2 class="h3 mb-0">Yorumlar</h2>

</div>

<div class="row g-4 pb-3">
    <div class="col-sm-4">
        <div class="d-flex flex-column align-items-center justify-content-center h-100 bg-body-tertiary rounded p-4">

            <div class="h1 pb-2 mb-1">
                {{ number_format($avgRating, 1) }}
            </div>

            <div class="hstack justify-content-center gap-1 fs-sm mb-2">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($avgRating >= $i)
                        <i class="ci-star-filled text-warning"></i>
                    @elseif ($avgRating >= $i - 0.5)
                        <i class="ci-star-half text-warning"></i>
                    @else
                        <i class="ci-star text-body-tertiary opacity-60"></i>
                    @endif
                @endfor
            </div>

            <div class="fs-sm">{{ $totalReviews }} yorum</div>
        </div>
    </div>

    <div class="col-sm-8">
        <div class="vstack gap-3">

            @foreach ([5,4,3,2,1] as $star)
                @php
                    $count = $ratings[$star];
                    $percent = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                @endphp

                <div class="hstack gap-2">
                    <div class="hstack fs-sm gap-1">
                        {{ $star }}<i class="ci-star-filled text-warning"></i>
                    </div>

                    <div class="progress w-100" style="height: 4px">
                        <div class="progress-bar bg-warning rounded-pill"
                             style="width: {{ $percent }}%"></div>
                    </div>

                    <div class="fs-sm text-nowrap text-end" style="width: 40px;">
                        {{ $count }}
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>

@forelse($comment as $takeComment)
    <div class="border-bottom py-3 mb-3">
        <div class="d-flex align-items-center mb-3">
            <div class="text-nowrap me-3">
                <span class="h6 mb-0">Rafael Marquez</span>
                <i class="ci-check-circle text-success align-middle ms-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-sm" data-bs-title="Verified customer"></i>
            </div>
            <span class="text-body-secondary fs-sm ms-auto">June 28, 2024</span>
        </div>
        <div class="d-flex gap-1 fs-sm pb-2 mb-1">
            <i class="ci-star-filled text-warning"></i>
            <i class="ci-star-filled text-warning"></i>
            <i class="ci-star-filled text-warning"></i>
            <i class="ci-star-filled text-warning"></i>
            <i class="ci-star-filled text-warning"></i>
        </div>
        <ul class="list-inline gap-2 pb-2 mb-1">
            <li class="fs-sm me-4"><span class="text-dark-emphasis fw-medium">Color:</span> Blue</li>
            <li class="fs-sm"><span class="text-dark-emphasis fw-medium">Model:</span> 128GB</li>
        </ul>
        <p class="fs-sm">The phone has a new A15 Bionic chip, which makes it lightning-fast and responsive. The camera system has also been upgraded, and it now includes a 12-megapixel ultra-wide lens and a 12-megapixel wide lens.</p>
        <ul class="list-unstyled fs-sm pb-2 mb-1">
            <li><span class="text-dark-emphasis fw-medium">Pros:</span> Powerful A15 Bionic chip, improved camera</li>
            <li><span class="text-dark-emphasis fw-medium">Cons:</span> High price tag</li>
        </ul>
        <div class="nav align-items-center">
            <button type="button" class="nav-link animate-underline px-0">
                <i class="ci-corner-down-right fs-base ms-1 me-1"></i>
                <span class="animate-target">Reply</span>
            </button>
            <div class="ps-3 pb-2">
                <div class="d-flex align-items-center pt-3 pb-2 mb-1">
                    <span class="badge bg-primary me-2">Reply</span>
                    <span class="h6 mb-0 me-4">Cartzilla Company</span>
                    <span class="text-body-secondary fs-sm">May 8, 2024</span>
                </div>
                <p class="fs-sm mb-0">Thank you for your feedback! We are glad that you were satisfied with your purchase :)</p>
            </div>
        </div>
    </div>
@empty


@endforelse


<!-- Review -->
<div class="border-bottom py-3 mb-3">
    <div class="d-flex align-items-center mb-3">
        <div class="text-nowrap me-3">
            <span class="h6 mb-0">Daniel Adams</span>
        </div>
        <span class="text-body-secondary fs-sm ms-auto">May 15, 2024</span>
    </div>
    <div class="d-flex gap-1 fs-sm pb-2 mb-1">
        <i class="ci-star-filled text-warning"></i>
        <i class="ci-star-filled text-warning"></i>
        <i class="ci-star-filled text-warning"></i>
        <i class="ci-star-filled text-warning"></i>
        <i class="ci-star text-body-tertiary opacity-75"></i>
    </div>
    <ul class="list-inline gap-2 pb-2 mb-1">
        <li class="fs-sm me-4"><span class="text-dark-emphasis fw-medium">Color:</span> Blue</li>
        <li class="fs-sm"><span class="text-dark-emphasis fw-medium">Model:</span> 128GB</li>
    </ul>
    <p class="fs-sm">The phone has a new A15 Bionic chip, which makes it lightning-fast and responsive. The camera system has also been upgraded, and it now includes a 12-megapixel ultra-wide lens and a 12-megapixel wide lens.</p>
    <ul class="list-unstyled fs-sm pb-2 mb-1">
        <li><span class="text-dark-emphasis fw-medium">Pros:</span> Powerful A15 Bionic chip, improved camera</li>
        <li><span class="text-dark-emphasis fw-medium">Cons:</span> High price tag</li>
    </ul>
    <div class="nav align-items-center">
        <button type="button" class="nav-link animate-underline px-0">
            <i class="ci-corner-down-right fs-base ms-1 me-1"></i>
            <span class="animate-target">Reply</span>
        </button>
        <button type="button" class="nav-link text-body-secondary animate-scale px-0 ms-auto me-n1">
            <i class="ci-thumbs-up text-success fs-base animate-target me-1"></i>
            18
        </button>
        <hr class="vr my-2 mx-3">
        <button type="button" class="nav-link text-body-secondary animate-scale px-0 ms-n1">
            <i class="ci-thumbs-down text-danger fs-base animate-target me-1"></i>
            2
        </button>
    </div>
</div>

<div class="nav">
    <a class="nav-link text-primary animate-underline px-0" href="shop-product-reviews-electronics.html">
        <span class="animate-target">See all reviews</span>
        <i class="ci-chevron-right fs-base ms-1"></i>
    </a>
</div>
