<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sessions extends Model
{
    protected $fillable = [
        'Курс_id',
        'Ном',
        'Лек',
        'Лаб',
        'Пр',
        'ИнтЛек',
        'ИнтЛаб',
        'ИнтПр',
        'СРС',
        'КонтрРаб',
        'Экз',
        'Зач',
        'ЗачО',
        'КП',
        'КР',
        'Реф',
        'Эссе',
        'РГР',
        'ВидКонтр',

    ];
}
