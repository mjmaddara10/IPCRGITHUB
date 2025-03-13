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

    //adminManageUser route
    Route::get('/manageuser', function () {
        return view('adminBlades.adminManageUser');
    })->name('admin.manageuser');

    //adminIpcr route
    Route::get('/adminAssign', function () {
        return view('adminBlades.adminAssign');
    })->name('admin.adminAssign');

    Route::get('/adminManagePpa', function () {
        return view('adminBlades.adminManagePpa');
    })->name('admin.adminManagePpa');
});

// ... existing routes ...
Route::get('/logout', function () {
    Auth::logout();
    Session::flush();
    return redirect('/admin/index');
})->name('logout');
// ... existing routes ...


