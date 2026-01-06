@extends('backend.v_layouts.staff') {{-- Sesuaikan dengan layout staff Anda --}}

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Profil Kerja Staff</h1>
        <span class="badge badge-warning p-2 shadow-sm text-dark">
            <i class="fas fa-calendar-alt mr-1"></i> {{ date('l, d F Y') }}
        </span>
    </div>

    <div class="row">
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4 border-left-warning">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <img src="{{ Auth::user()->avatar ? asset('storage/img-user/'.Auth::user()->avatar) : 'https://cdn-icons-png.flaticon.com/512/847/847969.png' }}" 
                             class="rounded-circle img-thumbnail shadow-sm" 
                             style="width: 140px; height: 140px; object-fit: cover; border: 3px solid #f6c23e;">
                    </div>
                    <h5 class="font-weight-bold text-dark mb-1">{{ Auth::user()->name }}</h5>
                    <p class="badge badge-warning text-dark px-3 py-2 text-uppercase mb-3" style="font-size: 0.7rem;">
                        <i class="fas fa-briefcase mr-1"></i> Operasional Staff
                    </p>
                    
                    <hr class="my-3">
                    
                    <div class="text-left px-3">
                        <div class="mb-2">
                            <small class="text-muted d-block">ID Staff</small>
                            <span class="font-weight-bold text-dark">STF-{{ str_pad(Auth::user()->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted d-block">Status Ketersediaan</small>
                            <span class="text-success"><i class="fas fa-circle mr-1" style="font-size: 0.6rem;"></i> On Duty (Aktif)</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-warning">
                    <h6 class="m-0 font-weight-bold text-dark small"><i class="fas fa-info-circle mr-2"></i>Catatan Staff</h6>
                </div>
                <div class="card-body">
                    <p class="small text-muted mb-0">
                        Pastikan data kontak Anda selalu update agar admin dan tim logistik dapat menghubungi Anda dengan mudah terkait manajemen stok dan orderan.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white border-bottom">
                    <h6 class="m-0 font-weight-bold text-warning"><i class="fas fa-id-card mr-2"></i>Informasi Data Diri</h6>
                </div>
                <div class="card-body">
                    <div class="row py-2">
                        <div class="col-sm-4 text-muted font-weight-bold">Email Kerja</div>
                        <div class="col-sm-8 text-dark">{{ Auth::user()->email }}</div>
                    </div>
                    <hr class="my-2">
                    <div class="row py-2">
                        <div class="col-sm-4 text-muted font-weight-bold">Nomor WhatsApp</div>
                        <div class="col-sm-8 text-dark">{{ Auth::user()->phone ?? 'Belum Ditambahkan' }}</div>
                    </div>
                    <hr class="my-2">
                    <div class="row py-2">
                        <div class="col-sm-4 text-muted font-weight-bold">Wewenang Role</div>
                        <div class="col-sm-8">
                            <span class="text-dark font-weight-bold text-capitalize">{{ Auth::user()->role }}</span>
                            <br><small class="text-muted">Manajemen Produk, Kategori, & Order</small>
                        </div>
                    </div>
                    <hr class="my-2">
                    <div class="row py-2">
                        <div class="col-sm-4 text-muted font-weight-bold">Terdaftar Sejak</div>
                        <div class="col-sm-8 text-dark">{{ Auth::user()->created_at->format('d F Y') }}</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center text-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Manajemen</div>
                                    <a href="{{ route('staff.products.index') }}" class="btn btn-sm btn-success btn-block">Stok Produk</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center text-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pesanan</div>
                                    <a href="{{ route('orders.index') }}" class="btn btn-sm btn-info btn-block">Daftar Order</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center text-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Keamanan</div>
                                    <button class="btn btn-sm btn-danger btn-block">Ganti Password</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection