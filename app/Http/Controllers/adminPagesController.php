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
        $programRequest = ProgramRequest::with(['requester','divisions','gass'])->where('status', 'pending')->orderBy('created_at', 'desc')->get();
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
    
        $data = [];
        $gassPrograms = [];
        $targets = [];
        $user = auth()->user();
        
        // For staff
        foreach (auth()->user()->subActivities as $subActivity) {
            $activity = $subActivity->activity;
            
            if (!$activity) {
                \Log::error("Missing activity for SubActivity ID: " . $subActivity->id);
                continue; // Skip this loop if activity is missing
            }

            $program = $activity->program;

            if (!$program) {
                \Log::error("Missing program for Activity ID: " . $activity->id);
                continue; // Also skip if program is missing
            }

            $data = [
                'program_id' => $program->id,
                'program_name' => $program->name,
                'program_order' => $program->order ?? 0,
                'activity_id' => $activity->id,
                'activity_name' => $activity->name,
                'activity_order' => $activity->order ?? 0,
                'sub_activity_id' => $subActivity->id,
                'sub_activity_name' => $subActivity->name,
                'sub_activity_success_indicator' => $subActivity->successIndicator,
                'sub_activity_quality' => $subActivity->quality,
                'sub_activity_efficiency' => $subActivity->efficiency,
                'sub_activity_timeliness' => $subActivity->timeliness,
                'sub_activity_remarks' => $subActivity->remarks,
                'sub_activity_order' => $subActivity->order ?? 0,
            ];

            if (!is_null($program->gass_id)) {
                $gassPrograms[] = array_merge($data, [
                    'program_division' => $program->divisions->pluck('name')->toArray(),
                    'program_budget' => $program->budget,
                    'program_success_indicator' => $program->successIndicator,
                    'program_quality' => $program->quality,
                    'program_efficiency' => $program->efficiency,
                    'program_timeliness' => $program->timeliness,
                    'program_remarks' => $program->remarks,
                    'activity_success_indicator' => $activity->successIndicator,
                    'activity_quality' => $activity->quality,
                    'activity_efficiency' => $activity->efficiency,
                    'activity_timeliness' => $activity->timeliness,
                    'activity_remarks' => $activity->remarks,
                    'gass_id' => $program->gass_id,
                    'gass_name' => optional($program->gass)->name,
                ]);
            } else {
                $targets[] = $data;
            }
        }

        return view('viewBlades.viewTargets', compact(
            'programs',
            'employees',
            'activities',
            'divisions'
        ),[
            'role' => auth()->user()->role,
            'targets' => $targets,
            'gasses' => $gassPrograms,
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
