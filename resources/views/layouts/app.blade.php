<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIREMU TNI') }}</title>

    <!-- Bootstrap + App Styles via Vite -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
<body>
    <div id="app">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-md navbar-dark 
            @if(request()->routeIs(['dashboard','input.data','input.edit','client.profil'])) bg-primary @else bg-dark @endif shadow-sm">
            <div class="container ml-1">
                <div class="card-header text-dark d-flex align-items-center gap-2 rounded-top-3">
                    <img src="{{ asset('images/LOGOPUSINFO.png') }}" alt="Logo" style="height: 40px;">
                    <a class="navbar-brand fw-bold">SIREMU TNI</a>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <span id="datetime" class="text-white fw-semibold small d-none d-md-inline"></span>
                <span id="datetime-mobile" class="text-white fw-semibold small d-md-none"></span>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side -->
                    <ul class="navbar-nav me-auto"></ul>

                    <!-- Right Side -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" 
                                   data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="{{ route('client.profil') }}">
                                        <ion-icon name="person-circle-outline"></ion-icon> Profil
                                    </a>

                                    @if(isset($prajuritNavbar) && $prajuritNavbar)
                                        <a class="dropdown-item" href="{{ route('input.edit', $prajuritNavbar->id) }}">
                                            <ion-icon name="reader-outline"></ion-icon> Update Data
                                        </a>
                                    @endif

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <ion-icon name="log-out-outline"></ion-icon> Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                function updateDateTime() {
                    const now = new Date();
                    const days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
                    const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

                    const day = days[now.getDay()];
                    const date = now.getDate().toString().padStart(2,'0');
                    const month = months[now.getMonth()];
                    const year = now.getFullYear();
                    const hours = now.getHours().toString().padStart(2,'0');
                    const minutes = now.getMinutes().toString().padStart(2,'0');
                    const seconds = now.getSeconds().toString().padStart(2,'0');
                
                    const formatted = `${day}, ${date} ${month} ${year} | ${hours}:${minutes}:${seconds}`;
                    document.getElementById('datetime').textContent = formatted;
                    document.getElementById('datetime-mobile').textContent = formatted;
                }
            
                updateDateTime();
                setInterval(updateDateTime, 1000);
            });
        </script>

        <!-- Content -->
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
