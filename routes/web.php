<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\BarController;
use App\Http\Controllers\KitchenController;
// use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\IngredientController;

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
    Route::resource('users', UserController::class);


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
    Route::get('/', [KasirController::class, 'index'])->name('index'); // ✅ route kasir.index
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

// table routes
Route::resource('tables', TableController::class);

// ==========================
// ✅ Ingredient routes (Admin, Bar, Kitchen)

// Admin — bisa CRUD penuh
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('ingredients', IngredientController::class);
    });

// Bar — hanya lihat & ubah stok bahan baku bar
Route::middleware(['auth', 'role:bar'])
    ->prefix('bar')
    ->name('bar.')
    ->group(function () {
        Route::get('ingredients', [IngredientController::class, 'index'])->name('ingredients.index');
        Route::get('ingredients/{ingredient}/edit', [IngredientController::class, 'edit'])->name('ingredients.edit');
        Route::put('ingredients/{ingredient}', [IngredientController::class, 'update'])->name('ingredients.update');
    });

// Kitchen — hanya lihat & ubah stok bahan baku kitchen
Route::middleware(['auth', 'role:kitchen'])
    ->prefix('kitchen')
    ->name('kitchen.')
    ->group(function () {
        Route::get('ingredients', [IngredientController::class, 'index'])->name('ingredients.index');
        Route::get('ingredients/{ingredient}/edit', [IngredientController::class, 'edit'])->name('ingredients.edit');
        Route::put('ingredients/{ingredient}', [IngredientController::class, 'update'])->name('ingredients.update');
    });


// ==========================
// ✅ Profile (semua user login)
// ==========================
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
