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
                                <li class="breadcrumb-item"><a href="https://softby.net">Softby</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Kontrol Paneli</a></li>
                                <li class="breadcrumb-item active">Yeni Ürün</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <form action="{{ route('user_create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="header-title">Temel Bilgiler</h4>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" required name="name" value="{{ old('name') }}" class="form-control" id="floatingInput" placeholder="">
                                            <label for="floatingInput">Ad</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" name="surname" required value="{{ old('surname') }}" class="form-control" id="floatingInput" placeholder="">
                                            <label for="floatingInput">Soyad</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="email" required name="email" required value="{{ old('email') }}" class="form-control" id="floatingInput" placeholder="">
                                    <label for="floatingInput">Email</label>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="user_phone" value="{{ old('user_phone') }}" class="form-control" id="floatingInput" placeholder="">
                                        <label for="floatingInput">Telefon</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="user_address" value="{{ old('user_address') }}" class="form-control" id="floatingInput" placeholder="">
                                        <label for="floatingInput">Adres</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <select class="form-select" required name="role" id="product_category" aria-label="">
                                                    <option selected="" disabled>Seçim Yapın.</option>
                                                    <option value="admin" @selected(old('role') == "admin")>Admin</option>
                                                    <option value="user" @selected(old('role') == "user")>Kullanıcı</option>
                                            </select>
                                            <label for="floatingSelect">Kullanıcı Yetki</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <select class="form-select" required name="sex" id="product_category" aria-label="">
                                                    <option selected="" disabled>Seçim Yapın.</option>
                                                    <option value="male" @selected(old('sex') == "male")>Erkek</option>
                                                    <option value="female" @selected(old('sex') == "female")>Kadın</option>
                                            </select>
                                            <label for="floatingSelect">Cinsiyet</label>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end card body-->
                        </div> <!-- end card -->

                    </div><!-- end col-->
                    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="header-title">Şifre</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Avatar & Resim</label>
                                        <input class="form-control" required type="file" name="avatar" id="inputGroupFile04">
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating mb-3">
                                            <input type="text" required name="password" class="form-control" id="floatingInput" placeholder="">
                                            <label for="floatingInput">Şifre</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating mb-3">
                                            <input type="text" required name="password_confirm" class="form-control" id="floatingInput" placeholder="">
                                            <label for="floatingInput">Şifre Onay</label>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div>
                </div> <!-- end row-->

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary w-100">Kaydet</button>
                </div>
            </form>
            </div>

        </div>
        <!-- container -->


@endsection
