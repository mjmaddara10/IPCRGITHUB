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

class assignController extends Controller
{
    public function getEmployeeDivision($id)
    {
        $employee = Employee::with('division')->find($id);

        if (!$employee || !$employee->division) {
            return response()->json(['error' => 'Division not found for this employee'], 404);
        }
        // dd($employee->division);
        return response()->json([
            'id' => $employee->division->id,
            'name' => $employee->division->name,
        ]);
    }

    // public function getEmployeeDivision($id)
    // {
    //     $employee = Employee::with('division')->find($id);

    //     if (!$employee) {
    //         return response()->json(['error' => 'Employee not found'], 404);
    //     }

    //     if (!$employee->division) {
    //         return response()->json(['error' => 'Division not found for this employee', 'employee' => $employee], 404);
    //     }

    //     return response()->json([
    //         'id' => $employee->division->id,
    //         'name' => $employee->division->name,
    //     ]);
    //}

}
