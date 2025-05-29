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
use App\Models\AuditTrail;
use App\Models\ProgramRequest;
use App\Models\ActivityRequest;
use App\Models\SubActivityRequest;
use App\Models\GassRequest;

class requestPpaController extends Controller
{
    // ====================== Program ====================== //
    public function addProgramRequest(Request $request) {
        $addProgramRequest = ProgramRequest::create([
            'requestor' => auth()->id(),
            'name' => $request->addProgramName,
            'successIndicator' => $request->addSuccessIndicator,
            'quality' => $request->addQuality,
            'efficiency' => $request->addEfficiency,
            'timeliness' => $request->addTimeliness,
            'remarks' => $request->addRemarks,
            'budget' => $request->addBudget,
            'action' => "add",
        ]);

        if (in_array('all', $request->divisions)) {
            $allDivisionIds = \App\Models\Division::pluck('id')->toArray();
            $addProgramRequest->divisions()->attach($allDivisionIds);
        } else {
            $addProgramRequest->divisions()->attach($request->divisions);
        }
        
        return redirect()->back()->with('status', 'Add request submitted for approval.');
    }

    public function editProgramRequest(Request $request) {
        $editProgramRequest = ProgramRequest::create([
            'requestor' => auth()->id(),
            'name' => $request->editProgramName,
            'program_id' => $request->editProgramId,
            'successIndicator' => $request->editSuccessIndicator,
            'quality' => $request->editQuality,
            'efficiency' => $request->editEfficiency,
            'timeliness' => $request->editTimeliness,
            'remarks' => $request->editRemarks,
            'budget' => $request->editBudget,
            'action' => "edit",
        ]);

        if (in_array('all', $request->divisions)) {
            $allDivisionIds = \App\Models\Division::pluck('id')->toArray();
            $editProgramRequest->divisions()->attach($allDivisionIds);
        } else {
            $editProgramRequest->divisions()->attach($request->divisions);
        }
        
        return redirect()->back()->with('status', 'Edit request submitted for approval.');
    }

    public function deleteProgramRequest(Request $request) {
        $deleteProgramRequest = ProgramRequest::create([
            'requestor' => auth()->id(),
            'name' => $request->deleteProgramName,
            'program_id' => $request->deleteProgramId,
            'successIndicator' => $request->deleteProgramSuccessIndicator,
            'quality' => $request->deleteProgramQuality,
            'efficiency' => $request->deleteProgramEfficiency,
            'timeliness' => $request->deleteProgramTimeliness,
            'remarks' => $request->deleteProgramRemarks,
            'budget' => $request->deleteProgramBudget,
            'action' => "delete",
        ]);
    }

    // ====================== Activity ====================== //
    public function addActivityRequest(Request $request) {
        $addActivityRequest = ActivityRequest::create([
            'program_id' => $request->programIdProg,
            'requestor' => auth()->id(),
            'name' => $request->addActivityName,
            'successIndicator' => $request->addSuccessIndicator,
            'quality' => $request->addQuality,
            'efficiency' => $request->addEfficiency,
            'timeliness' => $request->addTimeliness,
            'remarks' => $request->addRemarks,
            'budget' => $request->addBudget,
            'action' => "add",
        ]);

        $program = Program::findOrFail($request->programIdProg);
        $program->activityRequests()->save($addActivityRequest);

        if ($request->has('addAccountableId')) {
            $addActivityRequest->employees()->attach($request->addAccountableId);
        }
        
        return redirect()->back()->with('status', 'Add request submitted for approval.');
    }

    public function editActivityRequest(Request $request) {
        $editActivityRequest = ActivityRequest::create([
            'requestor' => auth()->id(),
            'name' => $request->editActivityName,
            'activity_id' => $request->editActivityId,
            'successIndicator' => $request->editSuccessIndicatorActivity,
            'quality' => $request->editQualityActivity,
            'efficiency' => $request->editEfficiencyActivity,
            'timeliness' => $request->editTimelinessActivity,
            'remarks' => $request->editRemarksActivity,
            'action' => "edit",
        ]);

        if ($request->has('editAccountableId')) {
            $editActivityRequest->employees()->attach($request->editAccountableId);
        }
        
        return redirect()->back()->with('status', 'Edit request submitted for approval.');
    }

    public function deleteActivityRequest(Request $request) {
        $deleteActivityRequest = ActivityRequest::create([
            'requestor' => auth()->id(),
            'name' => $request->deleteActivityName,
            'activity_id' => $request->deleteActivityId,
            'successIndicator' => $request->deleteActivitySuccessIndicator,
            'quality' => $request->deleteActivityQuality,
            'efficiency' => $request->deleteActivityEfficiency,
            'timeliness' => $request->deleteActivityTimeliness,
            'remarks' => $request->deleteActivityRemarks,
            'action' => "delete",
        ]);
    }

    // ====================== Sub-Activity ====================== //
    public function addSubActivityRequest(Request $request) {
        $addSubActivityRequest = SubActivityRequest::create([
            'activity_id' => $request->activityIdSub,
            'requestor' => auth()->id(),
            'name' => $request->addSubActivityName,
            'successIndicator' => $request->addSuccessIndicator,
            'quality' => $request->addQuality,
            'efficiency' => $request->addEfficiency,
            'timeliness' => $request->addTimeliness,
            'remarks' => $request->addRemarks,
            'budget' => $request->addBudget,
            'action' => "add",
        ]);

        $activity = Activity::findOrFail($request->activityIdSub);
        $activity->subActivityRequests()->save($addSubActivityRequest);

        if ($request->has('addAccountableId')) {
            $addSubActivityRequest->employees()->attach($request->addAccountableId);
        }
        
        return redirect()->back()->with('status', 'Add request submitted for approval.');
    }

    public function editSubActivityRequest(Request $request) {
        $editSubActivityRequest = SubActivityRequest::create([
            'requestor' => auth()->id(),
            'name' => $request->editActivityNameSub,
            'sub_activity_id' => $request->editActivityIdSub,
            'successIndicator' => $request->editSuccessIndicatorSub,
            'quality' => $request->editQualitySub,
            'efficiency' => $request->editEfficiencySub,
            'timeliness' => $request->editTimelinessSub,
            'remarks' => $request->editRemarksSub,
            'action' => "edit",
        ]);

        if ($request->has('editAccountableId')) {
            $editSubActivityRequest->employees()->attach($request->editAccountableId);
        }
        
        return redirect()->back()->with('status', 'Edit request submitted for approval.');
    }

    public function deleteSubActivityRequest(Request $request) {
        $deleteSubActivityRequest = SubActivityRequest::create([
            'requestor' => auth()->id(),
            'name' => $request->deleteSubActivityName,
            'sub_activity_id' => $request->deleteSubActivityId,
            'successIndicator' => $request->deleteSubActivitySuccessIndicator,
            'quality' => $request->deleteSubActivityQuality,
            'efficiency' => $request->deleteSubActivityEfficiency,
            'timeliness' => $request->deleteSubActivityTimeliness,
            'remarks' => $request->deleteSubActivityRemarks,
            'action' => "delete",
        ]);
    }

    // ====================== GASS ====================== //
    public function editGassRequest(Request $request) {
        $editGassRequest = GassRequest::create([
            'requestor' => auth()->id(),
            'gass_id' => $request->editGassId, //reference id
            'budget' => $request->editGassBudget,
            'action' => "edit",
        ]);
    }

    // =====================================For fetching divisions responsible in requests===================================== //
    // For new one
    public function getDivisions($id) {
        $programRequest = ProgramRequest::with('divisions')->findOrFail($id);
        return response()->json($programRequest->divisions);
    }

    // For an already existing program
    public function getReferenceDivisions($id) {
        $program = Program::with('divisions')->findOrFail($id);
        return response()->json($program->divisions);
    }

    // =====================================For fetching employees responsible in requests (Activity)===================================== //
    // For new one
    public function getEmployees($id) {
        $activityRequest = ActivityRequest::with('employees')->findOrFail($id);
        return response()->json($activityRequest->employees);
    }

    public function getReferenceEmployees($id) {
        $activity = Activity::with('employees')->findOrFail($id);
        return response()->json($activity->employees);
    }

    // =====================================For fetching employees responsible in requests (Sub-Activity)===================================== //
    // For new one
    public function getEmployeesSub($id) {
        $subActivityRequest = SubActivityRequest::with('employees')->findOrFail($id);
        return response()->json($subActivityRequest->employees);
    }

    public function getReferenceEmployeesSub($id) {
        $subActivity = SubActivity::with('employees')->findOrFail($id);
        return response()->json($subActivity->employees);
    }

    // =====================================For fetching reference details in requests===================================== //
    public function fetchReferenceProgramDetails($id) {
        $program = Program::findOrFail($id);
        return response()->json($program);
    }

    public function fetchReferenceActivityDetails($id) {
        $activity = Activity::findOrFail($id);
        return response()->json($activity);
    }

    public function fetchReferenceSubActivityDetails($id) {
        $subActivity = SubActivity::findOrFail($id);
        return response()->json($subActivity);
    }

    // =====================================For Department Head, reject requests===================================== //
    public function rejectProgramRequest(Request $request) {
        $programRequest = ProgramRequest::findOrFail($request->programId);
        $programRequest->delete();
    }

    public function rejectActivityRequest(Request $request) {
        $activityRequest = ActivityRequest::findOrFail($request->activityId);
        $activityRequest->delete();
    }

    public function rejectSubActivityRequest(Request $request) {
        $subActivityRequest = SubActivityRequest::findOrFail($request->subActivityId);
        $subActivityRequest->delete();
    }
}
