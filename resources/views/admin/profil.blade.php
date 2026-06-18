@extends('layouts.adminapp')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-5">

            <div class="card shadow border-0 rounded-4 overflow-hidden">
                <!-- Header -->
                <div class="text-center bg-primary text-white p-4">
                    <div class="profile-img-wrapper mx-auto mb-2">
                        <img src="{{ Auth::user()->foto 
                                 ? asset('storage/' . Auth::user()->foto) 
                                 : asset('images/default-user.png') }}"
                         class="profile-img rounded-circle shadow-sm"
                         style="width: 120px; height: 120px; object-fit: cover;"
                         alt="Foto Profil">
                    </div>
                    <h5 class="fw-bold mb-1">{{ Auth::user()->name }}</h5>
                    <span class="badge bg-danger role-badge">
                        {{ ucfirst(Auth::user()->role ?? 'Admin') }}
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
                                <ion-icon name="ribbon-outline" class="info-icon"></ion-icon>
                                <div>
                                    <small class="text-muted">Role</small>
                                    <p class="mb-0 fw-semibold">Admin</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-box small">
                                <ion-icon name="time-outline" class="info-icon"></ion-icon>
                                <div>
                                    <small class="text-muted">Terakhir Update</small>
                                    <p class="mb-0 fw-semibold">
                                        {{ Auth::user()->updated_at?->format('d M Y, H:i') ?? 'Belum pernah diperbarui' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Khusus Admin -->
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.reset-password.update', Auth::user()->id) }}"
                           class="btn btn-outline-dark ">
                           <ion-icon name="lock-open-outline"></ion-icon> Edit Prodil
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@include('profile-style')
@endsection
