<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\authorizationController;
use App\Http\Controllers\adminModificationController;
use App\Http\Controllers\adminPagesController;;


Route::get('/', function () {
    return view('index');
});

// Logging in
Route::post('/admin/adminIndex', [authorizationController::class, 'adminLogin'])->name('adminLogin');

Route::group(['middleware' => 'admin'], function () {
    // Updating admin account
    Route::post('/admin/adminSettings', [adminModificationController::class, 'editAccount'])->name('adminSettings');

    // Logging out
    Route::post('/', [authorizationController::class, 'adminLogout'])->name('adminLogout');

    Route::get('/admin/adminIndex', [adminPagesController::class, 'index'])->name('admin.index');
    Route::get('/admin/adminSettings', [adminPagesController::class, 'settings'])->name('admin.settings');
    Route::get('/admin/adminManageUsers', [adminPagesController::class, 'manageUsers'])->name('admin.manageUsers');
    Route::get('/admin/adminManagePpa', [adminPagesController::class, 'managePpa'])->name('admin.managePpa');
    Route::get('/admin/adminIpcr', [adminPagesController::class, 'viewIpcr'])->name('admin.viewIpcr');
    Route::get('/admin/adminAssign', [adminPagesController::class, 'assignIpcr'])->name('admin.assignIpcr');
});

Route::prefix('employee')->group(function () {
    Route::get('/index', function () {
        return view('employeeBlades.employeeIndex');
    })->name('employee.index');

    //Employee Assign
    Route::get('/employee/assignIpcr', function () {
        return view('employeeBlades.employeeAssign');
    })->name('employee.assignIpcr');

    //Employee View IPCR
    Route::get('/employee/viewIpcr', function () {
        return view('employeeBlades.employeeIpcr');
    })->name('employee.viewIpcr');

    //Employee Settings
    Route::get('/employee/settings', function () {
        return view('employeeBlades.employeeSettings');
    })->name('employee.settings');
});

// ... existing routes ...
Route::get('/logout', function () {
    Auth::logout();
    Session::flush();
    return redirect('/');
})->name('logout');
// ... existing routes ...

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
