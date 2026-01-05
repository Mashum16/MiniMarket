<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>MiniMarket | Staff</title>

    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

</head>

<body id="page-top">

<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('staff.dashboard') }}">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-smile-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Ruang Staff</div>
        </a>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('beranda') }}">
                <i class="fas fa-fw fa-home"></i>
                <span>Beranda</span>
            </a>
        </li>

        <hr class="sidebar-divider my-0">

        <li class="nav-item">
            <a class="nav-link" href="{{ route('staff.index') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>User</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('staff.products.index') }}">
                <i class="fas fa-fw fa-box"></i>
                <span>Produk</span>
            </a>
        </li>

        <li class="nav-item active">
            <a class="nav-link" href="{{ route('orders.index') }}">
                <i class="fas fa-fw fa-shopping-cart"></i>
                <span>Order</span>
            </a>
        </li>

        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>
    <!-- End Sidebar -->

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 shadow">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                            <span class="mr-2 text-gray-600 small">{{ Auth::user()->name }}</span>
                            <img class="img-profile rounded-circle"
                                 src="{{ Auth::user()->avatar
                                    ? asset('storage/img-user/'.Auth::user()->avatar)
                                    : 'https://cdn-icons-png.flaticon.com/512/847/847969.png' }}">
                        </a>

                        <div class="dropdown-menu dropdown-menu-right shadow">
                            <a class="dropdown-item" href="{{ route('profile') }}">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger" type="submit">Logout</button>
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>

            <!-- Content -->
            <div class="container-fluid">

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Data Order</h6>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable">
                                <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Nama</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge badge-info text-white">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('orders.show', $order->id) }}"
                                               class="btn btn-sm btn-primary">
                                                <i class="bi bi-eye"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <footer class="sticky-footer bg-white text-center">
            <span>&copy; MiniMarket</span>
        </footer>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/demo/datatables-demo.js') }}"></script>

</body>
</html>
