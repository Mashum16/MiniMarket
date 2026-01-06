<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    BerandaController,
    LoginController,
    RegisterController,
    UserController,
    ProductController,
    CartController,
    OrderController,
    ProfileController,
    AuditLogController,
    CategoryController,
    ProductImagesController,
    ReportController,
};

/*
|--------------------------------------------------------------------------
| WELCOME
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| GUEST
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);

    Route::get('/register', [RegisterController::class, 'registerForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'storeRegister'])->name('register.store');
});

/*
|--------------------------------------------------------------------------
| AUTH UMUM
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Beranda customer
    Route::get('/beranda', [BerandaController::class, 'beranda'])->name('customer.beranda');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Menampilkan halaman profil (index)
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    
    // Memproses update data profil
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // order
    Route::resource('orders', OrderController::class)->only(['index', 'show']);
    Route::post('/orders/{order}/status', [OrderController::class, 'updateStatus'])
        ->name('orders.updateStatus');

    // cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', [BerandaController::class, 'adminBeranda'])->name('beranda');

        Route::resource('products', ProductController::class);
        Route::resource('users', UserController::class);
        Route::resource('categories', CategoryController::class);

        Route::post('/product-images', [ProductImagesController::class, 'store'])
            ->name('product-images.store');

        Route::delete('/product-images/{id}', [ProductImagesController::class, 'destroy'])
            ->name('product-images.destroy');

        // LAPORAN
        Route::resource('laporan', ReportController::class)->only(['index']);
        Route::get('/laporan/print', [ReportController::class, 'print'])
            ->name('laporan.print');

        Route::get('/audit', [AuditLogController::class, 'index'])->name('audit.index');
        Route::get('/audit/{id}', [AuditLogController::class, 'show'])->name('audit.show');
});

/*
|--------------------------------------------------------------------------
| STAFF (TERBATAS)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:staff'])
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {

    // Beranda staff
    Route::get('/', [BerandaController::class, 'staffBeranda'])->name('beranda');

    // User (staff hanya lihat index)
    Route::resource('users', UserController::class)
        ->only(['index']);

    // Product (staff bisa semua method)
    Route::resource('products', ProductController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy', 'show']);

    // Product Images
    Route::post('/product-images', [ProductImagesController::class, 'store'])
        ->name('product-images.store');

    Route::delete('/product-images/{id}', [ProductImagesController::class, 'destroy'])
        ->name('product-images.destroy');

    // Laporan (staff versi berbeda dari admin)
    Route::get('/laporan', [ReportController::class, 'index'])
        ->name('laporan.index');

    Route::get('/laporan/print', [ReportController::class, 'print'])
        ->name('laporan.print');
});

