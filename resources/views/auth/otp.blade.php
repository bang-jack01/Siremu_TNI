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

    .card-header {
        background: transparent;
        border: none;
        text-align: center;
    }

    .otp-title {
        color: #fff;
        font-weight: 700;
        text-align: center;
        margin-top: 0.5rem;
        font-size: 1.9rem;
        letter-spacing: 1px;
        text-transform: uppercase;
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

    .text-link {
        color: #f8f9fa;
        text-decoration: none;
        transition: color 0.3s;
    }

    .text-link:hover {
        color: #ffc107;
    }
</style>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-5">
        <div class="card otp-box">
            <div class="card-header">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Mabes TNI" style="height: 60px;" class="mb-3">
                <div class="logo-group">
                    <img src="{{ asset('images/TNIAD.png') }}" alt="TNI AD" class="tni-logo">
                    <img src="{{ asset('images/TNIAL1.png') }}" alt="TNI AL" class="tni-logo">
                    <img src="{{ asset('images/TNIAU.png') }}" alt="TNI AU" class="tni-logo">
                </div>
                <h1 class="otp-title mt-3">Verifikasi OTP</h1>
                <p class="subtitle">Masukkan kode OTP yang telah dikirim ke email Anda</p>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('verify.otp') }}">
                    @csrf
                    <input type="hidden" name="email" value="{{ request('email') }}">

                    <div class="mb-3">
                        <label for="otp">Kode OTP</label>
                        <input type="text" name="otp" id="otp" class="form-control" required placeholder="Masukkan kode OTP Anda">
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-dark fw-bold">
                            Verifikasi
                        </button>
                    </div>

                    <div class="text-center">
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
