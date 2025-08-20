<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\BarController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

// Auth routes (Breeze)
require __DIR__ . '/auth.php';

// ==========================
// ✅ Dashboard redirect sesuai role
// ==========================
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('kasir')) {
        return redirect()->route('kasir.dashboard');
    } elseif ($user->hasRole('owner')) {
        return redirect()->route('owner.dashboard');
    } elseif ($user->hasRole('bar')) {
        return redirect()->route('bar.dashboard');
    } elseif ($user->hasRole('kitchen')) {
        return redirect()->route('kitchen.dashboard');
    }

    abort(403, 'Anda tidak punya akses ke dashboard.');
})->name('dashboard');

// ==========================
// ✅ Products (HANYA admin & owner) — nama route: products.*
// ==========================
Route::middleware(['auth', 'role:admin|owner'])->group(function () {
    Route::resource('products', ProductController::class); // -> products.index, products.create, ...
});

// ==========================
// ✅ Admin routes
// ==========================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Manajemen user & role
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::put('/users/{user}/role', [UserManagementController::class, 'updateRole'])->name('users.updateRole');

    // Hanya admin
    Route::resource('categories', CategoryController::class);
    Route::resource('subcategories', SubcategoryController::class);
    Route::resource('transactions', TransactionController::class);
});

// ==========================
// ✅ Owner routes (dashboard saja; tambah fitur owner di sini bila perlu)
// ==========================
Route::middleware(['auth', 'role:owner'])->prefix('owner')->name('owner.')->group(function () {
    // Pakai closure agar tidak butuh OwnerController
    Route::get('/dashboard', function () {
        return view()->exists('owner.dashboard')
            ? view('owner.dashboard')
            : response('Owner Dashboard', 200);
    })->name('dashboard');
});

// ==========================
// ✅ Kasir routes
// ==========================
Route::middleware(['auth', 'role:kasir'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/dashboard', [KasirController::class, 'index'])->name('dashboard');
    Route::resource('transaksi', TransactionController::class)->only(['index', 'store']);
});

// ==========================
// ✅ Bar routes
// ==========================
Route::middleware(['auth', 'role:bar'])->prefix('bar')->name('bar.')->group(function () {
    Route::get('/dashboard', [BarController::class, 'index'])->name('dashboard');
});

// ==========================
// ✅ Kitchen routes
// ==========================
Route::middleware(['auth', 'role:kitchen'])->prefix('kitchen')->name('kitchen.')->group(function () {
    Route::get('/dashboard', [KitchenController::class, 'index'])->name('dashboard');
});

// ==========================
// ✅ Profile (semua user login)
// ==========================
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});