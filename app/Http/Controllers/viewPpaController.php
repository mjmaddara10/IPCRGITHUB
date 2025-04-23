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
            'activities.program',
            'activities.subActivities', // get all sub-activities under the activity
            'subActivities.activity.program'
        ])->find($id);
    
        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }
    
        $targets = [];
    
        // First, include sub-activities the employee is assigned to
        foreach ($employee->subActivities as $subActivity) {
            $activity = $subActivity->activity;
            $program = $activity->program;
    
            $targets[] = [
                'program_name' => $program->name,
                'activity_name' => $activity->name,
                'activity_success_indicator' => $activity->successIndicator,
                'activity_quality' => $activity->quality,
                'activity_efficiency' => $activity->efficiency,
                'activity_timeliness' => $activity->timeliness,
                'activity_remarks' => $activity->remarks,
                'sub_activity_name' => $subActivity->name,
                'sub_activity_success_indicator' => $subActivity->successIndicator,
                'sub_activity_quality' => $subActivity->quality,
                'sub_activity_efficiency' => $subActivity->efficiency,
                'sub_activity_timeliness' => $subActivity->timeliness,
                'sub_activity_remarks' => $subActivity->remarks,
            ];
        }
    
        // Then include activities the employee is assigned to, but skip if sub-activities already included
        foreach ($employee->activities as $activity) {
            $program = $activity->program;
    
            // Check if this activity already has any sub-activities assigned to the employee
            $hasSubActivitiesAssigned = $activity->subActivities->some(function ($sub) use ($employee) {
                return $sub->employees->contains($employee->id);
            });
    
            if (!$hasSubActivitiesAssigned) {
                $targets[] = [
                    'program_name' => $program->name,
                    'activity_name' => $activity->name,
                    'activity_success_indicator' => $activity->successIndicator,
                    'activity_quality' => $activity->quality,
                    'activity_efficiency' => $activity->efficiency,
                    'activity_timeliness' => $activity->timeliness,
                    'activity_remarks' => $activity->remarks,
                    'sub_activity_name' => null,
                    'sub_activity_success_indicator' => null,
                    'sub_activity_quality' => null,
                    'sub_activity_efficiency' => null,
                    'sub_activity_timeliness' => null,
                    'sub_activity_remarks' => null,
                ];
            }
        }
    
        return response()->json($targets);
    }
}