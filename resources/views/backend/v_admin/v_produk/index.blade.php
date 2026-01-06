@extends('backend.v_layouts.admin')

@section('content')
<!-- Judul Halaman -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Produk</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Produk
    </a>
</div>

<!-- Tabel Data Produk -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($products as $p)
                        <tr>
                            <td>{{ $p->name }}</td>

                            <td>
                                {{ $p->category ? $p->category->name : '-' }}
                            </td>

                            <td>
                                Rp {{ number_format($p->price, 0, ',', '.') }}
                            </td>

                            <td>{{ $p->stock }}</td>

                            <td class="text-center">

                                <!-- BUTTON SHOW -->
                                <a href="{{ route('admin.products.show', $p->id) }}"
                                   class="btn btn-sm btn-info mx-1">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('admin.products.edit', $p->id) }}"
                                   class="btn btn-sm btn-warning mx-1">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('admin.products.destroy', $p->id) }}"
                                      method="POST"
                                      class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            class="btn btn-sm btn-danger mx-1 btn-delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- SweetAlert Sukses -->
@push('scripts')
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
