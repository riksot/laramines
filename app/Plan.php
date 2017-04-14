<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Nathanmac\Utilities\Parser\Parser;

class Plan extends Model
{
    protected $table = 'RPR';
//    public static $key = 'post_id'; Переопределение ключа

    public function getPlans(){  // Достаем планы из старой базы
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

    public function parseXmlFile($file){ // Парсинг загруженного XML файла с помощью Nathanmac\Utilities\Parser\Parser

        $parser = new Parser();
        $parsed = $parser->xml(file_get_contents($file));   // Парсинг файла
        dd($parsed);
        $planAll = array();
        $planAll = array_add($planAll, 'Информация', $this->getPlanInfoFromXML($parsed));   // Достаем информацию о плане
        $planAll = array_add($planAll, 'Дисциплины', $this->getDiscsFromXML($parsed));      // Достаем дисциплины
        $planAll = array_add($planAll, 'Практики',   $this->getPracticsFromXML($parsed));   // Достаем практики
//        dd($parsed['План']['СтрокиПлана']['Строка']);
//        dd($planAll['Дисциплины']);
//        dd($planAll);
        return $planAll;
    }

    private function getPlanInfoFromXML($parsed){ //  Достаём информацию о плане из xml
        $plan = array(
            'Головная' =>                   array_get($parsed, 'План.Титул.@Головная'),
            'ОбразовательноеУчреждение' =>  array_get($parsed, 'План.Титул.@ИмяВуза'),
            'СтруктурноеПодразделение' =>   array_get($parsed, 'План.Титул.@ИмяВуза2'),
            'НомерКафедры' =>               array_get($parsed, 'План.Титул.@КодКафедры'),
            'Факультет' =>                  array_get($parsed, 'План.Титул.@Факультет'),
            'КемОдобренПлан' =>             array_get($parsed, 'План.Титул.@WhoRatif'),
            'КодНаправления' =>             array_get($parsed, 'План.Титул.@ПоследнийШифр'),
            'ГодНачалаПодготовки' =>        array_get($parsed, 'План.Титул.@ГодНачалаПодготовки'),
            'ТипГОСа' =>                    array_get($parsed, 'План.Титул.@ТипГОСа'),
            'ДокументГОСа' =>               array_get($parsed, 'План.Титул.@ДокументГОСа'),
            'ДатаГОСа' =>                   array_get($parsed, 'План.Титул.@ДатаГОСа'),
            'Квалификация' =>               array_get($parsed, 'План.Титул.Квалификации.Квалификация.@Название'),
            'СрокОбучения' =>               array_get($parsed, 'План.Титул.Квалификации.Квалификация.@СрокОбучения'),
            'ВидыДеятельности' =>           array_get($parsed, 'План.Титул.ВидыДеятельности.ВидДеятельности'),
            'Направление' =>                array_get($parsed, 'План.Титул.Специальности.Специальность.0.@Название'),
            'Профиль' =>                    array_get($parsed, 'План.Титул.Специальности.Специальность.1.@Название'),
        );
        return $plan;
    }

    private function getPracticsFromXML($parsed){ //  Достаем практики
        $practics_parsed = array_get($parsed, 'План.СпецВидыРаботНов');
        $practics = array();
        $numberPractics = 0;
        if (array_get($practics_parsed, 'УчебПрактики.ПрочаяПрактика') !== null) {
            if (array_get($practics_parsed, 'УчебПрактики.ПрочаяПрактика.@Наименование') !== null) {
                $practics = array_add($practics, 'Практика'.$numberPractics, array_get($practics_parsed, 'УчебПрактики.ПрочаяПрактика'));
                $practics['Практика'.$numberPractics++]['Индекс'] = 'Б2.У.1';
            }
            else {
                if (is_array(array_get($practics_parsed, 'УчебПрактики.ПрочаяПрактика'))) {
                    foreach (array_get($practics_parsed, 'УчебПрактики.ПрочаяПрактика') as $key => $practic) {
                        $practics = array_add($practics, 'Практика' . $numberPractics, array_get($practics_parsed, 'УчебПрактики.ПрочаяПрактика.' . $key));
                        $practics['Практика'.$numberPractics++]['Индекс'] = 'Б2.У.'.($key+1);
                    }
                }
            }
        }
        if (array_get($practics_parsed, 'НИР.ПрочаяПрактика') !== null) {
            if (array_get($practics_parsed, 'НИР.ПрочаяПрактика.@Наименование') !== null) {
                $practics = array_add($practics, 'Практика'.$numberPractics, array_get($practics_parsed, 'НИР.ПрочаяПрактика'));
                $practics['Практика'.$numberPractics++]['Индекс'] = 'Б2.Н.1';
            }
            else {
                if (is_array(array_get($practics_parsed, 'НИР.ПрочаяПрактика'))) {
                    foreach (array_get($practics_parsed, 'НИР.ПрочаяПрактика') as $key => $practic) {
                        $practics = array_add($practics, 'Практика' . $numberPractics, array_get($practics_parsed, 'НИР.ПрочаяПрактика.' . $key));
                        $practics['Практика'.$numberPractics++]['Индекс'] = 'Б2.Н.'.($key+1);
                    }
                }
            }
        }
        if (array_get($practics_parsed, 'ПрочиеПрактики.ПрочаяПрактика') !== null) {
            if (array_get($practics_parsed, 'ПрочиеПрактики.ПрочаяПрактика.@Наименование') !== null) {
                $practics = array_add($practics, 'Практика'.$numberPractics, array_get($practics_parsed, 'ПрочиеПрактики.ПрочаяПрактика'));
                $practics['Практика'.$numberPractics++]['Индекс'] = 'Б2.П.1';
            }
            else {
                if (is_array(array_get($practics_parsed, 'ПрочиеПрактики.ПрочаяПрактика'))) {
                    foreach (array_get($practics_parsed, 'ПрочиеПрактики.ПрочаяПрактика') as $key => $practic) {
                        $practics = array_add($practics, 'Практика' . $numberPractics, array_get($practics_parsed, 'ПрочиеПрактики.ПрочаяПрактика.' . $key));
                        $practics['Практика'.$numberPractics++]['Индекс'] = 'Б2.П.'.($key+1);
                    }
                }
            }
        }

        $practics = $this->extractPractics($practics);

        return $practics;
    }

    private function extractPractics($practics){ // Редактируем практики под правильный формат после парсинга
        $pract = array();
        if (is_array($practics))
            foreach ($practics as $practic){
                $tempPractic = array();
                $tempPractic = array_add($tempPractic, 'Индекс',            array_get($practic, 'Индекс'));
                $tempPractic = array_add($tempPractic, 'Наименование',      array_get($practic, '@Наименование'));
                $tempPractic = array_add($tempPractic, 'НомерСеместра',     array_get($practic, 'Семестр.@Ном')*2);
                $tempPractic = array_add($tempPractic, 'ПланЧасов',         array_get($practic, 'Семестр.@ПланЧасов'));
                $tempPractic = array_add($tempPractic, 'ПланЗЕТ',           array_get($practic, 'Семестр.@ПланЗЕТ'));
                $tempPractic = array_add($tempPractic, 'ЗачО',              array_get($practic, 'Семестр.@ЗачО'));
                $tempPractic = array_add($tempPractic, 'ПерезачетЧасов',    array_get($practic, '@ПерезачетЧасов'));
                $pract[] = $tempPractic;
            }
        return $pract;
    }

    private function getDiscsFromXML($parsed){ //  Достаём дисциплины из xml
        $discs_parsed = array_get($parsed, 'План.СтрокиПлана.Строка');
        $discs = array();
        foreach ($discs_parsed as $disc){
            $dis = array();
            $dis = array_add($dis, 'Дисциплина',                array_get($disc, '@Дис'));
            $dis = array_add($dis, 'Цикл',                      array_get($disc, '@Цикл'));
            $dis = array_add($dis, 'НовЦикл',                   array_get($disc, '@НовЦикл'));
            $dis = array_add($dis, 'ИдетификаторДисциплины',    array_get($disc, '@ИдетификаторДисциплины'));
            $dis = array_add($dis, 'НовИдДисциплины',           array_get($disc, '@НовИдДисциплины'));
            $dis = array_add($dis, 'Кафедра',                   array_get($disc, '@Кафедра'));                  // Идентификатор кафедры в шахтах
            $dis = array_add($dis, 'ВсегоЧасов',                array_get($disc, '@ГОС'));                      // Всего часов
            $dis = array_add($dis, 'ПодлежитИзучению',          array_get($disc, '@ПодлежитИзучению'));         // Подлежит изучению часов
            $dis = array_add($dis, 'ПерезачетЧасов',            array_get($disc, '@ПерезачетЧасов'));           // Перезачтено часов
            $dis = array_add($dis, 'ПроектЗЕТПерезачтено',      array_get($disc, '@ПроектЗЕТПерезачтено'));     // Перезачтено ЗЕТ
            $dis = array_add($dis, 'КредитовНаДисциплину',      array_get($disc, '@КредитовНаДисциплину'));     // ЗЕТ

            if (!$dis['ПодлежитИзучению']) $dis = array_add($dis, 'ПерезачтеннаяДисциплина', 'Да');

// =========== Проверяем, есть ли перезачеты ===========================================================================

            if (array_get($disc, 'Курс') !== null){

// ========================== Парсинг курсов Начало ====================================================================

                $kolvoKursov = 1;
// ==================== Если несколько курсов ==========================================================================
                if (array_get($disc, 'Курс.@Ном') === null) {
//                    $dis = array_add($dis, 'НомерКурса', array_get($disc, 'Курс'));
                    $kolvoKursov = 0;
                    if (is_array(array_get($disc, 'Курс'))) {
                        foreach (array_get($disc, 'Курс') as $kurs) {
//                        $dis = array_add($dis, 'НомерКурса'.$kolvoKursov, array_get($disc, 'Курс.'.$kolvoKursov));

// ===================== Если несколько сессий в нескольких курсах =====================================================
                            if (array_get(array_get($disc, 'Курс.' . $kolvoKursov), 'Сессия') !== null)
                                if (array_get(array_get($disc, 'Курс.' . $kolvoKursov), 'Сессия.@Ном') === null) {
                                    $kolvosessii = 0;
                                    if (is_array(array_get($kurs, 'Сессия'))) {
                                        $dis = array_add($dis, 'НомерКурса'. $kolvoKursov, array_get($kurs, '@Ном'));
                                        foreach (array_get($kurs, 'Сессия') as $sessia) {
                                            $dis = array_add($dis, 'Курс' . $kolvoKursov . '.Сессия' . $kolvosessii, $sessia);
                                            $kolvosessii++;
                                        }
//                                        $dis['Курс' . $kolvoKursov]['НомерКурса'] = array_get($kurs, '@Ном');
                                    }
                                } else {

                                    $dis = array_add($dis, 'НомерКурса'. $kolvoKursov, array_get($kurs, '@Ном'));
                                    $dis = array_add($dis, 'Курс' . $kolvoKursov . '.Сессия0', array_get($kurs, 'Сессия'));
//                                    $dis['Курс' . $kolvoKursov]['НомерКурса'] = array_get($kurs, '@Ном');
                                }
                            $kolvoKursov++;
                        }
                    }
                }
                else {

                    //                   $dis = array_add($dis, 'НомерКурса0', array_get($disc, 'Курс'));
// ===================== Если несколько сессий в одном курсе ===========================================================
                    if (array_get(array_get($disc, 'Курс'), 'Сессия') !== null)
                        if (array_get(array_get($disc, 'Курс'), 'Сессия.@Ном') === null) {
                            $kolvosessii = 0;
                            //dd(array_get(array_get($disc, 'Курс'), 'Сессия'));
                            if (is_array(array_get(array_get($disc, 'Курс'), 'Сессия'))) {
                                $dis = array_add($dis, 'НомерКурса0', array_get($disc, 'Курс.@Ном'));
                                foreach (array_get(array_get($disc, 'Курс'), 'Сессия') as $sessia) {
                                    $dis = array_add($dis, 'Курс0' . '.Сессия' . $kolvosessii, $sessia);
//                                    $dis['Курс0']['НомерКурса'] = array_get($disc, 'Курс.@Ном');
                                    $kolvosessii++;
                                }
                            }
                        }
                        else {
                            $dis = array_add($dis, 'НомерКурса0', array_get($disc, 'Курс.@Ном'));
                            $dis = array_add($dis, 'Курс0'.'.Сессия0', array_get($disc, 'Курс.Сессия'));
//                            $dis['Курс0']['НомерКурса'] = array_get($disc, 'Курс.@Ном');
                        }

//                    $temp = array_get($disc, 'Курс');
//                    if (array_get($temp, 'Сессия.@Ном') === '1') $dis = array_add($dis, 'НомерКурса0.СессияУстановочная', array_get($temp, 'Сессия'));
//                    if (array_get($temp, 'Сессия.@Ном') === '2') $dis = array_add($dis, 'НомерКурса0.СессияОсень', array_get($temp, 'Сессия'));
//                    if (array_get($temp, 'Сессия.@Ном') === '3') $dis = array_add($dis, 'НомерКурса0.СессияВесна', array_get($temp, 'Сессия'));
                }
                $dis = array_add($dis, 'КоличествоКурсов', $kolvoKursov);

// ========================== Парсинг курсов Конец =====================================================================
            }
            else {
//                    $dis = array_add($dis, 'ПерезачтеннаяДисциплина', 'Да');
            }

            $discs[] = $dis;

        }
        //dd($discs);
        $discs = $this->mergeUstanSemestr($this->extractPlanDiscs($discs)); // разбиваем по семестрам и сливаем установочные семестры
        return $discs;
    }

    private function extractPlanDiscs($discs){ // Упорядочивание загруженных дисциплин

        function makeOneDisc($itemSessia, $Kurs){ // Разделяем дисциплины, которые идут несколько семестров в курсе
            $dis = array();
            switch (array_get($itemSessia, '@Ном')){ // Расписываем номера семестров
                case 1:
                    $dis = array_add($dis, 'СеместрУстановочный', $itemSessia);
                    break;
                case 2:
                    $dis = array_add($dis, 'НомерСеместра', (($Kurs)*2-1));
//                    $dis = array_add($dis, 'СеместрОсенний', $itemSessia);
                    break;
                case 3:
                    $dis = array_add($dis, 'НомерСеместра', (($Kurs)*2));
//                    $dis = array_add($dis, 'СеместрВесенний', $itemSessia);
                    break;
            }

//            if (array_get($itemSessia, '@'))            $dis = array_add($dis, 'Часы',                  array_get($itemSessia, '@'));
            if (array_get($itemSessia, '@Лек'))         $dis = array_add($dis, 'Лекции',                array_get($itemSessia, '@Лек'));
            if (array_get($itemSessia, '@Лаб'))         $dis = array_add($dis, 'Лабораторные',          array_get($itemSessia, '@Лаб'));
            if (array_get($itemSessia, '@Пр'))          $dis = array_add($dis, 'Практики',              array_get($itemSessia, '@Пр'));
            if (array_get($itemSessia, '@КСР'))         $dis = array_add($dis, 'КСР',                   array_get($itemSessia, '@КСР'));
            if (array_get($itemSessia, '@СРС'))         $dis = array_add($dis, 'СРС',                   array_get($itemSessia, '@СРС'));
//            if (array_get($itemSessia, '@ЗЕТ'))         $dis = array_add($dis, 'ЗЕТ',                   array_get($itemSessia, '@ЗЕТ'));
            if (array_get($itemSessia, '@Экз'))         $dis = array_add($dis, 'Экзамен',               array_get($itemSessia, '@Экз'));
            if (array_get($itemSessia, '@ЧасЭкз'))      $dis = array_add($dis, 'ЧасЭкз',                array_get($itemSessia, '@ЧасЭкз'));
            if (array_get($itemSessia, '@Зач'))         $dis = array_add($dis, 'Зачет',                 array_get($itemSessia, '@Зач'));
            if (array_get($itemSessia, '@ЗачО'))        $dis = array_add($dis, 'ЗачетСОценкой',         array_get($itemSessia, '@ЗачО'));
            if (array_get($itemSessia, '@КП'))          $dis = array_add($dis, 'КП',                    array_get($itemSessia, '@КП'));
            if (array_get($itemSessia, '@КР'))          $dis = array_add($dis, 'КР',                    array_get($itemSessia, '@КР'));
            if (array_get($itemSessia, '@КонтрРаб'))    $dis = array_add($dis, 'КонтрольнаяРабота',     array_get($itemSessia, '@КонтрРаб'));
            if (array_get($itemSessia, '@Контр'))       $dis = array_add($dis, 'Контр',                 array_get($itemSessia, '@Контр'));
            if (array_get($itemSessia, '@ВидКонтр'))    $dis = array_add($dis, 'ВидКонтроля',           array_get($itemSessia, '@ВидКонтр'));

            return $dis;
        }

        $extractedDiscs = array();

        if (is_array($discs)){
            foreach ($discs as $disc){ // Просматриваем дисциплины
                for ($indexKurs=0; $indexKurs < array_get($disc, 'КоличествоКурсов'); $indexKurs++) { // index - индекс курса = 0..5
                    if (is_array(array_get($disc, 'Курс'.$indexKurs)))  // Просматриваем сессии в курсе
                        foreach (array_get($disc, 'Курс'.$indexKurs) as $itemSessia) {
                            $dis = array();
                            if (array_get($disc, 'НовЦикл'))                $dis = array_add($dis, 'Цикл',                          array_get($disc, 'НовЦикл'));
                            if (array_get($disc, 'НовИдДисциплины'))        $dis = array_add($dis, 'Индекс',                        array_get($disc, 'НовИдДисциплины'));
                            if (array_get($disc, 'Дисциплина'))             $dis = array_add($dis, 'Наименование',                  array_get($disc, 'Дисциплина'));
                            if (array_get($disc, 'ПодлежитИзучению'))       $dis = array_add($dis, 'ПодлежитИзучениюЧасовВсего',    array_get($disc, 'ПодлежитИзучению'));
                            if (array_get($disc, 'ПерезачетЧасов'))         $dis = array_add($dis, 'ПерезачетЧасовВсего',           array_get($disc, 'ПерезачетЧасов'));
                            if (array_get($disc, 'ПроектЗЕТПерезачтено'))   $dis = array_add($dis, 'ПроектЗЕТПерезачтеноВсего',     array_get($disc, 'ПроектЗЕТПерезачтено'));
                            if (array_get($disc, 'КоличествоКурсов'))       $dis = array_add($dis, 'КоличествоКурсов',              array_get($disc, 'КоличествоКурсов'));
                            if (array_get($disc, 'КредитовНаДисциплину'))   $dis = array_add($dis, 'ЗЕТВсего',                      array_get($disc, 'КредитовНаДисциплину'));
                            if (array_get($disc, 'НомерКурса'.$indexKurs))  $dis = array_add($dis, 'НомерКурса',                    array_get($disc, 'НомерКурса'.$indexKurs));
//                            if (array_get($disc, 'Курс'.$indexKurs))        $dis = array_add($dis, 'Курс',                          array_get($disc, 'Курс'.$indexKurs));
                            $dis = array_collapse([$dis, makeOneDisc($itemSessia, array_get($disc, 'НомерКурса'.$indexKurs))]); // Запрос на разделение на семестры по номеру курса
                            $extractedDiscs[] = $dis;
                        }
                }
            }
        }

//        $deleted = array_except($extractedDiscs, array_keys($extractedDiscs, 'СеместрУстановочный'));
//        dd($deleted);
        return $extractedDiscs;
    }

    private function mergeUstanSemestr($discs) { // Слияние установочного семестра с первым семестром и подсчет Часов и ЗЕТ
        $dis = array();

        foreach ($discs as $key => $disc){
            if (array_get($disc, 'СеместрУстановочный')){
                if (array_get($disc, 'Лекции')) {
                    if (isset($discs[$key+1]['Лекции']))
                        $discs[$key+1]['Лекции'] += $discs[$key]['Лекции'];
                    else $discs[$key+1]['Лекции'] = $discs[$key]['Лекции'];
                }
                if (array_get($disc, 'Лабораторные')) {
                    if (isset($discs[$key+1]['Лабораторные']))
                        $discs[$key+1]['Лабораторные'] += $discs[$key]['Лабораторные'];
                    else $discs[$key+1]['Лабораторные'] = $discs[$key]['Лабораторные'];
                }
                if (array_get($disc, 'Практики')) {
                    if (isset($discs[$key+1]['Практики']))
                        $discs[$key+1]['Практики'] += $discs[$key]['Практики'];
                    else $discs[$key+1]['Практики'] = $discs[$key]['Практики'];
                }
                array_forget($discs,$key);
            } else {
                $dis[] = $disc;
                $discs[$key]['Часы'] = 0;
                if (isset($discs[$key]['Лекции']))          $discs[$key]['Часы'] +=$discs[$key]['Лекции'];
                if (isset($discs[$key]['Лабораторные']))    $discs[$key]['Часы'] +=$discs[$key]['Лабораторные'];
                if (isset($discs[$key]['Практики']))        $discs[$key]['Часы'] +=$discs[$key]['Практики'];
                if (isset($discs[$key]['КСР']))             $discs[$key]['Часы'] +=$discs[$key]['КСР'];
                if (isset($discs[$key]['СРС']))             $discs[$key]['Часы'] +=$discs[$key]['СРС'];
                if (isset($discs[$key]['ЧасЭкз']))          $discs[$key]['Часы'] +=$discs[$key]['ЧасЭкз'];
                if ($disc['Наименование'] != "Элективные курсы по физической культуре") $discs[$key]['ЗЕТ'] = $discs[$key]['Часы']/36;
            }
        }
//        dd($discs);
        return $discs;
    }

}



//        $dom = new \DOMDocument('1.0', 'UTF-8');
//        $dom->loadXML(file_get_contents($file));
//        $items = new \DOMXPath($dom);
////        $items = $dom->getElementsByTagName('Строка');
//        $temp = array();
//        foreach ($items->query('//Курс') as $item) { // Список по Курсам
////            $element = $dom->createElement('ТестовыйЭлемент', 'Запись в тестовый элемент'); // Создали элемент
////            $element = $dom->createAttribute('КСР'); // создали атрибут
////            $item->appendChild($element); // Записали элемент в структуру
//            $item->setAttribute('КСР_НОВЫЙ',$item->getAttribute('ЗЕТ'));  // установили атрибут
//            $temp[]=$item->childNodes;
//        }
//        $dom->save('uploads\file.xml');
//        return $file;


