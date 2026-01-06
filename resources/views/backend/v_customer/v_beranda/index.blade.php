<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>MiniMarket | Belanja Kebutuhan Harian</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
        <link href="{{ asset('css/Styles.css') }}" rel="stylesheet" />
        
        <style>
            body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
            .navbar { box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
            
            /* Card Styling */
            .card-product {
                border: none;
                border-radius: 15px;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                overflow: hidden;
                background: #fff;
            }
            .card-product:hover {
                transform: translateY(-10px);
                box-shadow: 0 15px 30px rgba(0,0,0,0.1);
            }
            .card-img-container {
                height: 200px;
                overflow: hidden;
                background: #f1f1f1;
            }
            .card-product img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.5s ease;
            }
            .card-product:hover img {
                transform: scale(1.1);
            }
            
            /* Price & Text */
            .product-price { color: #198754; font-size: 1.2rem; font-weight: 700; }
            .product-name { font-weight: 600; color: #2c3e50; min-height: 50px; }
            .product-desc { font-size: 0.85rem; color: #7f8c8d; }
            
            /* Button Styling */
            .btn-add {
                border-radius: 50px;
                padding: 8px 20px;
                font-weight: 600;
                transition: all 0.3s;
            }
            .btn-add:hover { background-color: #198754; color: white; border-color: #198754; }
            
            /* Custom Header */
            .hero-header {
                background: linear-gradient(135deg, #198754 0%, #146c43 100%);
                padding: 100px 0;
                margin-bottom: 50px;
                border-radius: 0 0 50px 50px;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand fw-bold text-success" href="#!">
                    <i class="bi-shop-window me-2"></i>MiniMarket
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" href="#!">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown">Shop</a>
                            <ul class="dropdown-menu border-0 shadow" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#!">All Products</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                                <li><a class="dropdown-item" href="#!">New Arrivals</a></li>
                            </ul>
                        </li>
                    </ul>
            
                    <div class="dropdown">
                        <a class="d-flex align-items-center text-decoration-none dropdown-toggle" 
                          href="#" id="dropdownUser" data-bs-toggle="dropdown">
                            <img src="{{ Auth::user()->avatar ? asset('storage/img-user/'. Auth::user()->avatar) : 'https://cdn-icons-png.flaticon.com/512/847/847969.png'}}" 
                                 width="35" height="35" class="rounded-circle border">
                            <span class="ms-2 fw-semibold text-dark">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow text-small" aria-labelledby="dropdownUser">
                            @if(Auth::user()->role === 'admin')
                            <li>
                                <a class="dropdown-item fw-bold text-primary" href="{{ route('admin.beranda') }}">
                                    <i class="bi bi-speedometer2 me-2"></i> Ruang Admin
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            @endif
                                
                            @if(Auth::user()->role === 'staff')
                            <li>
                                <a class="dropdown-item fw-bold text-warning" href="{{ route('admin.beranda') }}">
                                    <i class="bi bi-briefcase me-2"></i> Ruang Staff
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            @endif
                                
                            <li>
                                <a class="dropdown-item d-flex justify-content-between align-items-center" href="/cart">
                                    <span><i class="bi-cart-fill me-2"></i> Keranjang</span>
                                    <span class="badge bg-success rounded-pill">{{ count(session('cart', [])) }}</span>
                                </a>
                            </li>
                            <li><a class="dropdown-item" href="/profile"><i class="bi bi-person me-2"></i> Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <header class="hero-header text-white shadow">
            <div class="container px-4 px-lg-5">
                <div class="text-center">
                    <h1 class="display-3 fw-bold mb-2">Selamat Berbelanja!</h1>
                    <p class="lead fw-normal text-white-700 mb-0 opacity-75">Kualitas Terbaik untuk Kebutuhan Keluarga Anda</p>
                </div>
            </div>
        </header>

        @if(session('success'))
        <div class="container">
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        @endif  

        <section class="pb-5">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gy-4 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                @foreach ($products as $product)
                <div class="col">
                    <div class="card card-product h-100 shadow-sm">
                        <div class="card-img-container">
                            <img src="{{ $product->image ? asset('storage/img-product/' . $product->image) : 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg' }}"
                                alt="{{ $product->name }}" />
                        </div>
                                        
                        <div class="card-body p-4">
                            <div class="text-center">
                                <h5 class="product-name mb-2">{{ $product->name }}</h5>
                                    <div class="product-desc mb-3 text-truncate">
                                        {!! $product->description !!}
                                    </div>
                                <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                            </div>
                        </div>
                                        
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center">
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-success btn-add w-100">
                                        <i class="bi-cart-plus me-1"></i> Tambah
                                    </button>
                                </form>
                             </div>
                        </div>
                    </div>
                </div>
                @endforeach
                </div>
            </div>
        </section>

        <footer class="py-5 bg-dark">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start">
                        <p class="m-0 text-white">Copyright &copy; MiniMarket 2026</p>
                    </div>
                    <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                        <a href="#" class="text-white-50 me-3 text-decoration-none"><i class="bi-facebook"></i></a>
                        <a href="#" class="text-white-50 me-3 text-decoration-none"><i class="bi-instagram"></i></a>
                        <a href="#" class="text-white-50 text-decoration-none"><i class="bi-twitter"></i></a>
                    </div>
                </div>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>