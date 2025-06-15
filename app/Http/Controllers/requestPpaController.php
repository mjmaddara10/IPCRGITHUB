<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        Log::info($request->deleteProgramGassId);
        
        if ($request->deleteProgramGassId !== null) {
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
                'gass_id' => 1,
                'action' => "delete",
            ]);
        } else {
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

    public function addGassCritRequest(Request $request) {
        $addGassCritRequest = ProgramRequest::create([
            'requestor' => auth()->id(),
            'name' => $request->addProgramName,
            'successIndicator' => $request->addSuccessIndicator,
            'quality' => $request->addQuality,
            'efficiency' => $request->addEfficiency,
            'timeliness' => $request->addTimeliness,
            'remarks' => $request->addRemarks,
            'budget' => $request->addBudget,
            'gass_id' => 1,
            'action' => "add",
        ]);

        if (in_array('all', $request->divisions)) {
            $allDivisionIds = \App\Models\Division::pluck('id')->toArray();
            $addGassCritRequest->divisions()->attach($allDivisionIds);
        } else {
            $addGassCritRequest->divisions()->attach($request->divisions);
        }
        
        return redirect()->back()->with('status', 'Add request submitted for approval.');
    }

    public function editGassCritRequest(Request $request) {
        $editGassCritRequest = ProgramRequest::create([
            'requestor' => auth()->id(),
            'name' => $request->editGassProgramName,
            'successIndicator' => $request->editGassProgramSuccessIndicator,
            'quality' => $request->editGassProgramQuality,
            'efficiency' => $request->editGassProgramEfficiency,
            'timeliness' => $request->editGassProgramTimeliness,
            'remarks' => $request->editGassProgramRemarks,
            'program_id' => $request->editGassProgramId,
            'gass_id' => 1,
            'action' => "edit",
        ]);

        if (in_array('all', $request->divisions)) {
            $allDivisionIds = \App\Models\Division::pluck('id')->toArray();
            $editGassCritRequest->divisions()->attach($allDivisionIds);
        } else {
            $editGassCritRequest->divisions()->attach($request->divisions);
        }
        
        return redirect()->back()->with('status', 'Edit request submitted for approval.');
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

        $user = auth()->user();
        $middleInitial = $user->middleName ? strtoupper(substr($user->middleName, 0, 1)) . '.' : '';
        $fullName = $user->firstName . ' ' . $middleInitial . ' ' . $user->lastName;

        $requestorMiddleInitial = $programRequest->requester->middleName ? strtoupper(substr($programRequest->requester->middleName, 0, 1)) . '.' : '';
        $requestorFullName = $programRequest->requester->firstName . ' ' . $requestorMiddleInitial . ' ' . $programRequest->requester->lastName;

        // Create audit trail before deletion
        AuditTrail::create([
            'user_id' => $user->id,
            'full_name' => $fullName,
            'role' => $user->role,
            'action' => "Disapproved the request to {$programRequest->action} the activity {$programRequest->name} requested by {$requestorFullName}",
            'action_from' => null,
            'action_to' => null,  // No 'to' state for deletions
            'program_name' => $programRequest->name,
            'record_id' => null
        ]);

        $programRequest->delete();
    }

    public function rejectActivityRequest(Request $request) {
        $activityRequest = ActivityRequest::findOrFail($request->activityId);

        $user = auth()->user();
        $middleInitial = $user->middleName ? strtoupper(substr($user->middleName, 0, 1)) . '.' : '';
        $fullName = $user->firstName . ' ' . $middleInitial . ' ' . $user->lastName;

        $requestorMiddleInitial = $activityRequest->requester->middleName ? strtoupper(substr($activityRequest->requester->middleName, 0, 1)) . '.' : '';
        $requestorFullName = $activityRequest->requester->firstName . ' ' . $requestorMiddleInitial . ' ' . $activityRequest->requester->lastName;

        // Create audit trail before deletion
        AuditTrail::create([
            'user_id' => $user->id,
            'full_name' => $fullName,
            'role' => $user->role,
            'action' => "Disapproved the request to {$activityRequest->action} the activity {$activityRequest->name} requested by {$requestorFullName}",
            'action_from' => null,
            'action_to' => null,  // No 'to' state for deletions
            'program_name' => $activityRequest->name,
            'record_id' => null
        ]);

        $activityRequest->delete();
    }

    public function rejectSubActivityRequest(Request $request) {
        $subActivityRequest = SubActivityRequest::with('activity.program')->findOrFail($request->subActivityId);

        $user = auth()->user();
        $middleInitial = $user->middleName ? strtoupper(substr($user->middleName, 0, 1)) . '.' : '';
        $fullName = $user->firstName . ' ' . $middleInitial . ' ' . $user->lastName;

        $requestorMiddleInitial = $subActivityRequest->requester->middleName ? strtoupper(substr($subActivityRequest->requester->middleName, 0, 1)) . '.' : '';
        $requestorFullName = $subActivityRequest->requester->firstName . ' ' . $requestorMiddleInitial . ' ' . $subActivityRequest->requester->lastName;

        // Create audit trail before deletion
        AuditTrail::create([
            'user_id' => $user->id,
            'full_name' => $fullName,
            'role' => $user->role,
            'action' => "Disapproved the request to {$subActivityRequest->action} the sub-activity {$subActivityRequest->name} requested by {$requestorFullName}",
            'action_from' => null,
            'action_to' => null,  // No 'to' state for deletions
            'program_name' => $subActivityRequest->name,
            'record_id' => null
        ]);

        $subActivityRequest->delete();
    }

    public function rejectGassRequest(Request $request) {
        $gassRequest = GassRequest::findOrFail($request->gassId);

        $user = auth()->user();
        $middleInitial = $user->middleName ? strtoupper(substr($user->middleName, 0, 1)) . '.' : '';
        $fullName = $user->firstName . ' ' . $middleInitial . ' ' . $user->lastName;

        $requestorMiddleInitial = $gassRequest->requester->middleName ? strtoupper(substr($gassRequest->requester->middleName, 0, 1)) . '.' : '';
        $requestorFullName = $gassRequest->requester->firstName . ' ' . $requestorMiddleInitial . ' ' . $gassRequest->requester->lastName;

        // Create audit trail before deletion
        AuditTrail::create([
            'user_id' => $user->id,
            'full_name' => $fullName,
            'role' => $user->role,
            'action' => "Disapproved the request to {$gassRequest->action} GASS {$gassRequest->name} requested by {$requestorFullName}",
            'action_from' => null,
            'action_to' => null,  // No 'to' state for deletions
            'program_name' => $gassRequest->name,
            'record_id' => null
        ]);

        $gassRequest->delete();
    }
}
