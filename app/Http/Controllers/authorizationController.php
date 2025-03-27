<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;

class authorizationController extends Controller
{
    // ================== Admin Login =================//
    public function adminLogin(Request $request)
    {  
        // Check if the user exists in the tbl_admin table
        $admin = Admin::where('username', $request->username)->first();

        // Ensure the admin exists
        if (!$admin) {
            return redirect()->back()->withErrors(['username' => 'Invalid credentials']);
        }

        // Decrypt the password stored in the database
        $decryptedPassword = DB::selectOne("SELECT AES_DECRYPT(password, 'admin') as decrypted_password FROM tbl_admin WHERE id = ?", [$admin->id])->decrypted_password;

        // Compare the decrypted password with the plain password from the request
        if ($decryptedPassword === $request->password) {
            // If login is successful, log in the admin
            // dd($decryptedPassword);

            // if (!Auth::guard('admin')->check()) {
            //     dd('User is not authenticated');
            // }

            Auth::guard('admin')->login($admin);

            // Set session variables
            session([
                'id' => $admin->id,
                'firstName' => $admin->firstName,
                'middleName' => $admin->middleName,
                'middleInitial' => $admin->middleName ? substr($admin->middleName, 0, 1) . '.' : '',
                'lastName' => $admin->lastName,
                'username' => $admin->username,
                'password' => $admin->password,  // The AES encrypted password
                'position' => $admin->position,
                'division' => $admin->division,
                'status' => $admin->status,
                'plainPassword' => $request->password  // Store plain password in the session for showing purposes
            ]);

            // Redirect to the admin dashboard or another route
            return redirect()->route('admin.index');
        } else {
            // If login fails, redirect back with an error message
            return redirect()->back()->withErrors(['username' => 'Invalid credentials']);
        }
    }

    // ==================Admin Logout =================//
    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();  // Logs out the admin
        $request->session()->invalidate();  // Invalidate the session
        $request->session()->regenerateToken();  // Regenerate CSRF token

        return response()->json(['message' => 'Logged out successfully'], 200);  // Return a response
    }
}
