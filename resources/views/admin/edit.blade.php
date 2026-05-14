@extends('layouts.adminapp')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Edit Data Prajurit</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.update', $prajurit->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <!-- Foto -->
                    <div class="col-12 md-3 text-center">
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

                    <!-- Nama -->
                    <div class="col-md-6">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control" 
                               value="{{ old('name', $prajurit->name) }}" required>
                    </div>

                    <!-- Pangkat -->
                    <div class="col-md-6">
                        <label class="form-label">Pangkat</label>
                        <select name="pangkat" class="form-select" required>
                            <option value="">-- Pilih Pangkat --</option>

                            @php
                                $pangkats = [
                                    'AD' => ['Pratu', 'Praka', 'Kopral', 'Sersan', 'Letnan Dua', 'Letnan Satu', 'Kapten', 'Mayor', 'Letnan Kolonel', 'Kolonel', 'Brigadir Jenderal', 'Mayor Jenderal', 'Letnan Jenderal', 'Jenderal'],
                                    'AL' => ['Kelasi', 'Kopral', 'Sersan', 'Letnan Dua', 'Letnan Satu', 'Kapten', 'Mayor', 'Letnan Kolonel', 'Kolonel', 'Laksamana Pertama', 'Laksamana Muda', 'Laksamana Madya', 'Laksamana'],
                                    'AU' => ['Pradet', 'Kopral', 'Sersan', 'Letnan Dua', 'Letnan Satu', 'Kapten', 'Mayor', 'Letnan Kolonel', 'Kolonel', 'Marsekal Pertama', 'Marsekal Muda', 'Marsekal Madya', 'Marsekal']
                                ];
                            @endphp

                            @foreach($pangkats as $matra => $list)
                                <optgroup label="TNI {{ $matra }}">
                                    @foreach($list as $p)
                                        <option value="{{ $p }}" {{ old('pangkat', $prajurit->pangkat) == $p ? 'selected' : '' }}>
                                            {{ $p }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>

                    <!-- NRP -->
                    <div class="col-md-6">
                        <label class="form-label">NRP</label>
                        <input type="text" name="nrp" class="form-control" 
                               value="{{ old('nrp', $prajurit->nrp) }}" required>
                    </div>

                    <!-- KORP -->
                    <div class="col-md-6">
                        <label class="form-label">Korp</label>
                        <input type="text" name="korp" class="form-control" 
                               value="{{ old('korp', $prajurit->korp) }}" required>
                    </div>

                    <!-- NIK -->
                    <div class="col-md-6">
                        <label class="form-label">NIK</label>
                        <input type="text" name="nik" class="form-control" 
                               value="{{ old('nik', $prajurit->nik) }}" required>
                    </div>

                    <!-- Gender -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Jenis Kelamin</label>
                        <select name="gender" class="form-select shadow-sm" required>
                            <option value="" disabled {{ old('gender', $prajurit->gender) == '' ? 'selected' : '' }}>Pilih Gender</option>
                            <option value="Laki-laki" {{ old('gender', $prajurit->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('gender', $prajurit->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" 
                               value="{{ old('tempat_lahir', $prajurit->tempat_lahir) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" 
                               value="{{ old('tanggal_lahir', $prajurit->tanggal_lahir) }}">
                    </div>

                    <!-- Satuan Asal -->
                    <div class="col-md-6">
                        <label class="form-label">Satuan Asal</label>
                        <input type="text" name="satuan_asal" class="form-control" 
                               value="{{ old('satuan_asal', $prajurit->satuan_asal) }}">
                    </div>

                    <!-- Satuan Baru -->
                    <div class="col-md-6">
                        <label class="form-label">Satuan Baru</label>
                        <input type="text" name="satuan_baru" class="form-control" 
                               value="{{ old('satuan_baru', $prajurit->satuan_baru) }}">
                    </div>

                    <!-- No Kep -->
                    <div class="col-md-6">
                        <label class="form-label">No Kep</label>
                        <input type="text" name="no_kep" class="form-control" 
                               value="{{ old('no_kep', $prajurit->no_kep) }}">
                    </div>

                    <!-- Tgl Kep -->
                    <div class="col-md-6">
                        <label class="form-label">Tgl Kep</label>
                        <input type="date" name="tgl_kep" class="form-control" 
                               value="{{ old('tgl_kep', $prajurit->tgl_kep) }}">
                    </div>

                    <!-- No Sprint -->
                    <div class="col-md-6">
                        <label class="form-label">No Sprint</label>
                        <input type="text" name="no_sprin" class="form-control" 
                               value="{{ old('no_sprin', $prajurit->no_sprin) }}">
                    </div>

                    <!-- Tgl Sprint -->
                    <div class="col-md-6">
                        <label class="form-label">Tgl Sprint</label>
                        <input type="date" name="tgl_sprin" class="form-control" 
                               value="{{ old('tgl_sprin', $prajurit->tgl_sprin) }}">
                    </div>
                    
                    <!-- No HP -->
                    <div class="col-md-6">
                        <label class="form-label">No HP</label>
                        <input type="text" name="no_hp" class="form-control" 
                               value="{{ old('no_hp', $prajurit->no_hp) }}">
                    </div>


                    <!-- Alamat -->
                    <div class="col-12">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $prajurit->alamat) }}</textarea>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <a href="{{ route('admin.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
