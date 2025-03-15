<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\authorizationController;

Route::get('/', function () {
    return view('index');
});

// Logging in
Route::post('/adminIndex', [authorizationController::class, 'adminLoginPost'])->name('adminIndex');

Route::prefix('admin')->group(function () {

    // adminIndex route
    Route::get('/index', function () {
        return view('adminBlades.adminIndex');
    })->name('admin.index');

    //adminManageUser route
    Route::get('/admin/manageUsers', function () {
        return view('adminBlades.adminManageUsers');
    })->name('admin.manageUsers');

    //Manage PPA route
    Route::get('/admin/managePpa', function () {
        return view('adminBlades.adminManagePpa');
    })->name('admin.managePpa');

    //admin IPCR route
    Route::get('/viewIpcr', function () {
        return view('adminBlades.adminIpcr');
    })->name('admin.viewIpcr');

    //admin Assign IPCR route
    Route::get('/ipcr', function () {
        return view('adminBlades.adminAssign');
    })->name('admin.assignIpcr');

    Route::get('/settings', function () {
        return view('adminBlades.adminSettings');
    })->name('admin.settings');
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
