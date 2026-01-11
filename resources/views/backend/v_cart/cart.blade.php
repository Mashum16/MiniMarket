<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja | Premium Store</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif;
        }
        .card {
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border-radius: 12px;
        }
        .product-image {
            border-radius: 8px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .product-image:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<section class="h-100">
    <div class="container py-5">
        <div class="row d-flex justify-content-center my-4">
            
            @php
                $cart = session('cart', []);
                $subtotal = 0;
                foreach($cart as $item) {
                    $subtotal += $item['price'] * $item['qty'];
                }
            @endphp

            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center bg-white">
                        <h5 class="mb-0 fw-bold">Keranjang Belanja</h5>
                        <span class="badge bg-primary rounded-pill">{{ count($cart) }} Produk</span>
                    </div>
                    <div class="card-body">
                        @if(count($cart) > 0)
                            @foreach($cart as $id => $item)
                            <div class="row align-items-center">
                                <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                                    <div class="bg-image hover-zoom ripple rounded" data-mdb-ripple-color="light">
                                        <img src="{{ $item['image'] ? asset('storage/img-product/' . $item['image']) : 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg' }}" 
                                             class="w-100 product-image" alt="{{ $item['name'] }}" />
                                    </div>
                                </div>

                                <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                                    <p class="mb-1 text-muted small text-uppercase">Produk</p>
                                    <h5 class="fw-bold">{{ $item['name'] }}</h5>
                                    <p class="text-primary fw-bold mb-3">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                    
                                    <div class="d-flex gap-2">
                                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-light btn-sm px-3 shadow-0 border" title="Hapus item">
                                                <i class="fas fa-trash text-danger"></i>
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-light btn-sm px-3 shadow-0 border" title="Simpan ke Wishlist">
                                            <i class="fas fa-heart text-muted"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0 text-center">
                                    <p class="mb-1 text-muted small text-uppercase">Kuantitas</p>
                                    <div class="d-flex justify-content-center align-items-center mb-3">
                                        <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex align-items-center border rounded bg-light">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-link px-3 py-2 text-dark shadow-0" type="submit" name="qty" value="{{ $item['qty'] - 1 }}" {{ $item['qty'] <= 1 ? 'disabled' : '' }}>
                                                <i class="fas fa-minus"></i>
                                            </button>

                                            <input type="text" value="{{ $item['qty'] }}" class="form-control border-0 text-center bg-transparent fw-bold" style="width: 50px;" readonly>

                                            <button class="btn btn-link px-3 py-2 text-dark shadow-0" type="submit" name="qty" value="{{ $item['qty'] + 1 }}">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <h6 class="fw-bold mb-0 text-dark">Subtotal: Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</h6>
                                </div>
                            </div>
                            @if(!$loop->last) <hr class="my-4" /> @endif
                            @endforeach 
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-shopping-basket fa-4x mb-3 text-muted"></i>
                                <h4>Keranjang Kosong</h4>
                                <p class="text-muted">Anda belum menambahkan produk apapun.</p>
                                <a href="{{ route('customer.beranda') }}" class="btn btn-primary rounded-pill px-4 shadow-0">Cari Produk</a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-truck-fast fa-2x me-3 text-primary"></i>
                        <div>
                            <p class="mb-0 fw-bold text-dark">Estimasi Pengiriman</p>
                            <p class="mb-0 text-muted small">Tiba dalam 2-3 hari kerja</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-header py-3 bg-white">
                        <h5 class="mb-0 fw-bold">Ringkasan Pesanan</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                Total Produk
                                <span class="fw-bold text-dark">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                Pengiriman
                                <span class="text-success fw-bold">Gratis</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3 mt-2">
                                <div>
                                    <strong class="h5">Total Bayar</strong>
                                    <p class="mb-0 text-muted small">(Termasuk PPN 11%)</p>
                                </div>
                                <span class="h4 fw-bold text-primary">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </li>
                        </ul>

                        <form action="{{ route('cart.checkout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-lg btn-block shadow-0 rounded-pill py-3 fw-bold" {{ count($cart) == 0 ? 'disabled' : '' }}>
                                Bayar Sekarang <i class="fas fa-chevron-right ms-2"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <p class="mb-3 fw-bold small text-muted text-uppercase">Dukungan Pembayaran</p>
                        <div class="d-flex flex-wrap gap-3">
                            <i class="fab fa-cc-visa fa-2x text-muted"></i>
                            <i class="fab fa-cc-mastercard fa-2x text-muted"></i>
                            <i class="fab fa-cc-paypal fa-2x text-muted"></i>
                            <i class="fas fa-building-columns fa-2x text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>

</body>
</html>