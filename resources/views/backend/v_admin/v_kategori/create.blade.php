@extends('backend.v_layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf

                    <div class="card-body">
                        <h4 class="card-title">{{ $judul }}</h4>

                        <div class="form-group">
                            <label>Nama Kategori</label>
                            <input type="text"
                                   name="name"
                                   value="{{ old('name') }}"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Masukkan nama kategori">
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                                Kembali
                            </a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
