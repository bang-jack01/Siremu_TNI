@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="card-header bg-primary text-white text-center py-4"
             style="background: linear-gradient(90deg, #0056b3, #007bff);">
            <h4 class="fw-bold mb-0 text-uppercase">✦ Update Data Prajurit ✦</h4>
        </div>

        <div class="card-body p-5 bg-light">
            <form action="{{ route('input.update', $prajurit->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="text-center mb-4">
                    <div class="position-relative mx-auto rounded-circle border border-3 border-primary shadow-sm"
                         style="width: 140px; height: 140px; overflow: hidden; cursor: pointer;">
                        <input type="file" id="foto" name="foto" class="d-none" accept="image/*">
                        <label for="foto" class="w-100 h-100">
                            <img id="foto-preview"
                                src="{{ $prajurit->foto ? asset('storage/' . $prajurit->foto) : 'https://via.placeholder.com/140' }}"
                                alt="Foto Profil"
                                class="img-fluid w-100 h-100"
                                style="object-fit: cover;">
                        </label>
                        <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-50 text-white small py-1">
                            Ganti Foto
                        </div>
                    </div>
                    @error('foto') <small class="text-danger d-block mt-2">{{ $message }}</small> @enderror
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Pangkat</label>
                        <select name="pangkat" class="form-select shadow-sm" required>
                            <option value="">-- Pilih Pangkat --</option>
                            @foreach($pangkats as $matra => $list)
                                <optgroup label="TNI {{ $matra }}">
                                    @foreach($list as $p)
                                        <option value="{{ $matra }}|{{ $p }}" 
                                            {{ ($prajurit->angkatan.'|'.$prajurit->pangkat) == ($matra.'|'.$p) ? 'selected' : '' }}>
                                            {{ $p }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        @error('pangkat') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Satuan Baru</label>
                        <input type="text" name="satuan_baru" value="{{ $prajurit->satuan_baru }}" class="form-control shadow-sm" required>
                        @error('satuan_baru') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">No Kep</label>
                        <input type="text" name="no_kep" value="{{ $prajurit->no_kep }}" class="form-control shadow-sm">
                        @error('no_kep') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tanggal Kep</label>
                        <input type="date" name="tgl_kep" value="{{ $prajurit->tgl_kep }}" class="form-control shadow-sm">
                        @error('tgl_kep') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">No Sprint</label>
                        <input type="text" name="no_sprin" value="{{ $prajurit->no_sprin }}" class="form-control shadow-sm">
                        @error('no_sprin') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tanggal Sprint</label>
                        <input type="date" name="tgl_sprin" value="{{ $prajurit->tgl_sprin }}" class="form-control shadow-sm">
                        @error('tgl_sprin') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Alamat</label>
                        <input type="text" name="alamat" value="{{ $prajurit->alamat }}" class="form-control shadow-sm" required>
                        @error('alamat') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">No HP</label>
                        <input type="text" name="no_hp" value="{{ $prajurit->no_hp }}" class="form-control shadow-sm" required>
                        @error('no_hp') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold shadow-sm me-2"
                            style="border-radius: 10px; transition: all 0.3s;">
                        <i class="bi bi-save me-1"></i> Update Data
                    </button>
                    <a href="{{ route('dashboard') }}" 
                       class="btn btn-outline-secondary px-4 py-2 fw-semibold shadow-sm"
                       style="border-radius: 10px;">
                       <i class="bi bi-arrow-left-circle me-1"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.getElementById('foto').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => document.getElementById('foto-preview').src = e.target.result;
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
