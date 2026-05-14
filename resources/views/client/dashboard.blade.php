@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            @if(Auth::check() && is_null(Auth::user()->prajurit))
                <div class="card border-0 shadow-lg rounded-4 bg-white bg-opacity-75">
                    <div class="card-body text-center p-5">
                        <h4 class="fw-bold text-dark mb-3">⚠️ Data Prajurit Belum Lengkap</h4>
                        <p class="fw-semibold mb-4">
                            Anda wajib melengkapi <span class="text-primary">Data Prajurit</span> sebelum melanjutkan.
                        </p>
                        <a href="{{ route('input.data') }}" class="btn btn-primary px-4 shadow-sm">
                            <i class="bi bi-pencil-square me-1"></i> Lengkapi Data
                        </a>
                    </div>
                </div>

            @else
         
                <div class="card shadow-sm border-0 rounded-4 mb-4" 
                     style="background: linear-gradient(100deg, #c3d6faff, #619ef3ff);">
                    <div class="card-body text-center py-3 px-4">
                        <h3 class="fw-bold mb-1">
                            Selamat Datang, <span class="text-primary">{{ Auth::user()->nama }}</span>
                        </h3>
                        <p class="text-muted">
                            <strong>SIREMU TNI</strong> Sistem Registrasi Mutasi Prajurit 
                        <P>
                    <span >Untuk info selanjut nya silahkan data ke&nbsp;<strong>PUSINFOLAHTA TNI</strong></span>
                    </div>
                </div>
                <div class="profile-container mx-auto p-4 p-md-5 rounded-5 shadow-lg border-0"
                     style="background: linear-gradient(135deg, #ffffff, #f4f8ff);">

                    <p class="fw-semibold text-secondary mb-3"><ion-icon name="person-outline"></ion-icon> Data Personil</p>
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
                        <div class="d-flex align-items-center">
                            <img src="{{ Auth::user()->prajurit && Auth::user()->prajurit->foto && file_exists(public_path('storage/' . Auth::user()->prajurit->foto)) 
                                     ? asset('storage/' . Auth::user()->prajurit->foto) 
                                     : asset('images/default-user.png') }}"
                             class="profile-img rounded-circle shadow-sm"
                             style="width: 120px; height: 120px; object-fit: cover;"
                             alt="Foto Prajurit">
                            <div>
                                <h4 class="text-muted fw-bold text-balck  mb-0">Nama: {{ $prajurit->name ?? '-' }}</h4>
                                <p class="text-muted  mb-0">Email: {{ Auth::user()->email }}</p>
                            </div>
                        </div>
                    </div>

                    <hr class="text-muted mb-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">NIK</label>
                            <div class="info-box">{{ $prajurit->nik ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Pangkat</label>
                            <div class="info-box">{{ $prajurit->pangkat ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">NRP</label>
                            <div class="info-box">{{ $prajurit->nrp ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">KORP</label>
                            <div class="info-box">{{ $prajurit->korp ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Matra</label>
                            <div class="info-box">{{ $prajurit->angkatan ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Satuan Baru</label>
                            <div class="info-box">{{ $prajurit->satuan_baru ?? '-' }}</div>
                        </div>
                       <div class="col-md-6">
                            <label class="text-muted small mb-1">Tempat Lahir</label>
                            <div class="info-box">{{ $prajurit->tempat_lahir ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Tanggal Lahir</label>
                            <div class="info-box">{{ $prajurit->tanggal_lahir ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">No KEP</label>
                            <div class="info-box">{{ $prajurit->no_kep ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Tanggal KEP</label>
                            <div class="info-box">{{ $prajurit->tgl_kep ?? '-' }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted small mb-1">No SPRIN</label>
                            <div class="info-box">{{ $prajurit->no_sprin ?? '-' }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Tanggal SPRIN</label>
                            <div class="info-box">{{ $prajurit->tgl_sprin ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Jenis Kelamin</label>
                            <div class="info-box">{{ $prajurit->gender ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Tanggal Bergabung</label>
                            <div class="info-box">{{ $prajurit->created_at ? $prajurit->created_at->format('d M Y') : '-' }}</div>
                        </div>
                    </div>

                </div>
                <style>
                .profile-container {
                    background: linear-gradient(135deg, #ffffff, #f4f8ff);
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
                    border-radius: 25px;
                    transition: all 0.3s ease-in-out;
                    backdrop-filter: blur(6px);
                }
                .profile-container:hover {
                    transform: translateY(-3px);
                    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
                }
                .profile-img {
                    border: 3px solid #fff;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                }
                .info-box {
                    background: #f7f9fc;
                    padding: 10px 14px;
                    border-radius: 10px;
                    font-weight: 500;
                    color: #333;
                    box-shadow: inset 0 1px 3px rgba(0,0,0,0.05);
                    transition: background 0.2s ease-in-out;
                }
                .info-box:hover {
                    background: #eaf2ff;
                }
                .btn:hover {
                    transform: translateY(-2px);
                }
                </style>

            @endif
        </div>
    </div>
</div>
@endsection
