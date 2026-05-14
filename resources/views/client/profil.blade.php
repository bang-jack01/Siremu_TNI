
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-5">

            <div class="card shadow border-0 rounded-4 overflow-hidden">
                <!-- Header -->
                <div class="text-center bg-primary text-white p-4">
                    <div class="profile-img-wrapper mx-auto mb-2">
                        <img src="{{ Auth::user()->prajurit && Auth::user()->prajurit->foto && file_exists(public_path('storage/' . Auth::user()->prajurit->foto)) 
                                     ? asset('storage/' . Auth::user()->prajurit->foto) 
                                     : asset('images/default-user.png') }}"
                             class="profile-img rounded-circle shadow-sm"
                             style="width: 120px; height: 120px; object-fit: cover;"
                             alt="Foto Prajurit">
                    </div>
                    <h5 class="fw-bold mb-1">{{ Auth::user()->name }}</h5>
                    <span class="badge bg-success role-badge">
                        User
                    </span>
                </div>

                <!-- Body -->
                <div class="card-body p-3">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="info-box small">
                                <ion-icon name="person-outline" class="info-icon"></ion-icon>
                                <div>
                                    <small class="text-muted">Nama Lengkap</small>
                                    <p class="mb-0 fw-semibold">{{ Auth::user()->name }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-box small">
                                <ion-icon name="mail-outline" class="info-icon"></ion-icon>
                                <div>
                                    <small class="text-muted">Email</small>
                                    <p class="mb-0 fw-semibold">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-box small">
                                <ion-icon name="time-outline" class="info-icon"></ion-icon>
                                <div>
                                    <small class="text-muted">Terakhir Update</small>
                                    <p class="mb-0 fw-semibold">{{ Auth::user()->updated_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Back -->
                    <div class="text-center mt-3">
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary px-4">
                            <i class="bi bi-x-circle"></i> Back
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@include('profile-style')
@endsection
