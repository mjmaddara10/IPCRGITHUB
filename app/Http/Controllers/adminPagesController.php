<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Project;
use App\Models\Activity;
use App\Models\SubActivity;
use App\Models\Employee;
use App\Models\SubProject;
use App\Models\Division;

class adminPagesController extends Controller
{
    public function settings(){
        return view('viewBlades.settings', [
            'role' => auth()->user()->role
        ]);
    }

    public function viewEmployees(){
        $employees = Employee::all();

        return view('viewBlades.viewUsers', compact('employees'),[
            'role' => auth()->user()->role
        ]);
    }
    
    public function managePpa(){
        // Fetch all programs with their related projects
        $programs = Program::with(['divisions', 'activities.employees'])->get();
        $activities = Activity::with('subActivities','employees')->get();
        $employees = Employee::all();
        $divisions = Division::all();
        $subActivities = SubActivity::all();
    
        return view('viewBlades.managePpa', compact(
            'programs',
            'employees',
            'activities',
            'divisions'
        ),[
            'role' => auth()->user()->role
        ]);
    }

    public function viewIpcr(){
        // Fetch all programs with their related projects
        $programs = Program::with('divisions')->get();
        $activities = Activity::with('subActivities')->get();
        $employees = Employee::with('division')->get();
        $divisions = Division::with(['employees' => function ($query) {
            $query->where('role', 'Division Chief');
        }])->get(); 
    
        return view('viewBlades.viewTargets', compact(
            'programs',
            'employees',
            'activities',
            'divisions'
        ),[
            'role' => auth()->user()->role
        ]);
    }

    public function assignIpcr(){
        // Fetch all programs with their related projects
        $programs = Program::with('divisions')->get();
        $activities = Activity::with('subActivities')->get();
        $employees = Employee::with('division')->get();
        $divisions = Division::all();
    
        return view('viewBlades.adminAssign', compact(
            'programs',
            'employees',
            'activities',
            'divisions'
        ),[
            'role' => auth()->user()->role
        ]);
    }
}
