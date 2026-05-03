@extends('setting::backend.layout.default')
@section('content')


        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-head d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="page-main-title m-0">Yeni Ürün</h4>
                        </div>

                        <div class="text-end">
                            <ol class="breadcrumb m-0 py-0">
                                <li class="breadcrumb-item"><a href="#">/</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Kontrol Paneli</a></li>
                                <li class="breadcrumb-item active">Yeni Ürün</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div x-data="tabs()" x-init="init()">
                <div x-show="errors.length > 0" class="alert alert-danger" x-cloak>
                    <ul>
                        <template x-for="error in errors">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                </div>
            <div class="tab-header">

                <ul class="nav nav-tabs nav-bordered mb-3">

                    <li class="nav-item">
                        <a href="#"
                           @click.prevent="setTab('basic')"
                           class="nav-link"
                           :class="{ 'active': tab === 'basic' }">
                            Temel
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#"
                           @click.prevent="setTab('variant')"
                           class="nav-link"
                           :class="{ 'active': tab === 'variant' }">
                            Varyasyon
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#"
                           @click.prevent="setTab('image')"
                           class="nav-link"
                           :class="{ 'active': tab === 'image' }">
                            Resim
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#"
                           @click.prevent="setTab('text')"
                           class="nav-link"
                           :class="{ 'active': tab === 'text' }">
                            İçerik
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#"
                           @click.prevent="setTab('seo')"
                           class="nav-link"
                           :class="{ 'active': tab === 'seo' }">
                            Ayar & SEO
                        </a>
                    </li>

                </ul>

            </div>
            <div class="row">
                <form action="{{ route('product_create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex justify-content-end gap-2 mb-3">
                        <button type="submit" name="status" value="0" class="btn btn-warning">
                            <i class="bi bi-clock" style="margin-right: 5px;"></i> Taslak olarak kaydet
                        </button>

                        <button type="submit" name="status" value="1" class="btn btn-primary">
                            <i class="bi bi-check-circle" style="margin-right: 5px;"></i> Kaydet ve Yayınla
                        </button>
                    </div>
                <div class="row">
                    <div x-show="tab === 'basic'" x-cloak>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="header-title">Temel Bilgiler</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-floating mb-3">
                                    <input type="text" required name="title" value="{{ old('title') }}" class="form-control" id="floatingInput" placeholder="">
                                    <label for="floatingInput">Ürün Adı</label>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="number" required name="price" value="{{ old('price') }}" class="form-control" id="floatingInput" placeholder="">
                                            <label for="floatingInput">Ürün Fiyatı</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="number" name="sale_price" value="{{ old('sale_price') }}" class="form-control" id="floatingInput" placeholder="">
                                            <label for="floatingInput">İndirimli Fiyatı</label>
                                            <small style="color: rgb(199, 89, 89)">* Ürüne İndirim Uygulamak İstemiyorsanız Boş Bırakınız *</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="number" required name="stock" value="{{ old('stock') }}" class="form-control" id="floatingInput" placeholder="">
                                    <label for="floatingInput">Stok Adeti</label>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <select class="form-select" required name="category" id="product_category" aria-label="">
                                                <option selected="" disabled>Seçim Yapın.</option>
                                                @foreach (\App\Models\Categories::all() as $key)
                                                    <option value="{{ $key->id }}">{{ $key->category_title }}</option>
                                                @endforeach
                                            </select>
                                            <label for="floatingSelect">Bir Kategori Seçiniz</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div id="subcategory_select_container"></div>
                                        <input type="hidden" name="sub_category" id="selected_sub_category" value="{{ old('sub_category') }}">
                                        <div class="form-text">Son seçilen alt kategori ürünün kategorisi olarak kaydedilir.</div>
                                    </div>
                                    <div class="col-md-12">
                                        <div id="subcategory_empty_state" class="alert alert-light d-none">
                                            Seçilen kategoriye bağlı alt kategori bulunamadı.
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <select class="form-select" required name="brand" aria-label="">
                                                <option selected="" disabled>Seçim Yapın.</option>
                                                @foreach (\App\Models\Brands::all() as $brand)
                                                    <option value="{{ $brand->id }}" @selected(old('brand') == $brand->id)>{{ $brand->brand_title }}</option>
                                                @endforeach
                                            </select>
                                            <label for="floatingSelect">Marka Seçiniz</label>
                                        </div>
                                    </div>
                                </div>

                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div>
                    </div>
                    <div x-show="tab === 'variant'" x-cloak>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Varyasyonlar</h4>
                                </div>
                                <div class="card-body">
                                    <button type="button" id="addVariant" class="btn btn-success mb-3">Varyant Ekle</button>
                                    <div id="variantInputs" class="row">

                                        @php
                                            $oldNames = old('variant_name', []);
                                            $oldTypes = old('variant_type', []);
                                            $oldParentTypes = old('parent_variant_type', []);
                                            $oldParentNames = old('parent_variant_name', []);
                                            $oldPrices = old('variant_price', []);
                                            $oldStocks = old('variant_stock', []);
                                        @endphp

                                        @if(count($oldNames) > 0)
                                            @foreach($oldNames as $i => $name)
                                                <div class="col-md-4 variant-wrapper">
                                                    <div class="variant card mb-3 p-3">

                                                        <div class="d-flex justify-content-end mb-2">
                                                            @if($i != 0)
                                                                <button type="button" class="btn btn-danger btn-sm removeVariant">Sil</button>
                                                            @endif
                                                        </div>

                                                        <div class="form-floating mb-3">
                                                            <input type="file" name="variant_image[]" class="form-control">
                                                            <label>Resim (Opsiyonel)</label>
                                                        </div>

                                                        <div class="form-floating mb-3">
                                                            <input type="text" name="variant_type[]" class="form-control"
                                                                   value="{{ $oldTypes[$i] ?? 'Genel' }}">
                                                            <label>Varyant Tipi</label>
                                                        </div>

                                                        <div class="form-floating mb-3">
                                                            <input type="text" name="variant_name[]" class="form-control"
                                                                   value="{{ $name }}">
                                                            <label>Varyant Adı</label>
                                                        </div>

                                                        <div class="form-floating mb-3">
                                                            <input type="text" name="parent_variant_type[]" class="form-control"
                                                                   value="{{ $oldParentTypes[$i] ?? '' }}">
                                                            <label>Bağlı Üst Varyant Tipi (Opsiyonel)</label>
                                                        </div>

                                                        <div class="form-floating mb-3">
                                                            <input type="text" name="parent_variant_name[]" class="form-control"
                                                                   value="{{ $oldParentNames[$i] ?? '' }}">
                                                            <label>Bağlı Üst Varyant Adı (Opsiyonel)</label>
                                                            <small class="text-muted">Birden fazla seçenek için virgül kullanın (örn: S, M, L, XL)</small>
                                                        </div>

                                                        <div class="form-floating mb-3">
                                                            <input type="number" name="variant_price[]" class="form-control"
                                                                   value="{{ $oldPrices[$i] ?? '' }}">
                                                            <label>Fiyat</label>
                                                        </div>

                                                        <div class="form-floating mb-3">
                                                            <input type="number" name="variant_stock[]" class="form-control"
                                                                   value="{{ $oldStocks[$i] ?? '' }}">
                                                            <label>Stok</label>
                                                        </div>

                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            {{-- İlk boş varyant --}}
                                            <div class="col-md-4 variant-wrapper">
                                                <div class="variant card mb-3 p-3">

                                                    <div class="form-floating mb-3">
                                                        <input type="file" name="variant_image[]" class="form-control">
                                                        <label>Resim (Opsiyonel)</label>
                                                    </div>

                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="variant_type[]" class="form-control" value="Genel">
                                                        <label>Varyant Tipi</label>
                                                    </div>

                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="variant_name[]" class="form-control">
                                                        <label>Varyant Adı</label>
                                                    </div>

                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="parent_variant_type[]" class="form-control">
                                                        <label>Bağlı Üst Varyant Tipi (Opsiyonel)</label>
                                                    </div>

                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="parent_variant_name[]" class="form-control">
                                                        <label>Bağlı Üst Varyant Adı (Opsiyonel)</label>
                                                        <small class="text-muted">Birden fazla seçenek için virgül kullanın (örn: S, M, L, XL)</small>
                                                    </div>

                                                    <div class="form-floating mb-3">
                                                        <input type="number" name="variant_price[]" class="form-control">
                                                        <label>Fiyat</label>
                                                    </div>

                                                    <div class="form-floating mb-3">
                                                        <input type="number" name="variant_stock[]" class="form-control">
                                                        <label>Stok</label>
                                                    </div>

                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div x-show="tab === 'image'" x-cloak>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Resimler</h4>
                                </div>

                                <div class="card-body">

                                    <!-- Tekli Görsel -->
                                    <div class="mb-4">
                                        <label class="form-label">Ürün Öne Çıkan Görseli</label>
                                        <input class="form-control mb-2" type="file" name="image" id="mainImageInput">

                                        <!-- Preview -->
                                        <div id="mainImagePreview"></div>
                                    </div>

                                    <!-- Çoklu Görseller -->
                                    <div class="mb-3">
                                        <label class="form-label">Ürünün Diğer Resimleri</label>
                                        <input class="form-control mb-3" type="file" name="images[]" multiple id="multiImageInput">

                                        <!-- Preview Grid -->
                                        <div id="multiImagePreview" class="row g-2"></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div x-show="tab === 'text'" x-cloak>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">İçerik</h4>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="mb-2">Ürün Özellikleri</label>
                                        <textarea name="feature" id="feature" rows="10" cols="80">{{ old('feature') }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="mb-2">Taksitlendirme Bilgisi</label>
                                        <textarea name="installment" id="taksit" rows="10" cols="80">{{ old('installment') }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="mb-2">Ürün Açıklaması</label>
                                        <textarea name="description"  id="desc" rows="10" cols="80">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div x-show="tab === 'seo'" x-cloak>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Ayar & Seo</h4>
                                </div>
                                <div class="card-body">

                                    <div class="form-floating mb-3">
                                        <select class="form-select" required name="our_choice" id="floatingSelect" aria-label="">
                                            <option selected="" disabled>Seçim Yapın.</option>
                                            <option value="1" @selected(old('our_choice') == 1)>Evet</option>
                                            <option value="0" @selected(old('our_choice') == 0)>Hayır</option>
                                        </select>
                                        <label for="floatingSelect">Bizim Seçimlerimiz</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <select class="form-select" required name="best_selling" id="floatingSelect" aria-label="">
                                            <option selected="" disabled>Seçim Yapın.</option>
                                            <option value="1" @selected(old('best_selling') == 1)>Evet</option>
                                            <option value="0" @selected(old('best_selling') == 0)>Hayır</option>
                                        </select>
                                        <label for="floatingSelect">Çok Satan</label>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="form-label">Meta Başlık</label>
                                        <input type="text" name="meta_title"  class="form-control" value="{{ old('meta_title') }}" id="" placeholder="">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="form-label">Meta Anahtar Kelime</label>
                                        <input type="text" name="meta_keyw"  class="form-control" value="{{ old('meta_keyw') }}" id="" placeholder="">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="form-label">Meta Açıklama</label>
                                        <input type="text" name="meta_desc"  class="form-control" value="{{ old('meta_desc') }}" id="" placeholder="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end row-->

            </form>
            </div>
            </div>
        </div>
        <!-- container -->

@section('js')

    <script>
        document.getElementById('addVariant').addEventListener('click', function() {

            let first = document.querySelector('.variant').cloneNode(true);
            let clone = first.cloneNode(true);

            // inputları temizle
            clone.querySelectorAll('input').forEach(function(input) {
                if (input.name === 'variant_type[]') {
                    input.value = 'Genel';
                    return;
                }
                if (input.name === 'parent_variant_type[]' || input.name === 'parent_variant_name[]') {
                    input.value = '';
                    return;
                }
                if (input.type === 'file') {
                    input.value = null;
                    return;
                }
                input.value = '';
            });

            // remove butonu
            let header = document.createElement('div');
            header.classList.add('d-flex','justify-content-end','mb-2');

            let removeButton = document.createElement('button');
            removeButton.classList.add('btn','btn-danger','btn-sm','removeVariant');
            removeButton.innerHTML = 'Sil';

            header.appendChild(removeButton);
            clone.prepend(header);

            // wrapper oluştur (col-md-4)
            let wrapper = document.createElement('div');
            wrapper.classList.add('col-md-4','variant-wrapper');
            wrapper.appendChild(clone);

            document.getElementById('variantInputs').appendChild(wrapper);
        });

        // silme
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('removeVariant')) {
                event.preventDefault();
                event.target.closest('.variant-wrapper').remove();
            }
        });
    </script>
    <script>
        // 🔹 Tekli resim preview
        document.getElementById('mainImageInput').addEventListener('change', function(e) {
            const preview = document.getElementById('mainImagePreview');
            preview.innerHTML = '';

            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `
            <div style="position:relative; width:150px;">
                <img src="${e.target.result}" class="img-fluid rounded">
                <button type="button" class="btn btn-danger btn-sm remove-main"
                        style="position:absolute; top:5px; right:5px;">X</button>
            </div>
        `;
            }
            reader.readAsDataURL(file);
        });

        // tekli silme
        document.addEventListener('click', function(e){
            if(e.target.classList.contains('remove-main')){
                document.getElementById('mainImageInput').value = '';
                document.getElementById('mainImagePreview').innerHTML = '';
            }
        });


        // 🔹 Çoklu resim preview
        let multiFiles = [];

        document.getElementById('multiImageInput').addEventListener('change', function(e) {

            const preview = document.getElementById('multiImagePreview');

            Array.from(e.target.files).forEach(file => {
                multiFiles.push(file);
            });

            renderMultiPreview();
        });


        function renderMultiPreview() {
            const preview = document.getElementById('multiImagePreview');
            preview.innerHTML = '';

            multiFiles.forEach((file, index) => {
                const reader = new FileReader();

                reader.onload = function(e) {
                    let col = document.createElement('div');
                    col.classList.add('col-md-2');

                    col.innerHTML = `
                <div style="position:relative;">
                    <img src="${e.target.result}" class="img-fluid rounded">
                    <button type="button" class="btn btn-danger btn-sm remove-image"
                        data-index="${index}"
                        style="position:absolute; top:5px; right:5px;">X</button>
                </div>
            `;

                    preview.appendChild(col);
                }

                reader.readAsDataURL(file);
            });
        }


        // çoklu silme
        document.addEventListener('click', function(e){
            if(e.target.classList.contains('remove-image')){
                let index = e.target.getAttribute('data-index');
                multiFiles.splice(index, 1);
                renderMultiPreview();
            }
        });
    </script>
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
            <div class="form-floating mb-3 subcategory-level" data-level="${level}">
                <select class="form-select js-subcategory-select" aria-label="">
                    <option value="">Seçim Yapın</option>
                </select>
                <label>Alt Kategori ${level}</label>
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
<script>
    function tabs() {
        return {
            tab: 'basic',
            errors: [],

            init() {
                const params = new URLSearchParams(window.location.search);
                const urlTab = params.get('tab');
                const saved = localStorage.getItem('product_tab');

                if (urlTab) this.tab = urlTab;
                else if (saved) this.tab = saved;
                else this.tab = 'basic';
            },

            setTab(name) {
                this.tab = name;
                localStorage.setItem('product_tab', name);

                const url = new URL(window.location);
                url.searchParams.set('tab', name);
                window.history.replaceState({}, '', url);
            },

            validateAndSubmit(e) {
                this.errors = [];

                // TEMEL
                if (!document.querySelector('[name="title"]').value) {
                    this.errors.push("Ürün adı zorunlu");
                    this.tab = 'basic';
                }

                if (!document.querySelector('[name="price"]').value) {
                    this.errors.push("Fiyat zorunlu");
                    this.tab = 'basic';
                }

                if (!document.querySelector('[name="category"]').value) {
                    this.errors.push("Kategori seçmelisin");
                    this.tab = 'basic';
                }

                // RESİM
                if (!document.querySelector('[name="image"]').value) {
                    this.errors.push("Ürün görseli zorunlu");
                    this.tab = 'image';
                }

                // AÇIKLAMA
                if (!document.querySelector('[name="description"]').value) {
                    this.errors.push("Ürün açıklaması zorunlu");
                    this.tab = 'text';
                }


                // HATA VARSA DUR
                if (this.errors.length > 0) {
                    return;
                }

                // YOKSA SUBMIT
                e.target.submit();
            }
        }
    }
</script>
@endsection
@endsection
