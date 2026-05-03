@extends('page::frontend.layout.master')
@section('content')
    <div class="container py-5 mt-n2 mt-sm-0">
        <div class="row pt-md-2 pt-lg-3 pb-sm-2 pb-md-3 pb-lg-4 pb-xl-5">


            <!-- Sidebar navigation that turns into offcanvas on screens < 992px wide (lg breakpoint) -->
            @include('customer::frontend.include.sidebar')


            <!-- Personal info content -->
            <div class="col-lg-9">
                <div class="ps-lg-3 ps-xl-0">

                    <!-- Page title -->
                    <h1 class="h5 mb-1 mb-sm-2">Kuponlarım</h1>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 g-md-4 g-lg-3 g-xl-4">
                        @forelse($data as $take)


                        <div class="col">
                            <div class="card h-100">
                                <div class="card-body pb-3">
                                    <div class="d-flex align-items-start fs-sm justify-content-between mb-4">
                                        {{ $take->coupon_name }}
                                        <p class="badge text-body-emphasis bg-secondary-subtle fs-xs"> {{ [
                                        'both' => 'Ürün + Sepet',
                                        'product' => 'Sadece Ürün',
                                        'cart' => 'Sadece Sepet',
                                    ][$take->coupon_scope] ?? '-' }}</p>
                                    </div>
                                    <p class="fs-xs"> {{ $take->description }}</p>
                                    <div class="h6 mb-1 js-coupon-code">{{ $take->coupon_code }}</div>
                                    @php($isUsed = in_array((int) $take->id, $usedCouponIds ?? [], true))
                                    <div class="{{ $isUsed ? 'text-danger' : 'text-success' }} fs-xs">{{ $isUsed ? 'Kullanıldı' : 'Kullanılmadı' }}</div>
                                </div>
                                <div class="card-footer d-flex gap-3 bg-transparent border-0 pt-0 pb-4">
                                    <button type="button" class="btn btn-sm btn-outline-secondary js-copy-coupon">Kopyala</button>
                                </div>
                            </div>
                        </div>
                        @empty
                            <div class="text-center py-5 mx-auto">

                                {{-- SVG ICON --}}
                                <div class="mb-3">
                                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.5776 14.5419C15.5805 13.53 16.2 12.1373 16.2 10.6C16.2 7.50721 13.6928 5 10.6 5C7.50721 5 5 7.50721 5 10.6C5 13.6928 7.50721 16.2 10.6 16.2C12.1555 16.2 13.5628 15.5658 14.5776 14.5419ZM14.5776 14.5419L19 19M8.5 8.5L12.5 12.5M12.5 8.5L8.5 12.5" stroke="#464455" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>

                                {{-- TITLE --}}
                                <h5 class="mb-2 fw-semibold">
                                    Kupon bulunamadı
                                </h5>

                                {{-- DESCRIPTION --}}
                                <p class="text-body-secondary mb-3 small">
                                    Henüz daha size özel kupon gönderilmemiş.
                                </p>


                            </div>
                        @endforelse

                    </div>


                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
<script>
document.querySelectorAll('.js-copy-coupon').forEach(function (button) {
    button.addEventListener('click', async function () {
        const card = button.closest('.card');
        const code = card?.querySelector('.js-coupon-code')?.textContent?.trim();
        if (!code) {
            return;
        }

        try {
            await navigator.clipboard.writeText(code);
            const originalText = button.textContent;
            button.textContent = 'Kopyalandı!';
            setTimeout(function () {
                button.textContent = originalText;
            }, 1200);
        } catch (e) {
            window.prompt('Kupon kodunu kopyalayın:', code);
        }
    });
});
</script>
@endpush
