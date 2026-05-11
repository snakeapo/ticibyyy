@extends('setting::backend.layout.default')
@section('content')

    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-head d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="page-main-title m-0">Varyant Listesi</h4>
                    </div>

                    <div class="text-end">
                        <ol class="breadcrumb m-0 py-0">
                            <li class="breadcrumb-item"><a href="https://softby.net">Softby</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Kontrol Paneli</a></li>
                            <li class="breadcrumb-item active">Varyant Listesi</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        {{-- MEVCUT VARYANTLAR --}}
        <div class="card mb-4">
            <div class="card-header">
                <h4>Mevcut Varyantlar</h4>
            </div>

            <div class="card-body">
                <div class="row g-3">

                    @foreach ($data as $key)
                        <div class="col-md-4">
                            <div class="card p-3 h-100">

                                <form action="{{ route('product_variant_update',$key->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="d-flex justify-content-between mb-2">
                                        <strong>Varyant</strong>
                                        <div>
                                            <button class="btn btn-success btn-sm">✔</button>
                                            <a href="{{ route('product_variant_delete',$key->id) }}"
                                               onclick="confirmation(event)"
                                               class="btn btn-danger btn-sm">✖</a>
                                        </div>
                                    </div>

                                    <div class="text-center mb-2">
                                        <img src="/upload/product/{{ $key->variant_image }}"
                                             class="img-fluid rounded"
                                             style="max-height:100px;">
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="file" name="variant_image" class="form-control">
                                        <label>Resim</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="text" name="variant_type"
                                               value="{{ $key->variant_type ?? 'Genel' }}"
                                               class="form-control">
                                        <label>Varyant Tipi</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="text" name="variant_name"
                                               value="{{ $key->variant_name }}"
                                               class="form-control">
                                        <label>Varyant Adı</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="text" name="parent_variant_type"
                                               value="{{ $key->parent_variant_type }}"
                                               class="form-control">
                                        <label>Bağlı Üst Varyant Tipi (Opsiyonel)</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="text" name="parent_variant_name"
                                               value="{{ $key->parent_variant_name }}"
                                               class="form-control">
                                        <label>Bağlı Üst Varyant Adı (Opsiyonel)</label>
                                        <small class="text-muted">Birden fazla seçenek için virgül kullanın (örn: S, M, L, XL)</small>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="number" name="variant_price"
                                               value="{{ $key->variant_price }}"
                                               class="form-control">
                                        <label>Fiyat</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="number" name="variant_stock"
                                               value="{{ $key->variant_stock }}"
                                               class="form-control">
                                        <label>Stok</label>
                                    </div>
                                    <div class="form-check mb-3">

                                        <select name="is_color" class="form-control" >
                                            <option @selected($key->is_color == null) value="" >
                                                Hayır
                                            </option>

                                            <option @selected($key->is_color == 1) value="1" >
                                                Evet
                                            </option>
                                        </select>
                                        <label class="form-check-label" for="">
                                            Renk varyantı mı?
                                        </label>
                                    </div>
                                </form>

                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>


        {{-- YENİ VARYANT EKLE --}}
        <div class="card">
            <div class="card-header">
                <h4>Yeni Varyant</h4>
            </div>

            <div class="card-body">

                <button type="button" id="addVariant" class="btn btn-success mb-3">
                    + Varyant Ekle
                </button>

                <form action="{{ route('product_variant_create',$product->product_token) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div id="variantInputs" class="row g-3">

                        {{-- İlk kart --}}
                        <div class="col-md-4 variant-wrapper">
                            <div class="variant card p-3">

                                <div class="form-floating mb-3">
                                    <input type="file" name="variant_image[]" class="form-control">
                                    <label>Resim</label>
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
                                <div class="form-check mb-3">

                                    <select name="is_color[]" class="form-control" >
                                        <option value="">Hayır</option>
                                        <option value="1">Evet</option>
                                    </select>
                                    <label class="form-check-label" for="">
                                        Renk varyantı mı?
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary mt-3">
                        Kaydet
                    </button>

                </form>

            </div>
        </div>

    </div>
@endsection


@section('js')
    <script>
        document.getElementById('addVariant').addEventListener('click', function() {

            let first = document.querySelector('#variantInputs .variant');
            let clone = first.cloneNode(true);

            // temizle
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

            // sil butonu
            let header = document.createElement('div');
            header.classList.add('d-flex','justify-content-end','mb-2');

            let btn = document.createElement('button');
            btn.classList.add('btn','btn-danger','btn-sm','removeVariant');
            btn.innerHTML = 'Sil';

            header.appendChild(btn);
            clone.prepend(header);

            let wrapper = document.createElement('div');
            wrapper.classList.add('col-md-4','variant-wrapper');
            wrapper.appendChild(clone);

            document.getElementById('variantInputs').appendChild(wrapper);
        });

        // silme
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('removeVariant')) {
                e.preventDefault();
                e.target.closest('.variant-wrapper').remove();
            }
        });
    </script>
@endsection
