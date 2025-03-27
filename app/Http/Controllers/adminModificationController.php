<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class adminModificationController extends Controller
{
    function editAccount (Request $request) {
        $firstName = $request->input('updateFirstName');
        $middleName = $request->input('updateMiddleName');
        $lastName = $request->input('updateLastName');
        $username = $request->input('updateUsername');
        $password = $request->input('updatePassword');
        $position = $request->input('updatePosition');
        $division = $request->input('updateDivision');
        $status = $request->input('updateStatus');
        $plainPassword = $request->input('updatePassword');

        // $request->input('updateUsername');
        // $request->input('updatePassword');

        $admin = DB::table('tbl_admin')
            ->where('username', $username)
            ->first();

            // session(['id' => $admin->id]);

        DB::table('tbl_admin')
        ->where('username', $username)
        ->update([
            'firstName' => $firstName,
            'middleName' => $middleName,
            'lastName' => $lastName,
            'username' => $username,
            'password' => DB::raw("AES_ENCRYPT('$password', 'admin')"),
            'position' => $position,
            'division' => $division,
            'status' => $status
        ]);

        $admin = DB::table('tbl_admin')->where('username', $username)->first();

        session([
            'firstName' => $admin->firstName,
            'middleName' => $admin->middleName,
            'middleInitial' => $admin->middleName ? substr($admin->middleName, 0, 1) . '.' : '',
            'lastName' => $admin->lastName,
            'username' => $admin->username,
            'password' => $admin->password,
            'position' => $admin->position,
            'division' => $admin->division,
            'status' => $admin->status,
            'plainPassword' => $plainPassword
        ]);

        return redirect()->route('adminSettings')->with('message', 'success');
    }
}
