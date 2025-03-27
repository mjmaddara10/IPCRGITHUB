<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Project;
use App\Models\Activity;
use App\Models\Employee;

class adminPagesController extends Controller
{
    public function index(){
        return view('adminBlades.adminIndex');
    }

    public function settings(){
        return view('adminBlades.adminSettings');
    }

    public function manageUsers(){
        $employees = Employee::all();

        return view('adminBlades.adminManageUsers', compact('employees'));
    }
    
    public function managePpa(){
        // Fetch all programs with their related projects
        $programs = Program::with('projects')->get();
        $projects = Project::with('activities')->get();

        // Pass the data to the view
        return view('adminBlades.adminManagePpa', compact('programs','projects'));
    }

    public function viewIpcr(){
        return view('adminBlades.adminIpcr');
    }

    public function assignIpcr(){
        return view('adminBlades.adminAssign');
    }
}
