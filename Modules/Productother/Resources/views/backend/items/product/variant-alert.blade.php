@extends('setting::backend.layout.default')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Varyant Stok Uyarıları (≤ {{ $criticalLimit }})</h4>
            <a href="{{ route('product_list') }}" class="btn btn-secondary">Ürün Listesi</a>
        </div>

        <div class="card p-3">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Ürün</th>
                            <th>Varyant</th>
                            <th>Tip</th>
                            <th>Ek Fiyat</th>
                            <th>Kalan Stok</th>
                            <th>İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($variants as $variant)
                            <tr class="{{ (int) $variant->variant_stock === 0 ? 'table-danger' : 'table-warning' }}">
                                <td>{{ optional($variant->product)->title ?? '-' }}</td>
                                <td>{{ $variant->variant_name }}</td>
                                <td>{{ $variant->variant_type ?: '-' }}</td>
                                <td>{{ number_format((float) $variant->variant_price, 2) }} TL</td>
                                <td><strong>{{ $variant->variant_stock }}</strong></td>
                                <td>
                                    @if($variant->product_id)
                                        <a href="{{ route('product_variant', $variant->product_id) }}" class="btn btn-sm btn-outline-primary">Varyantı Düzenle</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Kritik seviyede varyant stoku bulunmuyor.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
