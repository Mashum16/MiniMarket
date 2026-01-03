<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MiniMarket - Detail Order</title>

<!-- Fonts & Icons -->
<link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<!-- SB Admin 2 -->
<link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>
<body id="page-top">

<div id="wrapper">

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('beranda') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-store"></i>
        </div>
        <div class="sidebar-brand-text mx-3">MiniMarket</div>
    </a>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('beranda') }}"><span>Beranda</span></a>
    </li>

    <li class="nav-item active">
        <a class="nav-link" href="{{ route('orders.index') }}"><span>Order</span></a>
    </li>
</ul>
<!-- End Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 shadow">
            <span class="ml-3 text-gray-600">Detail Order</span>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                        <img class="img-profile rounded-circle" src="https://cdn-icons-png.flaticon.com/512/847/847969.png">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item text-danger">Logout</button>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- End Topbar -->

        <!-- Page Content -->
        <div class="container-fluid">

            <!-- Order Info -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Order</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Kode Order:</strong> ORD-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                            <p><strong>Nama Pembeli:</strong> {{ $order->user->name}}</p>
                            <p><strong>Email:</strong> {{ $order->user->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y') }}</p>
                            <p><strong>Status:</strong>
                                <span class="badge badge-success">{{ ucfirst($order->status) }}</span>
                            </p>
                            <p><strong>Total:</strong> Rp {{ number_format($order->total,0,',','.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Produk</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                <tr>
                                    <td>{{ $item->product->name ?? '-' }}</td>
                                    <td>Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>
                                        Rp {{ number_format($item->price_at_purchase * $item->qty, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-3">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

        </div>
        <!-- End Container -->
    </div>

    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="text-center my-auto">
                <span>&copy; MiniMarket 2025</span>
            </div>
        </div>
    </footer>
</div>

</div>

<!-- JS -->

<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

</body>
</html>
