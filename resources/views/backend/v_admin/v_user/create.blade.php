@extends('backend.v_layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <h4 class="card-title">{{ $judul }}</h4>
                        <div class="row">

                            <!-- Foto / Avatar -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Avatar</label>
                                    <img id="avatarPreview" src="https://via.placeholder.com/150"
                                         class="img-thumbnail mb-2 d-block" style="max-width: 150px;">
                                    <input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror"
                                           onchange="previewAvatar(event)">
                                    @error('avatar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Detail User -->
                            <div class="col-md-8">

                                <div class="form-group">
                                    <label>Role</label>
                                    <select name="role" class="form-control @error('role') is-invalid @enderror">
                                        <option value="">- Pilih Role -</option>
                                        <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                                        <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                    @error('role')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="">- Pilih Status -</option>
                                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                           class="form-control @error('name') is-invalid @enderror"
                                           placeholder="Masukkan Nama">
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                           class="form-control @error('email') is-invalid @enderror"
                                           placeholder="Masukkan Email">
                                    @error('email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>HP</label>
                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           placeholder="Masukkan Nomor HP">
                                    @error('phone')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           placeholder="Masukkan Password">
                                    @error('password')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation"
                                           class="form-control" placeholder="Konfirmasi Password">
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Preview Avatar -->
@push('scripts')
<script>
function previewAvatar(event) {
    const reader = new FileReader();
    reader.onload = function() {
        document.getElementById('avatarPreview').src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endpush

@endsection
