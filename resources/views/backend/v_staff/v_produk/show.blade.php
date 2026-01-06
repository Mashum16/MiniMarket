@extends('backend.v_layouts.staff')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <h4 class="card-title">{{ $judul }}</h4>
                    <div class="row">

                        <!-- Kolom Kiri -->
                        <div class="col-md-6">

                            <!-- Kategori -->
                            <div class="form-group">
                                <label>Kategori</label>
                                <select class="form-control" disabled>
                                    <option> - Pilih Kategori - </option>
                                    @foreach ($categories as $row)
                                        <option value="{{ $row->id }}"
                                            {{ $product->category_id == $row->id ? 'selected' : '' }}>
                                            {{ $row->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Nama Produk -->
                            <div class="form-group">
                                <label>Nama Produk</label>
                                <input type="text" class="form-control"
                                       value="{{ $product->name }}" disabled>
                            </div>

                            <!-- Deskripsi -->
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <div class="border rounded p-2" style="min-height:150px;">
                                    {!! $product->description !!}
                                </div>
                            </div>

                            <!-- Gambar Utama -->
                            <div class="form-group">
                                <label>Gambar Utama</label>
                                <img src="{{ $product->image
                                            ? asset('storage/img-product/' . $product->image)
                                            : asset('images/no-image.png') }}"
                                     class="img-fluid mt-2" width="100%">
                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="col-md-6">
                            <label>Foto Tambahan</label>

                            <div id="foto-container" class="mb-3">
                                <div class="row">
                                    @foreach($product->images as $image)
                                       <div class="col-md-12 mb-3 text-center">
                                           <img src="{{ asset('storage/' . $image->image) }}"
                                               class="img-fluid mb-2"
                                                style="max-height: 250px; object-fit: cover;">
                                                                    
                                          <form action="{{ route('staff.product-images.destroy', $image->id) }}"
                                                 method="POST">
                                               @csrf
                                                @method('DELETE')
                                               <button type="submit" class="btn btn-sm btn-danger mx-1 btn-delete">
                                                   Hapus Foto
                                               </button>
                                           </form>
                                       </div>
                                    @endforeach
                                </div>
                            </div>
                                <form action="{{ route('staff.product-images.store') }}"
                                    method="POST"
                                    enctype="multipart/form-data"
                                   class="mb-3">
                                   @csrf

                                  <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                                
                                  <div class="form-group">
                                      <input type="file"
                                             name="image"
                                              class="form-control"
                                              required>
                                   </div>

                                   <button type="submit" class="btn btn-success mt-2">
                                      Simpan Foto
                                 </button>
                                </form>
                        </div>

                    </div>
                </div>

                <div class="border-top">
                    <div class="card-body">
                        <a href="{{ route('staff.products.index') }}"
                           class="btn btn-secondary">Kembali</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
