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
use App\Models\AuditTrail;

class ppaController extends Controller
{
    // =====================Add Sub-Activity========================= //
    public function addSubActivity(Request $request){
        $maxOrder = SubActivity::where('activity_id', $request->activityIdSub)->max('order') ?? 0;

        $subActivity = new SubActivity([
            'name' => $request->addSubActivityName,
            'successIndicator' => $request->addSuccessIndicator,
            'quality' => $request->addQuality,
            'efficiency' => $request->addEfficiency,
            'timeliness' => $request->addTimeliness,
            'remarks' => $request->addRemarks,
            'accountable' => $request->addAccountable,
            'activity_id' => $request->activityIdSub,
            'order' => $maxOrder + 1
        ]);

        // Find the activity and associate the activity with it
        $activity = Activity::findOrFail($request->activityIdSub);
        $activity->subActivities()->save($subActivity);
        $program = Program::findOrFail($activity->program_id);

        if ($request->has('addAccountableId')) {
            // $selectedActivity->employees()->attach($request->addAccountableId);
            $subActivity->employees()->attach($request->addAccountableId);
        }

        $responsibleEmployees = $subActivity->employees()
            ->get()
            ->map(function ($employee) {
                $middleInitial = $employee->middleName ? strtoupper(substr($employee->middleName, 0, 1)) . '.' : '';
                return trim($employee->firstName . ' ' . $middleInitial . ' ' . $employee->lastName);
            })
            ->implode(', ');

       // Get authenticated user details from Employee model
        $user = auth()->user();
        $middleInitial = $user->middleName ? strtoupper(substr($user->middleName, 0, 1)) . '.' : '';
        $fullName = $user->firstName . ' ' . $middleInitial . ' ' . $user->lastName;

        // Create audit trail
        AuditTrail::create([
            'user_id' => auth()->id(),
            'full_name' => $fullName,
            'role' => $user->role,
            'action' => "ADDED SUB ACTIVITY under {$activity->name}",
            'action_from' => null,  // No previous value for new items
            'action_to' => "Sub Activity Name: {$request->addSubActivityName}\n" .
                "SUCCESS INDICATOR: {$request->addSuccessIndicator}\n" .
                "QUALITY: {$request->addQuality}\n" .
                "EFFICIENCY: {$request->addEfficiency}\n" .
                "TIMELINESS: {$request->addTimeliness}\n" .
                "REMARKS: {$request->addRemarks}\n" .
                "RESPONSIBLE PERSON: {$responsibleEmployees}",
            'program_name' => $program->name,
            'record_id' => $subActivity->id,
            'activity_name' => $activity->name
        ]);

        return response()->json(['message' => 'Sub-activity added successfully!']);
    }

    // =====================Update Sub-Activity========================= //
    public function updateSubActivity(Request $request){
        // Find the sub-activity and update it
        $subActivity = SubActivity::findOrFail($request->editActivityIdSub);

        // Get the activity name before update
        $activity = Activity::findOrFail($subActivity->activity_id);
        $program = Program::findOrFail($activity->program_id);

        $oldSubActivityName = $subActivity->name;
        $oldSuccessIndicator = $subActivity->successIndicator;
        $oldQuality = $subActivity->quality;
        $oldEfficiency = $subActivity->efficiency;
        $oldTimeliness = $subActivity->timeliness;
        $oldRemarks = $subActivity->remarks;
        $oldResponsibleEmployees = $subActivity->employees()
            ->get()
            ->map(function ($employee) {
                $middleInitial = $employee->middleName ? strtoupper(substr($employee->middleName, 0, 1)) . '.' : '';
                return trim($employee->firstName . ' ' . $middleInitial . ' ' . $employee->lastName);
            })
            ->implode(', ');

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

        // Get the new responsible employees after update
        $newResponsibleEmployees = $subActivity->employees()
            ->get()
            ->map(function ($employee) {
                $middleInitial = $employee->middleName ? strtoupper(substr($employee->middleName, 0, 1)) . '.' : '';
                return trim($employee->firstName . ' ' . $middleInitial . ' ' . $employee->lastName);
            })
            ->implode(', ');

        // Get authenticated user details
        $user = auth()->user();
        $middleInitial = $user->middleName ? strtoupper(substr($user->middleName, 0, 1)) . '.' : '';
        $fullName = $user->firstName . ' ' . $middleInitial . ' ' . $user->lastName;

        // Create audit trail
        AuditTrail::create([
            'user_id' => $user->id,
            'full_name' => $fullName,
            'role' => $user->role,
            'action' => "UPDATED SUB ACTIVITY {$oldSubActivityName} under {$activity->name}",
            'action_from' => ($oldSubActivityName !== $request->editActivityNameSub ? "SUB ACTIVITY: {$oldSubActivityName}\n" : "") .
                ($oldSuccessIndicator !== $request->editSuccessIndicatorSub ? "SUCCESS INDICATOR: {$oldSuccessIndicator}\n" : "") .
                ($oldQuality !== $request->editQualitySub ? "QUALITY: {$oldQuality}\n" : "") .
                ($oldEfficiency !== $request->editEfficiencySub ? "EFFICIENCY: {$oldEfficiency}\n" : "") .
                ($oldTimeliness !== $request->editTimelinessSub ? "TIMELINESS: {$oldTimeliness}\n" : "") .
                ($oldRemarks !== $request->editRemarksSub ? "REMARKS: {$oldRemarks}\n" : "") .
                "RESPONSIBLE PERSON: {$oldResponsibleEmployees}",
            'action_to' => ($oldSubActivityName !== $request->editActivityNameSub ? "SUB ACTIVITY: {$request->editActivityNameSub}\n" : "") .
                ($oldSuccessIndicator !== $request->editSuccessIndicatorSub ? "SUCCESS INDICATOR: {$request->editSuccessIndicatorSub}\n" : "") .
                ($oldQuality !== $request->editQualitySub ? "QUALITY: {$request->editQualitySub}\n" : "") .
                ($oldEfficiency !== $request->editEfficiencySub ? "EFFICIENCY: {$request->editEfficiencySub}\n" : "") .
                ($oldTimeliness !== $request->editTimelinessSub ? "TIMELINESS: {$request->editTimelinessSub}\n" : "") .
                ($oldRemarks !== $request->editRemarksSub ? "REMARKS: {$request->editRemarksSub}\n" : "") .
                "RESPONSIBLE PERSON: {$newResponsibleEmployees}",
            'activity_name' => $activity->name,
            'program_name' => $program->name,
            'record_id' => $subActivity->id
        ]);

        // Return a response
        return response()->json(['message' => 'Sub-Activity updated successfully!']);
    }

    // =====================Delete Sub-Activity========================= //
    public function deleteSubActivity(Request $request){
        try{
            $subActivity = SubActivity::findOrFail($request->subActivityId);
            $activity = Activity::findOrFail($subActivity->activity_id);
            $program = Program::findOrFail($activity->program_id);

             // Get authenticated user details before deletion
            $user = auth()->user();
            $middleInitial = $user->middleName ? strtoupper(substr($user->middleName, 0, 1)) . '.' : '';
            $fullName = $user->firstName . ' ' . $middleInitial . ' ' . $user->lastName;

            // Create audit trail before deletion
            AuditTrail::create([
                'user_id' => $user->id,
                'full_name' => $fullName,
                'role' => $user->role,
                'action' => "DELETED SUB ACTIVITY: {$subActivity->name} under ACTIVITY {$activity->name}",
                'action_from' => null,
                'action_to' => null,  // No 'to' state for deletions
                'program_name' => $program->name,
                'record_id' => $deletedSubActivityId
            ]);

                $subActivity->delete();

                return response()->json(['message' => 'Sub-activity deleted successfully!'], 200);
            } 
        catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // If sub-activity is not found
            return response()->json(['error' => 'Sub-activity not found!'], 404);
        } catch (\Exception $e) {
            // For any other errors
            return response()->json(['error' => 'An error occurred while trying to delete the sub-activity.'], 500);
        }
    }

    // =====================Activity========================= //
    public function addActivityInProgram(Request $request){
        $maxOrder = Activity::where('program_id', $request->programIdProg)->max('order') ?? 0;

        $activity = new Activity([
            'name' => $request->addActivityName,
            'successIndicator' => $request->addSuccessIndicator,
            'quality' => $request->addQuality,
            'efficiency' => $request->addEfficiency,
            'timeliness' => $request->addTimeliness,
            'remarks' => $request->addRemarks,
            'program_id' => $request->programIdProg,
            'order' => $maxOrder + 1,
        ]);

        // Find the program and associate the activity with it
        $program = Program::findOrFail($request->programIdProg);
        $program->activities()->save($activity);

        if ($request->has('addAccountableId')) {
            $activity->employees()->attach($request->addAccountableId);
        }

        // Get the responsible employees after creation
        $responsibleEmployees = $activity->employees()
            ->get()
            ->map(function ($employee) {
                $middleInitial = $employee->middleName ? strtoupper(substr($employee->middleName, 0, 1)) . '.' : '';
                return trim($employee->firstName . ' ' . $middleInitial . ' ' . $employee->lastName);
            })
            ->implode(', ');

        // Get authenticated user details
        $user = auth()->user();
        $middleInitial = $user->middleName ? strtoupper(substr($user->middleName, 0, 1)) . '.' : '';
        $fullName = $user->firstName . ' ' . $middleInitial . ' ' . $user->lastName;

        // Create audit trail
        AuditTrail::create([
            'user_id' => $user->id,
            'full_name' => $fullName,
            'role' => $user->role,
            'action' => "ADDED ACTIVITY under {$program->name}",
            'action_from' => null,  // No previous value for new items
            'action_to' => "Activity Name: {$request->addActivityName}\n" .
                "SUCCESS INDICATOR: {$request->addSuccessIndicator}\n" .
                "QUALITY: {$request->addQuality}\n" .
                "EFFICIENCY: {$request->addEfficiency}\n" .
                "TIMELINESS: {$request->addTimeliness}\n" .
                "REMARKS: {$request->addRemarks}\n" .
                "RESPONSIBLE PERSON: {$responsibleEmployees}",
            'program_name' => $program->name,
            'record_id' => $activity->id,
            'activity_name' => $activity->name
        ]);

        return response()->json(['message' => 'Activity added successfully!']);
    }

    public function updateActivity(Request $request){
        // Find the activity and update it
        $activity = Activity::findOrFail($request->editActivityId);

        // Save the old values before update
        $oldName = $activity->name;
        $oldSuccessIndicator = $activity->successIndicator;
        $oldQuality = $activity->quality;
        $oldEfficiency = $activity->efficiency;
        $oldTimeliness = $activity->timeliness;
        $oldRemarks = $activity->remarks;

        // Get the old responsible employees before update
        $oldResponsibleEmployees = $activity->employees()
            ->get()
            ->map(function ($employee) {
                $middleInitial = $employee->middleName ? strtoupper(substr($employee->middleName, 0, 1)) . '.' : '';
                return trim($employee->firstName . ' ' . $middleInitial . ' ' . $employee->lastName);
            })
            ->implode(', ');

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

        // Get the new responsible employees after update
        $newResponsibleEmployees = $activity->employees()
            ->get()
            ->map(function ($employee) {
                $middleInitial = $employee->middleName ? strtoupper(substr($employee->middleName, 0, 1)) . '.' : '';
                return trim($employee->firstName . ' ' . $middleInitial . ' ' . $employee->lastName);
            })
            ->implode(', ');

        // Get authenticated user details
        $user = auth()->user();
        $middleInitial = $user->middleName ? strtoupper(substr($user->middleName, 0, 1)) . '.' : '';
        $fullName = $user->firstName . ' ' . $middleInitial . ' ' . $user->lastName;

        // Get the program name
        $program = Program::findOrFail($activity->program_id);

        // Create audit trail
        AuditTrail::create([
            'user_id' => $user->id,
            'full_name' => $fullName,
            'role' => $user->role,
            'action' => "UPDATED ACTIVITY {$oldName} under {$program->name}",
            'action_from' => ($oldName !== $request->editActivityName ? "Activity Name: {$oldName}\n" : "") .
                ($oldSuccessIndicator !== $request->editSuccessIndicatorActivity ? "SUCCESS INDICATOR: {$oldSuccessIndicator}\n" : "") .
                ($oldQuality !== $request->editQualityActivity ? "QUALITY: {$oldQuality}\n" : "") .
                ($oldEfficiency !== $request->editEfficiencyActivity ? "EFFICIENCY: {$oldEfficiency}\n" : "") .
                ($oldTimeliness !== $request->editTimelinessActivity ? "TIMELINESS: {$oldTimeliness}\n" : "") .
                ($oldRemarks !== $request->editRemarksActivity ? "REMARKS: {$oldRemarks}\n" : "") .
                ($oldResponsibleEmployees !== $newResponsibleEmployees ? "RESPONSIBLE PERSON: {$oldResponsibleEmployees}\n" : ""),
            'action_to' => ($oldName !== $request->editActivityName ? "Activity Name: {$request->editActivityName}\n" : "") .
                ($oldSuccessIndicator !== $request->editSuccessIndicatorActivity ? "SUCCESS INDICATOR: {$request->editSuccessIndicatorActivity}\n" : "") .
                ($oldQuality !== $request->editQualityActivity ? "QUALITY: {$request->editQualityActivity}\n" : "") .
                ($oldEfficiency !== $request->editEfficiencyActivity ? "EFFICIENCY: {$request->editEfficiencyActivity}\n" : "") .
                ($oldTimeliness !== $request->editTimelinessActivity ? "TIMELINESS: {$request->editTimelinessActivity}\n" : "") .
                ($oldRemarks !== $request->editRemarksActivity ? "REMARKS: {$request->editRemarksActivity}\n" : "") .
                ($oldResponsibleEmployees !== $newResponsibleEmployees ? "RESPONSIBLE PERSON: {$newResponsibleEmployees}\n" : ""),
            'program_name' => $program->name,
            'record_id' => $activity->id,
            'activity_name' => $activity->name
        ]);

        // Return a response (this is what your AJAX call will use)
        return response()->json(['message' => 'Activity updated successfully!']);
    }

    public function deleteActivity(Request $request) {
        try {
            // Find the activity by its ID
            $activity = Activity::findOrFail($request->activityId);

            // Get authenticated user details before deletion
            $user = auth()->user();
            $middleInitial = $user->middleName ? strtoupper(substr($user->middleName, 0, 1)) . '.' : '';
            $fullName = trim($user->firstName . ' ' . $middleInitial . ' ' . $user->lastName);

            // Find the program related to the activity
            $program = Program::findOrFail($activity->program_id);

            // Insert audit trail before deleting
            AuditTrail::create([
                'user_id' => $user->id,
                'full_name' => $fullName,
                'role' => $user->role,
                'action' => "DELETED ACTIVITY under {$program->name}",
                'action_from' => null,
                'action_to' => null,  // No 'to' state for deletions
                'program_name' => $program->name,
                'record_id' => $activity->id,
                'activity_name' => $activity->name
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
            
            $maxOrder = Program::max('order') ?? 0 ;

            // Create the program
            $program = Program::create([
                'name' => $request->addProgramName,
                'successIndicator' => $request->addSuccessIndicator,
                'quality' => $request->addQuality,
                'efficiency' => $request->addEfficiency,
                'timeliness' => $request->addTimeliness,
                'remarks' => $request->addRemarks,
                'budget' => $request->addBudget,
                'order' => $maxOrder + 1,
            ]);

            // Check if 'all' is selected
            if (in_array('all', $request->divisions)) {
                $allDivisionIds = \App\Models\Division::pluck('id')->toArray();
                $program->divisions()->attach($allDivisionIds);
            } else {
                $program->divisions()->attach($request->divisions);
            }

            // Audit Trail for adding program
            $user = auth()->user();
            $middleInitial = $user->middleName ? strtoupper(substr($user->middleName, 0, 1)) . '.' : '';
            $fullName = trim($user->firstName . ' ' . $middleInitial . ' ' . $user->lastName);

            // Get the divisions after creation
            $divisions = $program->divisions()
                ->get()
                ->pluck('name')
                ->implode(', ');

            AuditTrail::create([
                'user_id' => $user->id,
                'full_name' => $fullName,
                'role' => $user->role,
                'action' => "ADDED PROGRAM",
                'action_from' => null,  // No previous value for new items
                'action_to' => "Program Name: {$program->name}\n" .
                "SUCCESS INDICATOR: {$program->successIndicator}\n" .
                "QUALITY: {$program->quality}\n" .
                "EFFICIENCY: {$program->efficiency}\n" .
                "TIMELINESS: {$program->timeliness}\n" .
                "REMARKS: {$program->remarks}\n" .
                "BUDGET: {$program->budget}\n" .
                "DIVISIONS: {$divisions}",
                'program_name' => $program->name,
                'record_id' => $program->id
            ]);

            return redirect()->back()->with('success', 'Program added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while adding the program.');
        }
    }


    public function updateProgram(Request $request)
    {
        try {
            // Find the program
            $program = Program::findOrFail($request->editProgramId);

            // Save the old values before update
            $oldName = $program->name;
            $oldSuccessIndicator = $program->successIndicator;
            $oldQuality = $program->quality;
            $oldEfficiency = $program->efficiency;
            $oldTimeliness = $program->timeliness;
            $oldRemarks = $program->remarks;
            $oldBudget = $program->budget;

            // Get the old divisions before update
            $oldDivisions = $program->divisions()
                ->get()
                ->pluck('name')
                ->implode(', ');

            // Update fields
            $program->name = $request->editProgramName;
            $program->successIndicator = $request->editSuccessIndicator;
            $program->quality = $request->editQuality;
            $program->efficiency = $request->editEfficiency;
            $program->timeliness = $request->editTimeliness;
            $program->remarks = $request->editRemarks;
            $program->budget = $request->editBudget;
            $program->save();

            // Handle "all" divisions
            if (in_array('all', $request->divisions)) {
                $allDivisionIds = \App\Models\Division::pluck('id')->toArray();
                $program->divisions()->sync($allDivisionIds);
            } else {
                $program->divisions()->sync($request->divisions);
            }

            // Get the new divisions after update
            $newDivisions = $program->divisions()
                ->get()
                ->pluck('name')
                ->implode(', ');

            // Audit Trail for updating program
            $user = auth()->user();
            $middleInitial = $user->middleName ? strtoupper(substr($user->middleName, 0, 1)) . '.' : '';
            $fullName = trim($user->firstName . ' ' . $middleInitial . ' ' . $user->lastName);

            AuditTrail::create([
                'user_id' => $user->id,
                'full_name' => $fullName,
                'role' => $user->role,
                'action' => "UPDATED PROGRAM {$oldName}",
                'action_from' => ($oldName !== $request->editProgramName ? "Program Name: {$oldName}\n" : "") .
                    ($oldSuccessIndicator !== $request->editSuccessIndicator ? "SUCCESS INDICATOR: {$oldSuccessIndicator}\n" : "") .
                    ($oldQuality !== $request->editQuality ? "QUALITY: {$oldQuality}\n" : "") .
                    ($oldEfficiency !== $request->editEfficiency ? "EFFICIENCY: {$oldEfficiency}\n" : "") .
                    ($oldTimeliness !== $request->editTimeliness ? "TIMELINESS: {$oldTimeliness}\n" : "") .
                    ($oldRemarks !== $request->editRemarks ? "REMARKS: {$oldRemarks}\n" : "") .
                    ($oldBudget !== $request->editBudget ? "ALLOTTED BUDGET: {$oldBudget}\n" : "") .
                    ($oldDivisions !== $newDivisions ? "DIVISIONS: {$oldDivisions}\n" : ""),
                'action_to' => ($oldName !== $request->editProgramName ? "Program Name: {$request->editProgramName}\n" : "") .
                    ($oldSuccessIndicator !== $request->editSuccessIndicator ? "SUCCESS INDICATOR: {$request->editSuccessIndicator}\n" : "") .
                    ($oldQuality !== $request->editQuality ? "QUALITY: {$request->editQuality}\n" : "") .
                    ($oldEfficiency !== $request->editEfficiency ? "EFFICIENCY: {$request->editEfficiency}\n" : "") .
                    ($oldTimeliness !== $request->editTimeliness ? "TIMELINESS: {$request->editTimeliness}\n" : "") .
                    ($oldRemarks !== $request->editRemarks ? "REMARKS: {$request->editRemarks}\n" : "") .
                    ($oldBudget !== $request->editBudget ? "ALLOTTED BUDGET: {$request->editBudget}\n" : "") .
                    ($oldDivisions !== $newDivisions ? "DIVISIONS: {$newDivisions}\n" : ""),
                'program_name' => $program->name,
                'record_id' => $program->id
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Program not found.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the program.');
        }
    }

    public function deleteProgram(Request $request) {
        try {
            // Find the program
            $program = Program::findOrFail($request->programId);

            // Audit Trail for deleting program
            $user = auth()->user();
            $middleInitial = $user->middleName ? strtoupper(substr($user->middleName, 0, 1)) . '.' : '';
            $fullName = trim($user->firstName . ' ' . $middleInitial . ' ' . $user->lastName);

            AuditTrail::create([
                'user_id' => $user->id,
                'full_name' => $fullName,
                'role' => $user->role,
                'action' => "DELETED PROGRAM {$program->name}",
                'action_from' => null,
                'action_to' => null,  // No 'to' state for deletions
                'program_name' => $program->name,
                'record_id' => $program->id
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
    public function getAccountableByIds(Request $request) {
        $divisionIds = $request->input('divisionIds', []);

        if (empty($divisionIds)) {
            return response()->json([]);
        }

        $accountables = Employee::whereIn('role', ['Staff', 'Division Chief']) // Include both roles
            ->get();

        $results = $accountables->map(function ($employee) {
            $middleInitial = $employee->middleName ? strtoupper(substr($employee->middleName, 0, 1)) . '. ' : '';
            return [
                'id' => $employee->id,
                'name' => $employee->firstName . ' ' . $middleInitial . $employee->lastName,
                'role' => $employee->role,
                'position' => $employee->position,
            ];
        })->sortBy('name')->values(); // Sort and reindex

        return response()->json($results);
    }

    // =====================Autofill Responsible Division (Edit Program)========================= //
    public function getDivisionResponsible($id){
        $program = Program::with('divisions')->findOrFail($id);
        return response()->json($program->divisions);
    }

    // =====================Autofill Responsible Individual (Edit Activity)========================= //
    public function getActivityAccountables($id) {
        $activity = Activity::with('employees')->findOrFail($id);

        $employees = $activity->employees->map(function ($e) {
            $middleInitial = $e->middleName ? strtoupper(substr($e->middleName, 0, 1)) . '. ' : '';
            return [
                'id' => $e->id,
                'name' => $e->firstName . ' ' . $middleInitial . $e->lastName,
                'position' => $e->position,
            ];
        })->sortBy('name')->values(); // Sort alphabetically and reindex

        return response()->json($employees);
    }

    public function fetchEmployee($activityId) {
        $activity = Activity::findOrFail($activityId);

        $employees = Employee::all()->map(function ($e) {
            $middleInitial = $e->middleName ? strtoupper(substr($e->middleName, 0, 1)) . '. ' : '';
            return [
                'id' => $e->id,
                'name' => $e->firstName . ' ' . $middleInitial . $e->lastName,
                'position' => $e->position,
            ];
        });

        return response()->json($employees->unique('id')->sortBy('name')->values());
    }

    // =====================Autofill Responsible Individual (Edit SubActivity)========================= //
    public function getSubActivityAccountables($id) {
        $subActivity = SubActivity::with('employees')->findOrFail($id);

        $employees = $subActivity->employees->map(function ($e) {
            $middleInitial = $e->middleName ? strtoupper(substr($e->middleName, 0, 1)) . '. ' : '';
            return [
                'id' => $e->id,
                'name' => $e->firstName . ' ' . $middleInitial . $e->lastName,
                'position' => $e->position,
            ];
        })->sortBy('name')->values(); // Sort by name and reset the index

        return response()->json($employees);
    }

    public function fetchEmployeeSub($subActivityId) {
        $subActivity = SubActivity::findOrFail($subActivityId);

        // Get all employees instead of filtering by divisions
        $employees = Employee::all()->map(function ($e) {
            $middleInitial = $e->middleName ? strtoupper(substr($e->middleName, 0, 1)) . '. ' : '';
            return [
                'id' => $e->id,
                'name' => $e->firstName . ' ' . $middleInitial . $e->lastName,
                'position' => $e->position,
            ];
        });

        return response()->json($employees->unique('id')->sortBy('name')->values());
    }
}
