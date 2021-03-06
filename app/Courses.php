<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    protected $fillable = [
        'Дис_id',
        'Ном',
        'Лек',
        'Лаб',
        'Пр',
        'КСР',
        'СРС',
        'ЧасЭкз',
        'ИнтЛек',
        'ИнтЛаб',
        'ИнтПр',
        'ЗЕТ',
        'ПроектЛекВНед',
        'ПроектЛабВНед',
        'ПроектПрВНед',
        'ПроектЗЕТ',
        'Экз',
        'Зач',
        'ЗачО',
        'КП',
        'КР',
        'Реф',
        'Эссе',
        'КонтрРаб',
        'РГР',
    ];
}
