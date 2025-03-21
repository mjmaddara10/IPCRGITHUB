<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function adminLogin(Request $request)
    {
        $credentials = $request->only('adminUsername', 'adminPassword');

        // Find admin by username
        $admin = DB::table('tbl_admin')
            ->where('username', $credentials['adminUsername'])
            ->where('password', $credentials['adminPassword']) // Make sure password hashing or encryption is handled properly
            ->first();
        

        if ($admin) {
            // Login success
            Auth::admin($admin);

            // Store admin data in session to access them later in the application
            session([
                'id' => $admin->id,
                'firstName' => $admin->firstName,
                'middleName' => $admin->middleName,
                'middleInitial' => $admin->middleName ? substr($admin->middleName, 0, 1) . '.' : '',
                'lastName' => $admin->lastName,
                'username' => $admin->username,
                'password' => $admin->password,
                'position' => $admin->position,
                'division' => $admin->division,
                'status' => $admin->status
            ]);
            return redirect()->intended('admin/index');
        } else {
            return back()->withErrors(['error' => 'Invalid credentials']);
        }
    }


}
