<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>MiniMarket | Staff</title>

    <!-- Fonts -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Styles -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
</head>

<body id="page-top">

<div id="wrapper">

    <!-- ================= SIDEBAR ================= -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion">

        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('staff.dashboard') }}">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-user"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Ruang Staff</div>
        </a>

        <hr class="sidebar-divider my-0">

        <li class="nav-item">
            <a class="nav-link" href="{{ route('beranda') }}">
                <i class="fas fa-fw fa-home"></i>
                <span>Beranda</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        <li class="nav-item active">
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

        <li class="nav-item">
            <a class="nav-link" href="{{ route('orders.index') }}">
                <i class="fas fa-fw fa-shopping-cart"></i>
                <span>Order</span>
            </a>
        </li>

        <hr class="sidebar-divider d-none d-md-block">
    </ul>
    <!-- =============== END SIDEBAR =============== -->

    <div id="content-wrapper" class="d-flex flex-column">

        <!-- ================= TOPBAR ================= -->
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
                            <button class="dropdown-item text-danger" type="submit">
                                Logout
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- =============== END TOPBAR =============== -->

        <!-- ================= CONTENT ================= -->
        <div class="container-fluid">

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data User</h6>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable">
                            <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Edit</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($index as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>
                                        @if ($user->status == 1)
                                            <span class="badge bg-success text-white">Active</span>
                                        @else
                                            <span class="badge bg-danger text-white">Not Active</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('staff.edit', $user->id) }}"
                                           class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

            <a href="{{ route('staff.create') }}" class="btn btn-primary mb-3">
                <i class="bi bi-plus-lg"></i> Tambah User
            </a>

        </div>
        <!-- =============== END CONTENT =============== -->

        <footer class="sticky-footer bg-white">
            <div class="container my-auto text-center">
                <span>&copy; MiniMarket</span>
            </div>
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
