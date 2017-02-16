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

        foreach($plans as $plan) { // Добавление полных названий по сокращенным
            switch ($plan->RPRKV) {
                case 'S':
                    $plan->RPRKVF = 'С';
                    break;
                case 'U':
                    $plan->RPRKVF = 'СУ';
                    break;
                case 'B':
                    $plan->RPRKVF = 'Б';
                    break;
                case 'V':
                    $plan->RPRKVF = 'БУ';
                    break;
                case 'X':
                    $plan->RPRKVF = 'Б2В4т';
                    break;
                case 'Y':
                    $plan->RPRKVF = 'Б2В3т';
                    break;
                case 'R':
                    $plan->RPRKVF = 'Б2В3п';
                    break;
                case 'W':
                    $plan->RPRKVF = 'Б2В3п';
                    break;
                case 'M':
                    $plan->RPRKVF = 'М';
                    break;
                case 'N':
                    $plan->RPRKVF = 'Б2В4';
                    break;
                case 'P':
                    $plan->RPRKVF = 'Б2В3';
                    break;
            }
            $plan->KAFZAV = Kaf::where('KAFID','=',$plan->RPRNK)->first()->KAFZAV; // Выбор заведующего из базы кафедр
        }
        return $plans;
    }

//    public function scopePlans($query){
//        $fakult = Input::get('fakult');
//        $query->where('RPRNF','=',$fakult);
//    }
}

