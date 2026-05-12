<div class="container pb-5">
    <div class="row" x-data="{ open:true }">

        <!-- SIDEBAR -->
        <aside class="col-lg-3" x-show="open">
            <div class="offcanvas offcanvas-lg offcanvas-start" id="filterSidebar" data-bs-backdrop="false" wire:ignore.self>
                <div class="offcanvas-header d-lg-none">
                    <h5 class="offcanvas-title">Filtreler</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body flex-column pt-2 py-lg-0">

                    <!-- KATEGORİ -->
                    <div class="w-100 border rounded p-3 mb-3">
                        <h4 class="h6 mb-2">Kategoriler</h4>

                        @foreach($categories as $cat)
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="checkbox"
                                       wire:model.live="selectedCategories"
                                       value="{{ $cat->id }}"
                                       id="cat_{{ $cat->id }}">
                                <label class="form-check-label" for="cat_{{ $cat->id }}">
                                    {{ $cat->category_title }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    @if($hasSelectedCategories)
                        <!-- ALT KATEGORİ -->
                        <div class="w-100 border rounded p-3 mb-3">
                            <h4 class="h6 mb-2">Alt Kategoriler</h4>

                            @foreach($subcategories as $sub)
                                <div class="form-check">
                                    <input class="form-check-input"
                                           wire:model.live="selectedSubcategories"
                                           type="checkbox"
                                           value="{{ $sub->id }}"
                                           id="sub_{{ $sub->id }}">
                                    <label class="form-check-label" for="sub_{{ $sub->id }}">
                                        {{ $sub->sub_title }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    @if($hasSelectedCategories && !empty($selectedSubcategories))
                        <div class="w-100 border rounded p-3 mb-3">
                            <h4 class="h6 mb-2">En Alt Kategoriler</h4>
                            @foreach($childCategories as $child)
                                <div class="form-check">
                                    <input class="form-check-input"
                                           wire:model.live="selectedChildCategories"
                                           type="checkbox"
                                           value="{{ $child->id }}"
                                           id="child_{{ $child->id }}">
                                    <label class="form-check-label" for="child_{{ $child->id }}">
                                        {{ $child->sub_title }}
                                    </label>
                                </div>

                            @endforeach
                        </div>
                    @endif
                    @if($hasSelectedCategories)
                        <!-- MARKA -->
                        <div class="w-100 border rounded p-3 mb-3">
                            <h4 class="h6">Markalar</h4>

                            @foreach($brands as $item)
                                <div class="form-check">
                                    <input class="form-check-input"
                                           wire:model.live="selectedBrands"
                                           type="checkbox"
                                           value="{{ $item->id }}"
                                           id="brand_{{ $item->id }}">
                                    <label class="form-check-label" for="brand_{{ $item->id }}">
                                        {{ $item->brand_title }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- FİYAT -->
                    <div class="w-100 border rounded p-3 mb-3">
                        <h4 class="h6">Fiyat</h4>

                        <div class="d-flex gap-2">
                            <input type="number"
                                   class="form-control"
                                   placeholder="Min"
                                   wire:model.live.debounce.400ms="minPrice">

                            <input type="number"
                                   class="form-control"
                                   placeholder="Max"
                                   wire:model.live.debounce.400ms="maxPrice">
                        </div>
                    </div>
                    @if($hasSelectedCategories)
                        @forelse($variantGroups as $variantType => $variants)
                        <div class="w-100 border rounded p-3 mb-3">


                                <div class="mb-2">
                                    <h4 class="h6">{{ $variantType }}</h4>

                                    @foreach($variants as $variant)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{ $variant }}" wire:model.live="selectedVariants" id="variant_{{ md5($variantType . '_' . $variant) }}">
                                            <label class="form-check-label" for="variant_{{ md5($variantType . '_' . $variant) }}">{{ $variant }}</label>
                                        </div>
                                    @endforeach
                                </div>

                        </div>
                        @empty
                            <small>Seçili kategoriye ait varyant yok.</small>
                        @endforelse
                    @endif
                    <button class="btn btn-primary w-100" wire:click="clearFilters">
                        Temizle
                    </button>

                </div>
            </div>
        </aside>


        <!-- PRODUCTS -->
        <div class="col-lg-9">

            <!-- TOP BAR -->
            <div class="d-flex justify-content-between align-items-center mb-3">

                <div class="fs-sm">
                    {{ $products->total() }} ürün bulundu
                </div>
                <button type="button" class="btn btn-sm btn-secondary border-0 border-top border-light border-opacity-10 rounded d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#filterSidebar" aria-controls="filterSidebar" data-bs-theme="light">
                    <i class="ci-filter fs-base me-2"></i>
                    Filtre
                </button>
                <select class="form-select w-auto" wire:model.live="sortBy">
                    <option value="none">Varsayılan</option>
                    <option value="a_z">A-Z</option>
                    <option value="z_a">Z-A</option>
                    <option value="price_desc">Yüksek Fiyat</option>
                    <option value="price_asc">Düşük Fiyat</option>
                </select>

            </div>

            <!-- SEARCH -->
            <div class="mb-3">
                <input type="text"
                       class="form-control"
                       wire:model.live.debounce.400ms="search"
                       placeholder="Ürün ara...">
            </div>

            <!-- GRID -->
            <div class="row row-cols-2 row-cols-md-3 g-4"
                 wire:loading.class="opacity-50">

                @php($product = $products)
                @include('product::frontend.product.card')

            </div>

            <!-- PAGINATION -->
            <div class="pt-4 text-center">
                {{ $products->links('pagination::default') }}
            </div>

        </div>

    </div>
</div>
