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
        $admin = DB::table('tbladmin')
            ->where('username', $adminUsername)
            ->where('password', $adminPassword) // Make sure password hashing or encryption is handled properly
            ->first();

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
                'status' => $admin->status]);

        // Check if admin exists
        if ($admin) {
            return view('adminBlades.adminIndex');
        } else {
            // Send a failure JSON response if credentials don't match
            return response()->json(['message' => 'Invalid Credentials'], 401);
        }
    }
}
