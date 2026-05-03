@extends('setting::backend.layout.default')
@section('content')

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-head d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="page-main-title m-0">Yeni Yazı</h4>
                        </div>

                        <div class="text-end">
                            <ol class="breadcrumb m-0 py-0">
                                <li class="breadcrumb-item"><a href="https://softby.net">Softby</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Kontrol Paneli</a></li>
                                <li class="breadcrumb-item active">Yeni Yazı</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->


                <form action="{{ route('blog_create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                <div class="row">

                    <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="header-title">Temel Bilgiler</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-floating mb-3">
                                    <input type="text" required name="blog_title" value="{{ old('blog_title') }}" class="form-control" id="floatingInput" placeholder="">
                                    <label for="floatingInput">Blog Adı</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <select name="blog_category" class="form-control" id="" required>
                                        @foreach (\App\Models\Blogcats::all() as $key)
                                        <option value="{{ $key->id }}" @selected(old('blog_category') == $key->id)>{{ $key->category_title }}</option>
                                        @endforeach
                                    </select>
                                    <label for="floatingInput">Blog Kategori</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" required name="blog_tag" value="{{ old('blog_tag') }}" class="form-control" id="floatingInput" placeholder="">
                                    <label for="floatingInput">Yazı Tagları</label>
                                </div>
                                <div class="mb-3">
                                    <label label class="mb-2">Blog Açıklaması</label>
                                    <textarea name="blog_desc" required id="desc" rows="10" cols="80">{{ old('blog_desc') }}</textarea>
                                </div>
                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div> <!-- end card -->

                    <div class="col-lg-4 col-md-4 col-sm-12 col-12">

                        <div class="card">
                            <div class="card-header">
                                <h4 class="header-title">Diğer Bilgiler</h4>
                            </div>
                            <div class="card-body">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Blog Resim</label>
                                    <input class="form-control" type="file" required name="image" id="inputGroupFile04">
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="form-label">Meta Başlık</label>
                                    <input type="text" name="meta_title" required class="form-control" value="{{ old('meta_title') }}" id="" placeholder="">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="form-label">Meta Anahtar Kelime</label>
                                    <input type="text" name="meta_keyw" required class="form-control" value="{{ old('meta_keyw') }}" id="" placeholder="">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="form-label">Meta Açıklama</label>
                                    <input type="text" name="meta_desc" required class="form-control" value="{{ old('meta_desc') }}" id="" placeholder="">
                                </div>
                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div><!-- end col-->
                </div> <!-- end row-->
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary w-100">Kaydet</button>
                </div>
            </form>


        </div>
        <!-- container -->


@section('js')
<script>
    CKEDITOR.replace( 'desc' );
</script>

@endsection
@endsection
