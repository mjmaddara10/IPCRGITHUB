<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\AuditTrail;
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
        $subActivities = SubActivity::with('activity')->get();
        $divisions = Division::with(['employees' => function ($query) {
            $query->where('role', 'Division Chief');
        }])->get(); 
    
        $targets = [];
        $user = auth()->user();
        // For staff

        foreach (auth()->user()->subActivities as $subActivity) {
            $activity = $subActivity->activity;
            $program = $activity->program;

            if (!$activity) {
                \Log::error("Missing activity for SubActivity ID: " . $subActivity->id);
            }
            
            $targets[] = [
                'program_name' => $program->name,
                'activity_name' => $activity->name,
                'sub_activity_name' => $subActivity->name,
                'sub_activity_success_indicator' => $subActivity->successIndicator,
                'sub_activity_quality' => $subActivity->quality,
                'sub_activity_efficiency' => $subActivity->efficiency,
                'sub_activity_timeliness' => $subActivity->timeliness,
                'sub_activity_remarks' => $subActivity->remarks,
            ];
        }

        return view('viewBlades.viewTargets', compact(
            'programs',
            'employees',
            'activities',
            'divisions'
        ),[
            'role' => auth()->user()->role,
            'targets' => $targets,
            'user' => $user,
        ]);
    }

    public function audit(){
        // Fetch all programs with their related projects
        $programs = Program::with(['divisions', 'activities.employees'])->get();
        $activities = Activity::with('subActivities','employees')->get();
        $employees = Employee::all();
        $divisions = Division::all();
        $subActivities = SubActivity::all();
        $auditTrails = AuditTrail::orderBy('created_at', 'desc')->get();

        return view('viewBlades.auditTrail', compact(
            'programs',
            'employees',
            'activities',
            'divisions',
            'auditTrails'),['role' => auth()->user()->role
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
