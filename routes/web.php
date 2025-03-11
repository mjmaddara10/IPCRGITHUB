<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('adminBlades.adminIndex');
    })->name('admin.dashboard');

  // Settings route

  Route::get('/Setting', function () {
    return view('adminBlades.adminSettings');
})->name('admin.settings');
});

