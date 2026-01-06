@extends('backend.v_layouts.staff')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="h3 mb-4 text-gray-800">Selamat Datang di Staff MiniMarket</h1>
        <p>Ini adalah halaman beranda Staff. Dari sini, Anda bisa melihat Users, Produk dan Orders.</p>
    </div>
</div>

<div class="row">
    <!-- Contoh Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Users</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers ?? 0 }}</div>
            </div>
        </div>
    </div>
    <!-- Bisa tambah card lain untuk Produk, Order, dll -->
</div>
@endsection
