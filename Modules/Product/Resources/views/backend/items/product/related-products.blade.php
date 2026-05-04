@extends('setting::backend.layout.default')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-head d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="page-main-title m-0">Bağlı Ürün Yönetimi</h4>
                    </div>
                    <div class="text-end">
                        <ol class="breadcrumb m-0 py-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Kontrol Paneli</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('product_list') }}">Ürün Listesi</a></li>
                            <li class="breadcrumb-item active">Bağlı Ürünler</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3">Ürün Seç ({{ $relatedCount }}/5)</h5>
                        <form method="GET" class="mb-3">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Ürün adı veya token ara...">
                        </form>
                        <div class="table-responsive">
                            <table class="table table-striped align-middle">
                                <thead><tr><th>Ürün</th><th>Fiyat</th><th>Stok</th><th>Kategori</th><th>Alt</th><th>En Alt</th><th>Marka</th><th></th></tr></thead>
                                <tbody>
                                @forelse($availableProducts as $item)
                                    <tr>
                                        <td>
                                            <img src="/upload/product/{{ $item->image }}" style="width:36px;height:36px;object-fit:cover;border-radius:6px" onerror="this.onerror=null; this.src='{{ asset('/extra/img/photo.webp') }}';">
                                            <span class="ms-2">{{ $item->title }}</span><br><small class="text-muted">{{ $item->product_token }}</small>
                                        </td>
                                        <td>{{ number_format((float)$item->price,2,',','.') }} ₺</td>
                                        <td>{{ (int) $item->stock }}</td>
                                        <td>{{ $item->getCategory?->category_title ?? '-' }}</td>
                                        <td>{{ $item->getSubCategory?->parent?->sub_title ?? '-' }}</td>
                                        <td>{{ $item->getSubCategory?->sub_title ?? '-' }}</td>
                                        <td>{{ $item->getBrand?->brand_title ?? '-' }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('product_related_add', $product->id) }}">
                                                @csrf
                                                <input type="hidden" name="related_product_id" value="{{ $item->id }}">
                                                <button class="btn btn-sm btn-soft-primary">Seç</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty <tr><td colspan="8" class="text-center">Uygun ürün bulunamadı.</td></tr> @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $availableProducts->links() }}
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3">Seçilen Bağlı Ürünler</h5>
                        <form method="GET" class="mb-3">
                            <input type="text" name="selected_search" value="{{ request('selected_search') }}" class="form-control" placeholder="Seçilenlerde ara...">
                        </form>
                        @foreach($selectedProducts as $item)
                            <div class="d-flex justify-content-between border rounded p-2 mb-2">
                                <div>
                                    <div class="fw-semibold">{{ $item->title }}</div>
                                    <small class="text-muted">{{ $item->product_token }}</small>
                                </div>
                                <form method="POST" action="{{ route('product_related_remove', [$product->id, $item->id]) }}">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-soft-danger">Kaldır</button>
                                </form>
                            </div>
                        @endforeach
                        {{ $selectedProducts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
