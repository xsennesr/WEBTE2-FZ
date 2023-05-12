<?php

namespace App\Http\Controllers;

use PDF;

class PdfController extends Controller
{
    public function generatePDF()
    {
        $data = []; 

        $pdf = PDF::loadView('introduction-teacher.dashboard', $data); 

        return $pdf->download('hdtuto.pdf');
    }
}