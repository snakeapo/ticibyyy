<div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="alert alert-info">
        <strong>{{ $product->title }}</strong> ürünü için önerilen ürünleri yönetiyorsunuz.
        (Kategori: {{ $product->getCategory?->category_title ?? '-' }})
    </div>

    <div class="row g-3">
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Aynı Kategorideki Ürünler</h5>
                    <select wire:model.live="perPage" class="form-select form-select-sm" style="max-width: 90px;">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <div class="card-body">
                    <input wire:model.live.debounce.300ms="search" type="text" class="form-control mb-3" placeholder="Ürün adı / token ara...">

                    <div class="table-responsive" wire:loading.class="opacity-50">
                        <table class="table table-striped align-middle">
                            <thead>
                            <tr>
                                <th>Token</th>
                                <th>Ürün</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($availableProducts as $item)
                                <tr>
                                    <td>{{ $item->product_token }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($item->title, 45) }}</td>
                                    <td class="text-end">
                                        <button wire:click="addRelatedProduct({{ $item->id }})" class="btn btn-soft-primary btn-sm">
                                            Bağla
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Uygun ürün bulunamadı.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $availableProducts->links() }}
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Bağlı Ürünler ({{ $relatedIds->count() }}/5)</h5>
                    <select wire:model.live="selectedPerPage" class="form-select form-select-sm" style="max-width: 90px;">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <div class="card-body">
                    <input wire:model.live.debounce.300ms="selectedSearch" type="text" class="form-control mb-3" placeholder="Seçilenlerde ara...">

                    <div class="table-responsive" wire:loading.class="opacity-50">
                        <table class="table table-striped align-middle">
                            <thead>
                            <tr>
                                <th>Token</th>
                                <th>Ürün</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($selectedProducts as $item)
                                <tr>
                                    <td>{{ $item->product_token }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($item->title, 45) }}</td>
                                    <td class="text-end">
                                        <button wire:click="removeRelatedProduct({{ $item->id }})" class="btn btn-soft-danger btn-sm">
                                            Kaldır
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Henüz bağlı ürün yok.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $selectedProducts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
