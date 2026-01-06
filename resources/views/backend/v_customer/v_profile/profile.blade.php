@extends('backend.v_layouts.customer')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Profil Saya</h1>
    </div>

    <div class="row">
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4 border-bottom-success">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <img src="{{ Auth::user()->avatar ? asset('storage/img-user/'.Auth::user()->avatar) : 'https://cdn-icons-png.flaticon.com/512/847/847969.png' }}" 
                             class="rounded-circle img-thumbnail" 
                             style="width: 140px; height: 140px; object-fit: cover; border: 3px solid #1cc88a;">
                    </div>
                    <h5 class="font-weight-bold text-dark mb-0">{{ Auth::user()->name }}</h5>
                    <small class="text-success font-weight-bold">Pelanggan Setia</small>
                    
                    <hr class="my-3">
                    
                    <div class="bg-light p-3 rounded mb-3">
                        <small class="text-muted d-block font-italic">ID Pelanggan</small>
                        <span class="font-weight-bold text-dark">#MM-{{ str_pad(Auth::user()->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </div>

                    <div class="text-left small">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Status Akun:</span>
                            <span class="badge badge-success px-2">Aktif</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Bergabung:</span>
                            <span class="text-dark font-weight-bold">{{ Auth::user()->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card bg-gradient-success text-white shadow mb-4">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Apresiasi Pelanggan</div>
                            <div class="small">Terima kasih telah mempercayakan kebutuhan Anda kepada MiniMarket kami.</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-heart fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-info-circle mr-2"></i>Informasi Akun Terdaftar
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row py-3 align-items-center">
                        <div class="col-sm-4 text-muted font-weight-bold">Nama Lengkap</div>
                        <div class="col-sm-8 text-dark font-weight-bold">{{ Auth::user()->name }}</div>
                    </div>
                    
                    <div class="row py-3 align-items-center border-top">
                        <div class="col-sm-4 text-muted font-weight-bold">Alamat Email</div>
                        <div class="col-sm-8 text-dark">{{ Auth::user()->email }}</div>
                    </div>
                    
                    <div class="row py-3 align-items-center border-top">
                        <div class="col-sm-4 text-muted font-weight-bold">Nomor HP / WhatsApp</div>
                        <div class="col-sm-8 text-dark">{{ Auth::user()->phone ?? 'Data belum tersedia' }}</div>
                    </div>
                    
                    <div class="row py-3 align-items-center border-top">
                        <div class="col-sm-4 text-muted font-weight-bold">Tipe Keanggotaan</div>
                        <div class="col-sm-8 text-dark"><span class="badge badge-outline-success border border-success text-success px-3">Regular Member</span></div>
                    </div>

                    <div class="row py-3 align-items-center border-top">
                        <div class="col-sm-4 text-muted font-weight-bold">Keamanan</div>
                        <div class="col-sm-8 text-muted font-italic">Password Anda terenkripsi demi keamanan</div>
                    </div>

                    <div class="mt-4 p-3 bg-light rounded border-left-success">
                        <h6 class="font-weight-bold text-dark mb-1">Pemberitahuan</h6>
                        <p class="small text-muted mb-0">
                            Data di atas diambil langsung dari sistem otentikasi. Jika ingin melakukan perubahan data, harap hubungi layanan pelanggan kami.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <a href="{{ route('customer.beranda') }}" class="btn btn-success btn-block shadow-sm">
                        <i class="fas fa-shopping-cart mr-2"></i> Mulai Belanja Sekarang
                    </a>
                </div>
                <div class="col-md-6 mb-3">
                    <a href="{{ route('orders.index') }}" class="btn btn-dark btn-block shadow-sm">
                        <i class="fas fa-list mr-2"></i> Lihat Riwayat Pesanan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection