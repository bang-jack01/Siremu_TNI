<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIREMU TNI</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: url('/images/bg-tni.png') no-repeat center center fixed;
            background-size: cover;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }
        .logo-img {
            width: 60px;
            height: 60px;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="login-card text-center">

                    <!-- Logo -->
                    <div class="d-flex justify-content-center mb-3">
                        <img src="/images/logo1.png" alt="Logo1" class="logo-img me-3">
                        <img src="/images/logo2.png" alt="Logo2" class="logo-img">
                    </div>

                    <h3 class="mb-4">Login</h3>

                    <!-- FORM LOGIN -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="form-group mb-3">
                            <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" placeholder="Email" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group mb-3">
                            <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remember & Forgot -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                            <a href="{{ route('password.request') }}" class="small text-primary">Forgot Password?</a>
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="btn btn-dark w-100 mb-3">Continue</button>
                    </form>

                    <!-- Divider -->
                    <div class="d-flex align-items-center my-3">
                        <hr class="flex-grow-1">
                        <span class="mx-2">OR</span>
                        <hr class="flex-grow-1">
                    </div>

                    <!-- Social Login (dummy dulu) -->
                    <div class="d-grid gap-2">
                        <a href="#" class="btn btn-outline-danger">Log in with Google</a>
                        <a href="#" class="btn btn-outline-primary">Log in with Facebook</a>
                        <a href="#" class="btn btn-outline-dark">Log in with Apple</a>
                    </div>

                    <!-- Register -->
                    <p class="mt-3 small">
                        Don’t have an account?
                        <a href="{{ route('register') }}" class="fw-bold text-primary">Sign Up</a>
                    </p>

                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
