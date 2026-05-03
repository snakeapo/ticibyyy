@extends('customer::auth.master')

@section('content')
    <h1 class="h2 mt-auto">Şifrenizi sıfırlayın</h1>
    <div class="nav fs-sm mb-3 mb-lg-4">
        Hatırladınız mı?
        <a class="nav-link text-decoration-underline p-0 ms-2" href="{{ route('login') }}">Giriş yap</a>
    </div>
    <div class="nav fs-sm mb-4 d-lg-none">
        <span class="me-2">Hesap oluşturma konusunda kararsız mısınız?</span>
        <a class="nav-link text-decoration-underline p-0" href="#benefits" data-bs-toggle="offcanvas" aria-controls="benefits">Avantajlarını Keşfedin</a>
    </div>

        <form class="singin-form" method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control form-control-lg" name="email" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-lg btn-primary w-100">Sıfırlama Bağlantısı Gönder</button>
            </div>
        </form>


@endsection
