<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class authorizationController extends Controller
{
    function adminLoginPost (Request $request) {
        $adminUsername = $request->input('adminUsername');
        $adminPassword = $request->input('adminPassword');

        // Query the database to see if the user exists with matching credentials
        $admin = DB::table('tbl_admin')
            ->where('username', $adminUsername)
            ->where('password', $adminPassword) // Make sure password hashing or encryption is handled properly
            ->first();

        // Check if admin exists
        if ($admin) {
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

            return view('adminBlades.adminIndex');
        } else {
            return view('index');
        }
    }
}
