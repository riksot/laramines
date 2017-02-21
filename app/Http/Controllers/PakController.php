<?php

namespace App\Http\Controllers;

use App\Discipline;
use App\Fak;
use App\Plan;
use App\Student;
use FontLib\Table\Type\name;
use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

//use Symfony\Component\Console\Input\Input;

class PakController extends Controller
{
    public function selectFaculty(Fak $facultyModel){ // Выборка всех факультетов
        $faculty = $facultyModel->getFak();
        if (isset($_REQUEST['studid'])){
            $studid = $_REQUEST['studid'];
        } else ($studid = null);

//        $id = $_REQUEST['id'];
//        $faculty = DB::select('SELECT * FROM FAK');  // Выбираем все факультеты в базе
//        dump($studid);
        return view('pakSelector',['faculty' => $faculty, 'studid' => $studid]); // Передаем информацию в pakSelector
    }

    public function selectStudent(){ // Выборка студентов
        return view('students'); // Передаем информацию в pakSelector
    }



    public function jqueryResponse(Plan $planModel){
//        $fakult = Input::get('fakult');
//        $plans =  Plan::where('RPRNF','=',$fakult)->get();
        $plans = $planModel->getPlans();
        return view('tables.plans',['plans' => $plans]);
//        return \Response::json($plans);
    }

    public function selectPak(){  // Выборка всех планов
        if (isset($_REQUEST['studid'])){
            $studid = $_REQUEST['studid'];
        } else ($studid = null);
//        $plans = Plan::query(['RPRID,RPRNF,RPRNK,RPRKS,RPRNS,RPRG'])->get();
        //dump($studid);
        return view('pak.protocol',['studid' => $studid]);
    }

    public function testJquery(){ // Вывод таблицы из вида tables.plans
        $plans = Plan::all();
        //return response()->json(array('plans'=> $plans), 200);
        return view('tables.plans',['plans' => $plans]);
    }

    public function getStudentInfo($studid = null){ // Выбор студента по идентификатору
        if ($studid === null) {
            return view('test');
        } else {
            $student = Student::where('id','=',$studid)->get()->first();  // Выбрали одну строку
            //$fio = $student->pluck('name')->first(); // Выбрали одно поле

            $plan = Plan::where('RPRID','=',$student->pluck('plan')->first())->get()->first();
            $discs = Discipline::where('UPNOM','=',$student->pluck('plan')->first())->get();
            //dd($student->kurs);
            return view('tables.test-table', ['student' => $student, 'plan' => $plan, 'discs' => $discs]);
        }
    }


}


