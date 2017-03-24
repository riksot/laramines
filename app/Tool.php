<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    public function getXMLtoXML($file) { // Получаем XML и разбираем его вручную

        function change_files_coding_to_UTF8($file_name) // Конвертируем названия файлов для сохранения на диске
        {
            $coding   = mb_detect_encoding($file_name);
            $new_str  = mb_convert_encoding($file_name, 'Windows-1251' , $coding);
            return $new_str;
        }

        $items = simplexml_load_file($file);
        $itemsKurs = $items->xpath('//Строка/Курс');

        $temp = array();
        foreach ($itemsKurs as $item) {
            if ($item['ЗЕТ'] !== null && $item['КСР'] == null) {
                $item['КСР'] = ceil((float)$item['ЗЕТ']); // Добавляем КСР в курс
                $tempItem = $item->addChild('VZ'); // Добавляем узел
                $tempItem->addAttribute('ID', '106'); // Добавляем атрибуты узлу
                $tempItem->addAttribute('H', $item['КСР']); // Добавляем атрибуты узлу
                $item['СРС'] -= $item['КСР'];  // Уменьшаем СРС на КСР
                for ($i = 0; $i <= ($item->{'VZ'}->count() - 1); $i++) {
                    if ($item->{'VZ'}[$i]['ID'] == 107) $item->{'VZ'}[$i]['H'] = $item['СРС'];
                }

                $pr = 0;
                $lk = 0;
                $ksr = 0;
                $temp[] = $item->{'Сессия'}->count();
                for ($i = 0; $i <= ($item->{'Сессия'}->count() - 1); $i++) {

                    switch ($item->{'Сессия'}[$i]['Ном']) {
                        case 1:
                            $pr = $item->{'Сессия'}[$i]['Пр'];
                            $lk = $item->{'Сессия'}[$i]['Лек'];
                            break;
                        case 2:
                            $ksr = ceil((float)(($item->{'Сессия'}[$i]['Пр']
                                    + $item->{'Сессия'}[$i]['Лек']
                                    + $item->{'Сессия'}[$i]['Лаб']
                                    + $item->{'Сессия'}[$i]['СРС']
                                    + $item->{'Сессия'}[$i]['ЧасЭкз'] + $pr + $lk) / 36));
                            $item->{'Сессия'}[$i]['КСР'] = $ksr;
                            $item->{'Сессия'}[$i]['СРС'] -= $item->{'Сессия'}[$i]['КСР'];
                            $pr = 0;
                            $lk = 0;
                            $tempItem = $item->{'Сессия'}[$i]->addChild('VZ');
                            $tempItem->addAttribute('ID', '106');
                            $tempItem->addAttribute('H', $item->{'Сессия'}[$i]['КСР']);
                            for ($j = 0; $j <= ($item->{'VZ'}->count() - 1); $j++) {
                                if ($item->{'Сессия'}[$i]->{'VZ'}[$j]['ID'] == 107)
                                    $item->{'Сессия'}[$i]->{'VZ'}[$j]['H'] = $item->{'Сессия'}[$i]['СРС'];
                            }

                            break;
                        case 3:
                            $item->{'Сессия'}[$i]['КСР'] = $item['КСР'] - $ksr;
                            $item->{'Сессия'}[$i]['СРС'] -= $item->{'Сессия'}[$i]['КСР'];
                            $tempItem = $item->{'Сессия'}[$i]->addChild('VZ');
                            $tempItem->addAttribute('ID', '106');
                            $tempItem->addAttribute('H', $item->{'Сессия'}[$i]['КСР']);
                            for ($j = 0; $j <= ($item->{'VZ'}->count() - 1); $j++) {
                                if ($item->{'Сессия'}[$i]->{'VZ'}[$j]['ID'] == 107)
                                    $item->{'Сессия'}[$i]->{'VZ'}[$j]['H'] = $item->{'Сессия'}[$i]['СРС'];
                            }

                            break;
                    }
                }
            }
            file_put_contents('uploads\\'.change_files_coding_to_UTF8($file->getClientOriginalName()), $items->asXML());
        }
    }
}
