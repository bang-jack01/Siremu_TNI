@extends('layouts.adminapp')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Perbarui Profil Admin</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.reset-password.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="text-center mb-4">
                            <div class="position-relative border rounded-circle mx-auto shadow-sm"
                                style="width:130px; height:130px; overflow:hidden; cursor:pointer;">
                                <input type="file" id="foto" name="foto" class="d-none" accept="image/*">
                                <label for="foto" class="w-100 h-100">
                                    <img id="foto-preview"
                                        src="{{ $user->foto ? asset('storage/' . $user->foto) : 'https://via.placeholder.com/130' }}"
                                        class="img-fluid w-100 h-100"
                                        alt="Foto Profil"
                                        style="object-fit: cover; cursor: pointer;">
                                </label>
                            </div>
                            <p class="fw-bold mt-2">Ubah Foto Profil</p>
                            @error('foto')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email Baru</label>
                            <input type="email" name="email" id="email" class="form-control shadow-sm"
                                value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Password Baru</label>
                            <input type="password" name="password" id="password" class="form-control shadow-sm" placeholder="Isi jika ingin mengganti password">
                            @error('password')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control shadow-sm" placeholder="Ulangi password baru">
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success px-4">Simpan Perubahan</button>
                            <a href="{{ route('admin.index') }}" class="btn btn-secondary px-4">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
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
