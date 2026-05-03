@extends('page::frontend.layout.master')
@section('content')
<div class="container py-5 mt-n2 mt-sm-0">
    <div class="row pt-md-2 pt-lg-3 pb-sm-2 pb-md-3 pb-lg-4 pb-xl-5">
        @include('customer::frontend.include.sidebar')
        <div class="col-lg-9">
            <div class="ps-lg-3 ps-xl-0">
                <h1 class="h5 mb-1 mb-sm-2">Bildirim tercihlerim</h1>
                    <form action="{{ route('notice_setting_update') }}" method="POST" class="vstack gap-4 mt-4">
                        @csrf
                        @php($u=auth()->user())
                        <div class="form-check form-switch mb-0">
                            <input type="checkbox" name="notify_new_products" class="form-check-input" id="n1" @checked($u->notify_new_products)>
                            <label class="form-check-label ps-2" for="n1">
                                <span class="d-block h6 mb-2">Yeni ürünler</span>
                                <span class="fs-sm">Yeni ürünler eklendiğinde mail gönderilir.</span>
                            </label>
                        </div>
                        <div class="form-check form-switch mb-0">
                        <input type="checkbox" name="notify_stock_updates" class="form-check-input" id="n2" @checked($u->notify_stock_updates)>
                            <label class="form-check-label ps-2" for="n2">
                                <span class="d-block h6 mb-2">Stok güncellemeleri</span>
                                <span class="fs-sm">Gezdiğiniz/favori ürünlerde stok güncellenince mail gelir.</span>
                            </label>
                        </div>
                        <div class="form-check form-switch mb-0">
                            <input type="checkbox" name="notify_order_updates" class="form-check-input" id="n3" @checked($u->notify_order_updates)>
                            <label class="form-check-label ps-2" for="n3">
                                <span class="d-block h6 mb-2">Sipariş bilgilendirmesi</span>
                                <span class="fs-sm">Sipariş durum değişimlerinde mail gönderilir.</span>
                            </label>
                        </div>
                        <div class="form-check form-switch mb-0">
                            <input type="checkbox" name="notify_coupon_updates" class="form-check-input" id="n4" @checked($u->notify_coupon_updates)>
                            <label class="form-check-label ps-2" for="n4">
                                <span class="d-block h6 mb-2">Kupon bilgilendirmesi</span>
                                <span class="fs-sm">Yeni kuponlarda mail gönderilir.</span>
                            </label>
                        </div>
                        <div class="form-check form-switch mb-0">
                            <input type="checkbox" name="notify_price_drops" class="form-check-input" id="n5" @checked($u->notify_price_drops)>
                            <label class="form-check-label ps-2" for="n5">
                                <span class="d-block h6 mb-2">İndirimler</span>
                                <span class="fs-sm">Gezdiğiniz/favori ürün indirime girince mail gelir.</span>
                            </label>
                        </div>
                        <div class="form-check form-switch mb-0">
                            <input type="checkbox" name="notify_question_answers" class="form-check-input" id="n6" @checked($u->notify_question_answers)>
                            <label class="form-check-label ps-2" for="n6">
                                <span class="d-block h6 mb-2">Soru & cevap</span
                                <span class="fs-sm">Sorunuza cevap gelince mail gönderilir.</span>
                            </label>
                        </div>
                        <div class="form-check form-switch mb-0">
                            <input type="checkbox" name="notify_abandoned_cart" class="form-check-input" id="n7" @checked($u->notify_abandoned_cart)>
                            <label class="form-check-label ps-2" for="n7">
                                <span class="d-block h6 mb-2">Sepet hatırlatma</span>
                                <span class="fs-sm">1 gün bekleyen sepete hatırlatma maili gönderilir.</span>
                            </label>
                        </div>
                        <button class="btn btn-primary" type="submit">Kaydet</button>
                    </form>
            </div>
        </div>
    </div>
</div>
@endsection
