<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StockTransactionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockOpnameController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductAttributeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'showLoginPage'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    // Dashboard / Home
    Route::get('/', [DashboardController::class, 'index'])->name('index-practice');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Practice routes
    Route::name('practice.')->group(function () {
        Route::view('/practice/1', 'pages.practice.1')->name('first');
        Route::view('/practice/2', 'pages.practice.2')->name('second');
    });

    // Stock Transactions
    Route::get('/transactions', [StockTransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/create', [StockTransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [StockTransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{transaction}/edit', [StockTransactionController::class, 'edit'])->name('transactions.edit');
    Route::put('/transactions/{transaction}', [StockTransactionController::class, 'update'])->name('transactions.update');

    // Stock Opname
    Route::get('/stock-opname', function () {
        $products = \App\Models\Product::all();
        return view('pages.transactions.opname', compact('products'));
    })->name('stock.opname');

    Route::get('/opname', [StockOpnameController::class, 'index'])->name('opname.index');
    Route::put('/opname', [StockOpnameController::class, 'update'])->name('opname.update');

    Route::get('/products/export', [ProductController::class, 'export'])->name('products.export');
    Route::post('/products/import', [ProductController::class, 'import'])->name('products.import');
    Route::resource('products', ProductController::class);

    // Product Resource
    Route::resource('products', ProductController::class);
    Route::resource('attributes', ProductAttributeController::class);
    Route::resource('categories', CategoryController::class);

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/transactions', [ReportController::class, 'transactions'])->name('reports.transactions');
    Route::get('/reports/stocks', [ReportController::class, 'stocks'])->name('reports.stocks');
    Route::get('/reports/activities', [ReportController::class, 'activities'])->name('reports.activities');

    // Supplier
    Route::resource('suppliers', SupplierController::class);

    // Users
    Route::resource('users', UserController::class);

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'preview'])->name('settings.preview');
    
});
