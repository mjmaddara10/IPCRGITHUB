<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Project;

class ppaController extends Controller
{
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


}
