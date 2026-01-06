@extends('backend.v_layouts.staff')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">

            <h4 class="card-title">Laporan Data</h4>

            <form action="{{ route('staff.laporan.print') }}" method="GET" target="_blank">

                {{-- Jenis laporan --}}
                <div class="form-group">
                    <label>Jenis Laporan</label>
                    <select name="type" class="form-control" required>
                        <option value="">-- Pilih Laporan --</option>
                        <option value="users">User</option>
                        <option value="products">Produk</option>
                        <option value="orders">Order</option>
                    </select>
                </div>

                {{-- Tanggal awal --}}
                <div class="form-group mt-2">
                    <label>Tanggal Mulai</label>
                    <input type="date" name="start_date" class="form-control">
                </div>

                {{-- Tanggal akhir --}}
                <div class="form-group mt-2">
                    <label>Tanggal Akhir</label>
                    <input type="date" name="end_date" class="form-control">
                </div>

                <button class="btn btn-primary mt-3">
                    Cetak
                </button>
            </form>

        </div>
    </div>
</div>
@endsection
