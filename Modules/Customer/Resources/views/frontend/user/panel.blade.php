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
                    <h1 class="h5 mb-1 mb-sm-2">Kullanıcı bilgilerim</h1>

                    <!-- Basic info -->
                    <div class="border rounded p-4">
                        <form class="account-details-form" method="POST" action="{{ route('user_post') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">Adınız</label>
                                        <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">Soyadınız</label>
                                        <input type="text" name="surname" class="form-control" value="{{ Auth::user()->surname }}">
                                    </div>
                                </div>
                                <div class="col-lg-12 mt-3 mb-3">
                                    <div class="form-group">
                                        <label class="form-label">Email</label>
                                        <input type="text" name="email"  class="form-control" value="{{ Auth::user()->email }}">
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class="form-group">
                                        <label class="form-label">Avatar</label>
                                        <input type="file" name="avatar" class="form-control">
                                    </div>
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <div class="form-group">
                                        <label class="form-label">Telefon</label>
                                        <input type="text" name="user_phone" required class="form-control" value="{{ Auth::user()->user_phone }}">
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
