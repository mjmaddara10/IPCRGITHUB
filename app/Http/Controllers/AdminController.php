<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard'); // Make sure this matches your file path
    }
}
Route::get('/admin/Setting', [AdminController::class, 'Setting'])->name('admin.Setting');
