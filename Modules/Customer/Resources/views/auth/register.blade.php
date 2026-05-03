@extends('customer::auth.master')

@section('content')
    <h1 class="h2 mt-auto">Yeni hesap oluşturun</h1>
    <div class="nav fs-sm mb-3 mb-lg-4">
        Bir hesabınız var mı?
        <a class="nav-link text-decoration-underline p-0 ms-2" href="{{ route('login') }}">Giriş yap</a>
    </div>
    <div class="nav fs-sm mb-4 d-lg-none">
        <span class="me-2">Hesap oluşturma konusunda kararsız mısınız?</span>
        <a class="nav-link text-decoration-underline p-0" href="#benefits" data-bs-toggle="offcanvas" aria-controls="benefits">Avantajlarını Keşfedin</a>
    </div>
    <form class="singin-form" method="POST" action="{{ route('register') }}">
        @csrf
        <div class="row mb-2">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Adınız</label>
                    <input type="text" class="form-control form-control-lg" required name="name">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Soyadınız</label>
                    <input type="text" class="form-control form-control-lg" required name="surname">
                </div>
            </div>
        </div>
        <div class="form-group mb-2">
            <label class="form-label">Email</label>
            <input type="email" class="form-control form-control-lg" name="email" required>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Telefon</label>
            <input type="text" class="form-control form-control-lg" name="user_phone" value="{{ old('user_phone') }}" required>
        </div>
        <div class="form-group mb-3">
            <labe class="form-label"l>Cinsiyet</label>
            <select class="form-control form-control-lg" name="sex" required id="">
                <option value="male">Erkek</option>
                <option value="female">Kadın</option>
            </select>
        </div>
        <div class="row mb-4">
            <div class="col-md-6">
                <label for="register-password" class="form-label">Şifreniz</label>
                <div class="password-toggle">
                    <input type="password" name="password" class="form-control form-control-lg" id="register-password" required>
                    <div class="invalid-tooltip bg-transparent py-0">Lütfen şifrenizi giriniz.</div>
                    <label class="password-toggle-button fs-lg" aria-label="Show/hide password">
                        <input type="checkbox" class="btn-check">
                    </label>
                </div>
            </div>
            <div class="col-md-6">
                <label for="register-password" class="form-label">Şifreniz</label>
                <div class="password-toggle">
                    <input type="password" name="password_confirmation" class="form-control form-control-lg" id="register-password" required>
                    <div class="invalid-tooltip bg-transparent py-0">Lütfen şifrenizi giriniz.</div>
                    <label class="password-toggle-button fs-lg" aria-label="Show/hide password">
                        <input type="checkbox" class="btn-check">
                    </label>
                </div>

            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-lg btn-primary w-100">Hesabı Oluştur</button>
        </div>
    </form>


@endsection
