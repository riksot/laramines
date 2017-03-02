<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Nathanmac\Utilities\Parser\Parser;
class PlanController extends Controller
{
    public function index(){
        return view('plan');
    }

    public function showUploadFile(Request $request){
        $file = $request->file('uploadfile');
        if ($file->getMimeType() == 'application/xml') {

// =========================== Начало Nathanmac\Utilities\Parser\Parser ================================================

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
//                $dis = array_only($disc, array('@Дис', '@Цикл', '@НовЦикл', '@ИдетификаторДисциплины', '@НовИдДисциплины', '@Кафедра'));
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
                                            foreach (array_get($kurs, 'Сессия') as $sessia) {
                                                $dis = array_add($dis, 'НомерКурса' . $kolvoKursov . '.Сессия' . $kolvosessii, $sessia);
                                                $kolvosessii++;
                                            }
                                        }
                                    } else {
                                        $dis = array_add($dis, 'НомерКурса' . $kolvoKursov . '.Сессия0', array_get($kurs, 'Сессия'));
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
                                foreach (array_get(array_get($disc, 'Курс'), 'Сессия') as $sessia) {
                                    $dis = array_add($dis, 'НомерКурса0' . '.Сессия' . $kolvosessii, $sessia);
                                    $kolvosessii++;
                                }
                            }
                        }
                        else {
                            $dis = array_add($dis, 'НомерКурса0'.'.Сессия0', array_get($disc, 'Курс.Сессия'));
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

            dd($discs);
//            $array = array_only($discs, array('@Дис', '@Цикл', '@НовЦикл', '@НовИдДисциплины', '@Кафедра', 'Курс')); $discs

// =========================== Конец Nathanmac\Utilities\Parser\Parser =================================================

        }
        else echo 'Не тот тип файла. Загрузите правильный файл!';

    }
}



// ==========================  СВАЛКА!!!!! =============================================================================
// $xml = \XmlParser::load($file->getPathname());

//            $responseItems = (array) $parsed['План']['СтрокиПлана']['Строка'];
//            foreach ($responseItems as $responseItem){
//                dd($responseItem);
//            };
//                if (array_get($disc, 'Курс.@Лек')) $dis = array_add($dis, 'ЛекцииВсего', array_get($disc, 'Курс.@Лек'));
// ==========================  СВАЛКА!!!!! =============================================================================



//            //Display File Name
//            echo 'File Name: '.$file->getClientOriginalName();
//            echo '<br>';
//
//            //Display File Extension
//            echo 'File Extension: '.$file->getClientOriginalExtension();
//            echo '<br>';
//
//            //Display File Real Path
//            echo 'File Real Path: '.$file->getRealPath();
//            echo '<br>';
//
//            //Display File Size
//            echo 'File Size: '.$file->getSize();
//            echo '<br>';
//
//            //Display File Mime Type
//            echo 'File Mime Type: '.$file->getMimeType();
//
//            //Move Uploaded File
//            $destinationPath = 'uploads';
//            $file->move($destinationPath,$file->getClientOriginalName());

/*// =========================== Начало Orchestra\Parser\XmlServiceProvider ============================================

use Orchestra\Parser\XmlServiceProvider;
            $xml = \XmlParser::load($file->getPathname());
            $plan = $xml->parse([
                'Головная' =>                   ['uses' => 'План.Титул::Головная'],
                'ОбразовательноеУчреждение' =>  ['uses' => 'План.Титул::ИмяВуза'],
                'СтруктурноеПодразделение' =>   ['uses' => 'План.Титул::ИмяВуза2'],
                'Кафедра' =>                    ['uses' => 'План.Титул::КодКафедры'],
                'Факультет' =>                  ['uses' => 'План.Титул::Факультет'],
                'WhoRatif' =>                   ['uses' => 'План.Титул::WhoRatif'],
                'КодНаправления' =>             ['uses' => 'План.Титул::ПоследнийШифр'],
                'ГодНачалаПодготовки' =>        ['uses' => 'План.Титул::ГодНачалаПодготовки'],
                'ТипГОСа' =>                    ['uses' => 'План.Титул::ТипГОСа'],
                'ДокументГОСа' =>               ['uses' => 'План.Титул::ДокументГОСа'],
                'ДатаГОСа' =>                   ['uses' => 'План.Титул::ДатаГОСа'],
                'Квалификация' =>               ['uses' => 'План.Титул.Квалификации.Квалификация::Название'],
                'СрокОбучения' =>               ['uses' => 'План.Титул.Квалификации.Квалификация::СрокОбучения'],
                'ВидыДеятельности' =>           ['uses' => 'План.Титул.ВидыДеятельности.ВидДеятельности[::Ном>Ном,::Название>Название]', 'default' => null],
                'Разработчики' =>               ['uses' => 'План.Титул.Разработчики.Разработчик[::Ном>Ном,::ФИО>ФИО,::Должность>Должность,::Активный>Активный]', 'default' => null],
                'Специальности' =>              ['uses' => 'План.Титул.Специальности.Специальность[::Ном>Ном,::Название>Название]', 'default' => null],
                'Дисциплины' =>                 ['uses' => 'План.СтрокиПлана.Строка[::Дис>Дисциплина,::НовИдДисциплины>ИдДисциплины,::Цикл>Цикл,::НовЦикл>НовЦикл,::Кафедра>Кафедра,Курс::Ном>НомерКурса,Курс.Сессия::Ном>СессияНомер]', 'default' => null],

            ]);
            dd($plan);
// =========================== Конец Orchestra\Parser\XmlServiceProvider =============================================*/
