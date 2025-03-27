<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;

class authorizationController extends Controller
{
    public function adminLogin(Request $request)
    {  
        // Check if the user exists
        $admin = Admin::where('username', $request->username)->first();

        /*if ($admin && Hash::check($request->password, $admin->password)) {
            // If login is successful
            Auth::login($admin);

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
                'status' => $admin->status,
                'plainPassword' => $request->password
            ]);

            return redirect()->route('admin.index');  // Redirect to dashboard or another page
        } else {
            // If login fails
            return redirect()->back()->withErrors(['username' => 'Invalid credentials']);
        }*/

        $decryptedPassword = DB::selectOne("SELECT AES_DECRYPT(password, 'admin') as decrypted_password FROM tbl_admin WHERE id = ?", [$admin->id])->decrypted_password;
        
        // dd($decryptedPassword);
        
        // ³ÙU0…zˆÒíM6šu§/âj¥;dt‘6þzTâAî’Š
        // Compare the decrypted password with the plain password from the request
        if ($decryptedPassword === $request->password) {
            // If login is successful
            Auth::login($admin);

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
                'status' => $admin->status,
                'plainPassword' => $request->password
            ]);

            return redirect()->route('admin.index');  // Redirect to dashboard or another page
        } else {
            // If login fails
            return redirect()->back()->withErrors(['username' => 'Invalid credentials']);
        }
    }
}
