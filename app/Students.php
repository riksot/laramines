<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    public function getListStudentsFromGroup($idKurs, $idGroup)
    {
        $groupid = \DB::table('groups')->where('id', $idGroup)->value('name');
//        $groupid = \DB::select('select name from groups WHERE id = ?',[$idGroup]);

//        $group = \DB::table('students')->where('kurs', $idKurs)->where('groupname', $groupid);

        $group = \DB::select('select id,name from students WHERE kurs = ? AND groupname = ?',[$idKurs, $groupid]);
        $direction = \DB::table('groups')->where('id', $idGroup)->value('napr');
//        $group = \DB::select('select id,name from mines-test.students where kurs = ' + $idKurs);

        return ([$group, $direction]);
//        return \Response::json($group);

    }
}
