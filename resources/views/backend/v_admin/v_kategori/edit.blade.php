@extends('backend.v_layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <h4 class="card-title">{{ $judul }}</h4>

                        <!-- Nama Kategori -->
                        <div class="form-group">
                            <label>Nama Kategori</label>
                            <input type="text"
                                   name="name"
                                   value="{{ old('name', $category->name) }}"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Masukkan nama kategori">
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Update
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
