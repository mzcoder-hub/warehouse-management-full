<?php

use App\Http\Controllers\InventoriesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PurchasesController;
use App\Http\Controllers\SalessController;
use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    })->name('login');

    Route::get('/login', function () {
        return view('login');
    })->name('login');

    Route::post('/login', [LoginController::class, 'login'])->name('loginSubmit');
});


Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/inventories', [InventoriesController::class, 'showAllInventories'])->name('inventories');

    Route::get('/create-inventories', function () {
        return view('create-inventories');
    })->name('create');

    Route::get('/{id}/edit-inventories', [InventoriesController::class, 'edit'])->name('edit');
    Route::post('/{id}/edit-inventories', [InventoriesController::class, 'updated'])->name('update');
    Route::delete('/{id}/delete-inventories', [InventoriesController::class, 'delete'])->name('delete');

    Route::post('/create-product', [InventoriesController::class, 'create'])->name('createProduct');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


    // sales
    Route::get('/sales', [SalessController::class, 'index'])->name('sales.index');
    Route::get('/{idSales}/edit-sales', [SalessController::class, 'edit'])->name('sales.edit');
    Route::delete('/{idSales}/delete-sales', [SalessController::class, 'deleteSales'])->name('deleteSales');
    Route::post('/{idSales}/update-sales', [SalessController::class, 'update'])->name('updateSales');


    Route::get('/create-sales', [SalessController::class, 'getCreateSales'])->name('createSales');
    Route::post('/create-sales', [SalessController::class, 'storeSales'])->name('storeSales');

    // purchases
    Route::get('/purchases', function () {
        return view('purchases.index');
    })->name('purchases.index');

    Route::get('/create-purchases', [PurchasesController::class, 'getCreatePurchases'])->name('createPurchases');
    Route::post('/create-purchases', [PurchasesController::class, 'storePurchases'])->name('storePurchases');
    Route::get('/purchases', [PurchasesController::class, 'index'])->name('purchases.index');
    Route::get('/{idPurchase}/edit-purchases', [PurchasesController::class, 'edit'])->name('purchases.edit');
    Route::post('/{idPurchase}/update-purchase', [PurchasesController::class, 'update'])->name('updatePurchase');
    Route::delete('/{idPurchase}/delete-purchase', [PurchasesController::class, 'deletePurchase'])->name('deletePurchase');

    Route::get('/export/sales/excel', [ExportController::class, 'exportExcel'])->name('export.excel');
    Route::get('/export/sales/pdf', [ExportController::class, 'exportPdf'])->name('export.pdf');
    Route::get('/export/sales/csv', [ExportController::class, 'exportCsv'])->name('export.csv');

    Route::get('/export/purchases/excel', [ExportController::class, 'purchaseExportExcel'])->name('purchase.export.excel');
    Route::get('/export/purchases/pdf', [ExportController::class, 'purchaseExportPdf'])->name('purchase.export.pdf');
    Route::get('/export/purchases/csv', [ExportController::class, 'purchaseExportCsv'])->name('purchase.export.csv');
});
