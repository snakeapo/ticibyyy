@extends('setting::backend.layout.default')
@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="profile-bg-picture"
                style="background-image:url('/panel/assets/images/bg-profile.jpg')">
                <span class="picture-bg-overlay"></span>
                <!-- overlay -->
            </div>
            <!-- meta -->
            <div class="profile-user-box">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="profile-user-img"><img src="/upload/user/{{ $data->avatar }}" alt=""
                                class="avatar-lg rounded-circle"></div>
                        <div class="">
                            <h4 class="mt-4 fs-17 ellipsis">{{ $data->name }} {{ $data->surname }}</h4>
                            <p class="font-13"> #{{ $data->identy }}</p>
                            <p class="text-muted mb-0"><small>@if($data->role == "admin") Admin @elseif($data->role == "user") Kullanıcı @endif</small></p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex justify-content-end align-items-center gap-2">
                            <button type="button" class="btn btn-soft-success">
                              Bakiye: {{ number_format($data->balance,2) }} TL
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ meta -->
        </div>
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-sm-12">
            <div class="card p-0">
                <div class="card-body p-0">
                    <div class="profile-content">
                        <ul class="nav nav-underline nav-justified gap-0">
                            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab"
                                    data-bs-target="#aboutme" type="button" role="tab"
                                    aria-controls="home" aria-selected="true" href="#aboutme">Genel</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#edit-profile" type="button" role="tab"
                                    aria-controls="home" aria-selected="true"
                                    href="#edit-profile">Bilgiler</a></li>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#edit-password" type="button" role="tab"
                                    aria-controls="home" aria-selected="true"
                                    href="#edit-profile">Şifre</a></li>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#projects" type="button" role="tab"
                                    aria-controls="home" aria-selected="true"
                                    href="#projects">Siparişler</a></li>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#user-activities" type="button" role="tab"
                                    aria-controls="home" aria-selected="true"
                                    href="#user-activities">Çekim Talepleri</a></li>
                        </ul>

                        <div class="tab-content m-0 p-4">
                            <div class="tab-pane active" id="aboutme" role="tabpanel"
                                aria-labelledby="home-tab" tabindex="0">
                                <div class="profile-desk">
                                    <h5 class="fs-17 text-dark">Genel Bilgiler</h5>
                                    <table class="table table-condensed mb-0 border-top">
                                        <tbody>
                                            <tr>
                                                <th scope="row">Email</th>
                                                <td>
                                                    <a href="mailto:{{ $data->email }}" class="ng-binding">
                                                        {{ $data->email }}
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Telefon</th>
                                                <td>
                                                    <a href="tel:{{ $data->user_phone }}" class="ng-binding">
                                                        {{ $data->user_phone }}
                                                    </a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th scope="row">Adres</th>
                                                <td class="ng-binding">{{ $data->user_address }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Cinsiyet</th>
                                                <td>
                                                        @if($data->sex == "male")
                                                        Erkek
                                                        @elseif($data->sex == "female")
                                                        Kadın
                                                        @endif
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div> <!-- end profile-desk -->
                            </div> <!-- about-me -->

                            <div id="edit-password" class="tab-pane">
                                <form action="{{ route('change_password',$data->id) }}" method="POST">
                                    @csrf
                                    <div class="col-md-12">
                                        <div class="form-floating mb-3">
                                            <input type="text" required name="password" class="form-control" id="floatingInput" placeholder="">
                                            <label for="floatingInput">Yeni Şifre</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating mb-3">
                                            <input type="text" required name="password_confirm" class="form-control" id="floatingInput" placeholder="">
                                            <label for="floatingInput">Yeni Şifre Onay</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary w-100">Kaydet</button>
                                    </div>
                                </form>
                            </div>



                            <!-- settings -->
                            <div id="edit-profile" class="tab-pane">
                                <div class="user-profile-content">
                                    <form action="{{ route('user_update',$data->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text" required name="name" value="{{ $data->name }}" class="form-control" id="floatingInput" placeholder="">
                                                    <label for="floatingInput">Ad</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text" name="surname" required value="{{ $data->surname }}" class="form-control" id="floatingInput" placeholder="">
                                                    <label for="floatingInput">Soyad</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="email" required name="email" required value="{{ $data->email }}" class="form-control" id="floatingInput" placeholder="">
                                            <label for="floatingInput">Email</label>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-floating mb-3">
                                                <input type="number" name="user_phone" value="{{ $data->user_phone }}" class="form-control" id="floatingInput" placeholder="">
                                                <label for="floatingInput">Telefon</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-floating mb-3">
                                                <input type="text" name="user_address" value="{{ $data->user_address }}" class="form-control" id="floatingInput" placeholder="">
                                                <label for="floatingInput">Adres</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <select class="form-select" required name="role" id="product_category" aria-label="">
                                                            <option selected="" disabled>Seçim Yapın.</option>
                                                            <option value="admin" @selected($data->role == "admin")>Admin</option>
                                                            <option value="user" @selected($data->role == "user")>Kullanıcı</option>
                                                    </select>
                                                    <label for="floatingSelect">Kullanıcı Yetki</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <select class="form-select" required name="sex" id="product_category" aria-label="">
                                                            <option selected="" disabled>Seçim Yapın.</option>
                                                            <option value="male" @selected($data->sex == "male")>Erkek</option>
                                                            <option value="female" @selected($data->sex == "female")>Kadın</option>
                                                    </select>
                                                    <label for="floatingSelect">Cinsiyet</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Avatar & Resim</label>
                                            <input class="form-control" type="file" name="avatar" id="inputGroupFile04">
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary w-100">Kaydet</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- profile -->
                            <div id="projects" class="tab-pane">
                                <div class="row m-t-10">
                                    <div class="col-md-12">
                                        <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>#No</th>
                                                    <th>Sipariş Tarihi</th>
                                                    <th>Müşteri Email</th>
                                                    <th>Müşteri Ad Soyad</th>
                                                    <th>Ürün</th>
                                                    <th>Toplam</th>
                                                    <th>Detay</th>
                                                    <th>Fatura</th>
                                                    <th>Sil</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach (\App\Models\Orders::where('user_id',$data->id)->get() as $key)
                                                <tr>
                                                    <td>#{{ $key->order_no }}</td>
                                                    <td>{{ $key->created_at }}</td>
                                                    <td>{{ $key->getUser->email }}</td>
                                                    <td>{{ $key->getUser->name }} {{ $key->getUser->surname }}</td>
                                                    <td>{{ \App\Models\Orderitems::where('order_token',$key->order_no)->count()  }} Adet Ürün</td>
                                                    <td>{{ number_format($key->total,2) }} TL</td>
                                                    <td><a href="{{ route('order_detail',$key->id) }}" class="btn btn-primary">Detay</a></td>
                                                    <td><a href="{{ route('invoice',$key->order_no) }}" target="_blank" class="btn btn-pink">Fatura</a></td>
                                                    <td><a href="{{ route('order_delete',$key->id) }}" onclick="confirmation(event)" class="btn btn-danger">Sil</a></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Activities -->
                            <div id="user-activities" class="tab-pane">
                                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Oluşturma Tarihi</th>
                                            <th>Ad Soyad</th>
                                            <th>Hesap Numarası</th>
                                            <th>İban Numarası</th>
                                            <th>Banka Numarası</th>
                                            <th>Kullanıcı</th>
                                            <th>Tutar</th>
                                            <th>Durum</th>
                                            <th>Sil</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i = 1; @endphp
                                        @foreach (\App\Models\Withs::where('user_id',$data->id)->get() as $key)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $key->created_at }}</td>
                                            <td>{{ $key->name_surname }}</td>
                                            <td>{{ $key->account }}</td>
                                            <td>{{ $key->iban }}</td>
                                            <td>{{ $key->bank_name }}</td>
                                            <td>{{ $key->getUser->email }}</td>
                                            <td>{{ number_format($key->total,2) }} TL</td>
                                            <td>
                                                @if($key->status == 1)
                                                <p style="color: rgb(65, 160, 65)">Onaylandı</p>
                                                @elseif($key->status == 2)
                                                <p style="color: rgb(228, 95, 95)">Reddedildi</p>
                                                @else
                                                <p style="color: orange">Bekliyor</p>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('withdraw_okay',$key->id) }}" class="btn btn-primary btn-sm">Onayla</a>
                                                <a href="{{ route('withdraw_reject',$key->id) }}" class="btn btn-danger btn-sm">Reddet</a>
                                                <a href="{{ route('withdraw_delete',$key->id) }}" onclick="confirmation(event)" class="btn btn-danger btn-sm">Sil</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

</div>

@endsection
