<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    public function getGroups($kurs){
        $groups = Groups::all(); // выбираем все группы из базы
//        $groups = Groups::where('') ; // выбираем все группы из базы
        return \Response::json($groups);
    }
}
