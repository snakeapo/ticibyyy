@extends('setting::backend.layout.default')
@section('content')


        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-head d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="page-main-title m-0">Ürünü Düzenle</h4>
                        </div>

                        <div class="text-end">
                            <ol class="breadcrumb m-0 py-0">
                                <li class="breadcrumb-item"><a href="https://softby.net">Softby</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Kontrol Paneli</a></li>
                                <li class="breadcrumb-item active">Düzenle</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

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
                    <a href="#" @click.prevent="setTab('basic')" class="nav-link"
                       :class="{ 'active': tab === 'basic' }">Temel</a>
                </li>
                <li class="nav-item">
                    <a href="#" @click.prevent="setTab('text')" class="nav-link"
                       :class="{ 'active': tab === 'text' }">İçerik</a>
                </li>
                <li class="nav-item">
                    <a href="#" @click.prevent="setTab('image')" class="nav-link"
                       :class="{ 'active': tab === 'image' }">Resim</a>
                </li>
                <li class="nav-item">
                    <a href="#" @click.prevent="setTab('seo')" class="nav-link"
                       :class="{ 'active': tab === 'seo' }">SEO</a>
                </li>
            </ul>
                </div>

                <div class="row">
                    <form action="{{ route('product_update',$data->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex justify-content-end gap-2 mb-3">
                            <button type="submit" name="status" value="0" class="btn btn-warning">
                                <i class="bi bi-clock" style="margin-right: 5px;"></i> Taslak olarak güncelle
                            </button>

                            <button type="submit" name="status" value="1" class="btn btn-primary">
                                <i class="bi bi-check-circle" style="margin-right: 5px;"></i> Kaydet ve güncelle
                            </button>
                        </div>


                        <div class="row">



                                <!-- BASIC -->
                                <div x-show="tab === 'basic'" x-cloak>

                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="header-title">Temel Bilgiler</h4>
                                        </div>
                                        <div class="card-body">

                                            <div class="form-floating mb-3">
                                                <input type="text" required name="title" value="{{ $data->title }}" class="form-control">
                                                <label>Ürün Adı</label>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="number" required name="price" value="{{ $data->price }}" class="form-control">
                                                        <label>Ürün Fiyatı</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="number" name="sale_price" value="{{ $data->sale_price }}" class="form-control">
                                                        <label>İndirimli Fiyatı</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <input type="number" required name="stock" value="{{ $data->stock }}" class="form-control">
                                                <label>Stok Adeti</label>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <select class="form-select" name="category" id="product_category">
                                                            @foreach (\App\Models\Categories::all() as $key)
                                                                <option value="{{ $key->id }}" @selected($key->id == $data->category)>
                                                                    {{ $key->category_title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <label>Kategori</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div id="subcategory_select_container"></div>
                                                    <input type="hidden" name="sub_category" id="selected_sub_category"
                                                           value="{{ old('sub_category', $data->sub_category) }}">
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <select class="form-select" name="brand">
                                                            @foreach (\App\Models\Brands::all() as $brand)
                                                                <option value="{{ $brand->id }}" @selected($brand->id == $data->brand)>
                                                                    {{ $brand->brand_title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <label>Marka</label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                                <!-- TEXT -->
                                <div x-show="tab === 'text'" x-cloak>

                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="header-title">Açıklama Bilgileri</h4>
                                        </div>
                                        <div class="card-body">

                                            <textarea name="feature" class="form-control" id="feature">{{ $data->feature }}</textarea>
                                            <textarea name="installment" class="form-control" id="taksit">{{ $data->installment }}</textarea>
                                            <textarea name="description" class="form-control" id="desc">{{ $data->description }}</textarea>

                                        </div>
                                    </div>

                                </div>





                                <!-- IMAGE -->
                                <div x-show="tab === 'image'" x-cloak>

                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="header-title">Ürünü Detaylandırın</h4>
                                        </div>
                                        <div class="card-body">

                                            <img src="/upload/product/{{ $data->image }}" class="img-fluid mb-3">

                                            <input type="file" name="image" class="form-control">

                                        </div>
                                    </div>

                                </div>

                                <!-- SEO -->
                                <div x-show="tab === 'seo'" x-cloak>

                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="header-title">Diğer Bilgiler</h4>
                                        </div>
                                        <div class="card-body">



                                            <div class="form-floating mb-3">
                                                <select class="form-select" name="our_choice">
                                                    <option value="1" @selected($data->our_choice == 1)>Evet</option>
                                                    <option value="0" @selected($data->our_choice == 0)>Hayır</option>
                                                </select>
                                                <label>Bizim Seçimlerimiz</label>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <select class="form-select" name="best_selling">
                                                    <option value="1" @selected($data->best_selling == 1)>Evet</option>
                                                    <option value="0" @selected($data->best_selling == 0)>Hayır</option>
                                                </select>
                                                <label>Çok Satan</label>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <select class="form-select" name="has_return">
                                                    <option value="1" @selected( $data->has_return == '1')>Evet</option>
                                                    <option value="0" @selected( $data->has_return == '0')>Hayır</option>
                                                </select>
                                                <label>İade Var mı?</label>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <select class="form-select" name="has_exchange">
                                                    <option value="1" @selected( $data->has_exchange == '1')>Evet</option>
                                                    <option value="0" @selected( $data->has_exchange == '0')>Hayır</option>
                                                </select>
                                                <label>Değişim Var mı?</label>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <select class="form-select" name="whatsapp_order_enabled">
                                                    <option value="1" @selected($data->whatsapp_order_enabled == '1')>Evet</option>
                                                    <option value="0" @selected($data->whatsapp_order_enabled == '0')>Hayır</option>
                                                </select>
                                                <label>WhatsApp Siparişe Uygun mu?</label>
                                            </div>

                                            <div class="col-md-12 mb-3">
                                                <label for="form-label">Meta Başlık</label>
                                                <input type="text" name="meta_title"  class="form-control" value="{{ $data->meta_title }}" id="" placeholder="">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="form-label">Meta Anahtar Kelime</label>
                                                <input type="text" name="meta_keyw"  class="form-control" value="{{ $data->meta_keyw }}" id="" placeholder="">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="form-label">Meta Açıklama</label>
                                                <input type="text" name="meta_desc"  class="form-control" value="{{ $data->meta_desc }}" id="" placeholder="">
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                    </form>
                </div>

            </div>

        </div>
        <!-- container -->

@section('js')
<script>
    CKEDITOR.replace( 'desc' );
    CKEDITOR.replace( 'feature' );
    CKEDITOR.replace( 'taksit' );
</script>

<script>
    $(document).ready(function () {
        const categorySelect = $('#product_category');
        const container = $('#subcategory_select_container');
        const selectedSubCategoryInput = $('#selected_sub_category');
        const emptyState = $('#subcategory_empty_state');
        const selectedPath = @json($selectedSubcategoryPath ?? []);
        const selectedLeaf = Number(selectedSubCategoryInput.val());

        function createSubcategorySelect(level) {
            return $(`
                <div class="form-floating mb-3 subcategory-level" data-level="${level}">
                    <select class="form-select js-subcategory-select" aria-label="">
                        <option value="" selected>Seçim Yapın</option>
                    </select>
                    <label>Alt Kategori ${level}</label>
                </div>
            `);
        }

        function loadSubCategories(categoryId, parentSubcategoryId, level, preselectId = null) {
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

                    if (preselectId) {
                        selectElement.val(String(preselectId));
                    }

                    container.append(selectWrapper);

                    const selectedValue = selectElement.val();
                    if (selectedValue) {
                        selectedSubCategoryInput.val(selectedValue);
                    }
                },
                error: function () {
                    console.log('Alt kategori listesi alınamadı');
                }
            });
        }

        function preloadPath() {
            const categoryId = categorySelect.val();
            if (!categoryId || selectedPath.length === 0) {
                return;
            }

            let parentId = null;
            selectedPath.forEach((subId, index) => {
                const level = index + 1;
                loadSubCategories(categoryId, parentId, level, subId);
                parentId = subId;
            });

            setTimeout(function () {
                loadSubCategories(categoryId, selectedLeaf, selectedPath.length + 1);
            }, 300);
        }

        categorySelect.on('change', function () {
            const categoryId = $(this).val();
            container.html('');
            selectedSubCategoryInput.val('');
            emptyState.addClass('d-none');

            if (!categoryId) {
                return;
            }

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

        preloadPath();
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
