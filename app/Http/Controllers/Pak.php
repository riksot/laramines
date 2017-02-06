<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Controller;


class Pak extends Controller
{
    public function selectfaculty(){
        $faculty = DB::select('SELECT * FROM FAK');
        return view('pakSelector',['faculty' => $faculty]);
    }
}
