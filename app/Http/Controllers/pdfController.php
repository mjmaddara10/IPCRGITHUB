<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Activity;
use App\Models\SubActivity;
use App\Models\Project;
use App\Models\SubProject;
use App\Models\Program;
use App\Models\Employee;
use App\Models\Division;

class pdfController extends Controller
{
    public function generatePdf($id, Request $request) {
        $employee = Employee::find($id);

        $chiefInfo = json_decode($request->input('chiefInfo'), true);

        $data = [
            'title' => 'My PDF Title',
            'content' => 'Hello, this is the content!',
            'employee' => $employee,
            'chiefInfo' => $chiefInfo,
        ];


        $pdf = PDF::loadView('pdf', $data)->setPaper('legal', 'landscape');
        
        return $pdf->stream('my_document.pdf'); // or ->stream() to open in browser
    }
}
