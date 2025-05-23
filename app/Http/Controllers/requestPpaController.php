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

class requestPpaController extends Controller
{
    public function addProgramRequest(Request $request) {
        $addProgramRequest = ProgramRequest::create([
            'requested_by' => auth()->id(),
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

    // =====================================For fetching divisions responsible in requests===================================== //
    public function getDivisions($id) {
        $programRequest = ProgramRequest::with('divisions')->findOrFail($id);
        return response()->json($programRequest->divisions);
    }

    // =====================================For Department Head, reject requests===================================== //
    public function rejectProgramRequest(Request $request) {
        $programAddRequest = ProgramRequest::findOrFail($request->programId);
        $programAddRequest->delete();
        
        return redirect()->back()->with('status', 'Add request submitted for approval.');
    }

}
