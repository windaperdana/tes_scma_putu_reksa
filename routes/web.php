<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseRequestController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\PurchaseReceiptController;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

// Master Data Routes
Route::resource('branches', BranchController::class);
Route::resource('suppliers', SupplierController::class);
Route::resource('items', ItemController::class);

// Transaction Routes
Route::resource('purchase-requests', PurchaseRequestController::class);
Route::resource('purchase-orders', PurchaseOrderController::class);
Route::resource('purchase-receipts', PurchaseReceiptController::class);
