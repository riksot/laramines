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
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('templatesdoc/templateDonePlan.docx');
        $templateProcessor->setValue('kod', $info['Направление']);
        $templateProcessor->setValue('profile', $info['Профиль']);
        $templateProcessor->setValue('dekan', 'Декан заочного факультета');
        $info = $this->divideInfoForKurses($info);

        $templateProcessor->cloneRow('kurs', count($info['Курсы']));  // Создаем копии курсов
        foreach ($info['Курсы'] as $indexKurs => $kurs){
            $templateProcessor->setValue('kurs#'.($indexKurs+1), ($indexKurs+1));  // выставляем номера курсов с первом столбе
            $templateProcessor->cloneRow('disc#'.($indexKurs+1), (int)count($kurs));  // Создаем копии строк
            foreach ($kurs as $indexDisc => $disc){
                $templateProcessor->setValue('disc#'.($indexKurs+1).'#'.($indexDisc+1), $disc['Дисциплина']);
                $templateProcessor->setValue('zet#'.($indexKurs+1).'#'.($indexDisc+1), $disc['ЗЕТ']);
            }
        }




/*
        $templateProcessor->cloneRow('kurs', $numberOfKurs);  // Создаем копии курсов
        for ($i = $firstKurs; $i <= $numberOfKurs; $i++) {
            $templateProcessor->setValue('kurs#'.$i, $i);  // выставляем номера курсов с первом столбе
            $templateProcessor->cloneRow('disc#'.$i, (int)$countDiscs[$i]);  // Создаем копии строк
            for ($j = 0; $j <= $countDiscs[$i]-1; $j++) {
                $templateProcessor->setValue('disc#'.$i.'#'.$j, $info['Курсы'][$i-1][$j]['Дисциплина']);
            }
        }

*/


        return $templateProcessor;

//        $templateProcessor->saveAs('uploads\/'.$this->change_files_coding($file->getClientOriginalName()).'.doc');

    }

    public function divideInfoForKurses($info){ // разбираем инфо по курсам (только 5 курсов)
        $kurs1 = array();
        $kurs2 = array();
        $kurs3 = array();
        $kurs4 = array();
        $kurs5 = array();
        foreach (array_pull($info, 'Курсы') as $kurs){
            switch ($kurs['Курс']){
                case 1: $kurs1[] = $kurs;
                    break;
                case 2: $kurs2[] = $kurs;
                    break;
                case 3: $kurs3[] = $kurs;
                    break;
                case 4: $kurs4[] = $kurs;
                    break;
                case 5: $kurs5[] = $kurs;
                    break;
            }
        }
        $info = array_add($info, 'Курсы',[$kurs1, $kurs2, $kurs3, $kurs4, $kurs5]);
        return($info);
    }

}

