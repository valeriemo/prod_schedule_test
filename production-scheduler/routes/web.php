<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductionScheduleController;

Route::get('/', function () {
    return view('welcome');
});
// Order
Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

// ProductionSchedule
Route::get('/schedule', [ProductionScheduleController::class, 'index'])->name('schedule.index');
