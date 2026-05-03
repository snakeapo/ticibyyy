@extends('setting::backend.layout.default')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Mezat Sipariş Detayı</h4>
            <a href="{{ route('auction_admin_orders') }}" class="btn btn-secondary">Listeye Dön</a>
        </div>

        <div class="card p-3">
            <table class="table table-bordered mb-0">
                <tr><th width="260">Sipariş No</th><td>{{ $order->order_no }}</td></tr>
                <tr><th>Mezat</th><td>{{ optional($order->auction)->title ?? '-' }}</td></tr>
                <tr><th>Kazanan Üye</th><td>{{ optional($order->user)->name }} {{ optional($order->user)->surname }} (ID: {{ $order->user_id }})</td></tr>
                <tr><th>Kazanan Adres</th><td>{{ $order->address_snapshot ?: '-' }}</td></tr>
                <tr><th>Ürün</th><td>{{ optional(optional($order->item)->product)->title ?? optional($order->item)->custom_title ?? '-' }}</td></tr>
                <tr><th>Ürün Tipi</th><td>{{ $order->product_id ? 'Sistemde kayıtlı ürün' : 'Özel mezat ürünü' }}</td></tr>
                <tr><th>Kazanma Şekli</th><td>{{ $order->win_type }}</td></tr>
                <tr><th>Kazanma Teklifi</th><td>{{ number_format($order->final_price, 2) }} TL</td></tr>
                <tr><th>Sipariş Durumu</th><td>{{ $order->status }}</td></tr>
                <tr><th>Oluşturulma</th><td>{{ optional($order->created_at)->format('d.m.Y H:i:s') }}</td></tr>
            </table>
        </div>
    </div>
</div>
@endsection
