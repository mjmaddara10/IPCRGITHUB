<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\programController;
use App\Http\Controllers\ppaController;
use App\Http\Controllers\pdfController;
use App\Http\Controllers\viewPpaController;
use App\Http\Controllers\usersController;
use App\Http\Controllers\authorizationController;
use App\Http\Controllers\adminModificationController;
use App\Http\Controllers\adminPagesController;
use App\Http\Controllers\assignController;
use App\Http\Controllers\sortingController;
use App\Http\Controllers\gassController;
use App\Http\Controllers\requestPpaController;

Route::get('/', function () {
    return view('/index');
})->name('login');

Route::post('/userLogin', [authorizationController::class, 'userLogin'])->name('userLogin');
Route::post('/userLogout', [authorizationController::class, 'userLogout'])->name('userLogout');

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

    // Sorting
    Route::post('/programs/{id}/move/{direction}', [sortingController::class, 'moveProgram'])->name('program.move');
    Route::post('/activities/{id}/move/{direction}', [sortingController::class, 'moveActivity'])->name('activity.move');
    Route::post('/subActivities/{id}/move/{direction}', [sortingController::class, 'moveSubActivity'])->name('subActivity.move');

    // GASS
    Route::post('/updateGass', [gassController::class, 'updateGass'])->name('updateGass');
    Route::post('/addGassProgram', [gassController::class, 'addGassProgram'])->name('addGassProgram');
    Route::post('/updateGassProgram', [gassController::class, 'updateGassProgram'])->name('updateGassProgram');

    // ========================= Requesting for PPA Change ==========================//
    Route::post('/addProgramRequest', [requestPpaController::class, 'addProgramRequest'])->name('addProgramRequest');
    Route::post('/editProgramRequest', [requestPpaController::class, 'editProgramRequest'])->name('editProgramRequest');
    Route::post('/deleteProgramRequest', [requestPpaController::class, 'deleteProgramRequest'])->name('deleteProgramRequest');
    Route::post('/addActivityRequest', [requestPpaController::class, 'addActivityRequest'])->name('addActivityRequest');
    Route::post('/editActivityRequest', [requestPpaController::class, 'editActivityRequest'])->name('editActivityRequest');
    Route::post('/deleteActivityRequest', [requestPpaController::class, 'deleteActivityRequest'])->name('deleteActivityRequest');
    Route::post('/addSubActivityRequest', [requestPpaController::class, 'addSubActivityRequest'])->name('addSubActivityRequest');
    Route::post('/editSubActivityRequest', [requestPpaController::class, 'editSubActivityRequest'])->name('editSubActivityRequest');
    Route::post('/deleteSubActivityRequest', [requestPpaController::class, 'deleteSubActivityRequest'])->name('deleteSubActivityRequest');
    Route::post('/editGassRequest', [requestPpaController::class, 'editGassRequest'])->name('editGassRequest');
    Route::post('/addGassCritRequest', [requestPpaController::class, 'addGassCritRequest'])->name('addGassCritRequest');
    Route::post('/editGassCritRequest', [requestPpaController::class, 'editGassCritRequest'])->name('editGassCritRequest');

    // ========================= Reject Requests ==========================//
    Route::post('/rejectProgramRequest', [requestPpaController::class, 'rejectProgramRequest'])->name('rejectProgramRequest');
    Route::post('/rejectActivityRequest', [requestPpaController::class, 'rejectActivityRequest'])->name('rejectActivityRequest');
    Route::post('/rejectSubActivityRequest', [requestPpaController::class, 'rejectSubActivityRequest'])->name('rejectSubActivityRequest');
    Route::post('/rejectGassRequest', [requestPpaController::class, 'rejectGassRequest'])->name('rejectGassRequest');

    // ========================= View Details of Requests ==========================//
    Route::get('/programRequests/{id}/divisions', [requestPpaController::class, 'getDivisions']);
    Route::get('/program/{id}/divisions', [requestPpaController::class, 'getReferenceDivisions']);
    Route::get('/fetchReferenceProgramDetails/{id}', [requestPpaController::class, 'fetchReferenceProgramDetails']);

    Route::get('/activityRequests/{id}/employees', [requestPpaController::class, 'getEmployees']);
    Route::get('/activity/{id}/employees', [requestPpaController::class, 'getReferenceEmployees']);
    Route::get('/fetchReferenceActivityDetails/{id}', [requestPpaController::class, 'fetchReferenceActivityDetails']);

    Route::get('/subActivityRequests/{id}/employees', [requestPpaController::class, 'getEmployeesSub']);
    Route::get('/subActivity/{id}/employees', [requestPpaController::class, 'getReferenceEmployeesSub']);
    Route::get('/fetchReferenceSubActivityDetails/{id}', [requestPpaController::class, 'fetchReferenceSubActivityDetails']);
});

Route::prefix('viewPpa')->group(function () {
    Route::get('/{id}/getEmployeeDivision', [viewPpaController::class, 'getEmployeeDivision']);
    Route::get('/{id}/getEmployeeTargets', [viewPpaController::class, 'getEmployeeTargets']);
});

Route::prefix('pdf')->group(function () {
    // Route::post('/generatePdf', [PDFController::class, 'generatePdf'])->name('pdf.generatePdf');
    Route::get('/{id}/generatePdf', [PDFController::class, 'generatePdf'])->name('pdf.generatePdf');
});

//===================Middleware===================//
Route::middleware(['auth', 'role:Staff'])->group(function () {
    Route::prefix('staff')->group(function () {
        Route::get('/settings', [adminPagesController::class, 'settings'])->name('staff.settings');
        Route::get('/viewIpcr', [adminPagesController::class, 'viewIpcr'])->name('staff.viewIpcr');
    });
});

Route::middleware(['auth', 'role:Division Chief|Assistant Department Head'])->group(function () {
    Route::prefix('chief')->group(function () {
        Route::get('/managePpa', [adminPagesController::class, 'managePpa'])->name('chief.managePpa');
        Route::get('/viewEmployees', [adminPagesController::class, 'viewEmployees'])->name('chief.viewEmployees');
        Route::get('/settings', [adminPagesController::class, 'settings'])->name('chief.settings');
        Route::get('/viewIpcr', [adminPagesController::class, 'viewIpcr'])->name('chief.viewIpcr');
        Route::get('/audit', [adminPagesController::class, 'audit'])->name('chief.audit');
        
    });
});

Route::middleware(['auth', 'role:Department Head|Assistant Department Head'])->group(function () {
    Route::prefix('head')->group(function () {
        Route::get('/managePpa', [adminPagesController::class, 'managePpa'])->name('head.managePpa');
        Route::get('/viewEmployees', [adminPagesController::class, 'viewEmployees'])->name('head.viewEmployees');
        Route::get('/settings', [adminPagesController::class, 'settings'])->name('head.settings');
        Route::get('/viewIpcr', [adminPagesController::class, 'viewIpcr'])->name('head.viewIpcr');
        Route::get('/audit', [adminPagesController::class, 'audit'])->name('head.audit');
        Route::get('/approve', [adminPagesController::class, 'approve'])->name('head.approve');
        Route::post('/approve', [adminPagesController::class, 'approve'])->name('head.approve');
    });
});