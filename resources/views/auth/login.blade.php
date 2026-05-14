@extends('layouts.app')

@section('content')
<style>
    body {
        background: 
            linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.6)),
            url('{{ asset("images/bg.png") }}') no-repeat center center fixed;
        background-size: cover;
        font-family: 'Poppins', sans-serif;
    }

    .login-box {
        backdrop-filter: blur(8px);
        background: rgba(255, 255, 255, 0.15);
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.6);
        transition: all 0.3s ease-in-out;
        padding: 2rem;
        border: 1px solid rgba(255, 255, 255, 0.25);
    }

    .login-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.7);
    }

    .card-header {
        background: transparent;
        border: none;
    }

    .login-title {
        color: #fff;
        font-weight: 700;
        text-align: center;
        margin-top: 0.5rem;
        font-size: 2rem;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    label {
        font-weight: 600;
        color: #fff;
    }

    .form-control {
        border-radius: 10px;
        padding: 10px 14px;
        background: rgba(255, 255, 255, 0.85);
        border: none;
    }

    .form-control:focus {
        box-shadow: 0 0 0 2px #007bff;
    }

    .btn-dark {
        border-radius: 10px;
        background: linear-gradient(90deg, #1b1b1b, #434343);
        transition: 0.3s ease;
    }

    .btn-dark:hover {
        background: linear-gradient(90deg, #272727, #000);
        transform: scale(1.03);
    }

    .tni-logo {
        height: 45px;
        width: auto;
        transition: transform 0.3s ease;
    }

    .tni-logo:hover {
        transform: scale(1.1);
    }

    .logo-group {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 25px;
    }

    a.text-decoration-none {
        color: #f8f9fa;
        transition: color 0.3s;
    }

    a.text-decoration-none:hover {
        color: #ffc107;
    }
</style>

<div class="container d-flex justify-content-center align-items-center min-vh-80">
    <div class="col-md-5">
        <div class="card login-box">
            <!-- Header -->
            <div class="card-header text-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Mabes TNI" style="height: 60px;" class="mb-3">
                <div class="logo-group">
                    <img src="{{ asset('images/TNIAD.png') }}" alt="TNI AD" class="tni-logo">
                    <img src="{{ asset('images/TNIAL1.png') }}" alt="TNI AL" class="tni-logo">
                    <img src="{{ asset('images/TNIAU.png') }}" alt="TNI AU" class="tni-logo">
                </div>
                <h1 class="login-title mt-3">SIREMU TNI</h1>
                <p class="text-white mb-0">Sistem Registrasi Mutasi Tentara Nasional Indonesia</p>
            </div>

            <!-- Body -->
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email">{{ __('Email Address') }}</label>
                        <input id="email" type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}"
                               required autocomplete="email" autofocus
                               placeholder="Masukkan email Anda">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password">{{ __('Password') }}</label>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password" required autocomplete="current-password"
                               placeholder="Masukkan password Anda">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="form-check mb-3 text-white">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                               {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('Ingat Saya') }}
                        </label>
                    </div>

                    <!-- Submit -->
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-dark fw-bold">
                            {{ __('Login') }}
                        </button>
                    </div>

                    <!-- Forgot password -->
                    @if (Route::has('password.request'))
                        <div class="text-center">
                            <a class="text-decoration-none small" href="{{ route('password.request') }}">
                                {{ __('Lupa Password?') }}
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
