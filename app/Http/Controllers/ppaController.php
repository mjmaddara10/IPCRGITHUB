<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Project;
use App\Models\Program;
use App\Models\SubProject;

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
        $program = new Program();
        $program->name = $request->addProgramName;
        $program->save();
    }

    public function updateProgram(Request $request){
        // Find the program and update it
        $program = Program::findOrFail($request->editProgramId);
        $program->update([
            'id'=> $request->editProgramId,
            'name' => $request->editProgramName,
        ]);

        // Return a response (this is what your AJAX call will use)
        return response()->json(['message' => 'Program updated successfully!']);
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

    // =====================Sub-Project========================= //
    public function addSubProject(Request $request){
        $subProject = new SubProject([
            'name' => $request->addSubProjectTitle,
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

    
}
