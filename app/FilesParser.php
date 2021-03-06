<?php
/*
|--------------------------------------------------------------------------
| Модель парсинга загруженных файлов
|--------------------------------------------------------------------------
*/

namespace App;

use Illuminate\Database\Eloquent\Model;
use SoapBox\Formatter\Formatter;

class FilesParser extends Model
{
    // Вытаскиваем данные из xml в массив для создания карточки дисциплин
    public function makeDataForDonePlanWordDocument($file){
        $info = array();
        $info = array_add($info, 'НазваниеФайла', $file->getClientOriginalName());
        $items = simplexml_load_file($file);
        $info = array_add($info, 'Направление', (string)$items->xpath('//План/Титул/Специальности/Специальность')[0]['Название']);
        $info = array_add($info, 'Профиль',     (string)$items->xpath('//План/Титул/Специальности/Специальность')[1]['Название']);
        $itemsDisc = $items->xpath('//План/СтрокиПлана/Строка');
        $temp = ['0' => '', '1' => '', '2' => '', '3' => '', ];
//        dd($itemsDisc);
        foreach ($itemsDisc as $item){ // Достаем дисциплины

            // Проверяем наличие вторых дисциплин (по выбору)
            if(count(explode('.',$item['НовИдДисциплины'])) > 3
                AND (explode('.',$item['НовИдДисциплины'])[2] == 'ДВ')
                AND (explode('.',$item['НовИдДисциплины'])[count(explode('.',$item['НовИдДисциплины']))-1] == '2'))
                continue;

            if(isset($item['ПерезачетЧасов'])){
                $tempItem = array();
                $tempItem['Курс'] =                 '0';
                $tempItem['НовИдДисциплины'] =      (string)$item['НовИдДисциплины'];
                $tempItem['Дисциплина']      =      (string)$item['Дис'];
                $tempItem['Часы_Зима']       =      (string)$item['ПерезачетЧасов'];
                $tempItem['ЗЕТ_Зима']        =      (string)($item['ПерезачетЧасов']/$item['ЧасовВЗЕТ']);
                if(isset($item['ИзученоЗач']))      $tempItem['Зач_Зима'] = '*';
                if(isset($item['ИзученоЗачО']))     $tempItem['Зач_Зима'] = 'оценка';
                if(isset($item['ИзученоЭкз']))      $tempItem['Экз_Зима'] = '*';
                if ((string)$item['ПерезачетЧасов'] == (string)$item['ГОС']) $tempItem['Перезачет'] = 'Полный перезачет';

                $temp[0][] = $tempItem;
            }

            $i=0;
            if(is_array($item->xpath('Курс')))
                foreach($item->xpath('Курс') as $kurs){

                    $tempItem = array();
                    $tempItem = array_add($tempItem, 'НовИдДисциплины',         (string)$item['НовИдДисциплины']);
                    $tempItem = array_add($tempItem, 'Дисциплина',              (string)$item['Дис']);
                    $tempItem = array_add($tempItem, 'Курс',                    (string)$kurs['Ном']);

                    foreach ($kurs->xpath('Сессия') as $session){

                        if($session['Ном']=='1'){  // Установочная сессия
                            $tempItem['Часы_Зима'] = $session['Лек'] + $session['Лаб'] + $session['Пр'];
                        }
                        if($session['Ном']=='2'){  // Зимняя сессия
                            if (isset($tempItem['Часы_Зима']))
                                $tempItem['Часы_Зима'] =+ $tempItem['Часы_Зима']+ $session['Лек'] + $session['Лаб'] + $session['Пр'] + $session['КСР'] + $session['СРС'] + $session['ЧасЭкз'];
                            else
                                $tempItem['Часы_Зима'] = $session['Лек'] + $session['Лаб'] + $session['Пр'] + $session['КСР'] + $session['СРС'] + $session['ЧасЭкз'];
                            if(isset($kurs['ЗЕТ'])) $tempItem['ЗЕТ_Зима'] = $tempItem['Часы_Зима']/36;
                            if(isset($session['КонтрРаб'])) $tempItem['КонтрРаб_Зима'] = (string)$session['КонтрРаб'];
                            if(isset($session['Зач'])) $tempItem['Зач_Зима'] = '*';
                            if(isset($session['ЗачО'])) $tempItem['Зач_Зима'] = 'оценка';
                            if(isset($session['КП'])  AND isset($session['КР']))  $tempItem['КП_Зима'] = 'КП КР';
                            if(isset($session['КП'])  AND !isset($session['КР'])) $tempItem['КП_Зима'] = 'КП';
                            if(!isset($session['КП']) AND isset($session['КР']))  $tempItem['КП_Зима'] = 'КР';
                            if(isset($session['Экз'])) $tempItem['Экз_Зима'] = '*';
                        }
                        if($session['Ном']=='3'){ // летняя сессия
                            $tempItem['Часы_Лето'] = $session['Лек'] + $session['Лаб'] + $session['Пр'] + $session['КСР'] + $session['СРС'] + $session['ЧасЭкз'];
                            if(isset($kurs['ЗЕТ'])) $tempItem['ЗЕТ_Лето'] = $tempItem['Часы_Лето']/36;
                            if(isset($session['КонтрРаб'])) $tempItem['КонтрРаб_Лето'] = (string)$session['КонтрРаб'];
                            if(isset($session['Зач'])) $tempItem['Зач_Лето'] = '*';
                            if(isset($session['ЗачО'])) $tempItem['ЗачО_Лето'] = 'оценка';
                            if(isset($session['КП']) AND isset($session['КР'])) $tempItem['КП_Лето'] = 'КП КР';
                            if(isset($session['КП']) AND !isset($session['КР'])) $tempItem['КП_Лето'] = 'КП';
                            if(!isset($session['КП']) AND isset($session['КР'])) $tempItem['КП_Лето'] = 'КР';
                            if(isset($session['Экз'])) $tempItem['Экз_Лето'] = '*';
                        }
                        // dd($kurs, $session,  $tempItem);
                    }

                    // Если нет ЗЕТ (у элективных курсов по физкультуре)
//                if(isset($item->xpath('Курс')[$i]['ЗЕТ']))
//                $tempItem = array_add($tempItem, 'Часов',                   (string)($item->xpath('Курс')[$i]['ЗЕТ']*36));
//                else {
//                    $tempItem = array_add($tempItem, 'Часов',
//                        (string)($item->xpath('Курс')[$i]['Пр']+$item->xpath('Курс')[$i]['СРС']+$item->xpath('Курс')[$i]['ЧасЭкз']));
//                }
//                $tempItem = array_add($tempItem, 'ЗЕТ',                     (string)$item->xpath('Курс')[$i]['ЗЕТ']);

//                $tempItem = array_add($tempItem, 'КонтрРаб',                (string)$item->xpath('Курс')[$i]['КонтрРаб']);
//                $tempItem = array_add($tempItem, 'Зач',                     (string)$item->xpath('Курс')[$i]['Зач']);
//                $tempItem = array_add($tempItem, 'ЗачО',                    (string)$item->xpath('Курс')[$i]['ЗачО']);
//                $tempItem = array_add($tempItem, 'КП',                      (string)$item->xpath('Курс')[$i]['КП']);
//                $tempItem = array_add($tempItem, 'Экз',                     (string)$item->xpath('Курс')[$i]['Экз']);

// ========================== складываем дисциплины по курсам =============================
                    switch ((string)$kurs['Ном']){
                        case '1':
                            $temp[1][] = $tempItem;
                            break;
                        case '2':
                            $temp[2][] = $tempItem;
                            break;
                        case '3':
                            $temp[3][] = $tempItem;
                            break;
                        case '4':
                            $temp[4][] = $tempItem;
                            break;
                        case '5':
                            $temp[5][] = $tempItem;
                            break;
                    }
                    $i++;
                }


        }

        // ============ Сортируем дисциплины в курсах по семестрам для таблицы =================
        $temp1 = array();
        if(is_array($temp))
        foreach ($temp as $id => $kurs){
            $tempArray = array('1'=>[], '2'=>[], '3'=>[]);
            if(is_array($kurs))
            foreach ($kurs as $disc){
                if(isset($disc['Часы_Зима']) AND !isset($disc['Часы_Лето'])){
                    $tempArray[1][] = $disc;
                }
                if(isset($disc['Часы_Зима']) AND isset($disc['Часы_Лето'])){
                    $tempArray[2][] = $disc;
                }
                if(!isset($disc['Часы_Зима']) AND isset($disc['Часы_Лето'])){
                    $tempArray[3][] = $disc;
                }
            }
            $temp1[$id] = array_merge($tempArray[1],$tempArray[2],$tempArray[3]);
        }
        $temp = $temp1;

        // ================= Достаем практики ===================
        $itemsPractics = $items->xpath('//План/СпецВидыРаботНов//ПрочаяПрактика');
        foreach ($itemsPractics as $item){
            $tempItem = array();
            $tempItem = array_add($tempItem, 'Дисциплина',             (string)$item['Наименование']);
            if(isset($item->xpath('Семестр')[0]['Ном'])){
                $tempItem['Курс'] =      (string)$item->xpath('Семестр')[0]['Ном'];
                $tempItem['Часы_Лето'] = (string)$item->xpath('Семестр')[0]['ПланЧасов'];
                $tempItem['ЗЕТ_Лето'] =  (string)$item->xpath('Семестр')[0]['ПланЗЕТ'];
//              $tempItem = array_add($tempItem, 'Курс',                        (string)floor(($item->xpath('Семестр')[0]['Ном']+1)/2));
            }
            else{
                $tempItem['Курс'] =      '0';
                $tempItem['Часы_Зима'] = (string)$item['ПерезачетЧасов'];
                $tempItem['ЗЕТ_Зима'] =  (string)($item['ПерезачетЧасов']/$item['ЧасовВЗЕТ']);
                if (isset($item['ИзученоЗачО'])) $tempItem['Зач_Зима'] = 'оценка';
                if ((string)$item['ПерезачетЧасов'] == (string)($item['ЧасовВЗЕТ']*$item['ЗЕТэкспертное'])) $tempItem['Перезачет'] = 'Полный перезачет';

            }

            if(isset($item->xpath('Семестр')[0]['ЗачО']))
                $tempItem = array_add($tempItem, 'Зач_Лето','оценка');

            switch ($tempItem['Курс']){
                case '0':
                    $temp[0][] = $tempItem;
                    break;
                case '1':
                    $temp[1][] = $tempItem;
                    break;
                case '2':
                    $temp[2][] = $tempItem;
                    break;
                case '3':
                    $temp[3][] = $tempItem;
                    break;
                case '4':
                    $temp[4][] = $tempItem;
                    break;
                case '5':
                    $temp[5][] = $tempItem;
                    break;
                case '6':
                    $temp[6][] = $tempItem;
                    break;
            }
        }
        $info = array_add($info, 'Курсы', $temp);
      //  dd($info);
        return ($info);
    }

    // Парсер шахтинского xml файла mode1 - Простой запрос, mode=null - полный запрос
    public function parseXMLFile($file, $mode = null){

        function makeStringFromArray($attr, $child = null){ // Переделываем массив из xml файла в строку
            if (isset($child)) {
                $tempArray = Formatter::make($attr, Formatter::XML)->toArray();
                return serialize($tempArray);
            }
            else
                return serialize($attr);
        }

        $xmlFile = new \SimpleXMLElement($file);
        $parsedFile = array();

        $items = array();  // Поля титула
        if ($mode != null) {  // Если упрощенный режим парсинга, т.е. $mode = 1
            $items = array_add($items, 'ИмяВуза',               (string)$xmlFile->{'План'}->{'Титул'}['ИмяВуза']);
            $items = array_add($items, 'ИмяВуза2',              (string)$xmlFile->{'План'}->{'Титул'}['ИмяВуза2']);
            $items = array_add($items, 'Головная',              (string)$xmlFile->{'План'}->{'Титул'}['Головная']);
            $items = array_add($items, 'ПоследнийШифр',         (string)$xmlFile->{'План'}->{'Титул'}['ПоследнийШифр']);
            $items = array_add($items, 'ГодНачалаПодготовки',   (string)$xmlFile->{'План'}->{'Титул'}['ГодНачалаПодготовки']);

            $tempItem = Formatter::make((array)$xmlFile->{'План'}->{'Титул'}->{'Специальности'}, Formatter::XML)->toArray();
            $items = array_add($items, 'Направление',           $tempItem['Специальность'][0]['@attributes']['Название']);
            $items = array_add($items, 'Профиль',               $tempItem['Специальность'][1]['@attributes']['Название']);

            $tempItem = Formatter::make((array)$xmlFile->{'План'}->{'Титул'}->{'Квалификации'}, Formatter::XML)->toArray();
            $items = array_add($items, 'Квалификация',          $tempItem['Квалификация']['@attributes']['Название']);
            $items = array_add($items, 'СрокОбучения',          $tempItem['Квалификация']['@attributes']['СрокОбучения']);
            $parsedFile = array_add($parsedFile, 'Титул', $items);

        }
        else {  // Полная версия парсинга

            // XML - Документ
            $items = array_add($items, 'Тип', (string)$xmlFile['Тип']);
            $items = array_add($items, 'PrevName', (string)$xmlFile['PrevName']);
            $items = array_add($items, 'PrevWrite', (string)$xmlFile['PrevWrite']);
            $items = array_add($items, 'LastName', (string)$xmlFile['LastName']);
            $items = array_add($items, 'LastWrite', (string)$xmlFile['LastWrite']);

            // XML - План
            $items = array_add($items, 'ПодТип', (string)$xmlFile->{'План'}['ПодТип']);
            $items = array_add($items, 'Шифр', (string)$xmlFile->{'План'}['Шифр']);
            $items = array_add($items, 'ОбразовательнаяПрограмма', (string)$xmlFile->{'План'}['ОбразовательнаяПрограмма']);
            $items = array_add($items, 'ФормаОбучения', (string)$xmlFile->{'План'}['ФормаОбучения']);
            $items = array_add($items, 'УровеньОбразования', (string)$xmlFile->{'План'}['УровеньОбразования']);

            // XML - Титул
            $items = array_add($items, 'ПолноеИмяПлана', (string)$xmlFile->{'План'}->{'Титул'}['ПолноеИмяПлана']);
            $items = array_add($items, 'ИмяПлана', (string)$xmlFile->{'План'}->{'Титул'}['ИмяПлана']);
            $items = array_add($items, 'НомерПользователя', (string)$xmlFile->{'План'}->{'Титул'}['НомерПользователя']);
            $items = array_add($items, 'ИмяВуза', (string)$xmlFile->{'План'}->{'Титул'}['ИмяВуза']);
            $items = array_add($items, 'ИмяВуза2', (string)$xmlFile->{'План'}->{'Титул'}['ИмяВуза2']);
            $items = array_add($items, 'Головная', (string)$xmlFile->{'План'}->{'Титул'}['Головная']);
            $items = array_add($items, 'КодКафедры', (string)$xmlFile->{'План'}->{'Титул'}['КодКафедры']);
            $items = array_add($items, 'Факультет', (string)$xmlFile->{'План'}->{'Титул'}['Факультет']);
            $items = array_add($items, 'ПоследнийШифр', (string)$xmlFile->{'План'}->{'Титул'}['ПоследнийШифр']);
            $items = array_add($items, 'ГодНачалаПодготовки', (string)$xmlFile->{'План'}->{'Титул'}['ГодНачалаПодготовки']);
            $items = array_add($items, 'ДатаГОСа', (string)$xmlFile->{'План'}->{'Титул'}['ДатаГОСа']);
            $items = array_add($items, 'ДокументГОСа', (string)$xmlFile->{'План'}->{'Титул'}['ДокументГОСа']);
            $items = array_add($items, 'ТипГОСа', (string)$xmlFile->{'План'}->{'Титул'}['ТипГОСа']);
            $items = array_add($items, 'Приложение', (string)$xmlFile->{'План'}->{'Титул'}['Приложение']);
            $items = array_add($items, 'ДатаПриложения', (string)$xmlFile->{'План'}->{'Титул'}['ДатаПриложения']);
            $items = array_add($items, 'ВерсияПриложения', (string)$xmlFile->{'План'}->{'Титул'}['ВерсияПриложения']);
            $items = array_add($items, 'СеместровНаКурсе', (string)$xmlFile->{'План'}->{'Титул'}['СеместровНаКурсе']);
            $items = array_add($items, 'СессийНаКурсе', (string)$xmlFile->{'План'}->{'Титул'}['СессийНаКурсе']);
            $items = array_add($items, 'ЭлементовВНеделе', (string)$xmlFile->{'План'}->{'Титул'}['ЭлементовВНеделе']);
            $items = array_add($items, 'ВключатьЭкВСуммуЧасов', (string)$xmlFile->{'План'}->{'Титул'}['ВключатьЭкВСуммуЧасов']);
            $items = array_add($items, 'КСР_ИЗ', (string)$xmlFile->{'План'}->{'Титул'}['КСР_ИЗ']);
            $items = array_add($items, 'WhoRatif', (string)$xmlFile->{'План'}->{'Титул'}['WhoRatif']);
            $items = array_add($items, 'FacType', (string)$xmlFile->{'План'}->{'Титул'}['FacType']);
            $items = array_add($items, 'ДвИГА', (string)$xmlFile->{'План'}->{'Титул'}['ДвИГА']);
            $items = array_add($items, 'ГвИГА', (string)$xmlFile->{'План'}->{'Титул'}['ГвИГА']);
            $items = array_add($items, 'DetailGIA', (string)$xmlFile->{'План'}->{'Титул'}['DetailGIA']);
            $items = array_add($items, 'ИГА_ЗЕТвНеделе', (string)$xmlFile->{'План'}->{'Титул'}['ИГА_ЗЕТвНеделе']);
            $items = array_add($items, 'ИГА_ЧасовВЗЕТ', (string)$xmlFile->{'План'}->{'Титул'}['ИГА_ЧасовВЗЕТ']);
            $items = array_add($items, 'ИГА_Кафедра', (string)$xmlFile->{'План'}->{'Титул'}['ИГА_Кафедра']);
            $items = array_add($items, 'Программа', (string)$xmlFile->{'План'}->{'Титул'}['Программа']);
            $items = array_add($items, 'ООПет', (string)$xmlFile->{'План'}->{'Титул'}['ООПет']);
            $items = array_add($items, 'Лекц', (string)$xmlFile->{'План'}->{'Титул'}['Лекц']);
            $items = array_add($items, 'ДВВ', (string)$xmlFile->{'План'}->{'Титул'}['ДВВ']);
            $items = array_add($items, 'МаксНагр', (string)$xmlFile->{'План'}->{'Титул'}['МаксНагр']);
            $items = array_add($items, 'Уровень', (string)$xmlFile->{'План'}->{'Титул'}['Уровень']);
            $items = array_add($items, 'ВидПлана', (string)$xmlFile->{'План'}->{'Титул'}['ВидПлана']);
            $items = array_add($items, 'КодУровня', (string)$xmlFile->{'План'}->{'Титул'}['КодУровня']);
            $items = array_add($items, 'СокрКонтрольФакт', (string)$xmlFile->{'План'}->{'Титул'}['СокрКонтрольФакт']);

            // ======================= Обработка массив - строка в титуле =========================

            // XML - АтрибутыЦикловНов
            $items = array_add($items, 'АтрибутыЦикловНов',
                makeStringFromArray((array)$xmlFile->{'План'}->{'Титул'}->{'АтрибутыЦикловНов'}, 'Цикл'));

            // XML - АтрибутыЦиклов
            $items = array_add($items, 'АтрибутыЦиклов',
                makeStringFromArray((array)$xmlFile->{'План'}->{'Титул'}->{'АтрибутыЦиклов'}, 'Цикл'));

            // XML - Утверждение
            $items = array_add($items, 'Утверждение',
                makeStringFromArray((array)$xmlFile->{'План'}->{'Титул'}->{'Утверждение'}));

            // XML - Специальности
            $items = array_add($items, 'Специальности',
                makeStringFromArray((array)$xmlFile->{'План'}->{'Титул'}->{'Специальности'}, 'Специальность'));

            // XML - ВоеннаяСпециальность
            $items = array_add($items, 'ВоеннаяСпециальность',
                makeStringFromArray((array)$xmlFile->{'План'}->{'Титул'}->{'ВоеннаяСпециальность'}));

            // XML - ВоеннаяСпециализация
            $items = array_add($items, 'ВоеннаяСпециализация',
                makeStringFromArray((array)$xmlFile->{'План'}->{'Титул'}->{'ВоеннаяСпециализация'}));

            // XML - ПредназначениеВыпускников
            $items = array_add($items, 'ПредназначениеВыпускников',
                makeStringFromArray((array)$xmlFile->{'План'}->{'Титул'}->{'ПредназначениеВыпускников'}));

            // XML - Квалификации
            $items = array_add($items, 'Квалификации',
                makeStringFromArray((array)$xmlFile->{'План'}->{'Титул'}->{'Квалификации'}, 'Квалификация'));

            // XML - ВидыДеятельности
            $items = array_add($items, 'ВидыДеятельности',
                makeStringFromArray((array)$xmlFile->{'План'}->{'Титул'}->{'ВидыДеятельности'}, 'ВидДеятельности'));

            // XML - Разработчики
            $items = array_add($items, 'Разработчики',
                makeStringFromArray((array)$xmlFile->{'План'}->{'Титул'}->{'Разработчики'}, 'Разработчик'));

            // XML - ГрафикУчПроцесса
            $items = array_add($items, 'ГрафикУчПроцесса',
                makeStringFromArray((array)$xmlFile->{'План'}->{'Титул'}->{'ГрафикУчПроцесса'}, 'Курс'));

            // ============================== Обработка документа (складываем всё в титул)=================

            // XML - ЗЕТ
            $items = array_add($items, 'ЗЕТ',
                makeStringFromArray((array)$xmlFile->{'План'}->{'ЗЕТ'}, true));

            // XML - ДопКомпетенции
            $items = array_add($items, 'ДопКомпетенции',
                makeStringFromArray((array)$xmlFile->{'План'}->{'ДопКомпетенции'}, true));

            // XML - СпецВидыРабот
            $items = array_add($items, 'СпецВидыРабот',
                makeStringFromArray((array)$xmlFile->{'План'}->{'СпецВидыРабот'}, true));

            // XML - СпецВидыРаботНов
            $items = array_add($items, 'СпецВидыРаботНов',
                makeStringFromArray((array)$xmlFile->{'План'}->{'СпецВидыРаботНов'}, true));

            // XML - Нормы
            $items = array_add($items, 'Нормы',
                makeStringFromArray((array)$xmlFile->{'План'}->{'Нормы'}, true));

            // XML - АПП
            $items = array_add($items, 'АПП',
                makeStringFromArray((array)$xmlFile->{'План'}->{'АПП'}, true));

            // XML - ПараметрыПроверки
            $items = array_add($items, 'ПараметрыПроверки',
                makeStringFromArray((array)$xmlFile->{'План'}->{'ПараметрыПроверки'}, true));

            // XML - Примечание
            $items = array_add($items, 'Примечание',
                makeStringFromArray((array)$xmlFile->{'План'}->{'Примечание'}));

            $parsedFile = array_add($parsedFile, 'Титул', $items);

            // ====================== Закончили обработку титула ==========================================


            // ============================== Обработка дисциплин =========================================

            $itemsDisc = $xmlFile->xpath('//План/СтрокиПлана/Строка');
            $itemsDisc = Formatter::make($itemsDisc, Formatter::XML)->toArray();
            $parsedFile = array_add($parsedFile, 'СтрокиПлана', $itemsDisc);

            // ============================== Обработка компетенций =======================================

            $itemsCompetences = $xmlFile->xpath('//План/Компетенции/Строка');
            $itemsCompetences = Formatter::make($itemsCompetences, Formatter::XML)->toArray();
            $parsedFile = array_add($parsedFile, 'Компетенции', $itemsCompetences);


        }

        return $parsedFile;
    }

}
