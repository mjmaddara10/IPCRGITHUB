<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index() {
        $admins = Admin::all();

    
        return view('adminBlades.adminIndex')->name('adminIndex');
    }

    //========================Login=============================// 
    public function adminLogin(Request $request)
    {
        $credentials = $request->only('username', 'password');
        // dd($credentials);

        // Find admin by username
        $admin = DB::table('tbl_admin')
            ->where('username', $credentials['username'])
            ->where('password', $credentials['password']) // Make sure password hashing or encryption is handled properly
            ->first();
        // dd($admin);

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('adminIndex');
        } else {
            return back()->withErrors(['message' => 'Login failed.']);
        }

        // foreach ($admins as $admin) {
        //     // Check if the password is already hashed
        //     if (!Hash::needsRehash($admin->password)) {
        //         // Hash the password and save it
        //         $admin->password = Hash::make($admin->password);
        //         $admin->save();
        //     }
        // }

        
        // if ($admin) {
        //     // Login success
        //     Auth::admin($admin);

        //     // Store admin data in session to access them later in the application
        //     session([
        //         'id' => $admin->id,
        //         'firstName' => $admin->firstName,
        //         'middleName' => $admin->middleName,
        //         'middleInitial' => $admin->middleName ? substr($admin->middleName, 0, 1) . '.' : '',
        //         'lastName' => $admin->lastName,
        //         'username' => $admin->username,
        //         'password' => $admin->password,
        //         'position' => $admin->position,
        //         'division' => $admin->division,
        //         'status' => $admin->status
        //     ]);
        //     return redirect()->intended('admin/adminIndex')->with('message', 'success');
        //     dd($data);
        // } else {
        //     return back()->withErrors(['error' => 'Invalid credentials']);
        // }
    }


}
