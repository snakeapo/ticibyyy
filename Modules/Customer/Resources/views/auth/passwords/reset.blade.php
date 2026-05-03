@extends('customer::auth.master')
@section('content')
    <h1 class="h2 mt-auto">Yeni şifrenizi belirleyin</h1>

    <div class="nav fs-sm mb-4 d-lg-none">
        <span class="me-2">Hesap oluşturma konusunda kararsız mısınız?</span>
        <a class="nav-link text-decoration-underline p-0" href="#benefits" data-bs-toggle="offcanvas" aria-controls="benefits">Avantajlarını Keşfedin</a>
    </div>

    <form class="singin-form" method="POST" action="{{ route('password.update') }}">
        @csrf
        <div class="form-group">
            <label class="form-group mb-2">Email</label>
            <input type="email" class="form-control form-control-lg" name="email" value="{{ $email ?? old('email') }}">
        </div>
        <div class="form-group">
            <label class="form-group mb-2">Yeni Şifreniz</label>
            <input type="password" class="form-control form-control-lg" name="password" placeholder="********">
        </div>
        <div class="form-group">
            <label class="form-group mb-3">Şifrenizi Onaylayınız</label>
            <input type="password" class="form-control form-control-lg" name="password_confirmation" placeholder="********">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-lg btn-primary w-100">Sıfırlama Bağlantısı Gönder</button>
        </div>
    </form>


@endsection
