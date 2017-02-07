<?php

namespace App\Http\Controllers;

use App\Fak;
use App\Plan;
use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

//use Symfony\Component\Console\Input\Input;


class Pak extends Controller
{
    public function selectFaculty(){ // Выборка всех факультетов
        $faculty = Fak::all();
        //        $faculty = DB::select('SELECT * FROM FAK');  // Выбираем все факультеты в базе
        // dump($faculty);
        return view('pakSelector',['faculty' => $faculty]); // Передаем информацию в pakSelector
    }

//    public function selectPlans(){  // Выборка всех планов
//        $plans = Plan::query(['RPRID,RPRNF,RPRNK,RPRKS,RPRNS,RPRG'])->get();
//        // dump($plans);
//        return view('test',['plans' => $plans]);
//    }
    public function testJquery(){ // Вывод таблицы из вида tables.plans
        $plans = Plan::all();
        //return response()->json(array('plans'=> $plans), 200);
        return view('tables.plans',['plans' => $plans]);
    }

    public function jqueryResponse(){

        $fakult = Input::get('fakult');
        $plans =  Plan::where('RPRNF','=',$fakult)->get();

        return view('tables.plans',['plans' => $plans]);

//        return \Response::json($plans);

    }
}
