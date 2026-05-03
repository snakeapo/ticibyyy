@extends('page::frontend.layout.master')
@section('content')
    <div class="container py-5 mt-n2 mt-sm-0">
        <div class="row pt-md-2 pt-lg-3 pb-sm-2 pb-md-3 pb-lg-4 pb-xl-5">


            <!-- Sidebar navigation that turns into offcanvas on screens < 992px wide (lg breakpoint) -->
            @include('customer::frontend.include.sidebar')


            <!-- Personal info content -->
            <div class="col-lg-9">
                <div class="ps-lg-3 ps-xl-0">

                    <!-- Page title -->
                    <h1 class="h5 mb-1 mb-sm-2">Şifre değiştir</h1>

                    <!-- Basic info -->
                    <div class="border rounded p-4">
                        <form class="account-details-form" method="POST" action="{{ route('password_change_user') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="text" class="form-label">Mevcut Şifreniz</label>

                                    <div class="password-toggle">
                                        <input type="password" name="current_password" class="form-control form-control-lg" id="register-password" required>
                                        <label class="password-toggle-button fs-lg" aria-label="Show/hide password">
                                            <input type="checkbox" class="btn-check">
                                        </label>
                                    </div>

                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="text" class="form-label">Yeni Şifreniz</label>

                                    <div class="password-toggle">
                                        <input type="password" name="new_password" class="form-control form-control-lg" id="register-password" required>
                                        <label class="password-toggle-button fs-lg" aria-label="Show/hide password">
                                            <input type="checkbox" class="btn-check">
                                        </label>
                                    </div>

                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="text" class="form-label">Yeni Şifre Onay</label>

                                        <div class="password-toggle">
                                            <input type="password" name="new_password_confirmation" class="form-control form-control-lg" id="register-password" required>
                                            <label class="password-toggle-button fs-lg" aria-label="Show/hide password">
                                                <input type="checkbox" class="btn-check">
                                            </label>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb--0">
                                        <button class="btn btn-sm btn-success">Kaydet</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
