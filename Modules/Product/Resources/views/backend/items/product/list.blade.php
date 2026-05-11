@extends('setting::backend.layout.default')
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-head d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="page-main-title m-0">Ürün Listesi</h4>
                    </div>

                    <div class="text-end">
                        <ol class="breadcrumb m-0 py-0">
                            <li class="breadcrumb-item"><a href="https://softby.net">Softby</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Kontrol Paneli</a></li>
                            <li class="breadcrumb-item active">Ürün Listesi</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="header-title">Tüm Ürünler</h4>
                        <div class="float-end">
                            <button class="btn btn-success me-1" data-bs-toggle="modal" data-bs-target="#quickProductModal">Hızlı Ürün Ekle</button>
                            <button class="btn btn-info me-1" data-bs-toggle="modal" data-bs-target="#bulkImportModal">Toplu Ürün Yükle</button>
                            <a href="{{ route('collections') }}" class="btn btn-soft-dark me-1">Koleksiyonlar</a>
                            <a href="{{ route('product_insert') }}" class="btn btn-primary">Ürün Ekle</a>

                        </div>
                    </div>
                    <div class="card-body">
                        <livewire:admin.product-table />
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $categories = \App\Models\Categories::orderBy('category_title')->get();
        $subCategories = \App\Models\Subcategories::orderBy('sub_title')->get();
        $brands = \App\Models\Brands::orderBy('brand_title')->get();
    @endphp

    <div class="modal fade" id="quickProductModal" tabindex="-1">
        <div class="modal-dialog modal-lg"><div class="modal-content">
            <form action="{{ route('product_quick_create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Hızlı Ürün Ekle</h5></div>
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label>Ürün Adı</label>
                            <input name="title" class="form-control" required></div>
                        <div class="col-md-3">
                            <label>Fiyat</label>
                            <input name="price" type="number" step="0.01" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label>Stok</label>
                            <input name="stock" type="number" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Kategori</label>
                            <select class="form-select" required name="category" id="product_category" aria-label="">
                                <option selected="" disabled>Seçim Yapın.</option>
                                @foreach (\App\Models\Categories::all() as $key)
                                    <option value="{{ $key->id }}">{{ $key->category_title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div id="subcategory_select_container"></div>
                            <input type="hidden" name="sub_category" id="selected_sub_category" value="{{ old('sub_category') }}">
                            <div class="form-text">Son seçilen alt kategori ürünün kategorisi olarak kaydedilir.</div>
                        </div>
                        <div class="col-md-12">
                            <label>Marka</label>
                            <select name="brand" class="form-select" required>
                                @foreach($brands as $item)
                                    <option value="{{ $item->id }}">{{ $item->brand_title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label>Ürün Resmi</label>
                            <input name="image" type="file" accept="image/*" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label>İade Var mı?</label>
                            <select name="has_return" class="form-select" required>
                                <option value="0" selected>Hayır</option>
                                <option value="1">Evet</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Değişim Var mı?</label>
                            <select name="has_exchange" class="form-select" required>
                                <option value="0" selected>Hayır</option>
                                <option value="1">Evet</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>WhatsApp Siparişe Uygun mu?</label>
                            <select name="whatsapp_order_enabled" class="form-select" required>
                                <option value="0" selected>Hayır</option>
                                <option value="1">Evet</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Kapat</button><button class="btn btn-success">Kaydet</button></div>
            </form>
        </div></div>
    </div>

    <div class="modal fade" id="bulkImportModal" tabindex="-1">
        <div class="modal-dialog"><div class="modal-content">
            <form action="{{ route('product_bulk_import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Excel/XML Toplu Ürün Yükleme</h5></div>
                <div class="modal-body">
                    <input type="file" name="import_file" class="form-control mb-3" required>
                    <div class="small">
                        Gerekli alan eşleşmeleri: ürün adı, stok, fiyat, kategori, üst/alt/en alt kategori, resim, marka.
                    </div>
                    <hr>
                    <a href="{{ route('product_import_template', 'excel-bos') }}" class="btn btn-sm btn-outline-primary">Boş Excel(CSV) Şablon</a>
                    <a href="{{ route('product_import_template', 'excel-dolu') }}" class="btn btn-sm btn-outline-success">Dolu Excel(CSV) Örnek</a>
                    <a href="{{ route('product_import_template', 'xml') }}" class="btn btn-sm btn-outline-dark">XML Örnek</a>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Kapat</button><button class="btn btn-info">İçe Aktar</button></div>
            </form>
        </div></div>
    </div>
    @section('js')


    <script>
        $(document).ready(function () {

            const categorySelect = $('#product_category');
            const container = $('#subcategory_select_container');
            const selectedSubCategoryInput = $('#selected_sub_category');
            const emptyState = $('#subcategory_empty_state');

            const oldCategory = "{{ old('category') }}";
            const oldSubCategory = "{{ old('sub_category') }}";

            function createSubcategorySelect(level) {
                return $(`
            <div class=" mb-3 subcategory-level" data-level="${level}">
<label>Alt Kategori ${level}</label>
                <select class="form-select js-subcategory-select" aria-label="">
                    <option value="">Seçim Yapın</option>
                </select>

            </div>
        `);
            }

            function loadSubCategories(categoryId, parentSubcategoryId, level, callback = null) {
                $.ajax({
                    url: '{{ route("getSubCategories") }}',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        category_id: categoryId,
                        parent_subcategory_id: parentSubcategoryId
                    },
                    success: function (response) {

                        container.find('.subcategory-level').filter(function () {
                            return Number($(this).data('level')) >= level;
                        }).remove();

                        const subCategories = response && Array.isArray(response.subCategories) ? response.subCategories : [];

                        if (subCategories.length === 0) {
                            if (level === 1) {
                                emptyState.removeClass('d-none');
                            }
                            return;
                        }

                        emptyState.addClass('d-none');

                        const selectWrapper = createSubcategorySelect(level);
                        const selectElement = selectWrapper.find('select');

                        subCategories.forEach(function (item) {
                            selectElement.append(new Option(item.sub_title, item.id));
                        });

                        container.append(selectWrapper);

                        // 🔥 callback varsa çalıştır (OLD seçimi için)
                        if (callback) callback(selectElement);
                    },
                    error: function () {
                        console.log('Alt kategori listesi alınamadı');
                    }
                });
            }

            categorySelect.on('change', function () {
                const categoryId = $(this).val();

                container.html('');
                selectedSubCategoryInput.val('');
                emptyState.addClass('d-none');

                if (!categoryId) return;

                loadSubCategories(categoryId, null, 1);
            });

            container.on('change', '.js-subcategory-select', function () {
                const currentValue = $(this).val();
                const currentLevel = Number($(this).closest('.subcategory-level').data('level'));
                const categoryId = categorySelect.val();

                container.find('.subcategory-level').filter(function () {
                    return Number($(this).data('level')) > currentLevel;
                }).remove();

                selectedSubCategoryInput.val(currentValue || '');

                if (currentValue) {
                    loadSubCategories(categoryId, currentValue, currentLevel + 1);
                }
            });

            // 🚀 OLD DATA LOAD (EN KRİTİK KISIM)
            if (oldCategory) {

                categorySelect.val(oldCategory);

                let currentParent = null;
                let level = 1;

                function loadOldChain() {
                    loadSubCategories(oldCategory, currentParent, level, function(selectElement) {

                        // eğer bu select içinde oldSubCategory varsa seç
                        if (selectElement.find(`option[value="${oldSubCategory}"]`).length) {
                            selectElement.val(oldSubCategory);
                            selectedSubCategoryInput.val(oldSubCategory);
                            return; // 🔥 bitti
                        }

                        // yoksa ilk optionu al ve devam et
                        let firstOption = selectElement.find('option').eq(1).val();

                        if (firstOption) {
                            selectElement.val(firstOption);
                            currentParent = firstOption;
                            level++;
                            loadOldChain(); // recursive devam
                        }
                    });
                }

                loadOldChain();
            }

        });
    </script>
    @endsection
@endsection
