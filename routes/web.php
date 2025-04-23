<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\programController;
use App\Http\Controllers\ppaController;
use App\Http\Controllers\usersController;
use App\Http\Controllers\authorizationController;
use App\Http\Controllers\adminModificationController;
use App\Http\Controllers\adminPagesController;
use App\Http\Controllers\assignController;
use App\Models\SubActivity;
use App\Models\Program;
use App\Models\Project;
use App\Models\SubProject;
use App\Models\Employee;
use App\Models\Activity;
use App\Models\Division;



Route::get('/', function () {
    return view('index');
});

// Logging in
Route::post('/admin/adminIndex', [authorizationController::class, 'adminLogin'])->name('adminLogin');

Route::prefix('admin')->group(function () {
    Route::post('/updateActivity', [ppaController::class, 'updateActivity'])->name('updateActivity');
    Route::post('/deleteActivity', [ppaController::class, 'deleteActivity'])->name('deleteActivity');
    Route::post('/addActivityInProgram', [ppaController::class, 'addActivityInProgram'])->name('addActivityInProgram');

    Route::post('/addSubActivity', [ppaController::class, 'addSubActivity'])->name('addSubActivity');
    Route::post('/updateSubActivity', [ppaController::class, 'updateSubActivity'])->name('updateSubActivity');
    Route::post('/deleteSubActivity', [ppaController::class, 'deleteSubActivity'])->name('deleteSubActivity');
    
    Route::post('/addProgram', [ppaController::class, 'addProgram'])->name('addProgram');
    Route::post('/updateProgram', [ppaController::class, 'updateProgram'])->name('updateProgram');
    Route::post('/deleteProgram', [ppaController::class, 'deleteProgram'])->name('deleteProgram');

    Route::post('/getAccountableByIds', [ppaController::class, 'getAccountableByIds']);

    // Edit Program (Division<-->Program)
    Route::get('/programs/{id}/getDivisionResponsible', [ppaController::class, 'getDivisionResponsible']);

    // Edit Activity (Individual<-->Activity)
    Route::get('/activity/{id}/getActivityAccountables', [ppaController::class, 'getActivityAccountables']);

    // Edit Sub-Activity (Individual<-->Sub-Activity)
    Route::get('/subActivity/{id}/getSubActivityAccountables', [ppaController::class, 'getSubActivityAccountables']);

    // Fetch employee for autofill (Edit activity)
    Route::get('/activity/{id}/fetchEmployee', [ppaController::class, 'fetchEmployee']);

    // Fetch employee for autofill (Edit sub-activity)
    Route::get('/subActivity/{id}/fetchEmployeeSub', [ppaController::class, 'fetchEmployeeSub']);

});

Route::prefix('viewPpa')->group(function () {

    Route::get('/{id}/getEmployeeDivision', [viewPpaController::class, 'getEmployeeDivision']);
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
            $activities = Activity::with('employees')->get();

            return view("adminBlades.tables.$table", compact('programs', 'projects', 'subProjects','employees'));
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

