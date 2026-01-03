<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    BerandaController,
    LoginController,
    RegisterController,
    AdminDashboardController,
    StaffDashboardController,
    ProductController,
    CartController,
    OrderController,
    ProfileController,
    AuditLogController
};

/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/

// welcome
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

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/beranda', [BerandaController::class, 'beranda'])->name('beranda');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

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
| ADMIN (FULL ACCESS PRODUK)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    Route::resource('products', ProductController::class);
    Route::resource('users', AdminDashboardController::class);

    Route::get('/audit', [AuditLogController::class, 'index'])->name('audit.index');
    Route::get('/audit/{id}', [AuditLogController::class, 'show'])->name('audit.show');
});

/*
|--------------------------------------------------------------------------
| STAFF
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:staff'])
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {

    // STAFF DASHBOARD (RESOURCE)
    Route::resource('/', StaffDashboardController::class)
        ->only(['index', 'edit', 'update', 'create']);

    // alias opsional: /staff/dashboard
    Route::get('/dashboard', [StaffDashboardController::class, 'index'])
        ->name('dashboard');

    // PRODUK (staff hanya create & edit)
    Route::resource('products', ProductController::class)
        ->only(['index', 'create', 'store', 'edit', 'update']);
});


