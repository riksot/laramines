<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competences extends Model
{
    protected $fillable = [
        'План_id',
        'Код',
        'Индекс',
        'Содержание',
    ];
}
