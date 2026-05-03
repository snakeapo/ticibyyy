@extends('customer::auth.master')
@section('content')
    <h1 class="h2 mt-auto">Hesabınıza giriş yapın</h1>
    <div class="nav fs-sm mb-3 mb-lg-4">
        Bir hesabınız yok mu?
        <a class="nav-link text-decoration-underline p-0 ms-2" href="{{ route('register') }}">Hesap oluştur</a>
    </div>
    <div class="nav fs-sm mb-4 d-lg-none">
        <span class="me-2">Hesap oluşturma konusunda kararsız mısınız?</span>
        <a class="nav-link text-decoration-underline p-0" href="#benefits" data-bs-toggle="offcanvas" aria-controls="benefits">Avantajlarını Keşfedin</a>
    </div>

    <!-- Form -->
    <form action="{{ route('login') }}" method="POST" class="needs-validation" novalidate>
        @csrf
        <div class="position-relative mb-4">
            <label for="register-email" class="form-label">Email veya Telefon</label>
            <input type="text" class="form-control form-control-lg" name="login" id="register-email" value="{{ old('login') }}" required>
            <div class="invalid-tooltip bg-transparent py-0">Lütfen email veya telefon numaranızı giriniz</div>
        </div>
        <div class="mb-4">
            <label for="register-password" class="form-label">Şifreniz</label>
            <div class="password-toggle">
                <input type="password" name="password" class="form-control form-control-lg" id="register-password" required>
                <div class="invalid-tooltip bg-transparent py-0">Lütfen şifrenizi giriniz.</div>
                <label class="password-toggle-button fs-lg" aria-label="Show/hide password">
                    <input type="checkbox" class="btn-check">
                </label>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="form-check me-2">
                <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember" class="form-check-label">Beni hatırla</label>
            </div>
            <div class="nav">
                <a class="nav-link animate-underline p-0" href="{{ route('password.request') }}">
                    <span class="animate-target">Şifremi unuttum</span>
                </a>
            </div>
        </div>
        <button type="submit" class="btn btn-lg btn-primary w-100">
            Giriş yap
            <i class="ci-chevron-right fs-lg ms-1 me-n1"></i>
        </button>
    </form>

@endsection
