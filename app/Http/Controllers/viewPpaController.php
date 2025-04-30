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
            'subActivities.activity.program.divisions'
        ])->find($id);
    
        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }
    
        $role = $employee->role;
        $targets = [];
    
        // 🔹 FOR DEPARTMENT HEAD — get ALL programs, activities, sub-activities
        if ($role === 'Department Head' || $role === 'Assistant Department Head') {
            $allPrograms = Program::with([
                'divisions',
                'activities.subActivities'
            ])->get();
    
            foreach ($allPrograms as $program) {
                foreach ($program->activities as $activity) {
                    // if sub-activities exist
                    if ($activity->subActivities->count()) {
                        foreach ($activity->subActivities as $subActivity) {
                            $targets[] = [
                                'program_id' => $program->id,
                                'program_name' => $program->name,
                                'program_division' => $program->divisions->pluck('name')->toArray(),
                                'program_budget' => $program->budget,
                                'program_success_indicator' => $program->successIndicator,
                                'program_quality' => $program->quality,
                                'program_efficiency' => $program->efficiency,
                                'program_timeliness' => $program->timeliness,
                                'program_remarks' => $program->remarks,
                                'activity_id' => $activity->id,
                                'activity_name' => $activity->name,
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
                            ];
                        }
                    } else {
                        // activity without sub-activities
                        $targets[] = [
                            'program_id' => $program->id,
                            'program_name' => $program->name,
                            'program_division' => $program->divisions->pluck('name')->toArray(),
                            'program_budget' => $program->budget,
                            'program_success_indicator' => $program->successIndicator,
                            'program_quality' => $program->quality,
                            'program_efficiency' => $program->efficiency,
                            'program_timeliness' => $program->timeliness,
                            'program_remarks' => $program->remarks,
                            'activity_id' => $activity->id,
                            'activity_name' => $activity->name,
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
                        ];
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
                }
                $program = $activity->program;
    
                $targets[] = [
                    'program_id' => $program->id,
                    'program_name' => $program->name,
                    'activity_id' => $activity->id,
                    'activity_name' => $activity->name,
                    'sub_activity_id' => $subActivity->id,
                    'sub_activity_name' => $subActivity->name,
                    'sub_activity_success_indicator' => $subActivity->successIndicator,
                    'sub_activity_quality' => $subActivity->quality,
                    'sub_activity_efficiency' => $subActivity->efficiency,
                    'sub_activity_timeliness' => $subActivity->timeliness,
                    'sub_activity_remarks' => $subActivity->remarks,
                ];
            }
        }

        // dd($targets);
    
        return response()->json([
            'role' => $role,
            'targets' => $targets
        ]);
    }
}