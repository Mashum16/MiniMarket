<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Minimarket</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{ asset('css/Styles.css') }}" rel="stylesheet" />
    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="#!">MiniMarket</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#!">All Products</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                                <li><a class="dropdown-item" href="#!">New Arrivals</a></li>
                            </ul>

                             @if(auth()->check() && auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link text-danger fw-bold" href="{{ route('admin.index') }}">
                                Admin
                                </a>
                            </li>
                            @endif
                            
                        </li>
                    </ul>
            
                    <div class="dropdown">
                        <a class="d-flex align-items-center text-decoration-none dropdown-toggle" 
                          href="#" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                           <img src="{{ Auth::user()->avatar
                           ? asset('storage/img-user/'. Auth::user()->avatar)
                           : 'https://cdn-icons-png.flaticon.com/512/847/847969.png'}}" alt="profile" width="40" height="40" class="rounded-circle">
                           <span class="ms-2 fw-semibold">{{ Auth::user()->name }}</span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end text-small shadow" aria-labelledby="dropdownUser">

                            <!-- Keranjang -->
                            <li>
                                <a class="dropdown-item d-flex justify-content-between align-items-center" href="/riwayat">
                                <span>
                                <i class="bi-cart-fill me-2"></i> Keranjang
                                </span>
                                <span class="badge bg-dark text-white rounded-pill">0</span>
                                </a>
                            </li>

                            <li><a class="dropdown-item" href="/profile">Profil</a></li>
                            <li><a class="dropdown-item" href="/settings">Pengaturan</a></li>

                            <li><hr class="dropdown-divider"></li>

                            <!-- Logout -->
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit">
                                        Logout
                                    </button>
                            </form>
                        </li>
                    </ul>
                   </div>
                    
                </div>
            </div>
        </nav>
        <!-- Header-->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif  
        <header class="bg-success py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Selamat Berbelanja!</h1>
                    <p class="lead fw-normal text-white-50 mb-0">Semua Kebutuhan Anda Pasti Ada Disini</p>
                </div>
            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                  
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                @foreach ($products as $product)
                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Product image -->
                        <img class="card-img-top"
                            src="{{ $product->image ? asset('storage/img-product/' . $product->image) : 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg' }}"
                            alt="{{ $product->name }}" />
                                        
                        <!-- Product details -->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <h5 class="fw-bolder">{{ $product->name }}</h5>
                                ${{ $product->price }}
                            </div>
                                        
                            <div>
                                <p>{{ $product->description }}</p>
                            </div>
                        </div>
                                        
                        <!-- tambah -->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center">
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                        @csrf
                                    <button type="submit" class="btn btn-outline-dark mt-auto" >Tambah</button>
                                </form>
                             </div>
                        </div>
                    </div>
                </div>
                @endforeach
                </div>
            </div>
        </section>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
