<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function fetch()
    {
        // Fetch all programs with their related projects
        $programs = Program::with('projects')->get();

        // Pass the data to the view
        return view('adminBlades.adminManagePpa', compact('programs'));
    }
}
