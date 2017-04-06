<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    public function getGroups($kurs){
//        $groups = Groups::all(); // выбираем все группы из базы
        $groups = \DB::select('select id,name,napr from groups where kurs'.$kurs.' > 0 ');
        return \Response::json($groups);
    }
}
