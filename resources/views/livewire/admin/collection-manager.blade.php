<div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-3">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Koleksiyon CRUD</h5>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <label class="form-label">Koleksiyon Adı</label>
                        <input wire:model.defer="title" type="text" class="form-control" placeholder="Örn: Yaz Kampanyası">
                        @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Açıklama</label>
                        <textarea wire:model.defer="description" rows="3" class="form-control" placeholder="Koleksiyon açıklaması"></textarea>
                    </div>
                    <div class="form-check mb-3">
                        <input wire:model.defer="status" class="form-check-input" type="checkbox" id="statusCheck">
                        <label class="form-check-label" for="statusCheck">Aktif</label>
                    </div>

                    <div class="d-flex gap-2">
                        @if($selectedCollectionId)
                            <button wire:click="updateCollection" class="btn btn-primary">Güncelle</button>
                            <button wire:click="resetForm" class="btn btn-soft-secondary">Temizle</button>
                        @else
                            <button wire:click="createCollection" class="btn btn-primary">Oluştur</button>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Koleksiyonlar</h5>
                </div>
                <div class="card-body">
                    <input wire:model.live.debounce.300ms="collectionSearch" type="text" class="form-control mb-3" placeholder="Koleksiyon ara...">
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead>
                            <tr>
                                <th>Ad</th>
                                <th>Durum</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($collections as $collection)
                                <tr>
                                    <td>
                                        <strong>{{ $collection->title }}</strong>
                                    </td>
                                    <td>
                                        @if($collection->status)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Pasif</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <button wire:click="selectCollection({{ $collection->id }})" class="btn btn-soft-primary btn-sm">Seç</button>
                                        <button wire:click="deleteCollection({{ $collection->id }})" class="btn btn-soft-danger btn-sm">Sil</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Koleksiyon bulunamadı.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $collections->links() }}
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card mb-3">
                <div class="card-body">
                    @if($selectedCollection)
                        <h5 class="mb-0">Seçili Koleksiyon: {{ $selectedCollection->title }}</h5>
                    @else
                        <h5 class="mb-0 text-muted">Ürün atamak için önce bir koleksiyon seçin.</h5>
                    @endif
                </div>
            </div>

            <div class="row g-3">
                <div class="col-lg-6">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Ürün Listesi</h5>
                            <select wire:model.live="productPerPage" class="form-select form-select-sm" style="max-width: 90px;">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                        <div class="card-body">
                            <div class="row g-2 mb-2">
                                <div class="col-md-7">
                                    <input wire:model.live.debounce.300ms="productSearch" type="text" class="form-control" placeholder="Ürün ara...">
                                </div>
                                <div class="col-md-5">
                                    <select wire:model.live="categoryFilter" class="form-select">
                                        <option value="">Kategori (Tümü)</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

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
                                                <button
                                                    wire:click="addProductToCollection({{ $item->id }})"
                                                    class="btn btn-soft-primary btn-sm"
                                                    @disabled(!$selectedCollectionId)
                                                >Ekle</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">Ürün bulunamadı.</td>
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
                            <h5 class="mb-0">Seçilen Ürünler</h5>
                            <select wire:model.live="selectedProductPerPage" class="form-select form-select-sm" style="max-width: 90px;">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                        <div class="card-body">
                            <input wire:model.live.debounce.300ms="selectedProductSearch" type="text" class="form-control mb-2" placeholder="Seçilen ürünlerde ara...">

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
                                                <button
                                                    wire:click="removeProductFromCollection({{ $item->id }})"
                                                    class="btn btn-soft-danger btn-sm"
                                                    @disabled(!$selectedCollectionId)
                                                >Çıkar</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">Koleksiyonda ürün bulunmuyor.</td>
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
    </div>
</div>
