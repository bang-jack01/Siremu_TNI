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

    .password-box {
        backdrop-filter: blur(8px);
        background: rgba(255, 255, 255, 0.15);
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.6);
        transition: all 0.3s ease-in-out;
        padding: 2rem;
        border: 1px solid rgba(255, 255, 255, 0.25);
    }

    .password-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.7);
    }

    .card-header {
        background: transparent;
        border: none;
        text-align: center;
    }

    .password-title {
        color: #fff;
        font-weight: 700;
        text-align: center;
        margin-top: 0.5rem;
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
        margin-bottom: 0.5rem;
    }

    a.text-decoration-none {
        color: #f8f9fa;
        transition: color 0.3s;
    }

    a.text-decoration-none:hover {
        color: #ffc107;
    }

    .alert {
        border-radius: 10px;
        font-size: 0.9rem;
    }
</style>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-5">
        <div class="card password-box border-0">
            <!-- Header -->
            <div class="card-header">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Mabes TNI" style="height: 60px;" class="mb-3">
                <div class="logo-group">
                    <img src="{{ asset('images/TNIAD.png') }}" alt="TNI AD" class="tni-logo">
                    <img src="{{ asset('images/TNIAL1.png') }}" alt="TNI AL" class="tni-logo">
                    <img src="{{ asset('images/TNIAU.png') }}" alt="TNI AU" class="tni-logo">
                </div>
                <h1 class="password-title">Set Your Password</h1>
                <p class="subtitle">Minimal 8 Karakter  (*@129Klh_*)</p>
            </div>

            <!-- Body -->
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success text-center">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('set.password') }}">
                    @csrf
                    <input type="hidden" name="email" value="{{ session('register.email', request('email')) }}">

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Create Password</label>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password" required placeholder="Masukkan password baru Anda">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input id="password_confirmation" type="password"
                               class="form-control" name="password_confirmation"
                               required placeholder="Konfirmasi password Anda">
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-dark fw-bold">Set Password</button>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-decoration-none small">
                            Kembali ke Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
