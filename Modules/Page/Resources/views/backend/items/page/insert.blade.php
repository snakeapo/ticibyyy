@extends('setting::backend.layout.default')
@section('content')

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-head d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="page-main-title m-0">Yeni Sayfa</h4>
                        </div>

                        <div class="text-end">
                            <ol class="breadcrumb m-0 py-0">
                                <li class="breadcrumb-item"><a href="https://softby.net">Softby</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Kontrol Paneli</a></li>
                                <li class="breadcrumb-item active">Yeni Sayfa</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->


                <form action="{{ route('page_create') }}" method="POST">
                    @csrf
                <div class="row">

                    <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="header-title">Temel Bilgiler</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-floating mb-3">
                                    <input type="text" required name="page_title" value="{{ old('page_title') }}" class="form-control" id="floatingInput" placeholder="">
                                    <label for="floatingInput">Sayfa Adı</label>
                                </div>

                                <div class="mb-3">
                                <label class="mb-2">Sayfa Açıklaması</label>
                                <textarea name="page_desc" required id="desc" rows="10" cols="80">{{ old('page_desc') }}</textarea>
                            </div>
                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div> <!-- end card -->

                    <div class="col-lg-4 col-md-4 col-sm-12 col-12">

                        <div class="card">
                            <div class="card-header">
                                <h4 class="header-title">Meta Bilgileri</h4>
                            </div>
                            <div class="card-body">
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
