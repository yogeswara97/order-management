<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('loginForm');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login');

// Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('index');

    Route::resource('order', OrderController::class);
    Route::get('/order/{id}/pdf', [OrderController::class, 'exportPdf'])->name('exportPdf');

    Route::get('/order/{orderId}/item/create', [ItemController::class, 'createItem'])->name('createItem');
    Route::post('/order/{orderId}/item/store', [ItemController::class, 'storeItem'])->name('storeItem');
    Route::get('/order/{orderId}/item/{itemId}', [ItemController::class, 'editItem'])->name('editItem');
    Route::put('/order/{orderId}/item/{itemId}/edit', [ItemController::class, 'updateItem'])->name('updateItem');
    Route::delete('/orders/{orderId}/items/{itemId}', [ItemController::class, 'destroyItem'])->name('destroyItem');


    Route::resource('customer', CustomerController::class);

    Route::resource('admin', AdminController::class);

    Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot.index');
// });

Route::fallback(function () {
    return redirect()->route('index');
});
