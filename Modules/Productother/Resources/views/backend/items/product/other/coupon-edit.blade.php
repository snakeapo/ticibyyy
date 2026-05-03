@extends('setting::backend.layout.default')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-head d-flex align-items-center">
                <div class="flex-grow-1">
                    <h4 class="page-main-title m-0">Kuponu Düzenle</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="{{ route('coupon_list') }}">Kupon Listesi</a></li>
                        <li class="breadcrumb-item active">Düzenle</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="card">

                <div class="card-body">
                    <form action="{{ route('coupon_update',$coupon->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" required name="coupon_name" value="{{ old('coupon_name', $coupon->coupon_name) }}" class="form-control" placeholder="">
                            <label>Kupon Adı</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" min="0" required name="coupon_quantity" value="{{ old('coupon_quantity', $coupon->coupon_quantity) }}" class="form-control" placeholder="">
                            <label>Kupon Adeti</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" min="0.01" step="0.01" required name="coupon_ratio" value="{{ old('coupon_ratio', $coupon->coupon_ratio) }}" class="form-control" placeholder="">
                            <label>İndirim Değeri</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" required name="discount_type">
                                <option value="fixed" @selected(old('discount_type', $coupon->discount_type ?? 'fixed') === 'fixed')>Sabit Tutar (TL)</option>
                                <option value="percent" @selected(old('discount_type', $coupon->discount_type ?? 'fixed') === 'percent')>Yüzde (%)</option>
                            </select>
                            <label>İndirim Tipi</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" required name="coupon_scope">
                                <option value="both" @selected(old('coupon_scope', $coupon->coupon_scope ?? 'both') === 'both')>Ürün + Sepet</option>
                                <option value="product" @selected(old('coupon_scope', $coupon->coupon_scope ?? 'both') === 'product')>Sadece Ürün</option>
                                <option value="cart" @selected(old('coupon_scope', $coupon->coupon_scope ?? 'both') === 'cart')>Sadece Sepet</option>
                            </select>
                            <label>Kullanım Alanı</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" required name="coupon_code" value="{{ old('coupon_code', $coupon->coupon_code) }}" class="form-control js-coupon-code" placeholder="">
                            <label>Kupon Kodu</label>
                            <div class="mt-2">
                                <button type="button" class="btn btn-sm btn-secondary js-generate-coupon">Rastgele Kod Üret</button>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea name="description" class="form-control" cols="30" rows="10">{{ old('description', $coupon->description) }}</textarea>
                            <label>Açıklama</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" required name="hide" aria-label="">
                                <option value="1" @selected(old('hide', $coupon->hide) == 1)>Herkese açık</option>
                                <option value="0" @selected(old('hide', $coupon->hide) == 0)>Gizli</option>
                            </select>
                            <label>Yayın</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" required name="status" aria-label="">
                                <option value="1" @selected(old('status', $coupon->status) == 1)>Aktif</option>
                                <option value="0" @selected(old('status', $coupon->status) == 0)>Deaktif</option>
                            </select>
                            <label>Durum</label>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary w-100">Güncelle</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@section('js')
<script>
    function generateCouponCode() {
        const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        let output = 'CPN-';

        for (let i = 0; i < 8; i++) {
            output += chars.charAt(Math.floor(Math.random() * chars.length));
        }

        return output;
    }

    document.querySelectorAll('.js-generate-coupon').forEach(function (button) {
        button.addEventListener('click', function () {
            const wrap = button.closest('form');
            const input = wrap.querySelector('.js-coupon-code');
            if (input) {
                input.value = generateCouponCode();
            }
        });
    });
</script>
@endsection
@endsection
