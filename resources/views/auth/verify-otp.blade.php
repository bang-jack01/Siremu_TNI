@extends('layouts.app')

@section('content')
<style>
    body {
        background: 
            linear-gradient(rgba(0, 0, 0, 0.55), rgba(0, 0, 0, 0.65)),
            url('{{ asset("images/bg.png") }}') no-repeat center center fixed;
        background-size: cover;
        font-family: 'Poppins', sans-serif;
    }

    .otp-box {
        backdrop-filter: blur(8px);
        background: rgba(255, 255, 255, 0.15);
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.6);
        transition: all 0.3s ease-in-out;
        padding: 2rem;
        border: 1px solid rgba(255, 255, 255, 0.25);
    }

    .otp-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.7);
    }

    .otp-header {
        background: transparent;
        border: none;
        text-align: center;
    }

    .otp-title {
        color: #fff;
        font-weight: 700;
        font-size: 1.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .subtitle {
        color: #dcdcdc;
        font-size: 0.9rem;
        text-align: center;
        margin-top: -5px;
    }

    label {
        font-weight: 600;
        color: #fff;
    }

    .form-control {
        border-radius: 10px;
        padding: 10px 14px;
        background: rgba(255, 255, 255, 0.9);
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
        margin-bottom: 0.5rem;
    }

    .text-link {
        color: #f8f9fa;
        text-decoration: none;
        transition: color 0.3s;
    }

    .text-link:hover {
        color: #ffc107;
    }

    .alert {
        border-radius: 10px;
        font-size: 0.9rem;
    }
</style>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-5">
        <div class="card otp-box border-0">
            <div class="otp-header">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Mabes TNI" style="height: 60px;" class="mb-3">
                <div class="logo-group">
                    <img src="{{ asset('images/TNIAD.png') }}" alt="TNI AD" class="tni-logo">
                    <img src="{{ asset('images/TNIAL1.png') }}" alt="TNI AL" class="tni-logo">
                    <img src="{{ asset('images/TNIAU.png') }}" alt="TNI AU" class="tni-logo">
                </div>
                <h1 class="otp-title">Verifikasi OTP</h1>
                <p class="subtitle">Masukkan kode OTP yang dikirim ke email Anda</p>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success text-center">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('verify.otp') }}">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">

                    <div class="mb-3">
                        <label for="otp" class="form-label">Kode OTP</label>
                        <input id="otp" type="text" 
                               class="form-control @error('otp') is-invalid @enderror"
                               name="otp" value="{{ old('otp') }}" required maxlength="6" minlength="6"
                               placeholder="Masukkan 6 digit OTP">
                        @error('otp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-dark fw-bold">Verifikasi</button>
                    </div>

                    <div class="text-center small text-light">
                        OTP dikirim ke <strong>{{ $email }}</strong>
                    </div>

                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}" class="text-link small">
                            Kembali ke <span class="text-warning fw-semibold">Login</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
