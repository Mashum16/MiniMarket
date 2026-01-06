@extends('backend.v_layouts.staff')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('staff.products.update', $product->id) }}"
                      method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <h4 class="card-title">{{ $judul }}</h4>
                        <div class="row">

                            <!-- Gambar Produk -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Gambar Produk</label>

                                    <img id="imagePreview"
                                         src="{{ $product->image
                                                ? asset('storage/' . $product->image)
                                                : 'https://via.placeholder.com/150' }}"
                                         class="img-thumbnail mb-2 d-block"
                                         style="max-width: 150px;">

                                    <input type="file" name="image"
                                           class="form-control @error('image') is-invalid @enderror"
                                           onchange="previewImage(event)">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
                                </div>
                            </div>

                            <!-- Detail Produk -->
                            <div class="col-md-8">

                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select name="category_id"
                                            class="form-control @error('category_id') is-invalid @enderror">
                                        <option value="">- Pilih Kategori -</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Nama Produk</label>
                                    <input type="text" name="name"
                                           value="{{ old('name', $product->name) }}"
                                           class="form-control @error('name') is-invalid @enderror">
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Harga</label>
                                    <input type="number" name="price"
                                           value="{{ old('price', $product->price) }}"
                                           class="form-control @error('price') is-invalid @enderror">
                                    @error('price')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Stok</label>
                                    <input type="number" name="stock"
                                           value="{{ old('stock', $product->stock) }}"
                                           class="form-control @error('stock') is-invalid @enderror">
                                    @error('stock')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea name="description" id="ckeditor"
                                              class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('staff.products.index') }}"
                               class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@push('script')
@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 2000
    });
</script>
@endif
@endpush
@endsection
