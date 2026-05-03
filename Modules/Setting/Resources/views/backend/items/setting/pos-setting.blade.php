@extends('setting::backend.layout.default')
@section('content')



        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-head d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="page-main-title m-0">Paytr Pos Ayarları</h4>
                        </div>

                        <div class="text-end">
                            <ol class="breadcrumb m-0 py-0">
                                <li class="breadcrumb-item"><a href="https://softby.net">Softby</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Kontrol Paneli</a></li>
                                <li class="breadcrumb-item active">Paytr Ayarları</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">

                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-12 col-12">

                        <div class="card">
                            <div class="card-header">
                                <h4 class="header-title">Paytr Pos Ayarları</h4>
                            </div>
                            <div class="card-body">

                                <form action="{{ route('pos_setting_update',$data->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-floating mb-3">
                                        <input type="text" required name="paytr_id" value="{{ $data->paytr_id }}" class="form-control" id="floatingInput" placeholder="">
                                        <label for="floatingInput">Mağaza ID</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" required name="paytr_salt" value="{{ $data->paytr_salt }}" class="form-control" id="floatingInput" placeholder="">
                                        <label for="floatingInput">Paytr Salt</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" required name="paytr_key" value="{{ $data->paytr_key }}" class="form-control" id="floatingInput" placeholder="">
                                        <label for="floatingInput">Paytr Key</label>
                                    </div>

                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary w-100">Kaydet</button>
                                    </div>
                                </form>

                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div><!-- end col-->
                    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="header-title">Bilgilendirme</h4>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info text-center mb-0" role="alert">
                                    <div class="avatar-sm mb-2 mx-auto">
                                        <span class="avatar-title bg-info rounded-circle">
                                            <i class="ri-check-line align-middle fs-22"></i>
                                        </span>
                                    </div>
                                    <h4 class="alert-heading">! ÖNEMLİ !</h4>
                                    <p>Sistemde kullanılan sanal pos PAYTR'dir, başvurunuzu ona göre ve Paytr bilgilerine göre girmelisiniz ayarları</p>
                                    <p><b>Paytr Dönüş URL</b></p>
                                    <p><b>{{ env('APP_URL') }}/paytr-odeme-basarili</b></p>
                                </div>


                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div>
                </div> <!-- end row-->


            </div>

        </div>
        <!-- container -->



@endsection
