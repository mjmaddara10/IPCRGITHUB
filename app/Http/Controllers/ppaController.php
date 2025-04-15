<?php

namespace App\Http\Controllers;

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
    public function addActivity(Request $request){
        $activity = new Activity([
            'name' => $request->addActivityName,
            'successIndicator' => $request->addSuccessIndicator,
            'quality' => $request->addQuality,
            'efficiency' => $request->addEfficiency,
            'timeliness' => $request->addTimeliness,
            'remarks' => $request->addRemarks,
            'project_id' => $request->projectId,
        ]);
    
        // Find the project and associate the activity with it
        $project = Project::findOrFail($request->projectId);
        $project->activities()->save($activity);
    }

    public function updateActivity(Request $request){
        // Find the activity and update it
        $activity = Activity::findOrFail($request->activityId);
        $activity->update([
            'name' => $request->editActivityName,
            'successIndicator' => $request->editSuccessIndicator,
            'quality' => $request->editQuality,
            'efficiency' => $request->editEfficiency,
            'timeliness' => $request->editTimeliness,
            'remarks' => $request->editRemarks,
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

    // =====================Project========================= //
    public function addProject(Request $request){
        $project = new Project([
            'name' => $request->addProjectName,
            'successIndicator' => $request->addSuccessIndicatorProject,
            'quality' => $request->addQualityProject,
            'efficiency' => $request->addEfficiencyProject,
            'timeliness' => $request->addTimelinessProject,
            'remarks' => $request->addRemarksProject,
            'program_id' => $request->programId,
        ]);
    
        // Find the project and associate the sub-project with it
        $program = Program::findOrFail($request->programId);
        $program->projects()->save($project);
    }

    public function updateProject(Request $request){
        // Find the project and update it
        $project = Project::findOrFail($request->editProjectId);
        $project->update([
            'id'=> $request->editProjectId,
            'name' => $request->editProjectName,
        ]);

        // Return a response (this is what your AJAX call will use)
        return response()->json(['message' => 'Project updated successfully!']);
    }

    public function deleteProject(Request $request){
        try{
            $project = Project::findOrFail($request->projectId);
            $project->delete();

            return response()->json(['message' => 'Project deleted successfully!'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // If project is not found
            return response()->json(['error' => 'Project not found!'], 404);
        } catch (\Exception $e) {
            // For any other errors
            return response()->json(['error' => 'An error occurred while trying to delete the project.'], 500);
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

    /*public function filterProgram(Request $request) {
        $divisionId = $request->query('division_id');

        // If 'all' is selected, get programs assigned to all divisions
        if ($divisionId == 'all') {
            $programs = Program::whereHas('divisions')->get(); // All programs with at least one division assigned
        } else {
            // Otherwise, get programs assigned to the selected division
            $programs = Program::whereHas('divisions', function ($query) use ($divisionId) {
                $query->where('id', $divisionId);
            })->get();
        }

        // Return programs as JSON
        return response()->json([
            'programs' => $programs
        ]);
    }*/

    // =====================Sub-Project========================= //
    public function addSubProject(Request $request){
        $subProject = new SubProject([
            'name' => $request->addSubProjectTitle,
            'successIndicator' => $request->addSuccessIndicatorSubProject,
            'quality' => $request->addQualitySubProject,
            'efficiency' => $request->addEfficiencySubProject,
            'timeliness' => $request->addTimelinessSubProject,
            'remarks' => $request->addRemarksSubProject,
            'project_id' => $request->projectIdSub,
        ]);
    
        // Find the project and associate the sub-project with it
        $project = Project::findOrFail($request->projectIdSub);
        $project->subProjects()->save($subProject);
    }

    public function updateSubProject(Request $request){
        // Find the project and update it
        $subProject = SubProject::findOrFail($request->editSubProjectId);
        $subProject->update([
            'id'=> $request->editSubProjectId,
            'name' => $request->editSubProjectName,
            'successIndicator' => $request->editSuccessIndicatorSubProject,
            'quality' => $request->editQualitySubProject,
            'efficiency' => $request->editEfficiencySubProject,
            'timeliness' => $request->editTimelinessSubProject,
            'remarks' => $request->editRemarksSubProject,
        ]);

        // Return a response (this is what your AJAX call will use)
        return response()->json(['message' => 'Project updated successfully!']);
    }

    public function deleteSubProject(Request $request){
        try{
            $subProject = SubProject::findOrFail($request->subProjectId);
            $subProject->delete();

            return response()->json(['message' => 'Sub-Project deleted successfully!'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // If project is not found
            return response()->json(['error' => 'Project not found!'], 404);
        } catch (\Exception $e) {
            // For any other errors
            return response()->json(['error' => $e->getMessage()], 500);
            // return response()->json(['error' => 'An error occurred while trying to delete the project.'], 500);
        }
    }

    // =====================Add Activity in Sub-Project========================= //
    public function addActivityInSub(Request $request){
        $activity = new Activity([
            'name' => $request->addActivityName,
            'successIndicator' => $request->addSuccessIndicator,
            'quality' => $request->addQuality,
            'efficiency' => $request->addEfficiency,
            'timeliness' => $request->addTimeliness,
            'remarks' => $request->addRemarks,
            'subProjectId' => $request->subProjectId,
        ]);
    
        // Find the sub-project and associate the activity with it
        $subProject = SubProject::findOrFail($request->subProjectId);
        $subProject->activities()->save($activity);
    }

    // =====================Add Activity in Program========================= //
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

    // =====================Autofill Accountable========================= //
    /*public function getAccountable($divisionName){
        dd($divisionName);
        $accountable = Employee::where('division', $divisionName)
        ->where('role', "Department Chief") // or however you define responsibility
        ->first();
    
        if ($accountable) {
            return response()->json($accountable);
        } else {
            return response()->json(['error' => 'No accountable found'], 404);
        }
    }*/

    // Test
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
}
