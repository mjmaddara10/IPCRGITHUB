<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\authorizationController;

Route::get('/', function () {
    return view('index');
});

// Logging in
Route::post('/adminIndex', [authorizationController::class, 'adminLoginPost'])->name('admin.index');

Route::prefix('admin')->group(function () {
    //adminSettings route
    Route::get('/settings', function () {
        return view('adminBlades.adminSettings');
    })->name('admin.settings');

    //adminManageUser route
    Route::get('/manageuser', function () {
        return view('adminBlades.adminManageUser');
    })->name('admin.manageUser');

    //adminIpcr route
    Route::get('/Assign', function () {
        return view('adminBlades.adminAssign');
    })->name('admin.assign');
   //ManagePpa route
    Route::get('/ManagePpa', function () {
        return view('adminBlades.adminManagePpa');
    })->name('admin.managePpa');
    //admin IPCR route
    Route::get('/Ipcr', function () {
        return view('adminBlades.adminIpcr');
    })->name('admin.ipcr');
});

Route::prefix('employee')->group(function () {
    Route::get('/index', function () {
        return view('employeeBlades.employeeIndex');
    })->name('employee.index');

 /* Employee Settings route
    Route::get('/settings', function () {
        return view('employeeBlades.employeeSettings');
    })->name('employee.settings');
*/
    //Employee Assign
    Route::get('/Assign', function () {
        return view('employeeBlades.employeeAssign');
    })->name('employee.assign');

    //Employee IPCR
    Route::get('/Ipcr', function () {
        return view('employeeBlades.employeeIpcr');
    })->name('employee.ipcr');

});



// ... existing routes ...
Route::get('/logout', function () {
    Auth::logout();
    Session::flush();
    return redirect('/');
})->name('logout');
// ... existing routes ...


