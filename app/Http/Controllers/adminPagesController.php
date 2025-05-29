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
use App\Models\Gass;
use App\Models\ProgramRequest;
use App\Models\ActivityRequest;
use App\Models\SubActivityRequest;
use App\Models\GassRequest;


class adminPagesController extends Controller
{
    public function approve(){
        $programRequest = ProgramRequest::with(['requester','divisions'])->where('status', 'pending')->orderBy('created_at', 'desc')->get();
        $activityRequest = ActivityRequest::with(['requester','employees'])->where('status', 'pending')->orderBy('created_at', 'desc')->get();
        $subActivityRequest = SubActivityRequest::with(['requester','employees'])->where('status', 'pending')->orderBy('created_at', 'desc')->get();
        $gassRequest = GassRequest::with(['requester'])->where('status', 'pending')->orderBy('created_at', 'desc')->get();

        return view('viewBlades.approveChanges', [
            'role' => auth()->user()->role,
            'programRequest' => $programRequest,
            'activityRequest' => $activityRequest,
            'subActivityRequest' => $subActivityRequest,
            'gassRequest' => $gassRequest,
        ]);
    }

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
        $programs = Program::with([
            'divisions',
            'activities.subActivities',
            'activities.employees'
        ])
        ->whereNull('gass_id') // ✅ Only programs without a gass_id
        ->orderBy('order')
        ->get();

        $gasses = Gass::with([
            'programs' => function ($query) {
                $query->orderBy('order');
            },
            'programs.divisions', // <-- this is what was missing
            'programs.activities' => function ($query) {
                $query->orderBy('order');
            },
            'programs.activities.subActivities' => function ($query) {
                $query->orderBy('order');
            },
        ])->get();
    
        $employees = Employee::all();
        $divisions = Division::all();
    
        return view('viewBlades.managePpa', compact(
            'programs',
            'employees',
            'divisions',
            'gasses',
        ), [
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
                'program_order' => $program->order ?? 0,
                'activity_name' => $activity->name,
                'activity_order' => $activity->order ?? 0,
                'sub_activity_name' => $subActivity->name,
                'sub_activity_success_indicator' => $subActivity->successIndicator,
                'sub_activity_quality' => $subActivity->quality,
                'sub_activity_efficiency' => $subActivity->efficiency,
                'sub_activity_timeliness' => $subActivity->timeliness,
                'sub_activity_remarks' => $subActivity->remarks,
                'sub_activity_order' => $subActivity->order ?? 0,
            ];
        }

        usort($targets, function ($a, $b) {
            $programCompare = $a['program_order'] <=> $b['program_order'];
            if ($programCompare !== 0) return $programCompare;
    
            $activityCompare = $a['activity_order'] <=> $b['activity_order'];
            if ($activityCompare !== 0) return $activityCompare;
    
            return $a['sub_activity_order'] <=> $b['sub_activity_order'];
        });

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
