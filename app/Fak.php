<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fak extends Model
{
    protected $table = 'FAK';

    public function getFak(){
        $faculty = Fak::all();  // Выбираем все факультеты в базе
        return $faculty;
    }
}
