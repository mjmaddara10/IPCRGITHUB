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
    }

    // =====================Update Sub-Activity========================= //
    public function updateSubActivity(Request $request){
        // Find the sub-activity and update it
        $subActivity = SubActivity::findOrFail($request->editActivityIdSub);
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
        if ($request->has('editAccountableId')) {
            $subActivity->employees()->sync($request->editAccountableId);
        }

        // Return a response (this is what your AJAX call will use)
        return response()->json(['message' => 'Sub-Activity updated successfully!']);
    }

    // =====================Delete Sub-Activity========================= //
    public function deleteSubActivity(Request $request){
        try{
            $subActivity = SubActivity::findOrFail($request->subActivityId);
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
        ]);

        // Find the program and associate the activity with it
        $program = Program::findOrFail($request->programIdProg);
        $program->activities()->save($activity);
        $selectedActivity->save();

        if ($request->has('addAccountableId')) {
            // $selectedActivity->employees()->attach($request->addAccountableId);
            $activity->employees()->attach($request->addAccountableId);
        }
    }

    public function updateActivity(Request $request){
        // dd($request->all());
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
        if ($request->has('editAccountableId')) {
            $activity->employees()->sync($request->editAccountableId);
        }

        // Return a response (this is what your AJAX call will use)
        return response()->json(['message' => 'Activity updated successfully!']);
    }

    public function deleteActivity(Request $request){
        try{
            $activity = Activity::findOrFail($request->activityId);
            $activity->delete();

            return response()->json(['message' => 'Activity deleted successfully!'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // If activity is not found
            return response()->json(['error' => 'Activity not found!'], 404);
        } catch (\Exception $e) {
            // For any other errors
            return response()->json(['error' => 'An error occurred while trying to delete the activity.'], 500);
        }
    }

    // =====================Program========================= //
    public function addProgram(Request $request){
        $program = Program::create([
            'name' => $request->addProgramName,
            'successIndicator' => $request->addSuccessIndicator,
            'quality' => $request->addQuality,
            'efficiency' => $request->addEfficiency,
            'timeliness' => $request->addTimeliness,
            'remarks' => $request->addRemarks,
        ]);
    
        // Check if 'all' is selected
        if (in_array('all', $request->divisions)) {
            $allDivisionIds = \App\Models\Division::pluck('id')->toArray();
            $program->divisions()->attach($allDivisionIds);
        } else {
            $program->divisions()->attach($request->divisions);
        }
    
        return redirect()->back()->with('success', 'Program added successfully.');
    }

    public function updateProgram(Request $request){
        // Find the program and update it
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
    
        return redirect()->back()->with('success', 'Program updated successfully.');
    }
    
    public function deleteProgram(Request $request){
        try{
            $program = Program::findOrFail($request->programId);
            $program->delete();

            return response()->json(['message' => 'Program deleted successfully!'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // If project is not found
            return response()->json(['error' => 'Program not found!'], 404);
        } catch (\Exception $e) {
            // For any other errors
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
