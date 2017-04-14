<?php

namespace App\Http\Controllers;

use App\Student;
use App\Students;
use Illuminate\Http\Request;
use App\Groups;

class StudentsController extends Controller
{
    public function index(){ // Основная страница студентов
        return view('students');
//        return view('students')->with('groups',[]);
    }


    public function getListGroupsForStudents(Groups $groups){ // Получаем список групп на курсе
        return $groups->getGroups(\request('idKurs'));
//        return \request('id');
    }

    public function getListStudentsForStudents(Students $students){  // Получаем список студентов в группе
//        return view('tables.groupStudentsList')->with('idGroup',\request('idGroup'));

        $studentList = $students->getListStudentsFromGroup(\request('idKurs'), \request('idGroup'))[0]; // список студентов
        $groupId = $students->getListStudentsFromGroup(\request('idKurs'), \request('idGroup'))[1];

        return view('tables.groupStudentsList',['studentsList' => $studentList, 'groupId' => $groupId]);

//        return $students->getListStudentsFromGroup(\request('idKurs'), \request('idGroup'));

    }

    public function showStudent($id)
    {
        //$student = Student::find($id);
        $student = Student::select(['name','kurs','groupname'])->where('id',$id)->first();
//        dump($student);
        return view('student.protocol',['student' => $student]);
    }
}
