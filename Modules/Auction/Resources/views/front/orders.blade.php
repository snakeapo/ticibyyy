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
        @endphp

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">Mezattan Kalan Siparişlerim</h3>
            <a href="{{ route('auction_live_index') }}" class="axil-btn btn-bg-secondary">Mezatlara Dön</a>
        </div>

        <div class="card p-3">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Sipariş No</th>
                            <th>Mezat</th>
                            <th>Ürün</th>
                            <th>Tutar</th>
                            <th>Kazanım Türü</th>
                            <th>Durum</th>
                            <th>Tarih</th>
                            <th>Detay</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            @php
                                $statusMeta = $statusLabels[$order->status] ?? ['text' => ucfirst($order->status), 'class' => 'secondary'];
                            @endphp
                            <tr>
                                <td>{{ $order->order_no }}</td>
                                <td>{{ optional($order->auction)->title ?? '-' }}</td>
                                <td>{{ optional(optional($order->item)->product)->title ?? optional($order->item)->custom_title ?? '-' }}</td>
                                <td>{{ number_format($order->total_amount, 2) }} TL</td>
                                <td>{{ $winTypeLabels[$order->win_type] ?? $order->win_type }}</td>
                                <td><span class="badge bg-{{ $statusMeta['class'] }}">{{ $statusMeta['text'] }}</span></td>
                                <td>{{ optional($order->created_at)->format('d.m.Y H:i') }}</td>
                                <td>
                                    @if(!$order->isCheckoutCompleted())
                                        <a class="btn btn-sm btn-success" href="{{ route('auction_live_checkout', $order) }}">Tamamla</a>
                                    @endif
                                    <a class="btn btn-sm btn-primary" href="{{ route('auction_live_order_detail', $order) }}">Detay</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center">Henüz mezattan oluşmuş siparişiniz yok.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $orders->links() }}
        </div>
    </div>
</main>
@endsection
