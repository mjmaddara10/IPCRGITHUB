<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\authorizationController;
use App\Http\Controllers\adminModificationController;


Route::get('/', function () {
    return view('index');
});

// Logging in
Route::post('/login', [authorizationController::class, 'adminLoginPost'])->name('adminIndex');
// Route::post('/adminIndex', [AdminController::class, 'adminLogin'])->name('adminIndex');

// Updating admin account
Route::post('/admin/adminSettings', [adminModificationController::class, 'editAccount'])->name('adminSettings');

Route::prefix('admin')->group(function () {

    // adminIndex route
    

    Route::get('/index', function () {
        return view('adminBlades.adminIndex');
    })->name('admin.index');

    Route::get('/adminSettings', function () {
        return view('adminBlades.adminSettings');
    })->name('admin.settings');

    //adminManageUser route
    Route::get('/adminManageUsers', function () {
        return view('adminBlades.adminManageUsers');
    })->name('admin.manageUsers');

    //Manage PPA route including controller for fetching PPAs
    Route::get('/adminManagePpa', [ProgramController::class, 'fetch'])->name('admin.managePpa');

    //admin IPCR route
    Route::get('/adminIpcr', function () {
        return view('adminBlades.adminIpcr');
    })->name('admin.viewIpcr');

    //admin Assign IPCR route
    Route::get('/adminAssign', function () {
        return view('adminBlades.adminAssign');
    })->name('admin.assignIpcr');

    
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
