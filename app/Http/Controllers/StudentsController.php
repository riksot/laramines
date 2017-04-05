<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Groups;

class StudentsController extends Controller
{
    public function index(){ // Основная страница студентов
        return view('students');
//        return view('students')->with('groups',[]);
    }


    public function getListGroupsForStudents(Groups $groups){ // Получаем список групп
        return $groups->getGroups(\request('id'));
//        return \request('id');
    }

    public function getListStudentsForStudents($group){  // Получаем список студентов
//        return $groups->getGroups(\request('id'));
        return \request('id');
    }
}
