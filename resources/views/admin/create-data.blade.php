@extends('layouts.adminapp')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Tambah Data Prajurit Baru</h5>
        </div>
        <div class="card-body">
           <form action="{{ route('admin.data.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="text-center mb-4">
                    <div class="position-relative border rounded-circle mx-auto shadow-sm"
                        style="width:130px; height:130px; overflow:hidden; cursor: pointer;">
                        <input type="file" id="foto" name="foto" class="d-none" accept="image/*">
                        <label for="foto" class="w-100 h-100">
                            <img id="foto-preview" src="https://via.placeholder.com/130"
                                class="img-fluid w-100 h-100"
                                alt="Upload Foto"
                                style="object-fit: cover; cursor: pointer;">
                        </label>
                    </div>
                    <p class="fw-bold mt-2">Upload Foto</p>
                    @error('foto')
                        <small class="text-danger d-block">{{ $message }}</small>
                    @enderror
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="fw-bold">Nama</label>
                        <input type="text" name="name" class="form-control shadow-sm" value="{{ old('name') }}" required>
                    </div>
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

                    <div class="col-md-6">
                        <label class="fw-bold">Nrp</label>
                        <input type="text" name="nrp" class="form-control shadow-sm" value="{{ old('nrp_korp') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold">Korp</label>
                        <input type="text" name="korp" class="form-control shadow-sm" value="{{ old('nrp_korp') }}" required>
                    </div>
                    <div class="col-md-6"> 
                        <label class="fw-bold">NIK</label> 
                        <input type="text" name="nik" class="form-control shadow-sm" value="{{ old('nik') }}" required> 
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="gender" class="form-label fw-bold">Jenis Kelamin </label>
                        <select id="gender" name="gender" class="form-select shadow-sm" required>
                            <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Pilih jenis kelamin</option>
                            <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control shadow-sm" value="{{ old('tempat_lahir') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control shadow-sm" value="{{ old('tanggal_lahir') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold">No HP</label>
                        <input type="text" name="no_hp" class="form-control shadow-sm" value="{{ old('no_hp') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold">Alamat</label>
                        <textarea name="alamat" class="form-control shadow-sm" rows="1" required>{{ old('alamat') }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-bold">No Kep</label>
                        <input type="text" name="no_kep" class="form-control shadow-sm" value="{{ old('no_kep') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold">Tanggal Kep</label>
                        <input type="date" name="tgl_kep" class="form-control shadow-sm" value="{{ old('tgl_kep') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="fw-bold">No Sprint</label>
                        <input type="text" name="no_sprin" class="form-control shadow-sm" value="{{ old('no_sprint') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold">Tanggal Sprint</label>
                        <input type="date" name="tgl_sprin" class="form-control shadow-sm" value="{{ old('tgl_sprint') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="fw-bold">Satuan Asal</label>
                        <input type="text" name="satuan_asal" class="form-control shadow-sm" value="{{ old('satuan_asal') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold">Satuan Baru</label>
                        <input type="text" name="satuan_baru" class="form-control shadow-sm" value="{{ old('satuan_baru') }}" required>
                    </div>
                </div>
                <div class="mt-4 d-flex justify-content-end">
                    <a href="{{ route('admin.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-success px-4">Simpan</button>
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
