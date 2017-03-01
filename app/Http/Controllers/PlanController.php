<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Orchestra\Parser\XmlServiceProvider;
use Nathanmac\Utilities\Parser\Parser;
class PlanController extends Controller
{
    public function index(){
        return view('plan');
    }

    public function showUploadFile(Request $request){
        $file = $request->file('uploadfile');

        if ($file->getMimeType() == 'application/xml') {

/*// =========================== Начало Orchestra\Parser\XmlServiceProvider ==============================


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
// =========================== Конец Orchestra\Parser\XmlServiceProvider ==============================*/


// =========================== Начало Nathanmac\Utilities\Parser\Parser ==============================

//            $responseItems = (array) $parsed['План']['СтрокиПлана']['Строка'];
//            foreach ($responseItems as $responseItem){
//                dd($responseItem);
//            };

            $parser = new Parser();
            $parsed = $parser->xml(file_get_contents($file));

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

            $discs = array_get($parsed, 'План.СтрокиПлана.Строка'); // Достаём дисциплины из xml
            $dis_arr = array();
            foreach ($discs as $disc){
//                $dis = array_only($disc, array('@Дис', '@Цикл', '@НовЦикл', '@ИдетификаторДисциплины', '@НовИдДисциплины', '@Кафедра'));
                $dis = array();
                $dis = array_add($dis, 'Дисциплина', array_get($disc, '@Дис'));
                $dis = array_add($dis, 'Цикл', array_get($disc, '@Цикл'));
                $dis = array_add($dis, 'НовЦикл', array_get($disc, '@НовЦикл'));
                $dis = array_add($dis, 'ИдетификаторДисциплины', array_get($disc, '@ИдетификаторДисциплины'));
                $dis = array_add($dis, 'НовИдДисциплины', array_get($disc, '@НовИдДисциплины'));
                $dis = array_add($dis, 'Кафедра', array_get($disc, '@Кафедра'));
                $dis = array_add($dis, 'НомерКурса', array_get($disc, 'Курс.@Ном'));
                if (array_get($disc, 'Курс.@Лек')) $dis = array_add($dis, 'ЛекцииВсего', array_get($disc, 'Курс.@Лек'));
                if (array_get($disc, 'Курс.@Лаб')) $dis = array_add($dis, 'ЛабораторныеВсего', array_get($disc, 'Курс.@Лаб'));
                if (array_get($disc, 'Курс.@Пр')) $dis = array_add($dis, 'ПрактикиВсего', array_get($disc, 'Курс.@Пр'));
                if (array_get($disc, 'Курс.@КСР')) $dis = array_add($dis, 'КСРВсего', array_get($disc, 'Курс.@КСР'));
                if (array_get($disc, 'Курс.@СРС')) $dis = array_add($dis, 'СРСВсего', array_get($disc, 'Курс.@СРС'));
                if (array_get($disc, 'Курс.@ЗЕТ')) $dis = array_add($dis, 'ЗЕТВсего', array_get($disc, 'Курс.@ЗЕТ'));

                // Парсинг сессий
                if (array_get($disc, 'Курс.Сессия') !== null) {
                    for ($i=1 ; $i <= 3; $i++){
                        switch (array_get($disc, 'Курс.Сессия.@Ном')) {
                            case '1':
                                $dis = array_add($dis, 'СессияУстановочная', array_get($disc, 'Курс.Сессия'));
                                break;
                            case '2':
                                $dis = array_add($dis, 'СессияОсень', array_get($disc, 'Курс.Сессия'));
                                break;
                            case '3':
                                $dis = array_add($dis, 'СессияВесна', array_get($disc, 'Курс.Сессия'));
                                break;
                        }
                        if (array_get($disc, 'Курс.Сессия.0.@Ном') !== null) $dis = array_add($dis, 'СессияУстановочная', array_get($disc, 'Курс.Сессия.0'));
                        if (array_get($disc, 'Курс.Сессия.1.@Ном') !== null) $dis = array_add($dis, 'СессияОсень', array_get($disc, 'Курс.Сессия.1'));
                        if (array_get($disc, 'Курс.Сессия.2.@Ном') !== null) $dis = array_add($dis, 'СессияВесна', array_get($disc, 'Курс.Сессия.2'));
                    }
                }



//                echo($dis['Дисциплина']);
//                foreach (array_get($disc, 'Курс.Сессия') as $ar){
//                    $dis = array_add($dis, 'Сессия', $ar);
//                }
//                for ($i=1 ; $i <= 3; $i++){
//                    if (array_get($disc, 'Курс.Сессия.@Ном') == '1') $dis = array_add($dis, 'СессияУстановочная', array_get($disc, 'Курс.Сессия'));
//                    if (array_get($disc, 'Курс.Сессия.@Ном') == '2') $dis = array_add($dis, 'СессияОсень', array_get($disc, 'Курс.Сессия'));
//                    if (array_get($disc, 'Курс.Сессия.@Ном') == '3') $dis = array_add($dis, 'СессияВесна', array_get($disc, 'Курс.Сессия'));
//                    if ((array_get($disc, 'Курс.Сессия.@Ном') === null) & is_array(array_get($disc, 'Курс.Сессия.@Ном'))) {
//
//                        foreach (array_get($disc, 'Курс.Сессия') as $ar){
//                            if (array_get($ar, '@Ном') == '1') $dis = array_add($dis, '=СессияУстановочная', array_get($ar, '@Ном'));
//                            if (array_get($ar, '@Ном') == '2') $dis = array_add($dis, '=СессияОсень', array_get($ar, '@Ном'));
//                            if (array_get($ar, '@Ном') == '3') $dis = array_add($dis, '=СессияВесна', array_get($ar, '@Ном'));
//                        }
//                    }
//                }
//                dd($dis);
//                if (is_array(array_only($disc, array('Курс.Сессия.@Ном')))) {
//                    $dis = array_add($dis, 'НомерСессии', 'Несколько сессий');
//                    dd(array_get($disc, 'Курс'));
//                } else $dis = array_add($dis, 'НомерСессии', array_get($disc, 'Курс.Сессия.@Ном'));
//                  $dis = array_add($dis, 'Сессия', array_only($disc, array('Курс.Сессия.@Ном')));
//                switch (array_get($disc, 'Курс.Сессия.@Ном')){
//                    case '1':
//                        $dis = array_add($dis, 'ЛекцииУстановочные', array_get($disc, 'Курс.Сессия.@Лек'));
//                        $dis = array_add($dis, 'ЛабораторныеУстановочные', array_get($disc, 'Курс.Сессия.@Лаб'));
//                        $dis = array_add($dis, 'ПрактикиУстановочные', array_get($disc, 'Курс.Сессия.@Пр'));
//                        $dis = array_add($dis, 'КСРУстановочные', array_get($disc, 'Курс.Сессия.@КСР'));
//                        $dis = array_add($dis, 'СРСУстановочные', array_get($disc, 'Курс.Сессия.@СРС'));
//                        $dis = array_add($dis, 'ЗЕТУстановочные', array_get($disc, 'Курс.Сессия.@ЗЕТ'));
//                    break;
//                    case '2':
//                        $dis = array_add($dis, 'ЛекцииОсень', array_get($disc, 'Курс.Сессия.@Лек'));
//                        $dis = array_add($dis, 'ЛабораторныеОсень', array_get($disc, 'Курс.Сессия.@Лаб'));
//                        $dis = array_add($dis, 'ПрактикиОсень', array_get($disc, 'Курс.Сессия.@Пр'));
//                        $dis = array_add($dis, 'КСРОсень', array_get($disc, 'Курс.Сессия.@КСР'));
//                        $dis = array_add($dis, 'СРСОсень', array_get($disc, 'Курс.Сессия.@СРС'));
//                        $dis = array_add($dis, 'ЗЕТОсень', array_get($disc, 'Курс.Сессия.@ЗЕТ'));
//                    break;
//                    case '3':
//                        $dis = array_add($dis, 'ЛекцииВесна', array_get($disc, 'Курс.Сессия.@Лек'));
//                        $dis = array_add($dis, 'ЛабораторныеВеснае', array_get($disc, 'Курс.Сессия.@Лаб'));
//                        $dis = array_add($dis, 'ПрактикиВесна', array_get($disc, 'Курс.Сессия.@Пр'));
//                        $dis = array_add($dis, 'КСРВесна', array_get($disc, 'Курс.Сессия.@КСР'));
//                        $dis = array_add($dis, 'СРСВесна', array_get($disc, 'Курс.Сессия.@СРС'));
//                        $dis = array_add($dis, 'ЗЕТВесна', array_get($disc, 'Курс.Сессия.@ЗЕТ'));
//                    break;
//                    case null:
//                    break;
//                }
//                if (array_get($disc, 'Курс.Сессия.@Ном') === '1'){
//                    $dis = array_add($dis, 'ЗЕТВсего', array_get($disc, 'Курс.@ЗЕТ'));
//                }

                $dis_arr[] = $dis;
            };




//            $array = array_only($discs, array('@Дис', '@Цикл', '@НовЦикл', '@НовИдДисциплины', '@Кафедра', 'Курс')); $discs
            dd($dis_arr);

// =========================== Конец Nathanmac\Utilities\Parser\Parser ==============================


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
        }
        else echo 'Не тот тип файла. Загрузите xml!';

       // $xml = \XmlParser::load($file->getPathname());



    }
}
