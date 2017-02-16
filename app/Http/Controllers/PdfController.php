<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade as PDF;

class PdfController extends Controller
{
    public function pdf($data = []){
        $pdf = PDF::loadView('pdf',$data);
        return $pdf->setPaper('a4')->stream('print.pdf');
    }
}
