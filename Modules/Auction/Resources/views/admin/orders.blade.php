@extends('setting::backend.layout.default')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Mezat Siparişleri</h4>
            <a href="{{ route('auction_admin_index') }}" class="btn btn-secondary">Mezat Yönetimi</a>
        </div>

        <div class="card p-3">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Sipariş No</th>
                            <th>Mezat</th>
                            <th>Ürün</th>
                            <th>Kullanıcı</th>
                            <th>Tutar</th>
                            <th>Kazanım Türü</th>
                            <th>Durum</th>
                            <th>Tarih</th>
                            <th>Detay</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $order->order_no }}</td>
                                <td>{{ optional($order->auction)->title ?? '-' }}</td>
                                <td>{{ optional(optional($order->item)->product)->title ?? optional($order->item)->custom_title ?? '-' }}</td>
                                <td>{{ optional($order->user)->name }} {{ optional($order->user)->surname }}</td>
                                <td>{{ number_format($order->final_price, 2) }} TL</td>
                                <td>{{ $order->win_type }}</td>
                                <td>{{ $order->status }}</td>
                                <td>{{ optional($order->created_at)->format('d.m.Y H:i') }}</td>
                                <td><a class="btn btn-sm btn-primary" href="{{ route('auction_admin_order_show', $order) }}">İncele</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="9" class="text-center">Henüz mezat siparişi yok.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
