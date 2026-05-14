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

    .reset-card {
        backdrop-filter: blur(8px);
        background: rgba(255, 255, 255, 0.15);
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.6);
        padding: 2rem;
        border: 1px solid rgba(255, 255, 255, 0.25);
        transition: all 0.3s ease-in-out;
    }

    .reset-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.7);
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

    .reset-title {
        color: #fff;
        font-weight: 700;
        text-align: center;
        margin-top: 0.5rem;
        font-size: 1.8rem;
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
        <div class="card reset-card text-center">
            <!-- Logo Section -->
            <div class="mb-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Mabes TNI" style="height: 60px;" class="mb-3">
                <div class="logo-group">
                    <img src="{{ asset('images/TNIAD.png') }}" alt="TNI AD" class="tni-logo">
                    <img src="{{ asset('images/TNIAL1.png') }}" alt="TNI AL" class="tni-logo">
                    <img src="{{ asset('images/TNIAU.png') }}" alt="TNI AU" class="tni-logo">
                </div>
            </div>

            <h2 class="reset-title mb-3">Reset Password</h2>
            <p class="text-white-50 small mb-4">Silakan masukkan password baru Anda</p>

            <!-- Body -->
            <div class="card-body">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ request()->email ?? old('email') }}">

                    <!-- Password -->
                    <div class="mb-3 text-start">
                        <label for="password" class="form-label">Password Baru</label>
                        <input id="password" type="password" 
                               class="form-control @error('password') is-invalid @enderror"
                               name="password" required autocomplete="new-password"
                               placeholder="Masukkan password baru">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3 text-start">
                        <label for="password-confirm" class="form-label">Konfirmasi Password</label>
                        <input id="password-confirm" type="password" 
                               class="form-control" 
                               name="password_confirmation" required autocomplete="new-password"
                               placeholder="Ulangi password baru">
                    </div>

                    <!-- Submit -->
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-dark fw-bold">
                            Reset Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
