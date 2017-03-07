<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;

class Plan extends Model
{
    protected $table = 'RPR';
//    public static $key = 'post_id'; Переопределение ключа

    public function getPlans(){
        $fakult = Input::get('fakult');
        $plans =  Plan::where('RPRNF','=',$fakult)->get();

        foreach($plans as $plan) { // Добавление полных названий по сокращенным !!!СДЕЛАТЬ РАСШИФРОВКУ RPRKVFull ВО ВСПЛЫВАЮЩЕМ ОКНЕ!!!
            switch ($plan->RPRKV) {
                case 'S':
                    $plan->RPRKVF = 'С';
                    $plan->RPRKVFull = 'С';
                    break;
                case 'U':
                    $plan->RPRKVF = 'СУ';
                    $plan->RPRKVFull = 'С';
                    break;
                case 'B':
                    $plan->RPRKVF = 'Б';
                    $plan->RPRKVFull = 'С';
                    break;
                case 'V':
                    $plan->RPRKVF = 'БУ';
                    $plan->RPRKVFull = 'С';
                    break;
                case 'X':
                    $plan->RPRKVF = 'Б2В4т';
                    $plan->RPRKVFull = 'С';
                    break;
                case 'Y':
                    $plan->RPRKVF = 'Б2В3т';
                    $plan->RPRKVFull = 'С';
                    break;
                case 'R':
                    $plan->RPRKVF = 'Б2В3п';
                    $plan->RPRKVFull = 'С';
                    break;
                case 'W':
                    $plan->RPRKVF = 'Б2В3п';
                    $plan->RPRKVFull = 'С';
                    break;
                case 'M':
                    $plan->RPRKVF = 'М';
                    $plan->RPRKVFull = 'С';
                    break;
                case 'N':
                    $plan->RPRKVF = 'Б2В4';
                    $plan->RPRKVFull = 'С';
                    break;
                case 'P':
                    $plan->RPRKVF = 'Б2В3';
                    $plan->RPRKVFull = 'С';
                    break;
            }
            $plan->KAFZAV = Kaf::where('KAFID','=',$plan->RPRNK)->first()->KAFZAV; // Выбор заведующего из базы кафедр
        }
        return $plans;
    }

    public function parseXmlFile($file){ // Парсинг загруженного XML файла

    }

    public function extractPlanDiscs($discs){ // Упорядочивание загруженных дисциплин

    }

}

