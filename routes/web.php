<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;

Route::prefix('admin')->group(function () {
    Route::get('/index', function () {
        return view('adminBlades.adminIndex');
    })->name('admin.index');

    /*
    Route::get('/settings', function () {
        return view('adminBlades.adminSettings');
    })->name('admin.settings');
*/
    //adminManageUser route
    Route::get('/manageuser', function () {
        return view('adminBlades.adminManageUser');
    })->name('admin.manageUser');

    //adminIpcr route
    Route::get('/Assign', function () {
        return view('adminBlades.adminAssign');
    })->name('admin.Assign');
   //ManagePpa route
    Route::get('/ManagePpa', function () {
        return view('adminBlades.adminManagePpa');
    })->name('admin.ManagePpa');
    //admin IPCR route
    Route::get('/Ipcr', function () {
        return view('adminBlades.adminIpcr');
    })->name('admin.Ipcr');
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
    })->name('employee.Assign');

    //Employee IPCR
    Route::get('/Ipcr', function () {
        return view('employeeBlades.employeeIpcr');
    })->name('employee.Ipcr');

});

Route::get('/index', function () {
    return view('index');
})->name('index');

// ... existing routes ...
Route::get('/logout', function () {
    Auth::logout();
    Session::flush();
    return redirect('/admin/index');
})->name('logout');
// ... existing routes ...


