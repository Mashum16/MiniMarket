<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;

// halaman welcome (ga penting sih)
Route::get('/', function () {
    return view('welcome');
});

// guest akan login atau register dlu disini
Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'login'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'authenticate']);

    Route::get('/register', [RegisterController::class, 'registerForm'])
        ->name('register');

    Route::post('/register', [RegisterController::class, 'storeRegister'])
        ->name('register.store');
});

// resource untuk produk jadinya bisa melihat, menambah, mengedit dashboard produk
Route::resource('products', ProductController::class);

// logout
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// untuk yang sudah login bisa melihat :
Route::middleware('auth')->group(function () {
    Route::get('/beranda', [BerandaController::class, 'beranda'])
        ->name('beranda');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

        Route::resource('orders', OrderController::class)->only([
        'index', 'show'
        
    ]);
    
    // Opsional: update status untuk admin/staff
    Route::post('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // keranjang (pake sesi bukan pake tabel, ribet anj tar klo pake tabel)
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    
    // checkout keranjang
    Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});

// staff (gw lupa aseli ada ini role)
Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/staff/dashboard', function () {
        return view('backend.v_dashboard.staffDashboard');
    })->name('staff.dashboard');
});

// admin
Route::middleware(['auth', 'role:admin'])->group(function () {

    // membuat user (Hanya untuk Admin)
    Route::resource('admin', AdminDashboardController::class);

});

