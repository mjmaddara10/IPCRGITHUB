<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class pdfController extends Controller
{
    public function generatePdf() {
        $data = [ 'title' => 'My PDF Title', 'content' => 'Hello, this is the content!' ];

        $pdf = Pdf::loadView('pdf', $data);

        $pdf = PDF::loadView('pdf', $data)->setPaper('legal', 'landscape');

        return $pdf->download('my_document.pdf'); // or ->stream() to open in browser
    }
}
