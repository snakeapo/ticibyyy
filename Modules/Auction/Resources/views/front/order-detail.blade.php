@extends('page::frontend.layout.master')
@section('content')
<main class="main-wrapper">
    <div class="container py-5">
        @php
            $winTypeLabels = [
                'bid' => 'Teklif ile kazandınız',
                'buy_now' => 'Hemen al ile kazanıldı',
                'auto_buy_now' => 'Teklif hemen al seviyesine ulaştı',
            ];

            $statusLabels = [
                'pending' => ['text' => 'Hazırlanıyor', 'class' => 'warning'],
                'processing' => ['text' => 'İşleniyor', 'class' => 'info'],
                'shipped' => ['text' => 'Kargoda', 'class' => 'primary'],
                'delivered' => ['text' => 'Teslim edildi', 'class' => 'success'],
                'cancelled' => ['text' => 'İptal edildi', 'class' => 'danger'],
            ];

            $statusMeta = $statusLabels[$order->status] ?? ['text' => ucfirst($order->status), 'class' => 'secondary'];
        @endphp

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">Mezat Sipariş Detayı</h3>
            <div class="d-flex gap-2">
                @if(!$order->isCheckoutCompleted())
                    <a href="{{ route('auction_live_checkout', $order) }}" class="axil-btn btn-bg-primary">Siparişi Tamamla</a>
                @endif
                <a href="{{ route('auction_live_my_orders') }}" class="axil-btn btn-bg-secondary">Siparişlerime Dön</a>
            </div>
        </div>

        <div class="card p-3">
            <table class="table table-bordered mb-0">
                <tr><th width="260">Sipariş No</th><td>{{ $order->order_no }}</td></tr>
                <tr><th>Mezat</th><td>{{ optional($order->auction)->title ?? '-' }}</td></tr>
                <tr><th>Ürün</th><td>{{ optional(optional($order->item)->product)->title ?? optional($order->item)->custom_title ?? '-' }}</td></tr>
                <tr><th>Ürün Tipi</th><td>{{ $order->product_id ? 'Sistemde kayıtlı ürün' : 'Özel mezat ürünü' }}</td></tr>
                <tr><th>Kazanma Şekli</th><td>{{ $winTypeLabels[$order->win_type] ?? $order->win_type }}</td></tr>
                <tr><th>Kazanma Teklifi</th><td>{{ number_format($order->final_price, 2) }} TL</td></tr>
                <tr><th>Kargo</th><td>{{ optional($order->cargo)->cargo_title ?? '-' }} @if($order->cargo_price) ({{ number_format($order->cargo_price, 2) }} TL) @endif</td></tr>
                <tr><th>Toplam</th><td>{{ number_format($order->total_amount, 2) }} TL</td></tr>
                <tr><th>Ödeme</th><td>{{ $order->payment_method ?: '-' }}</td></tr>
                <tr><th>Adres</th><td>{{ $order->address_snapshot ?: 'Sipariş tamamlama bekleniyor' }}</td></tr>
                <tr><th>Durum</th><td><span class="badge bg-{{ $statusMeta['class'] }}">{{ $statusMeta['text'] }}</span></td></tr>
                <tr><th>Tarih</th><td>{{ optional($order->created_at)->format('d.m.Y H:i:s') }}</td></tr>
            </table>
        </div>
    </div>
</main>
@endsection
