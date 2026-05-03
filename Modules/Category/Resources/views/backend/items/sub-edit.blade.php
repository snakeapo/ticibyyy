@extends('setting::backend.layout.default')
@section('content')


    <!-- Start Content-->
    <div class="container-fluid" x-data="{ deleteOpen:false, deleteId:null }">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-head d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="page-main-title m-0">Alt Kategoriler</h4>
                    </div>

                    <div class="text-end">
                        <ol class="breadcrumb m-0 py-0">
                            <li class="breadcrumb-item"><a href="#">/</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Kontrol Paneli</a></li>
                            <li class="breadcrumb-item active">Alt Kategori</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <a href="{{ route('subcategory_list') }}" class="btn btn-primary mb-3">Yeni kategori oluştur</a>

        <div class="row">

            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="header-title">Alt Kategori Listesi</h4>
                        </div>
                        <div class="card-body">
                            <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                <thead>

                                <tr>
                                    <th>#</th>
                                    <th>Kategori Adı</th>

                                    <th>Kategori Yolu</th>
                                    <th>İşlem</th>
                                </tr>
                                </thead>


                                <tbody>
                                @php $i = 1; @endphp
                                @foreach ($data as $key)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $key->sub_title }}</td>

                                        <td>
                                            {{ $key->getCategory?->category_title }}
                                            @if($key->parent)
                                                <i class="ri-arrow-left-down-line"></i> {{ $key->parent->sub_title }}
                                            @endif
                                        </td>
                                        <td><a href="{{ route('subcategory_edit',$key->id) }}" class="btn btn-soft-primary btn-sm" >Düzenle</a>
                                            <button type="button"
                                                    class="btn btn-soft-danger btn-sm"
                                                    @click="deleteOpen = true; deleteId = {{$key->id}}">
                                                Sil
                                            </button>
                                        </td>
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                            {{ $data->links() }}
                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
                <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="header-title">Alt kategoriyi düzenle</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('subcategory_update',$key->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-floating mb-3">
                                    <input type="text" required name="sub_title" value="{{ $key->sub_title }}" class="form-control" id="floatingInput" placeholder="">
                                    <label for="floatingInput">Kategori Adı</label>
                                </div>
                                <div class="form-floating mb-3">
                                    @php
                                        $selectedParent = $find->parent_id
                                            ? 'subcategory:' . $find->parent_id
                                            : 'category:' . $find->top_category;
                                    @endphp
                                    <select class="form-select" required name="parent_target" id="floatingSelect" aria-label="">
                                        <option selected="" disabled>Üst Kategori</option>
                                        @foreach ($parentOptions as $option)
                                            @if($option['value'] !== 'subcategory:' . $find->id)
                                                <option value="{{ $option['value'] }}" @selected($selectedParent === $option['value'])>{{ $option['label'] }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <label for="floatingSelect">Bir Üst Kategori Seçin</label>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="form-label">Meta Başlık</label>
                                    <input type="text" name="meta_title" value="{{ $key->meta_title }}" class="form-control" id="" placeholder="">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="form-label">Meta Anahtar Kelime</label>
                                    <input type="text" name="meta_keyw" value="{{ $key->meta_keyw }}" class="form-control" id="" placeholder="">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="form-label">Meta Açıklama</label>
                                    <input type="text" name="meta_desc" value="{{ $key->meta_desc }}" class="form-control" id="" placeholder="">
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary w-100">Güncelle</button>
                                </div>
                            </form>

                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div>
            </div> <!-- end row-->


        </div>
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
                        :action="`/spanel/subcategory-delete/${deleteId}`"
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
    <!-- container -->


@endsection
