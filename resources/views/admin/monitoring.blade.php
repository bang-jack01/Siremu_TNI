@extends('layouts.adminapp')

@section('content')
<div class="container-fluid">
    <div class="card shadow border-0 rounded-4 overflow-hidden">
        <div class="card-header text-white py-3" 
            style="background: linear-gradient(135deg, #0d6efd, #084298) !important;">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="fw-bold mb-2 mb-sm-0">
                    <ion-icon name="bar-chart-outline"></ion-icon> Monitoring & Laporan Prajurit
                </h5>
                <span class="small opacity-75">Sistem Registrasi Mutasi TNI</span>
            </div>
        </div>
        <div class="card-body pb-2">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                <form method="GET" action="{{ route('admin.monitoring') }}" 
                      class="d-flex flex-wrap align-items-center gap-2">

                    <label class="fw-semibold me-2 text-secondary">Filter:</label>
                    <select name="filter" class="form-select form-select-sm w-auto">
                        <option value="1bulan" {{ $filter == '1bulan' ? 'selected' : '' }}>1 Bulan Terakhir</option>
                        <option value="3bulan" {{ $filter == '3bulan' ? 'selected' : '' }}>3 Bulan Terakhir</option>
                        <option value="1tahun" {{ $filter == '1tahun' ? 'selected' : '' }}>1 Tahun Terakhir</option>
                    </select>

                    <select name="angkatan" class="form-select form-select-sm w-auto">
                        <option value="" {{ $angkatan == '' ? 'selected' : '' }}>Semua Angkatan</option>
                        <option value="AD" {{ $angkatan == 'AD' ? 'selected' : '' }}>AD</option>
                        <option value="AL" {{ $angkatan == 'AL' ? 'selected' : '' }}>AL</option>
                        <option value="AU" {{ $angkatan == 'AU' ? 'selected' : '' }}>AU</option>
                    </select>

                    <button type="submit" class="btn btn-primary btn-sm px-3 shadow-sm">
                        <ion-icon name="filter-outline"></ion-icon> Filter
                    </button>

                    <a href="{{ route('admin.exportExcel', ['filter' => $filter, 'angkatan' => $angkatan]) }}" 
                       class="btn btn-warning btn-sm px-3 shadow-sm">
                        <ion-icon name="download-outline"></ion-icon> Export Excel
                    </a>
                </form>
                @if(request()->has('filter'))
                <div class="d-flex align-items-center gap-3 mt-3 mt-md-0">
                    @if($angkatan == '' || $angkatan == 'AD')
                    <div class="text-center">
                        <img src="{{ asset('images/TNIAD.png') }}" width="30" alt="AD">
                        <div class="small fw-bold text-success mt-1">{{ $countAD ?? 0 }}</div>
                    </div>
                    @endif

                    @if($angkatan == '' || $angkatan == 'AL')
                    <div class="text-center">
                        <img src="{{ asset('images/TNIAL1.png') }}" width="30" alt="AL">
                        <div class="small fw-bold text-primary mt-1">{{ $countAL ?? 0 }}</div>
                    </div>
                    @endif

                    @if($angkatan == '' || $angkatan == 'AU')
                    <div class="text-center">
                        <img src="{{ asset('images/TNIAU.png') }}" width="30" alt="AU">
                        <div class="small fw-bold text-info mt-1">{{ $countAU ?? 0 }}</div>
                    </div>
                    @endif
                    @if($angkatan == '')
                    <div class="text-center ms-3 ps-3 border-start border-2 border-secondary">
                        <div class="fw-bold text-dark small">Total</div>
                        <div class="fw-semibold text-secondary">
                            {{ ($countAD ?? 0) + ($countAL ?? 0) + ($countAU ?? 0) }}
                        </div>
                    </div>
                    @endif
                </div>
                @endif
            </div>

            {{-- 📋 Data Tabel --}}
            <div class="table-responsive mt-3">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>NRP</th>
                            <th>KORP</th>
                            <th>NIK</th>
                            <th>Pangkat</th>
                            <th>Matra</th>
                            <th>Satuan Asal</th>
                            <th>Satuan Baru</th>
                            <th>Tanggal Registrasi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse($data as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $row->name }}</td>
                            <td>{{ $row->nrp}}</td>
                            <td>{{ $row->korp }}</td>
                            <td>{{ $row->nik }}</td>
                            <td>{{ $row->pangkat }}</td>
                            <td>{{ $row->angkatan }}</td>
                            <td>{{ $row->satuan_asal }}</td>
                            <td>{{ $row->satuan_baru }}</td>
                            <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <ion-icon name="alert-circle-outline" class="fs-4 text-secondary"></ion-icon>
                                <div>Tidak ada data ditemukan</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
