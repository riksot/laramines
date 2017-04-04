<?php
/*
|--------------------------------------------------------------------------
| Модель парсинга загруженных файлов
|--------------------------------------------------------------------------
*/

namespace App;

use Illuminate\Database\Eloquent\Model;

class FilesParser extends Model
{
    public function makeDataForDonePlanWordDocument($file){ // Вытаскиваем данные из xml в массив
        $info = array();
        $info = array_add($info, 'НазваниеФайла', $file->getClientOriginalName());
        $items = simplexml_load_file($file);
        $info = array_add($info, 'Направление', (string)$items->xpath('//План/Титул/Специальности/Специальность')[0]['Название']);
        $info = array_add($info, 'Профиль',     (string)$items->xpath('//План/Титул/Специальности/Специальность')[1]['Название']);
        $itemsDisc = $items->xpath('//План/СтрокиПлана/Строка');
        $temp = array();
        foreach ($itemsDisc as $item){
            $i=0;
            foreach ($item->xpath('Курс') as $kurs){
                $tempItem = array();
                $tempItem = array_add($tempItem, 'Дисциплина',              (string)$item['Дис']);
                $tempItem = array_add($tempItem, 'Курс',                    (string)$item->xpath('Курс')[$i]['Ном']);
                $tempItem = array_add($tempItem, 'ПодлежитИзучениюВсего',   (string)$item['ПодлежитИзучению']);
                $tempItem = array_add($tempItem, 'ЗЕТ',                     (string)$item->xpath('Курс')[$i]['ЗЕТ']);
                $tempItem = array_add($tempItem, 'КонтрРаб',                (string)$item->xpath('Курс')[$i]['КонтрРаб']);
                $tempItem = array_add($tempItem, 'Зач',                     (string)$item->xpath('Курс')[$i]['Зач']);
                $tempItem = array_add($tempItem, 'ЗачО',                    (string)$item->xpath('Курс')[$i]['ЗачО']);
                $tempItem = array_add($tempItem, 'КП',                      (string)$item->xpath('Курс')[$i]['КП']);
                $tempItem = array_add($tempItem, 'Экз',                     (string)$item->xpath('Курс')[$i]['Экз']);
                $i++;
                $temp[] = $tempItem;
            }
        }
        $info = array_add($info, 'Курсы', $temp);
        return ($info);
    }
}
