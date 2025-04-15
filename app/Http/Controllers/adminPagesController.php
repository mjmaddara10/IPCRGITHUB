<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Project;
use App\Models\Activity;
use App\Models\Employee;
use App\Models\SubProject;
use App\Models\Division;

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
        $programs = Program::with('projects','divisions')->get();
        $projects = Project::with('activities' , 'subProjects')->get();
        $subProjects = SubProject::with('activities')->get();
        $activities = Activity::with('subActivities')->get();
        $employees = Employee::all(); // Fetch all employees 
        $divisions = Division::all();

        // Pass the data to the view
        return view('adminBlades.adminManagePpa', compact('programs','projects','subProjects','employees','activities','divisions'));
    }

    public function viewIpcr(){
        return view('adminBlades.adminIpcr');
    }

    public function assignIpcr(){
        return view('adminBlades.adminAssign');
    }
}
