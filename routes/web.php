<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\programController;
use App\Http\Controllers\ppaController;
use App\Http\Controllers\usersController;
use App\Http\Controllers\authorizationController;
use App\Http\Controllers\adminModificationController;
use App\Http\Controllers\adminPagesController;
use App\Models\Program;
use App\Models\Project;
use App\Models\SubProject;


Route::get('/', function () {
    return view('index');
});

// Logging in
Route::post('/admin/adminIndex', [authorizationController::class, 'adminLogin'])->name('adminLogin');

Route::prefix('admin')->group(function () {
    Route::post('/updateActivity', [ppaController::class, 'updateActivity'])->name('updateActivity');
    Route::post('/deleteActivity', [ppaController::class, 'deleteActivity'])->name('deleteActivity');
    Route::post('/addActivity', [ppaController::class, 'addActivity'])->name('addActivity');

    Route::post('/addSubProject', [ppaController::class, 'addSubProject'])->name('addSubProject');
    Route::post('/updateSubProject', [ppaController::class, 'updateSubProject'])->name('updateSubProject');
    Route::post('/deleteSubProject', [ppaController::class, 'deleteSubProject'])->name('deleteSubProject');

    Route::post('/addProject', [ppaController::class, 'addProject'])->name('addProject');
    Route::post('/updateProject', [ppaController::class, 'updateProject'])->name('updateProject');
    Route::post('/deleteProject', [ppaController::class, 'deleteProject'])->name('deleteProject');
    
    Route::post('/addProgram', [ppaController::class, 'addProgram'])->name('addProgram');
    Route::post('/updateProgram', [ppaController::class, 'updateProgram'])->name('updateProgram');
    Route::post('/deleteProgram', [ppaController::class, 'deleteProgram'])->name('deleteProgram');

    Route::post('/addActivityInSub', [ppaController::class, 'addActivityInSub'])->name('addActivityInSub');
});

Route::group(['middleware' => 'admin'], function () {
    // Updating admin account
    Route::post('/admin/adminSettings', [adminModificationController::class, 'editAccount'])->name('adminSettings');

    // Logging out
    Route::post('/', [authorizationController::class, 'adminLogout'])->name('adminLogout');

    Route::get('/admin/adminIndex', [adminPagesController::class, 'index'])->name('admin.index');
    Route::get('/admin/adminSettings', [adminPagesController::class, 'settings'])->name('admin.settings');
    Route::get('/admin/adminViewEmployees', [adminPagesController::class, 'viewEmployees'])->name('admin.viewEmployees');
    Route::get('/admin/adminManagePpa', [adminPagesController::class, 'managePpa'])->name('admin.managePpa');

    Route::get('/admin/adminManagePpa2', [adminPagesController::class, 'managePpa2'])->name('admin.managePpa2');

    Route::get('/admin/adminIpcr', [adminPagesController::class, 'viewIpcr'])->name('admin.viewIpcr');
    Route::get('/admin/adminAssign', [adminPagesController::class, 'assignIpcr'])->name('admin.assignIpcr');

    Route::get('/get-table/{table}', function ($table) {
        if (view()->exists("adminBlades.tables.$table")) {
            $programs = Program::with('projects')->get();
            $projects = Project::with('activities', 'subProjects')->get();
            $subProjects = SubProject::with('activities')->get();

            return view("adminBlades.tables.$table", compact('programs', 'projects', 'subProjects'));
        }
        return response("Table not found", 404);
    });
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
})->name('logoutUser');
// ... existing routes ...

Auth::routes();

