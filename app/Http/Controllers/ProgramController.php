<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Project;
use App\Models\Activity;

class ProgramController extends Controller
{
    public function fetch()
    {
        // Fetch all programs with their related projects
        $programs = Program::with('projects')->get();
        $projects = Project::with('activities')->get();

        // Pass the data to the view
        return view('adminBlades.adminManagePpa', compact('programs','projects'));
    }
}
