@extends('customer::auth.master')
@section('content')
    <div class="auth-brand text-center mb-4">
        <a href="/" class="logo-dark">
            <img src="assets/images/logo-black.png" alt="dark logo" />
        </a>
        <a href="/" class="logo-light">
            <img src="assets/images/logo.png" alt="logo" />
        </a>
        <h4 class="fw-bold mt-3">Hoşgeldiniz</h4>
        <p class="text-muted w-lg-75 mx-auto">Panele giriş yapmak için bilgilerinizi giriniz.</p>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.login.submit') }}"  method="POST">
            @csrf
            <div class="mb-3">
                <label for="userEmail" class="form-label">
                    Email veya Telefon
                    <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <input type="text" class="form-control" name="login" id="userEmail" placeholder="Email veya telefon numaranız" required />
                </div>
            </div>

            <div class="mb-3">
                <label for="userPassword" class="form-label">
                    Şifreniz
                    <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <input type="password" name="password" class="form-control" id="userPassword" placeholder="••••••••" required />
                </div>
            </div>


            <div class="d-grid">
                <button type="submit" class="btn btn-primary fw-semibold py-2">Giriş yap</button>
            </div>
        </form>

    </div>

    <p class="text-center text-muted mt-4 mb-0">
        ©
        <script>
            document.write(new Date().getFullYear())
        </script>
        Powered by
        <span class="fw-bold">Ticiby</span>
    </p>

@endsection
