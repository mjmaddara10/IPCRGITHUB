<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\SubActivity;
use App\Models\Project;
use App\Models\SubProject;
use App\Models\Program;
use App\Models\Employee;
use App\Models\Division;
use App\Models\AuditTrail;
use App\Models\Gass;
use App\Models\GassRequest;

class gassController extends Controller
{
    // =====================Edit GASS========================= //
    public function updateGass(Request $request) {
        Log::info('Edit GASS Budget:', [$request->editGassBudget]);
        $gass = Gass::findOrFail($request->editGassId);

        $oldBudget = $gass->budget;

        $gass->update([
            'budget' => $request->editGassBudget,
        ]);

        if ($request->filled('editGassRequestId')) {
            $editRequestGass = GassRequest::findOrFail($request->editGassRequestId);
            $editRequestGass->update([
                'status' => 'approved',
            ]);
        }

        // Get authenticated user details
        $requestorId = $request->requestorId;

        if (!$requestorId) {
            $user = auth()->user();
        } else {
            $user = \App\Models\Employee::find($requestorId);
        }
        
        $middleInitial = $user->middleName ? strtoupper(substr($user->middleName, 0, 1)) . '.' : '';
        $fullName = $user->firstName . ' ' . $middleInitial . ' ' . $user->lastName;

        // Create audit trail
        AuditTrail::create([
            'user_id' => $user->id,
            'full_name' => $fullName,
            'role' => $user->role,
            'action' => "UPDATED GASS",
            'action_from' => "ALLOTTED BUDGET: {$oldBudget}",
            'action_to' =>  "REMARKS: {$request->editGassBudget}",
            'record_id' => $gass->id
        ]);

        // Return a response
        return response()->json(['message' => 'Sub-Activity updated successfully!']);
    }

    // =====================Main Activity========================= //
    public function addGassProgram(Request $request) {
        try {
            $gass = Gass::first();
            $maxOrder = $gass->programs()->max('order') ?? 0;

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
                'gass_id' => $gass->id,
            ]);

            // Check if 'all' is selected
            if (in_array('all', $request->divisions)) {
                $allDivisionIds = \App\Models\Division::pluck('id')->toArray();
                $program->divisions()->attach($allDivisionIds);
            } else {
                $program->divisions()->attach($request->divisions);
            }

            // Audit Trail for adding program
            $requestorId = $request->requestorId;

            if (!$requestorId) {
                $user = auth()->user();
            } else {
                $user = \App\Models\Employee::find($requestorId);
            }
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

    public function updateGassProgram(Request $request) {
        try {
            // Find the program
            $program = Program::findOrFail($request->editGassProgramId);

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
            $program->name = $request->editGassProgramName;
            $program->successIndicator = $request->editGassProgramSuccessIndicator;
            $program->quality = $request->editGassProgramQuality;
            $program->efficiency = $request->editGassProgramEfficiency;
            $program->timeliness = $request->editGassProgramTimeliness;
            $program->remarks = $request->editGassProgramRemarks;
            $program->budget = $request->editGassProgramBudget;
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

    public function deleteGassProgram(Request $request) {
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
}
