<?php
/*
|--------------------------------------------------------------------------
| Модель управления документами
|--------------------------------------------------------------------------
*/


namespace App;

use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpWord\PhpWord;

class Document extends Model
{
    public function change_files_coding($file_name) // Конвертируем названия файлов для сохранения на диске
    {
        $coding   = mb_detect_encoding($file_name);
        $new_str  = mb_convert_encoding($file_name, 'Windows-1251' , $coding);
        return $new_str;
    }

    public function makeDonePlanWordDocument($info) {  // Создание doc файла на основе готового шаблона и массива array
        dd($info);
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('templatesdoc/templateDonePlan.docx');

        $templateProcessor->setValue('kod', 'Код направления');
        $templateProcessor->setValue('profile', 'Название профиля');
        $templateProcessor->setValue('dekan', 'Декан заочного факультета');

        $numberOfKurs = 3;
        $numberOfDisc = 1;
        $firstKurs = 1;
        $countDiscs = [1 => 3, 2 => 15,3 => 8];

        $templateProcessor->cloneRow('kurs', $numberOfKurs);  // Создаем копии строк

        for ($i = $firstKurs; $i <= $numberOfKurs; $i++) {
            $templateProcessor->setValue('kurs#'.$i, $i);
            $templateProcessor->cloneRow('disc#'.$i, (int)$countDiscs[$i]);  // Создаем копии строк
            for ($j = 1; $j <= $countDiscs[$i]; $j++) {
                $templateProcessor->setValue('disc#'.$i.'#'.$j, 'Название дисциплины '.$numberOfDisc++);
            }
        }
        return $templateProcessor;

//        $templateProcessor->saveAs('uploads\/'.$this->change_files_coding($file->getClientOriginalName()).'.doc');

    }

}

