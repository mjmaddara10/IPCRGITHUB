<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class pdfController extends Controller
{
    public function generatePdf(Request $request) {
        $data = [ 'title' => 'My PDF Title',
            'content' => 'Hello, this is the content!',
            'role' => $request->input('role'),
            'assignments' => json_decode($request->input('assignments'), true), ];

        // $assignments = json_decode($request->input('assignments'));  // Decode if it's JSON
        // $role = $request->input('role');

        $pdf = PDF::loadView('pdf', $data)->setPaper('legal', 'landscape');
        
        return $pdf->stream('my_document.pdf'); // or ->stream() to open in browser
    }
}
