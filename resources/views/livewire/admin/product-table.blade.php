<div >
    <div class="d-flex justify-content-end mb-2">
        <a href="{{ route('variant_stock_alerts') }}" class="btn btn-soft-dark btn-sm">Varyant Stok Uyarıları</a>
    </div>
    <div class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text" wire:model.live.debounce.350ms="search" class="form-control" placeholder="Ürün adı veya token ara...">
        </div>
        <div class="col-md-2">
            <select wire:model.live="status" class="form-select">
                <option value="">Durum (Tümü)</option>
                <option value="1">Aktif</option>
                <option value="0">Pasif</option>
            </select>
        </div>
        <div class="col-md-2">
            <select wire:model.live="category" class="form-select">
                <option value="">Kategori (Tümü)</option>
                @foreach($categories as $item)
                    <option value="{{ $item->id }}">{{ $item->category_title }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select wire:model.live="subCategory" class="form-select">
                <option value="">Alt Kategori (Tümü)</option>
                @foreach($subCategories as $item)
                    <option value="{{ $item->id }}">{{ $item->sub_title }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1">
            <select wire:model.live="brand" class="form-select">
                <option value="">Marka</option>
                @foreach($brands as $item)
                    <option value="{{ $item->id }}">{{ $item->brand_title }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1">
            <select wire:model.live="perPage" class="form-select">
                <option value="15">15</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </div>
    </div>

    <div class="table-responsive" wire:loading.class="opacity-50">
        <table class="table table-striped align-middle w-100">
            <thead>
            <tr>
                <th>Token</th>
                <th>Ürün</th>
                <th>Stok</th>
                <th>Üst Kategori</th>
                <th>Alt Kategori</th>
                <th>Marka</th>
                <th>Durum</th>
                <th>Diğer</th>
                <th>İşlem</th>

            </tr>
            </thead>

            <tbody>
            @forelse($products as $key)
                <tr>

                    <td>{{ $key->product_token }}</td>

                    <td>
                        <div class="d-flex align-items-center gap-2">

                            <!-- Ürün Görseli -->
                            <img src="/upload/product/{{ $key->image }}"
                                 alt=""
                                 style="width:40px; height:40px; object-fit:cover; border-radius:6px;"
                                 onerror="this.onerror=null; this.src='{{ asset('/extra/img/photo.webp') }}';"
                            >

                            <!-- Ürün Adı -->
                            <strong>
                                {{ \Illuminate\Support\Str::limit($key->title, 35) }}
                            </strong>

                        </div>
                    </td>
                    <td>
                    <span class="badge bg-light text-dark">
                        {{ $key->stock }}
                    </span>
                    </td>

                    <td>{{ $key->getCategory?->category_title ?? '-' }}</td>

                    <td>{{ $key->getSubCategory?->sub_title ?? '-' }}</td>

                    <td>{{ $key->getBrand?->brand_title ?? '-' }}</td>

                    <!-- 🔥 DURUM -->
                    <td>
                        @if($key->status == 1)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-danger">Pasif</span>
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('product_image', $key->id) }}" class="btn btn-soft-purple btn-sm">
                            Resimler
                        </a>

                        <a href="{{ route('product_variant', $key->id) }}" class="btn btn-soft-dark btn-sm">
                            Varyant
                        </a>
                    </td>

                    <td>
                        <a href="{{ route('product_edit', $key->id) }}" class="btn btn-soft-primary btn-sm">
                            Düzenle
                        </a>

                        <a href="{{ route('product_related', $key->id) }}" class="btn btn-soft-warning btn-sm">
                            Bağlı Ürünler
                        </a>

                        <button type="button" class="btn btn-soft-danger btn-sm"
                                @click="$dispatch('open-delete-modal', { id: {{$key->id}} })">
                            Sil
                        </button>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center py-4">
                        Kayıt bulunamadı.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $products->links() }}
    </div>
    <div
        x-data="{
        deleteOpen:false,
        deleteId:null
         }"

        @open-delete-modal.window="
        deleteOpen = true;
        deleteId = $event.detail.id;
          "
    >
        <div
            x-show="deleteOpen"
            x-cloak
            x-transition.opacity
            class="position-fixed top-0 start-0 w-100 h-100"
            style="background:rgba(0,0,0,.5); z-index:9999999;"
            @keydown.escape.window="deleteOpen=false"
        >
            <!-- BACKDROP -->
            <div
                class="w-100 h-100 d-flex align-items-center justify-content-center"
                @click="deleteOpen=false"
            >
                <!-- MODAL CONTENT -->
                <div
                    class="bg-white rounded shadow p-4"
                    style="width:500px; max-width:95%;"
                    @click.stop
                >
                    <div class="text-center">
                        <svg width="64" height="64" fill="#e36161" viewBox="0 0 60 60">
                            <circle cx="30" cy="30" r="28" stroke="#e36161" stroke-width="2" fill="none"/>
                            <line x1="18" y1="18" x2="42" y2="42" stroke="#e36161" stroke-width="3"/>
                            <line x1="42" y1="18" x2="18" y2="42" stroke="#e36161" stroke-width="3"/>
                        </svg>

                        <h5 class="mt-3">Silme işlemini onaylıyor musunuz?</h5>
                        <p class="text-muted">
                            Bu işlem geri alınamaz.
                        </p>
                    </div>

                    <form
                        method="POST"
                        :action="`/spanel/product-delete/${deleteId}`"
                        class="mt-4"
                    >
                        @csrf
                        @method('DELETE')

                        <div class="row">
                            <div class="col-6">
                                <button
                                    type="button"
                                    class="btn btn-soft-secondary w-100"
                                    @click="deleteOpen=false"
                                >
                                    Vazgeç
                                </button>
                            </div>
                            <div class="col-6">
                                <button
                                    type="submit"
                                    class="btn btn-soft-danger w-100"
                                >
                                    Evet, sil
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>
</div>
