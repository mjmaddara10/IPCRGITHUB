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

class ppaController extends Controller
{
    // =====================Activity========================= //
    public function addActivityInProgram(Request $request){
        $activity = new Activity([
            'name' => $request->addActivityName,
            'successIndicator' => $request->addSuccessIndicator,
            'quality' => $request->addQuality,
            'efficiency' => $request->addEfficiency,
            'timeliness' => $request->addTimeliness,
            'remarks' => $request->addRemarks,
            'accountable' => $request->addAccountable,
            'program_Id' => $request->programIdProg,
        ]);

        // Find the program and associate the activity with it
        $program = Program::findOrFail($request->programIdProg);
        $program->activities()->save($activity);
    }

    public function updateActivity(Request $request){
        // Find the activity and update it
        $activity = Activity::findOrFail($request->activityId);
        $activity->update([
            'name' => $request->editActivityName,
            'successIndicator' => $request->editSuccessIndicatorActivity,
            'quality' => $request->editQualityActivity,
            'efficiency' => $request->editEfficiencyActivity,
            'timeliness' => $request->editTimelinessActivity,
            'remarks' => $request->editRemarksActivity,
        ]);

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

    // =====================Autofill Accountable (Add Activity)========================= //
    public function getAccountable($divisionName){
        $accountable = Employee::whereRaw('LOWER(division) = ?', [strtolower($divisionName)])
            ->where('role', 'Department Chief')
            ->get();
    
        if ($accountable->isEmpty()) {
            return response()->json([], 404);
        }
    
        $results = $accountable->map(function ($a) {
            $middleInitial = $a->middleName ? strtoupper(substr($a->middleName, 0, 1)) . '. ' : '';
            return [
                'id' => $a->id,
                'name' => $a->firstName . ' ' . $middleInitial . $a->lastName,
            ];
        });
    
        return response()->json($results);
    }

    public function getAccountableMultiple(Request $request) {
        $divisionNames = $request->input('divisionNames', []);

        if (empty($divisionNames)) {
            return response()->json([], 400);
        }

        $accountable = Employee::whereIn(DB::raw('LOWER(division)'), array_map('strtolower', $divisionNames))
            ->where('role', 'Department Chief')
            ->get();

        $results = $accountable->map(function ($a) {
            $middleInitial = $a->middleName ? strtoupper(substr($a->middleName, 0, 1)) . '. ' : '';
            return [
                'id' => $a->id,
                'name' => $a->firstName . ' ' . $middleInitial . $a->lastName,
            ];
        });

        return response()->json($results);
    }

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
                'role' => $employee->role, // include role for display in the dropdown
            ];
        });

        return response()->json($results);
    }

    // =====================Autofill Responsible Division (Edit Program)========================= //
    public function getDivisionResponsible($id){
        $program = Program::with('divisions')->findOrFail($id);
        return response()->json($program->divisions);
    }

}
