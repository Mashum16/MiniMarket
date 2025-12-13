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
use App\Http\Controllers\AuditLogController;

/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/

// halaman welcome
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| GUEST (Belum Login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'login'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'authenticate']);

    Route::get('/register', [RegisterController::class, 'registerForm'])
        ->name('register');

    Route::post('/register', [RegisterController::class, 'storeRegister'])
        ->name('register.store');
});

/*
|--------------------------------------------------------------------------
| AUTH (Sudah Login)
|--------------------------------------------------------------------------
*/

// logout
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/beranda', [BerandaController::class, 'beranda'])
        ->name('beranda');

    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile');

    // produk (CRUD)
    Route::resource('products', ProductController::class);

    // order user
    Route::resource('orders', OrderController::class)
        ->only(['index', 'show']);

    // update status order (admin / staff)
    Route::post('/orders/{order}/status', [OrderController::class, 'updateStatus'])
        ->name('orders.updateStatus');

    // ================= CART =================
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // checkout keranjang
    Route::post('/checkout', [CartController::class, 'checkout'])
        ->name('cart.checkout');
});

/*
|--------------------------------------------------------------------------
| STAFF
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:staff'])->group(function () {

    Route::get('/staff/dashboard', function () {
        return view('backend.v_dashboard.staffDashboard');
    })->name('staff.dashboard');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
    Route::middleware(['auth', 'role:admin'])->group(function () {

    // manajemen user
    Route::resource('admin', AdminDashboardController::class);

    // ================= AUDIT LOG =================
    Route::get('/audit', [AuditLogController::class, 'index'])
        ->name('audit.index');

    Route::get('/audit/{id}', [AuditLogController::class, 'show'])
        ->name('audit.show');
});
