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
use App\Models\SelectedActivity;
use App\Models\SelectedSubActivity;
use App\Models\AuditTrail;

class ppaController extends Controller
{
    // =====================Add Sub-Activity========================= //
    public function addSubActivity(Request $request)
    {
        $subActivity = new SubActivity([
            'name' => $request->addSubActivityName,
            'successIndicator' => $request->addSuccessIndicator,
            'quality' => $request->addQuality,
            'efficiency' => $request->addEfficiency,
            'timeliness' => $request->addTimeliness,
            'remarks' => $request->addRemarks,
            'accountable' => $request->addAccountable,
            'activity_id' => $request->activityIdSub,
        ]);

        // Find the activity and associate the activity with it
        $activity = Activity::findOrFail($request->activityIdSub);
        $activity->subActivities()->save($subActivity);
        // $selectedActivity->save();

        $program = Program::findOrFail($activity->program_id);

        if ($request->has('addAccountableId')) {
            // $selectedActivity->employees()->attach($request->addAccountableId);
            $subActivity->employees()->attach($request->addAccountableId);
        }

        // Get authenticated user details from Employee model
        $user = auth()->user();
        $middleInitial = $user->middleName ? strtoupper(substr($user->middleName, 0, 1)) . '.' : '';
        $fullName = trim($user->firstName . ' ' . $middleInitial . ' ' . $user->lastName);

        // Create detailed audit trail
        AuditTrail::create([
            'user_id' => auth()->id(),
            'full_name' => $fullName,
            'role' => $user->role,
            'action' => ($request->addSubActivityName ? "ADDED SUB ACTIVITY: {$request->addSubActivityName} Under the {$activity->name}\n" : "") .
                ($request->addSuccessIndicator ? "SUCCESS INDICATOR: {$request->addSuccessIndicator}\n" : "") .
                ($request->addQuality ? "QUALITY: {$request->addQuality}\n" : "") .
                ($request->addEfficiency ? "EFFICIENCY: {$request->addEfficiency}\n" : "") .
                ($request->addTimeliness ? "TIMELINESS: {$request->addTimeliness}\n" : "") .
                ($request->addRemarks ? "REMARKS: {$request->addRemarks}" : ""),
            'program_name' => $program->name
        ]);

        return response()->json(['message' => 'Sub-activity added successfully!']);
    }

    // =====================Update Sub-Activity========================= //
    public function updateSubActivity(Request $request)
    {
        // Find the sub-activity first
        $subActivity = SubActivity::findOrFail($request->editActivityIdSub);

        // Get the activity related to the sub-activity
        $activity = Activity::findOrFail($subActivity->activity_id);
        $program = Program::findOrFail($activity->program_id);
        // Get the OLD sub-activity name BEFORE updating
        $oldSubActivityName = $subActivity->name;
        $oldSuccessIndicator = $subActivity->successIndicator;
        $oldQuality = $subActivity->quality;
        $oldEfficiency = $subActivity->efficiency;
        $oldTimeliness = $subActivity->timeliness;
        $oldRemarks = $subActivity->remarks;

        // Update the sub-activity
        $subActivity->update([
            'name' => $request->editActivityNameSub,
            'successIndicator' => $request->editSuccessIndicatorSub,
            'quality' => $request->editQualitySub,
            'efficiency' => $request->editEfficiencySub,
            'timeliness' => $request->editTimelinessSub,
            'remarks' => $request->editRemarksSub,
            'accountable' => $request->editAccountableSub,
        ]);

        // Sync the individuals responsible
        $subActivity->employees()->sync($request->input('editAccountableId', []));

        // Get authenticated user details
        $user = auth()->user();
        $middleInitial = $user->middleName ? strtoupper(substr($user->middleName, 0, 1)) . '.' : '';
        $fullName = trim($user->firstName . ' ' . $middleInitial . ' ' . $user->lastName);

        // Create detailed audit trail with updated format
        AuditTrail::create([
            'user_id' => $user->id,
            'full_name' => $fullName,
            'role' => $user->role,
            'action' => "UPDATED SUB ACTIVITY: " . ($oldSubActivityName !== $request->editActivityNameSub ? "{$oldSubActivityName} to {$request->editActivityNameSub}" : $oldSubActivityName) . " Under the {$activity->name}\n" .
                ($oldSuccessIndicator !== $request->editSuccessIndicatorSub ? "SUCCESS INDICATOR: {$oldSuccessIndicator} to {$request->editSuccessIndicatorSub}\n" : "") .
                ($oldQuality !== $request->editQualitySub ? "QUALITY: {$oldQuality} to {$request->editQualitySub}\n" : "") .
                ($oldEfficiency !== $request->editEfficiencySub ? "EFFICIENCY: {$oldEfficiency} to {$request->editEfficiencySub}\n" : "") .
                ($oldTimeliness !== $request->editTimelinessSub ? "TIMELINESS: {$oldTimeliness} to {$request->editTimelinessSub}\n" : "") .
                ($oldRemarks !== $request->editRemarksSub ? "REMARKS: {$oldRemarks} to {$request->editRemarksSub}" : ""),
            'program_name' => $program->name
        ]);

        // Return a response
        return response()->json(['message' => 'Sub-Activity updated successfully!']);
    }



    // =====================Delete Sub-Activity========================= //
    public function deleteSubActivity(Request $request)
    {
        try {
            // Find the sub-activity first
            $subActivity = SubActivity::findOrFail($request->subActivityId);

            // Get the activity and program name
            $activity = Activity::findOrFail($subActivity->activity_id);
            $program = Program::findOrFail($activity->program_id);

            // Get authenticated user details before deletion
            $user = auth()->user();
            $middleInitial = $user->middleName ? strtoupper(substr($user->middleName, 0, 1)) . '.' : '';
            $fullName = trim($user->firstName . ' ' . $middleInitial . ' ' . $user->lastName);

            // Create detailed audit trail with program name
            AuditTrail::create([
                'user_id' => $user->id,
                'full_name' => $fullName,
                'role' => $user->role,
                'action' => "DELETED SUB ACTIVITY: {$subActivity->name} Under the {$activity->name}\n" .
                    "SUCCESS INDICATOR: {$subActivity->successIndicator}\n" .
                    "QUALITY: {$subActivity->quality}\n" .
                    "EFFICIENCY: {$subActivity->efficiency}\n" .
                    "TIMELINESS: {$subActivity->timeliness}\n" .
                    "REMARKS: {$subActivity->remarks}",
                'program_name' => $program->name
            ]);

            // Delete the sub-activity
            $subActivity->delete();

            return response()->json(['message' => 'Sub-activity deleted successfully!'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // If sub-activity is not found
            return response()->json(['error' => 'Sub-activity not found!'], 404);
        } catch (\Exception $e) {
            // For any other errors
            return response()->json(['error' => 'An error occurred while trying to delete the sub-activity.'], 500);
        }
    }


    // =====================Activity========================= //
    public function addActivityInProgram(Request $request)
    {
        // Create new Activity and SelectedActivity instances
        $activity = new Activity([
            'name' => $request->addActivityName,
            'successIndicator' => $request->addSuccessIndicator,
            'quality' => $request->addQuality,
            'efficiency' => $request->addEfficiency,
            'timeliness' => $request->addTimeliness,
            'remarks' => $request->addRemarks,
            'program_Id' => $request->programIdProg,
        ]);

        $selectedActivity = new SelectedActivity([
            'name' => $request->addActivityName,
            'successIndicator' => $request->addSuccessIndicator,
            'quality' => $request->addQuality,
            'efficiency' => $request->addEfficiency,
            'timeliness' => $request->addTimeliness,
            'remarks' => $request->addRemarks,
            'program_Id' => $request->programIdProg,
            'project_id' => $request->project_id,
        ]);

        // Find the program and associate the activity
        $program = Program::findOrFail($request->programIdProg);
        $program->activities()->save($activity);
        $selectedActivity->save();

        if ($request->has('addAccountableId')) {
            $activity->employees()->attach($request->addAccountableId);
        }

        // Get authenticated user details
        $user = auth()->user();
        $middleInitial = $user->middleName ? strtoupper(substr($user->middleName, 0, 1)) . '.' : '';
        $fullName = trim($user->firstName . ' ' . $middleInitial . ' ' . $user->lastName);

        // Create audit trail using AuditTrail model
        AuditTrail::create([
            'user_id' => $user->id,
            'full_name' => $fullName,
            'role' => $user->role,
            'action' => ($request->addActivityName ? "ADDED ACTIVITY: {$request->addActivityName}\n" : "") .
                ($request->addSuccessIndicator ? "SUCCESS INDICATOR: {$request->addSuccessIndicator}\n" : "") .
                ($request->addQuality ? "QUALITY: {$request->addQuality}\n" : "") .
                ($request->addEfficiency ? "EFFICIENCY: {$request->addEfficiency}\n" : "") .
                ($request->addTimeliness ? "TIMELINESS: {$request->addTimeliness}\n" : "") .
                ($request->addRemarks ? "REMARKS: {$request->addRemarks}" : ""),
            'program_name' => $program->name
        ]);

        return response()->json(['message' => 'Activity added successfully!']);
    }


    public function updateActivity(Request $request)
    {
        // Find the activity first
        $activity = Activity::findOrFail($request->editActivityId);

        // Save the old values before update
        $oldName = $activity->name;
        $oldSuccessIndicator = $activity->successIndicator;
        $oldQuality = $activity->quality;
        $oldEfficiency = $activity->efficiency;
        $oldTimeliness = $activity->timeliness;
        $oldRemarks = $activity->remarks;

        // Update the activity fields
        $activity->update([
            'name' => $request->editActivityName,
            'successIndicator' => $request->editSuccessIndicatorActivity,
            'quality' => $request->editQualityActivity,
            'efficiency' => $request->editEfficiencyActivity,
            'timeliness' => $request->editTimelinessActivity,
            'remarks' => $request->editRemarksActivity,
        ]);

        // Sync the individuals responsible
        $activity->employees()->sync($request->input('editAccountableId', []));

        // Get authenticated user details
        $user = auth()->user();
        $middleInitial = $user->middleName ? strtoupper(substr($user->middleName, 0, 1)) . '.' : '';
        $fullName = trim($user->firstName . ' ' . $middleInitial . ' ' . $user->lastName);

        // Get the program name
        $program = Program::findOrFail($activity->program_id);

        // Create audit trail using model with updated format
        AuditTrail::create([
            'user_id' => $user->id,
            'full_name' => $fullName,
            'role' => $user->role,
            'action' => "UPDATED ACTIVITY: " . ($oldName !== $request->editActivityName ? "{$oldName} to {$request->editActivityName}\n" : $oldName . "\n") .
                ($oldSuccessIndicator !== $request->editSuccessIndicatorActivity ? "SUCCESS INDICATOR: {$oldSuccessIndicator} to {$request->editSuccessIndicatorActivity}\n" : "") .
                ($oldQuality !== $request->editQualityActivity ? "QUALITY: {$oldQuality} to {$request->editQualityActivity}\n" : "") .
                ($oldEfficiency !== $request->editEfficiencyActivity ? "EFFICIENCY: {$oldEfficiency} to {$request->editEfficiencyActivity}\n" : "") .
                ($oldTimeliness !== $request->editTimelinessActivity ? "TIMELINESS: {$oldTimeliness} to {$request->editTimelinessActivity}\n" : "") .
                ($oldRemarks !== $request->editRemarksActivity ? "REMARKS: {$oldRemarks} to {$request->editRemarksActivity}" : ""),
            'program_name' => $program->name
        ]);

        return response()->json(['message' => 'Activity updated successfully!']);
    }


    public function deleteActivity(Request $request)
    {
        try {
            // Find the activity by its ID
            $activity = Activity::findOrFail($request->activityId);

            // Get authenticated user details before deletion
            $user = auth()->user();
            $middleInitial = $user->middleName ? strtoupper(substr($user->middleName, 0, 1)) . '.' : '';
            $fullName = trim($user->firstName . ' ' . $middleInitial . ' ' . $user->lastName);

            // Find the program related to the activity
            $program = Program::findOrFail($activity->program_id);

            // Insert audit trail before deleting, using the AuditTrail model
            AuditTrail::create([
                'user_id' => $user->id,
                'full_name' => $fullName,
                'role' => $user->role,
                'action' => "DELETED ACTIVITY: {$activity->name}\n" .
                    "SUCCESS INDICATOR: {$activity->successIndicator}\n" .
                    "QUALITY: {$activity->quality}\n" .
                    "EFFICIENCY: {$activity->efficiency}\n" .
                    "TIMELINESS: {$activity->timeliness}\n" .
                    "REMARKS: {$activity->remarks}",
                'program_name' => $program->name
            ]);

            // Now delete the activity
            $activity->delete();

            return response()->json(['message' => 'Activity deleted successfully!'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // If activity or program is not found
            return response()->json(['error' => 'Activity or Program not found!'], 404);
        } catch (\Exception $e) {
            // Handle any other errors
            return response()->json(['error' => 'An error occurred while trying to delete the activity.'], 500);
        }
    }



    // =====================Program========================= //
    public function addProgram(Request $request)
    {
        try {
            // Create the program
            $program = Program::create([
                'name' => $request->addProgramName,
                'successIndicator' => $request->addSuccessIndicator,
                'quality' => $request->addQuality,
                'efficiency' => $request->addEfficiency,
                'timeliness' => $request->addTimeliness,
                'remarks' => $request->addRemarks,
                'budget' => $request->addBudget,
            ]);

            // Check if 'all' is selected and attach divisions
            if (in_array('all', $request->divisions)) {
                $allDivisionIds = \App\Models\Division::pluck('id')->toArray();
                $program->divisions()->attach($allDivisionIds);
            } else {
                $program->divisions()->attach($request->divisions);
            }

            // Get authenticated user details for the audit trail
            $user = auth()->user();
            $middleInitial = $user->middleName ? strtoupper(substr($user->middleName, 0, 1)) . '.' : '';
            $fullName = trim($user->firstName . ' ' . $middleInitial . ' ' . $user->lastName);

            // Create audit trail using the AuditTrail model
            AuditTrail::create([
                'user_id' => $user->id,
                'full_name' => $fullName,
                'role' => $user->role,
                'action' => "ADDED PROGRAM: {$program->name}\n" .
                    "SUCCESS INDICATOR: {$program->successIndicator}\n" .
                    "QUALITY: {$program->quality}\n" .
                    "EFFICIENCY: {$program->efficiency}\n" .
                    "TIMELINESS: {$program->timeliness}\n" .
                    "REMARKS: {$program->remarks}\n" .
                    "BUDGET: {$program->budget}",
                'program_name' => $program->name
            ]);

            // Return with success message
            return redirect()->back()->with('success', 'Program added successfully.');
        } catch (\Exception $e) {
            // Handle any errors and return with an error message
            return redirect()->back()->with('error', 'An error occurred while adding the program.');
        }
    }



    public function updateProgram(Request $request)
    {
        try {
            // Find the program by its ID
            $program = Program::findOrFail($request->editProgramId);

            // Save the old values before update
            $oldName = $program->name;
            $oldSuccessIndicator = $program->successIndicator;
            $oldQuality = $program->quality;
            $oldEfficiency = $program->efficiency;
            $oldTimeliness = $program->timeliness;
            $oldRemarks = $program->remarks;
            $oldBudget = $program->budget;

            // Update the program fields
            $program->name = $request->editProgramName;
            $program->successIndicator = $request->editSuccessIndicator;
            $program->quality = $request->editQuality;
            $program->efficiency = $request->editEfficiency;
            $program->timeliness = $request->editTimeliness;
            $program->remarks = $request->editRemarks;
            $program->budget = $request->editBudget;
            $program->save();


            // Handle the "all" divisions scenario
            if (in_array('all', $request->divisions)) {
                $allDivisionIds = \App\Models\Division::pluck('id')->toArray();
                $program->divisions()->sync($allDivisionIds);
            } else {
                $program->divisions()->sync($request->divisions);
            }

            // Get authenticated user details for the audit trail
            $user = auth()->user();
            $middleInitial = $user->middleName ? strtoupper(substr($user->middleName, 0, 1)) . '.' : '';
            $fullName = trim($user->firstName . ' ' . $middleInitial . ' ' . $user->lastName);

            // Create audit trail using model with updated format
            AuditTrail::create([
                'user_id' => $user->id,
                'full_name' => $fullName,
                'role' => $user->role,
                'action' => "UPDATED PROGRAM: " . ($oldName !== $request->editProgramName ? "{$oldName} to {$request->editProgramName}\n" : $oldName . "\n") .
                    ($oldSuccessIndicator !== $request->editSuccessIndicator ? "SUCCESS INDICATOR: {$oldSuccessIndicator} to {$request->editSuccessIndicator}\n" : "") .
                    ($oldQuality !== $request->editQuality ? "QUALITY: {$oldQuality} to {$request->editQuality}\n" : "") .
                    ($oldEfficiency !== $request->editEfficiency ? "EFFICIENCY: {$oldEfficiency} to {$request->editEfficiency}\n" : "") .
                    ($oldTimeliness !== $request->editTimeliness ? "TIMELINESS: {$oldTimeliness} to {$request->editTimeliness}\n" : "") .
                    ($oldRemarks !== $request->editRemarks ? "REMARKS: {$oldRemarks} to {$request->editRemarks}\n" : "") .
                    ($oldBudget !== $request->editBudget ? "ALLOTTED BUDGET: {$oldBudget} to {$request->editBudget}" : ""),
                'program_name' => $program->name
            ]);

            // Return with a success message
            return redirect()->back()->with('success', 'Program updated successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Handle case when program is not found
            return redirect()->back()->with('error', 'Program not found.');
        } catch (\Exception $e) {
            // Handle any other errors that may occur
            return redirect()->back()->with('error', 'An error occurred while updating the program.');
        }
    }



    public function deleteProgram(Request $request)
    {
        try {
            // Find the program by its ID
            $program = Program::findOrFail($request->programId);

            // Get authenticated user details for the audit trail
            $user = auth()->user();
            $middleInitial = $user->middleName ? strtoupper(substr($user->middleName, 0, 1)) . '.' : '';
            $fullName = trim($user->firstName . ' ' . $middleInitial . ' ' . $user->lastName);

            // Create an audit trail for deleting the program
            AuditTrail::create([
                'user_id' => auth()->id(),
                'full_name' => $fullName,
                'role' => $user->role,
                'action' => "DELETED PROGRAM: {$program->name}\n" .
                    "SUCCESS INDICATOR: {$program->successIndicator}\n" .
                    "QUALITY: {$program->quality}\n" .
                    "EFFICIENCY: {$program->efficiency}\n" .
                    "TIMELINESS: {$program->timeliness}\n" .
                    "REMARKS: {$program->remarks}\n" .
                    "ALLOTTED BUDGET: {$program->budget}",
                'program_name' => $program->name
            ]);

            // Now delete the program
            $program->delete();

            return response()->json(['message' => 'Program deleted successfully!'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // If program is not found
            return response()->json(['error' => 'Program not found!'], 404);
        } catch (\Exception $e) {
            // Handle any other errors
            return response()->json(['error' => 'An error occurred while trying to delete the program.'], 500);
        }
    }





    // =====================Autofill Accountable (Add Activity)========================= //
    public function getAccountableByIds(Request $request)
    {
        $divisionIds = $request->input('divisionIds', []);

        if (empty($divisionIds)) {
            return response()->json([]);
        }

        $accountables = Employee::whereIn('division_id', $divisionIds)
            ->whereIn('role', ['Staff', 'Division Chief']) // Include both roles
            ->get();

        $results = $accountables->map(function ($employee) {
            $middleInitial = $employee->middleName ? strtoupper(substr($employee->middleName, 0, 1)) . '. ' : '';
            return [
                'id' => $employee->id,
                'name' => $employee->firstName . ' ' . $middleInitial . $employee->lastName,
                'role' => $employee->role,
                'position' => $employee->position,
            ];
        });

        return response()->json($results);
    }

    // =====================Autofill Responsible Division (Edit Program)========================= //
    public function getDivisionResponsible($id)
    {
        $program = Program::with('divisions')->findOrFail($id);
        return response()->json($program->divisions);
    }

    // =====================Autofill Responsible Individual (Edit Activity)========================= //
    public function getActivityAccountables($id)
    {
        $activity = Activity::with('employees')->findOrFail($id);

        $employees = $activity->employees->map(function ($e) {
            $middleInitial = $e->middleName ? strtoupper(substr($e->middleName, 0, 1)) . '. ' : '';
            return [
                'id' => $e->id,
                'name' => $e->firstName . ' ' . $middleInitial . $e->lastName,
                'position' => $e->position,
            ];
        });

        return response()->json($employees);
    }

    public function fetchEmployee($activityId)
    {
        $activity = Activity::with('program.divisions.employees')->findOrFail($activityId);

        $employees = collect();

        if ($activity->program && $activity->program->divisions) {
            foreach ($activity->program->divisions as $division) {
                foreach ($division->employees as $e) {
                    $middleInitial = $e->middleName ? strtoupper(substr($e->middleName, 0, 1)) . '. ' : '';
                    $employees->push([
                        'id' => $e->id,
                        'name' => $e->firstName . ' ' . $middleInitial . $e->lastName,
                        'position' => $e->position,
                    ]);
                }
            }
        }

        return response()->json($employees->unique('id')->values());
    }

    // =====================Autofill Responsible Individual (Edit SubActivity)========================= //
    public function getSubActivityAccountables($id)
    {
        $subActivity = SubActivity::with('employees')->findOrFail($id);

        $employees = $subActivity->employees->map(function ($e) {
            $middleInitial = $e->middleName ? strtoupper(substr($e->middleName, 0, 1)) . '. ' : '';
            return [
                'id' => $e->id,
                'name' => $e->firstName . ' ' . $middleInitial . $e->lastName,
                'position' => $e->position,
            ];
        });

        return response()->json($employees);
    }

    public function fetchEmployeeSub($subActivityId)
    {
        $subActivity = SubActivity::with('activity.program.divisions.employees')->findOrFail($subActivityId);

        $employees = collect();

        if (
            $subActivity->activity &&
            $subActivity->activity->program &&
            $subActivity->activity->program->divisions
        ) {
            foreach ($subActivity->activity->program->divisions as $division) {
                foreach ($division->employees as $e) {
                    $middleInitial = $e->middleName ? strtoupper(substr($e->middleName, 0, 1)) . '. ' : '';
                    $employees->push([
                        'id' => $e->id,
                        'name' => $e->firstName . ' ' . $middleInitial . $e->lastName,
                        'position' => $e->position,
                    ]);
                }
            }
        }

        return response()->json($employees->unique('id')->values());
    }
}
