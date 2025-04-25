<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;

class authorizationController extends Controller
{
    public function userLogin(Request $request) {

        // Retrieve user based on username
        $user = Employee::where('username', $request->username)->first();

        if (!$user) {
            \Log::debug('User not found');
            return back()->withErrors(['username' => 'Invalid credentials']);
        }

        // Log the user in (default guard)
        

        // Set session variables if needed
        session([
            'id' => $user->id,
            'username' => $user->username,
            'password' => $user->password,
            'firstName' => $user->firstName,
            'middleName' => $user->middleName,
            'middleInitial' => $user->middleName ? substr($user->middleName, 0, 1) . '.' : '',
            'lastName' => $user->lastName,
            'role' => $user->role,
            'position' => $user->position,
            'division_id' => $user->division_id,
            'division_name' => $user->division ? $user->division->name : null,
            'status' => $user->status,
        ]);

        Auth::guard('web')->login($user);

        // dd (auth()->user());
        // dd(auth()->check());
        
        
        // Redirect based on role
        switch ($user->role) {
            case 'Staff':
                return redirect()->route('staff.viewIpcr');
            case 'Division Chief':
                return redirect()->route('chief.managePpa');
            case 'Department Head':
                return redirect()->route('head.managePpa');
            break;
        }
    }

    public function userLogout() {
        // Log the user out
        Auth::logout();

        // Invalidate the session
        session()->invalidate();
        session()->regenerateToken();

        // Redirect to a desired page after logging out (e.g., login page)
        return redirect()->route('login');
    }
}
