<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Nathanmac\Utilities\Parser\Parser;

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

    public function parseXmlFile($file){ // Парсинг загруженного XML файла с помощью Nathanmac\Utilities\Parser\Parser

        $parser = new Parser();
        $parsed = $parser->xml(file_get_contents($file));

// ========================== Достаём информацию о плане из xml ========================================================

        $plan = array(
            'Головная' =>                   array_get($parsed, 'План.Титул.@Головная'),
            'ОбразовательноеУчреждение' =>  array_get($parsed, 'План.Титул.@ИмяВуза'),
            'СтруктурноеПодразделение' =>   array_get($parsed, 'План.Титул.@ИмяВуза2'),
            'Кафедра' =>                    array_get($parsed, 'План.Титул.@КодКафедры'),
            'Факультет' =>                  array_get($parsed, 'План.Титул.@Факультет'),
            'WhoRatif' =>                   array_get($parsed, 'План.Титул.@WhoRatif'),
            'КодНаправления' =>             array_get($parsed, 'План.Титул.@ПоследнийШифр'),
            'ГодНачалаПодготовки' =>        array_get($parsed, 'План.Титул.@ГодНачалаПодготовки'),
            'ТипГОСа' =>                    array_get($parsed, 'План.Титул.@ТипГОСа'),
            'ДокументГОСа' =>               array_get($parsed, 'План.Титул.@ДокументГОСа'),
            'ДатаГОСа' =>                   array_get($parsed, 'План.Титул.@ДатаГОСа'),
            'Квалификация' =>               array_get($parsed, 'План.Титул.Квалификации.Квалификация.@Название'),
            'СрокОбучения' =>               array_get($parsed, 'План.Титул.Квалификации.Квалификация.@СрокОбучения'),
            'ВидыДеятельности' =>           array_get($parsed, 'План.Титул.ВидыДеятельности.ВидДеятельности'),
        );

// ========================== Достаём дисциплины из xml ================================================================

        $discs_parsed = array_get($parsed, 'План.СтрокиПлана.Строка');
        $discs = array();
        foreach ($discs_parsed as $disc){
            $dis = array();
            $dis = array_add($dis, 'Дисциплина',                array_get($disc, '@Дис'));
            $dis = array_add($dis, 'Цикл',                      array_get($disc, '@Цикл'));
            $dis = array_add($dis, 'НовЦикл',                   array_get($disc, '@НовЦикл'));
            $dis = array_add($dis, 'ИдетификаторДисциплины',    array_get($disc, '@ИдетификаторДисциплины'));
            $dis = array_add($dis, 'НовИдДисциплины',           array_get($disc, '@НовИдДисциплины'));
            $dis = array_add($dis, 'Кафедра',                   array_get($disc, '@Кафедра'));
            $dis = array_add($dis, 'ПодлежитИзучению',          array_get($disc, '@ПодлежитИзучению'));
            $dis = array_add($dis, 'ПерезачетЧасов',            array_get($disc, '@ПерезачетЧасов'));
            $dis = array_add($dis, 'ПроектЗЕТПерезачтено',      array_get($disc, '@ПроектЗЕТПерезачтено'));
            $dis = array_add($dis, 'КредитовНаДисциплину',      array_get($disc, '@КредитовНаДисциплину'));

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
                                        //============================================
                                        $dis = array_add($dis, 'НомерКурса'. $kolvoKursov, array_get($kurs, '@Ном'));
                                        foreach (array_get($kurs, 'Сессия') as $sessia) {
                                            $dis = array_add($dis, 'Курс' . $kolvoKursov . '.Сессия' . $kolvosessii, $sessia);
                                            $kolvosessii++;
                                        }
                                    }
                                } else {
                                    $dis = array_add($dis, 'НомерКурса'. $kolvoKursov, array_get($kurs, '@Ном'));
                                    $dis = array_add($dis, 'Курс' . $kolvoKursov . '.Сессия0', array_get($kurs, 'Сессия'));
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
                                    $kolvosessii++;
                                }
                            }
                        }
                        else {
                            $dis = array_add($dis, 'НомерКурса0', array_get($disc, 'Курс.@Ном'));
                            $dis = array_add($dis, 'Курс0'.'.Сессия0', array_get($disc, 'Курс.Сессия'));
                        }

//                    $temp = array_get($disc, 'Курс');
//                    if (array_get($temp, 'Сессия.@Ном') === '1') $dis = array_add($dis, 'НомерКурса0.СессияУстановочная', array_get($temp, 'Сессия'));
//                    if (array_get($temp, 'Сессия.@Ном') === '2') $dis = array_add($dis, 'НомерКурса0.СессияОсень', array_get($temp, 'Сессия'));
//                    if (array_get($temp, 'Сессия.@Ном') === '3') $dis = array_add($dis, 'НомерКурса0.СессияВесна', array_get($temp, 'Сессия'));
                }
                $dis = array_add($dis, 'Количествокурсов', $kolvoKursov);

// ========================== Парсинг курсов Конец =====================================================================
            }
            else {
//                    $dis = array_add($dis, 'ПерезачтеннаяДисциплина', 'Да');
            }

            $discs[] = $dis;

        }
// ========================== Парсинг дисциплин Конец ==================================================================

// ========================== Парсинг практик Начало ===================================================================

        $practics_parsed = array_get($parsed, 'План.СпецВидыРаботНов');
        $practics = array();
        $numberPractics = 0;
        if (array_get($practics_parsed, 'УчебПрактики.ПрочаяПрактика') !== null) {
            if (array_get($practics_parsed, 'УчебПрактики.ПрочаяПрактика.@Наименование') !== null) {
                $practics = array_add($practics, 'Практика'.$numberPractics++, array_get($practics_parsed, 'УчебПрактики.ПрочаяПрактика'));
            }
            else {
                $counter_practic = 0;
                if (is_array(array_get($practics_parsed, 'УчебПрактики.ПрочаяПрактика'))) {
                    foreach (array_get($practics_parsed, 'УчебПрактики.ПрочаяПрактика') as $practic) {
                        $practics = array_add($practics, 'Практика' . $numberPractics++, array_get($practics_parsed, 'УчебПрактики.ПрочаяПрактика.' . $counter_practic++));
                    }
                }
            }
        }
        if (array_get($practics_parsed, 'НИР.ПрочаяПрактика') !== null) {
            if (array_get($practics_parsed, 'НИР.ПрочаяПрактика.@Наименование') !== null) {
                $practics = array_add($practics, 'Практика'.$numberPractics++, array_get($practics_parsed, 'НИР.ПрочаяПрактика'));
            }
            else {
                $counter_practic = 0;
                if (is_array(array_get($practics_parsed, 'НИР.ПрочаяПрактика'))) {
                    foreach (array_get($practics_parsed, 'НИР.ПрочаяПрактика') as $practic) {
                        $practics = array_add($practics, 'Практика' . $numberPractics++, array_get($practics_parsed, 'НИР.ПрочаяПрактика.' . $counter_practic++));
                    }
                }
            }
        }
        if (array_get($practics_parsed, 'ПрочиеПрактики.ПрочаяПрактика') !== null) {
            if (array_get($practics_parsed, 'ПрочиеПрактики.ПрочаяПрактика.@Наименование') !== null) {
                $practics = array_add($practics, 'Практика'.$numberPractics++, array_get($practics_parsed, 'ПрочиеПрактики.ПрочаяПрактика'));
            }
            else {
                $counter_practic = 0;
                if (is_array(array_get($practics_parsed, 'ПрочиеПрактики.ПрочаяПрактика'))) {
                    foreach (array_get($practics_parsed, 'ПрочиеПрактики.ПрочаяПрактика') as $practic) {
                        $practics = array_add($practics, 'Практика' . $numberPractics++, array_get($practics_parsed, 'ПрочиеПрактики.ПрочаяПрактика.' . $counter_practic++));
                    }
                }
            }
        }
// ========================== Парсинг практик Конец ====================================================================

// ========================== Собираем всё в кучу и отправляем =========================================================
        $planAll = array();
        $planAll = array_add($planAll, 'Информация', $plan);
        $planAll = array_add($planAll, 'Дисциплины', $this->extractPlanDiscs($discs));
        $planAll = array_add($planAll, 'Практики', $practics);
        dd(array_get($planAll, 'Дисциплины'));
        dd($discs);

        return $planAll;
    }

    private function extractPlanDiscs($discs){ // Упорядочивание загруженных дисциплин
        $extractedDiscs = array();
        foreach ($discs as $disc){
            for ($index=0; $index < array_get($disc, 'Количествокурсов'); $index++) { // index - индекс курса = 0..5
                $extractedDiscs[] = $this->makeOneDisc($disc, $index);
            }
        }

        return $extractedDiscs;


    }

    private function makeOneDisc($disc, $index){ // Формируем запись в дисциплинах

        $dis = array();
        $dis = array_add($dis, 'Цикл', array_get($disc, 'НовЦикл'));
        $dis = array_add($dis, 'Индекс', array_get($disc, 'НовИдДисциплины'));
        $dis = array_add($dis, 'Наименование', array_get($disc, 'Дисциплина'));
        $dis = array_add($dis, 'ПодлежитИзучениюЧасов', array_get($disc, 'ПодлежитИзучению'));
        $dis = array_add($dis, 'ПерезачетЧасов', array_get($disc, 'ПерезачетЧасов'));
        $dis = array_add($dis, 'ПроектЗЕТПерезачтено', array_get($disc, 'ПроектЗЕТПерезачтено'));
        $dis = array_add($dis, 'ЗЕТ', array_get($disc, 'КредитовНаДисциплину'));
        $dis = array_add($dis, 'НомерКурса', array_get($disc, 'НомерКурса'.$index));
//        $dis = array_add($dis, 'Курс', array_get($disc, 'Курс'.$index));

        if (is_array(array_get($disc, 'Курс'.$index)))
            foreach (array_get($disc, 'Курс'.$index) as $itemKurs) {
                switch (array_get($itemKurs, '@Ном')){
                    case 1:
                        $dis = array_add($dis, 'СеместрУстановочный', $itemKurs);
                        break;
                    case 2:
                        $dis = array_add($dis, 'СеместрОсенний', $itemKurs);
                        break;
                    case 3:
                        $dis = array_add($dis, 'СеместрВесенний', $itemKurs);
                        break;
                }
            }

        return $dis;
    }

}

