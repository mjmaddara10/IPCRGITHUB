<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;

Route::prefix('admin')->group(function () {
    Route::get('/index', function () {
        return view('adminBlades.adminIndex');
    })->name('admin.index');

    // Settings route
    Route::get('/settings', function () {
        return view('adminBlades.adminSettings');
    })->name('admin.settings');
});
