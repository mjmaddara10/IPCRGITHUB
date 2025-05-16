<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\SubActivity;
use App\Models\Project;
use App\Models\SubProject;
use App\Models\Program;
use App\Models\Employee;
use App\Models\Division;
use App\Models\Gass;

class viewPpaController extends Controller{
    public function getEmployeeDivision($id)
    {
        $employee = Employee::with('division')->find($id);

        if (!$employee || !$employee->division) {
            return response()->json(['error' => 'Division not found for this employee'], 404);
        }
        // dd($employee->division);
        return response()->json([
            'id' => $employee->division->id,
            'name' => $employee->division->name,
        ]);
    }

    public function getEmployeeTargets($id) {
        $employee = Employee::with([
            'activities.program.divisions',
            'activities.subActivities',
            'subActivities.activity.program.gass',
            'subActivities.activity.program.divisions'
        ])->find($id);
    
        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }
    
        $role = $employee->role;
        $targets = [];
        $gassPrograms = [];
    
        // 🔹 FOR DEPARTMENT HEAD — get ALL programs, activities, sub-activities
        if ($role === 'Department Head') {
            $allPrograms = Program::with([
                'divisions',
                'activities.subActivities'
            ])->get();
    
            foreach ($allPrograms as $program) {
                foreach ($program->activities as $activity) {
                    $programData = [
                        'program_id' => $program->id,
                        'program_name' => $program->name,
                        'program_order' => $program->order ?? 0,
                        'program_division' => $program->divisions->pluck('name')->toArray(),
                        'program_budget' => $program->budget,
                        'program_success_indicator' => $program->successIndicator,
                        'program_quality' => $program->quality,
                        'program_efficiency' => $program->efficiency,
                        'program_timeliness' => $program->timeliness,
                        'program_remarks' => $program->remarks,
                        'activity_id' => $activity->id,
                        'activity_name' => $activity->name,
                        'activity_order' => $activity->order ?? 0,
                        'activity_success_indicator' => $activity->successIndicator,
                        'activity_quality' => $activity->quality,
                        'activity_efficiency' => $activity->efficiency,
                        'activity_timeliness' => $activity->timeliness,
                        'activity_remarks' => $activity->remarks,
                        'sub_activity_id' => null,
                        'sub_activity_name' => null,
                        'sub_activity_success_indicator' => null,
                        'sub_activity_quality' => null,
                        'sub_activity_efficiency' => null,
                        'sub_activity_timeliness' => null,
                        'sub_activity_remarks' => null,
                        'sub_activity_order' => null,
                        'gass_id' => $program->gass_id,
                        'gass_name' => $program->gass ? $program->gass->name : null,
                        'gass_budget' => $program->gass ? $program->gass->budget : null,
                    ];

                    if (!is_null($program->gass_id)) {
                        $programData['gass_id'] = $program->gass_id;
                        $programData['gass_name'] = $program->gass ? $program->gass->name : null;
                        $gassPrograms[] = $programData;
                    } else {
                        $targets[] = $programData;
                    }
                }
            }
        }
        
        // 🔹 FOR STAFF or DIVISION CHIEF — only get what they are assigned to
        else {
            foreach ($employee->subActivities as $subActivity) {
                $activity = $subActivity->activity;

                if (!$activity) {
                    \Log::error("Missing activity for SubActivity ID: " . $subActivity->id);
                    continue;
                }

                $program = $activity->program;

                // If program has a gass_id, push to gassPrograms
                if (!is_null($program->gass_id)) {
                    $gassPrograms[] = [
                        'program_id' => $program->id,
                        'program_name' => $program->name,
                        'program_order' => $program->order ?? 0,
                        'program_division' => $program->divisions->pluck('name')->toArray(),
                        'program_budget' => $program->budget,
                        'program_success_indicator' => $program->successIndicator,
                        'program_quality' => $program->quality,
                        'program_efficiency' => $program->efficiency,
                        'program_timeliness' => $program->timeliness,
                        'program_remarks' => $program->remarks,
                        'activity_id' => $activity->id,
                        'activity_name' => $activity->name,
                        'activity_order' => $activity->order ?? 0,
                        'activity_success_indicator' => $activity->successIndicator,
                        'activity_quality' => $activity->quality,
                        'activity_efficiency' => $activity->efficiency,
                        'activity_timeliness' => $activity->timeliness,
                        'activity_remarks' => $activity->remarks,
                        'sub_activity_id' => $subActivity->id,
                        'sub_activity_name' => $subActivity->name,
                        'sub_activity_success_indicator' => $subActivity->successIndicator,
                        'sub_activity_quality' => $subActivity->quality,
                        'sub_activity_efficiency' => $subActivity->efficiency,
                        'sub_activity_timeliness' => $subActivity->timeliness,
                        'sub_activity_remarks' => $subActivity->remarks,
                        'sub_activity_order' => $subActivity->order ?? 0,
                        'gass_id' => $program->gass_id,
                        'gass_name' => $program->gass ? $program->gass->name : null,
                    ];
                } else {
                    // Otherwise, push to targets
                    $targets[] = [
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
                }
            }
        }

        usort($targets, function ($a, $b) {
            $programCompare = $a['program_order'] <=> $b['program_order'];
            if ($programCompare !== 0) return $programCompare;
    
            $activityCompare = $a['activity_order'] <=> $b['activity_order'];
            if ($activityCompare !== 0) return $activityCompare;
    
            return $a['sub_activity_order'] <=> $b['sub_activity_order'];
        });

        usort($gassPrograms, function ($a, $b) {
            $programCompare = $a['program_order'] <=> $b['program_order'];
            if ($programCompare !== 0) return $programCompare;
    
            $activityCompare = $a['activity_order'] <=> $b['activity_order'];
            if ($activityCompare !== 0) return $activityCompare;
    
            return $a['sub_activity_order'] <=> $b['sub_activity_order'];
        });

        // dd($targets);
    
        return response()->json([
            'role' => $role,
            'targets' => $targets,
            'gasses' => $gassPrograms,
        ]);
    }
}