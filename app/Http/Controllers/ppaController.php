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

class ppaController extends Controller
{
    // =====================Add Sub-Activity========================= //
    public function addSubActivity(Request $request){
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

        if ($request->has('addAccountableId')) {
            // $selectedActivity->employees()->attach($request->addAccountableId);
            $subActivity->employees()->attach($request->addAccountableId);
        }

       // Get authenticated user details from Employee model
        $user = auth()->user();
        $middleInitial = $user->middleName ? strtoupper(substr($user->middleName, 0, 1)) . '.' : '';
        $fullName = $user->firstName . ' ' . $middleInitial . ' ' . $user->lastName;

        // Create audit trail
        DB::table('audit_trails')->insert([
            'user_id' => auth()->id(),
            'full_name' => $fullName,
            'role' => $user->role,
            'action' => 'Added Sub Activity: ' . $request->addSubActivityName,
            'activity_name' => $activity->name,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json(['message' => 'Sub-activity added successfully!']);
    }

    // =====================Update Sub-Activity========================= //
    public function updateSubActivity(Request $request){
        // Find the sub-activity and update it
        $subActivity = SubActivity::findOrFail($request->editActivityIdSub);

        // Get the activity name before update
        $activity = Activity::findOrFail($subActivity->activity_id);

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
        $fullName = $user->firstName . ' ' . $middleInitial . ' ' . $user->lastName;

        // Create audit trail
        DB::table('audit_trails')->insert([
            'user_id' => auth()->id(),
            'full_name' => $fullName,
            'role' => $user->role,
            'action' => 'Updated Sub Activity: ' . $request->editActivityNameSub,
            'activity_name' => $activity->name,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Return a response
        return response()->json(['message' => 'Sub-Activity updated successfully!']);
    }

    // =====================Delete Sub-Activity========================= //
    public function deleteSubActivity(Request $request){
        try{
            $subActivity = SubActivity::findOrFail($request->subActivityId);
             // Get authenticated user details before deletion
        $user = auth()->user();
        $middleInitial = $user->middleName ? strtoupper(substr($user->middleName, 0, 1)) . '.' : '';
        $fullName = $user->firstName . ' ' . $middleInitial . ' ' . $user->lastName;

        // Create audit trail before deletion
        DB::table('audit_trails')->insert([
            'user_id' => auth()->id(),
            'full_name' => $fullName,
            'role' => $user->role,
            'action' => 'Deleted Sub Activity',
            'activity_name' => $subActivity->name,
            'created_at' => now(),
            'updated_at' => now()
        ]);
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
    public function addActivityInProgram(Request $request){
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

        // Find the program and associate the activity with it
        $program = Program::findOrFail($request->programIdProg);
        $program->activities()->save($activity);
        $selectedActivity->save();

        if ($request->has('addAccountableId')) {
            // $selectedActivity->employees()->attach($request->addAccountableId);
            $activity->employees()->attach($request->addAccountableId);
        }

        // Get authenticated user details
        $user = auth()->user();
        $middleInitial = $user->middleName ? strtoupper(substr($user->middleName, 0, 1)) . '.' : '';
        $fullName = $user->firstName . ' ' . $middleInitial . ' ' . $user->lastName;

        // Create audit trail
        DB::table('audit_trails')->insert([
            'user_id' => auth()->id(),
            'full_name' => $fullName,
            'role' => $user->role,
            'action' => 'Added Activity: ' . $request->addActivityName,
            'activity_name' => $program->name,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json(['message' => 'Activity added successfully!']);
    }

    public function updateActivity(Request $request){
        // Find the activity and update it
        $activity = Activity::findOrFail($request->editActivityId);
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
        $fullName = $user->firstName . ' ' . $middleInitial . ' ' . $user->lastName;

        // Get the program name
        $activity = Program::findOrFail($activity->program_id);

        // Create audit trail
        DB::table('audit_trails')->insert([
            'user_id' => auth()->id(),
            'full_name' => $fullName,
            'role' => $user->role,
            'action' => 'Updated Activity: ' . $request->editActivityName,
            'activity_name' => $activity->name,
            'created_at' => now(),
            'updated_at' => now()
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
            DB::table('audit_trails')->insert([
                'user_id'       => auth()->id(),
                'full_name'     => $fullName,
                'role'          => $user->role,
                'action'        => 'Deleted Activity: ' . $activity->name,
                'activity_name' => $program->name,
                'created_at'    => now(),
                'updated_at'    => now()
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

            DB::table('audit_trails')->insert([
                'user_id'       => auth()->id(),
                'full_name'     => $fullName,
                'role'          => $user->role,
                'action'        => 'Added Program: ' . $program->name,
                'activity_name' => $program->name, // storing program name as activity_name
                'created_at'    => now(),
                'updated_at'    => now(),
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

            // Update fields
            $program->name = $request->editProgramName;
            $program->successIndicator = $request->editSuccessIndicator;
            $program->quality = $request->editQuality;
            $program->efficiency = $request->editEfficiency;
            $program->timeliness = $request->editTimeliness;
            $program->remarks = $request->editRemarks;
            $program->save();

            // Handle "all" divisions
            if (in_array('all', $request->divisions)) {
                $allDivisionIds = \App\Models\Division::pluck('id')->toArray();
                $program->divisions()->sync($allDivisionIds);
            } else {
                $program->divisions()->sync($request->divisions);
            }

            // Audit Trail for updating program
            $user = auth()->user();
            $middleInitial = $user->middleName ? strtoupper(substr($user->middleName, 0, 1)) . '.' : '';
            $fullName = trim($user->firstName . ' ' . $middleInitial . ' ' . $user->lastName);

            DB::table('audit_trails')->insert([
                'user_id'       => auth()->id(),
                'full_name'     => $fullName,
                'role'          => $user->role,
                'action'        => 'Updated Program: ' . $program->name,
                'activity_name' => $program->name,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);

            return redirect()->back()->with('success', 'Program updated successfully.');
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

            DB::table('audit_trails')->insert([
                'user_id'       => auth()->id(),
                'full_name'     => $fullName,
                'role'          => $user->role,
                'action'        => 'Deleted Program: ' . $program->name,
                'activity_name' => $program->name, // storing program name as activity_name
                'created_at'    => now(),
                'updated_at'    => now(),
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
        });

        return response()->json($employees);
    }

    public function fetchEmployee($activityId) {
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
    public function getSubActivityAccountables($id) {
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

    public function fetchEmployeeSub($subActivityId) {
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
