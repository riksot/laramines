<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;

class Plan extends Model
{
    protected $table = 'RPR';

    public function getPlans(){
        $fakult = Input::get('fakult');
        $plans =  Plan::where('RPRNF','=',$fakult)->get();
        return $plans;
    }

//    public function scopePlans($query){
//        $fakult = Input::get('fakult');
//        $query->where('RPRNF','=',$fakult);
//    }
}

