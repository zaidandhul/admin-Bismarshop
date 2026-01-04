<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CustomerAddressController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\AnalyticsController;

Route::get('/', function () {
    return redirect('/login.html');
});

// Serve uploaded files stored in ../uploads via /uploads/... URL
Route::get('/uploads/{path}', function ($path) {
    $base = public_path('..'.DIRECTORY_SEPARATOR.'uploads');
    $fullPath = realpath($base.DIRECTORY_SEPARATOR.$path);
    if (!$fullPath || !is_file($fullPath) || strpos($fullPath, realpath($base)) !== 0) {
        abort(404);
    }
    return response()->file($fullPath);
})->where('path', '.*');

// Export analytics ke Excel menggunakan Blade view khusus
Route::get('/analytics/export/excel', [AnalyticsController::class, 'exportExcel']);

// Halaman receipt order (nota) untuk admin, menampilkan receipt.blade.php
Route::get('/orders/{id}/receipt', [OrderController::class, 'receipt']);

// Admin customer addresses endpoints
Route::prefix('admin')->group(function () {
    Route::get('/customers/{user}/addresses', [CustomerAddressController::class, 'index']);
    Route::post('/customers/{user}/addresses', [CustomerAddressController::class, 'store']);
    Route::post('/customers/{user}/addresses/{address}/default', [CustomerAddressController::class, 'setDefault']);
    Route::delete('/customers/{user}/addresses/{address}', [CustomerAddressController::class, 'destroy']);
});