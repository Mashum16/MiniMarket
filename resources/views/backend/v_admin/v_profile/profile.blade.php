@extends('backend.v_layouts.admin') {{-- Pastikan layout mengarah ke folder admin --}}

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Profil Administrator</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.beranda') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profil</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4 border-left-primary">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <img src="{{ Auth::user()->avatar ? asset('storage/img-user/'.Auth::user()->avatar) : 'https://cdn-icons-png.flaticon.com/512/847/847969.png' }}" 
                             class="rounded-circle img-thumbnail" 
                             style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #4e73df;">
                    </div>
                    <h5 class="font-weight-bold text-primary mb-1">{{ Auth::user()->name }}</h5>
                    <p class="text-uppercase small font-weight-bold text-muted letter-spacing-1">
                        <i class="fas fa-user-shield mr-1"></i> {{ Auth::user()->role }}
                    </p>
                    
                    <hr class="my-3">
                    
                    <div class="row no-gutters align-items-center bg-light p-2 rounded">
                        <div class="col-6 border-right">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Status</div>
                            <span class="badge badge-success px-3">Active</span>
                        </div>
                        <div class="col-6">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Akses</div>
                            <span class="small font-weight-bold text-dark">Full Access</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-gray-100">
                    <h6 class="m-0 font-weight-bold text-dark small"><i class="fas fa-server mr-2"></i>Informasi Sistem</h6>
                </div>
                <div class="card-body">
                    <div class="small mb-1 text-muted">Login Terakhir:</div>
                    <div class="small font-weight-bold mb-3">{{ now()->format('d M Y, H:i') }} (WIB)</div>
                    
                    <div class="small mb-1 text-muted">IP Address:</div>
                    <div class="small font-weight-bold text-primary">{{ request()->ip() }}</div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-primary">
                    <h6 class="m-0 font-weight-bold text-white">Data Otentikasi Admin</h6>
                    <a href="#" class="btn btn-sm btn-light text-primary font-weight-bold shadow-sm">
                        <i class="fas fa-cog fa-sm mr-1"></i> Kelola Akun
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td width="30%" class="text-muted font-weight-bold">Nama Lengkap</td>
                                    <td class="text-dark font-weight-bold">: {{ Auth::user()->name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted font-weight-bold">E-mail Resmi</td>
                                    <td class="text-dark">: {{ Auth::user()->email }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted font-weight-bold">Nomor Telepon</td>
                                    <td class="text-dark">: {{ Auth::user()->phone ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted font-weight-bold">Level Otoritas</td>
                                    <td class="text-dark">
                                        <span class="badge badge-primary text-capitalize">{{ Auth::user()->role }} System</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted font-weight-bold">Dibuat Pada</td>
                                    <td class="text-dark">: {{ Auth::user()->created_at->format('d F Y') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="alert alert-info border-left-info mt-3" role="alert">
                        <strong>Perhatian:</strong> Sebagai Administrator, Anda bertanggung jawab penuh atas perubahan data pada sistem. Pastikan untuk selalu menjaga kerahasiaan kredensial login Anda.
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-body">
                    <h6 class="font-weight-bold text-dark mb-3">Tindakan Cepat</h6>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <a href="{{ route('admin.audit.index') }}" class="btn btn-outline-primary btn-block btn-sm">
                                <i class="fas fa-list-ul mr-2"></i> Lihat Log Audit
                            </a>
                        </div>
                        <div class="col-md-4 mb-2">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary btn-block btn-sm">
                                <i class="fas fa-users-cog mr-2"></i> Manajemen User
                            </a>
                        </div>
                        <div class="col-md-4 mb-2">
                            <button class="btn btn-outline-danger btn-block btn-sm">
                                <i class="fas fa-key mr-2"></i> Ganti Password
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection