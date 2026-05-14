@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white text-center rounded-top">
            <h4 class="fw-bold mb-0">Isi Data Diri Prajurit</h4>
        </div>

        <div class="card-body p-5">
            {{-- Form Input Data --}}
            <form action="{{ route('input.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-5 align-items-center">
                    <div class="col-md-3 text-center">
                        <div class="position-relative border rounded-circle mx-auto shadow-sm mt-3"
                            style="width:130px; height:130px; overflow:hidden; cursor:pointer;">
                            <input type="file" id="foto" name="foto" class="d-none" accept="image/*">
                            <label for="foto" class="w-100 h-100">
                                <img id="foto-preview"
                                    src="{{ $prajurit->foto ? asset('storage/' . $prajurit->foto) : 'https://via.placeholder.com/140' }}"
                                    alt="Foto Profil"
                                    class="img-fluid w-100 h-100"
                                    style="object-fit: cover;">
                            </label>
                            <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-50 text-white small py-1">
                                Upload Foto
                            </div>
                        </div>
                        <p class="fw-bold mt-3">{{ Auth::user()->name }}</p>
                        @error('foto')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-9">
                        <div class="alert alert-info small shadow-sm" role="alert">
                            ✅ Pastikan data diisi dengan benar.  
                            <b>Periksa kembali sebelum melakukan submit!</b>
                        </div>
                    </div>
                </div>
                <div class="row g-4">

                    {{-- Nama --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control shadow-sm" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Pangkat --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Pangkat</label>
                        <select name="pangkat" class="form-select" required>
                            <option value="">-- Pilih Pangkat --</option>
                            @foreach($pangkats as $matra => $list)
                                <optgroup label="TNI {{ $matra }}">
                                    @foreach($list as $p)
                                        <option value="{{ $matra }}|{{ $p }}" {{ old('pangkat') == "$matra|$p" ? 'selected' : '' }}>
                                            {{ $p }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>

                        @error('pangkat')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- NRP/KORP --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">NRP</label>
                        <input type="text" name="nrp" value="{{ old('nrp_korp') }}" class="form-control shadow-sm" required>
                        @error('nrp_korp') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">KORP</label>
                        <input type="text" name="korp" value="{{ old('nrp_korp') }}" class="form-control shadow-sm" required>
                        @error('nrp_korp') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    {{-- NIK --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">NIK</label>
                        <input type="text" name="nik" value="{{ old('nik') }}" class="form-control shadow-sm" required>
                        @error('nik') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="gender" class="form-label fw-bold">Jenis Kelamin</label>
                        <select id="gender" name="gender" class="form-select shadow-sm" required>
                            <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>       
                    {{-- Tempat Lahir --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="form-control shadow-sm" required>
                        @error('tempat_lahir') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="form-control shadow-sm" required>
                        @error('tanggal_lahir') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    {{-- No Kep --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">No Kep</label>
                        <input type="text" name="no_kep" value="{{ old('no_kep') }}" class="form-control shadow-sm">
                        @error('no_kep') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    {{-- Tanggal Kep --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tanggal Kep</label>
                        <input type="date" name="tgl_kep" value="{{ old('tgl_kep') }}" class="form-control shadow-sm">
                        @error('tgl_kep') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    {{-- No Sprint --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">No Sprint</label>
                        <input type="text" name="no_sprin" value="{{ old('no_sprin') }}" class="form-control shadow-sm">
                        @error('no_sprin') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tanggal Sprint</label>
                        <input type="date" name="tgl_sprin" value="{{ old('tgl_sprin') }}" class="form-control shadow-sm">
                        @error('tgl_sprin') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Satuan Asal --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Satuan Asal</label>
                        <input type="text" name="satuan_asal" value="{{ old('satuan_asal') }}" class="form-control shadow-sm" required>
                        @error('satuan_asal') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Satuan Baru --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Satuan Baru</label>
                        <input type="text" name="satuan_baru" value="{{ old('satuan_baru') }}" class="form-control shadow-sm" required>
                        @error('satuan_baru') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    
                    {{-- No HP --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">No Handphone</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="form-control shadow-sm" required>
                        @error('no_hp') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    {{-- Alamat --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Alamat</label>
                        <input type="text" name="alamat" value="{{ old('alamat') }}" class="form-control shadow-sm" required>
                        @error('alamat') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                </div>

                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm">
                        <i class="bi bi-save"></i> Submit
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-lg px-5 shadow-sm ms-2">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fotoInput = document.getElementById('foto');
    const fotoPreview = document.getElementById('foto-preview');

    fotoInput.addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                fotoPreview.src = e.target.result;
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });
});
</script>
@endsection
