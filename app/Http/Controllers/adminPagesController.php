<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Project;
use App\Models\Activity;
use App\Models\Employee;
use App\Models\SubProject;

class adminPagesController extends Controller
{
    public function index(){
        return view('adminBlades.adminIndex');
    }

    public function settings(){
        return view('adminBlades.adminSettings');
    }

    public function viewEmployees(){
        $employees = Employee::all();

        return view('adminBlades.adminViewEmployees', compact('employees'));
    }
    
    public function managePpa(){
        // Fetch all programs with their related projects
        $programs = Program::with('projects')->get();
        $projects = Project::with('activities' , 'subProjects')->get();
        $subProjects = SubProject::with('activities')->get();

        // Pass the data to the view
        return view('adminBlades.adminManagePpa', compact('programs','projects','subProjects'));
    }

    public function managePpa2(){
        // Fetch all programs with their related projects
        $programs = Program::with('projects')->get();
        $projects = Project::with('activities' , 'subProjects')->get();
        $subProjects = SubProject::with('activities')->get();

        // Pass the data to the view
        return view('adminBlades.adminManagePpa2', compact('programs','projects','subProjects'));
    }

    public function viewIpcr(){
        return view('adminBlades.adminIpcr');
    }

    public function assignIpcr(){
        return view('adminBlades.adminAssign');
    }
}
