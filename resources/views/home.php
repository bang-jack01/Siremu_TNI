@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body text-center p-5">
                    
                    <!-- Judul -->
                    <h1 class="fw-bold mb-3">
                        Selamat datang di 
                        <span class="text-primary">SIREMU</span>
                    </h1>
                    <h5 class="text-muted mb-4">Sistem Remutasi Prajurit</h5>
                    
                    <!-- Info -->
                    <p class="lead mb-4">Input data <span class="fw-semibold">dimana saja</span> dan <span class="fw-semibold">kapan saja</span>.</p>
                    
                    <!-- Divider -->
                    <div class="mb-4">
                        <hr class="w-50 mx-auto">
                    </div>

                    <!-- CTA -->
                    <p class="fw-semibold mb-3">Silakan input data diri Anda</p>
                    <a href="{{ route('input.data') }}" class="btn btn-primary btn-lg px-5 shadow-sm">
                        <i class="bi bi-pencil-square me-2"></i> INPUT
                    </a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
