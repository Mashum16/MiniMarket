@extends('backend.v_layouts.admin')

@section('content')
<!-- Judul Halaman -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Kategori</h1>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Kategori
    </a>
</div>

<!-- Tabel Data Kategori -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama Kategori</th>
                        <th>Slug</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Nama Kategori</th>
                        <th>Slug</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td class="text-center">
                                <!-- Edit -->
                                <a href="{{ route('admin.categories.edit', $category->id) }}"
                                   class="btn btn-sm btn-warning mx-1">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <!-- Hapus -->
                                <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                      method="POST"
                                      class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger mx-1 btn-delete">
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
