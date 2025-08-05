<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\UserManagementController; // Controller untuk manajemen user

// Landing Page
Route::get('/', function () {
    return view('welcome');
});

// Redirect Dashboard Berdasarkan Role
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    $user = auth()->user();
    if ($user->hasRole('admin')) {
        return view('dashboard.admin');
    } elseif ($user->hasRole('kasir')) {
        return view('dashboard.kasir');
    } elseif ($user->hasRole('owner')) {
        return view('dashboard.owner');
    } else {
        abort(403, 'aduh, kamu tidak punya akses ke dashboard ini.');
    }
})->name('dashboard');

// Profile Settings
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes Untuk Produk (Hanya Admin & Kasir)
Route::middleware(['auth'])->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('kasir', KasirController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('subcategories', SubcategoryController::class);
});

// Manajemen User untuk Admin: Melihat & Mengubah Role User
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::put('/users/{user}/role', [UserManagementController::class, 'updateRole'])->name('users.updateRole');
});

// Include route auth default dari Laravel Breeze/Fortify/Jetstream
require __DIR__ . '/auth.php';