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

    .register-box {
        backdrop-filter: blur(8px);
        background: rgba(255, 255, 255, 0.15);
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.6);
        transition: all 0.3s ease-in-out;
        padding: 2rem;
        border: 1px solid rgba(255, 255, 255, 0.25);
    }

    .register-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.7);
    }

    .card-header {
        background: transparent;
        border: none;
        text-align: center;
    }

    .register-title {
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

    .subtitle {
        color: #dcdcdc;
        font-size: 0.9rem;
        text-align: center;
        margin-top: -5px;
    }
</style>

<div class="container d-flex justify-content-center align-items-center min-vh-80">
    <div class="col-md-5">
        <div class="card register-box">
            <!-- Header -->
            <div class="card-header">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Mabes TNI" style="height: 60px;" class="mb-3">
                <div class="logo-group">
                    <img src="{{ asset('images/TNIAD.png') }}" alt="TNI AD" class="tni-logo">
                    <img src="{{ asset('images/TNIAL1.png') }}" alt="TNI AL" class="tni-logo">
                    <img src="{{ asset('images/TNIAU.png') }}" alt="TNI AU" class="tni-logo">
                </div>
                <h1 class="register-title mt-3">SIREMU TNI</h1>
                <p class="subtitle">Sistem Registrasi Mutasi Tentara Nasional Indonesia</p>
            </div>

            <!-- Body -->
            <div class="card-body">
                <form method="POST" action="{{ route('register.step.one') }}">
                    @csrf

                    <!-- Nama -->
                    <div class="mb-3">
                        <label for="name">Nama</label>
                        <input id="name" type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               name="name" value="{{ old('name') }}" required autofocus
                               placeholder="Masukkan nama lengkap Anda">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input id="email" type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required
                               placeholder="Masukkan email Anda">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tombol Submit -->
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-dark fw-bold">
                            Register
                        </button>
                    </div>

                    <!-- Sudah punya akun -->
                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-decoration-none small">
                            Sudah punya akun? <span class="text-warning fw-semibold">Login</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
