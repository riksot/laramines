<?php

namespace App\Http\Controllers;
use App\Plan;
use function foo\func;
use Illuminate\Http\Request;


class PlanController extends Controller
{
    public function index(){
        return view('plan');
    }

    public function showUploadFile(Request $request, Plan $planModel){
        $file = $request->file('uploadfile');
        if ($file->getMimeType() == 'application/xml') {

            $planAll = $planModel->parseXmlFile($file);   // Парсинг файла в модели Plan
           // dd(array_get($planAll,'Дисциплины'));
            return view('tables.downloadPlan', ['planAll' => $planAll]);
        }
        else echo 'Не тот тип файла. Загрузите правильный файл!';
    }

    public function parseXMLFile(Request $request){ // Парсер шахтинского xml файла

        function makeStringFromArray($xmlFile, $parent, $child){ // переделываем массив из xml файла в строку
            $attr =(array)$xmlFile->{'План'}->{'Титул'}->{$parent};
            $temparr = array();
            if (is_array($attr[$child]))
                foreach ($attr[$child] as $id => $item){
                    $temparr = array_add($temparr, $child.$id, implode(';;',array_flatten((array)$item,1)));
                }
            else
                $temparr = array_add($temparr, $child, implode(';;',array_flatten((array)$attr[$child],1)));
            return $temparr;

        }

        $file = $request->file('uploadfile');
        if ($file->getMimeType() == 'application/xml') {
            $xmlFile = simplexml_load_file($file);
            $parsedFile = array();
            $items = array();
/*
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

*/

            // XML - АтрибутыЦикловНов
            $attr =(array)$xmlFile->{'План'}->{'Титул'}->{'АтрибутыЦикловНов'};
                $temparr = array();
            if (is_array($attr['Цикл']))
                foreach ($attr['Цикл'] as $id => $item){
                    $temparr = array_add($temparr, 'Цикл'.$id, implode(';;',array_flatten((array)$item,1)));
                }
            else
                $temparr = array_add($temparr, 'Цикл', implode(';;',array_flatten((array)$attr['Цикл'],1)));
            $items = array_add($items, 'АтрибутыЦикловНов', implode('##',$temparr));

            // XML - АтрибутыЦиклов
            $attr =(array)$xmlFile->{'План'}->{'Титул'}->{'АтрибутыЦиклов'};
            $temparr = array();
            if (is_array($attr['Цикл']))
                foreach ($attr['Цикл'] as $id => $item){
                    $temparr = array_add($temparr, 'Цикл'.$id, implode(';;',array_flatten((array)$item,1)));
                }
            else
                $temparr = array_add($temparr, 'Цикл', implode(';;',array_flatten((array)$attr['Цикл'],1)));
            $items = array_add($items, 'АтрибутыЦиклов', implode('##',$temparr));

            // XML - Специальности
            $attr =(array)$xmlFile->{'План'}->{'Титул'}->{'Специальности'};
            $temparr = array();
            if (is_array($attr['Специальность']))
                foreach ($attr['Специальность'] as $id => $item){
                    $temparr = array_add($temparr, 'Специальность'.$id, implode(';;',array_flatten((array)$item,1)));
                }
            else
                $temparr = array_add($temparr, 'Специальность', implode(';;',array_flatten((array)$attr['Специальность'],1)));
            $items = array_add($items, 'Специальности', implode('##',$temparr));

            // XML - Квалификации
            $attr =(array)$xmlFile->{'План'}->{'Титул'}->{'Квалификации'};
            $temparr = array();
            if (is_array($attr['Квалификация']))
                foreach ($attr['Квалификация'] as $id => $item){
                    $temparr = array_add($temparr, 'Квалификация'.$id, implode(';;',array_flatten((array)$item,1)));
                }
            else
                $temparr = array_add($temparr, 'Квалификация', implode(';;',array_flatten((array)$attr['Квалификация'],1)));
            $items = array_add($items, 'Квалификации', implode('##',$temparr));

            // XML - ВидыДеятельности
            $attr =(array)$xmlFile->{'План'}->{'Титул'}->{'ВидыДеятельности'};
            $temparr = array();
            if (is_array($attr['ВидДеятельности']))
                foreach ($attr['ВидДеятельности'] as $id => $item){
                    $temparr = array_add($temparr, 'ВидДеятельности'.$id, implode(';;',array_flatten((array)$item,1)));
                }
            else
                $temparr = array_add($temparr, 'ВидДеятельности', implode(';;',array_flatten((array)$attr['ВидДеятельности'],1)));
            $items = array_add($items, 'ВидыДеятельности', implode('##',$temparr));

            // XML - Разработчики
            $attr =(array)$xmlFile->{'План'}->{'Титул'}->{'Разработчики'};
            $temparr = array();
            if (is_array($attr['Разработчик']))
                foreach ($attr['Разработчик'] as $id => $item){
                    $temparr = array_add($temparr, 'Разработчик'.$id, implode(';;',array_flatten((array)$item,1)));
                }
            else
                $temparr = array_add($temparr, 'Разработчик', implode(';;',array_flatten((array)$attr['Разработчик'],1)));
            $items = array_add($items, 'Разработчики', implode('##',$temparr));






            dd($xmlFile,$items);

            return view('tables.downloadPlan', ['planAll' => '']);
        }
        else return view('plan', ['alert' => 'Не тот тип файла. Загрузите правильный файл!']);
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

//            $array = array_only($discs, array('@Дис', '@Цикл', '@НовЦикл', '@НовИдДисциплины', '@Кафедра', 'Курс')); $discs
