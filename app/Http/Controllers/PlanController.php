<?php

namespace App\Http\Controllers;
use App\Courses;
use App\Disciplines;
use App\FilesParser;
use App\Plan;
use App\Plans;
use function foo\func;
use Illuminate\Http\Request;
use SoapBox\Formatter\Formatter;
use Symfony\Component\Console\Descriptor\XmlDescriptor;

class PlanController extends Controller
{
    public function index(){
        return view('plan.uploadPlan');
    }

    public function showUploadFile(Request $request, Plan $planModel){
        $file = $request->file('uploadfile');
        if ($file->getMimeType() == 'application/xml') {

            $planAll = $planModel->parseXmlFile($file);   // Парсинг файла в модели Plan
           // dd(array_get($planAll,'Дисциплины'));

            return view('tables.downloadPlan', ['planAll' => $planAll]);

        }
        else return 'Не тот тип файла. Загрузите правильный файл!';
    }

    public function uploadPlan(Request $request, FilesParser $info){ // Загрузка шахтинского xml файла
        $file = $request->file('uploadfile');
        \Storage::disk('public')->put('\/'.$file->getFilename(),file_get_contents($file->getRealPath()));  // Убираем файл в публичную папку

        $fileName = $file->getFilename();
        $fileXML=\Storage::disk('public')->get('\/'.$fileName);

        $mainPlanInfo = $info->parseXMLFile($fileXML,1);
        return view('plan.planToBase', ['planAll' => $mainPlanInfo['Титул'], 'fileName' => $fileName]);

    }


    public function savePlanToBase(FilesParser $info){ // Загрузка шахтинского xml файла в базу через ajax

        function pullCourseInfo($attributesArray){
            return $attributesArray;
        }


        $fileXML=\Storage::disk('public')->get('\/'.$_REQUEST['filepath']);
        $parsedFile = $info->parseXMLFile($fileXML);

//        $plans->insert($parsedFile['Титул']); // старое
        $plansArray = $parsedFile['Титул'];
        $plans = new Plans($plansArray); // Загружаем титул в базу (таблица plans)
        $plans->save();
        $planId = $plans->id;
//        dd($plans->id);  // Получаем id плана

        foreach ($parsedFile['СтрокиПлана'] as $item){

            //////////////////////// ПЕРЕДЕЛАТЬ В НОРМАЛЬНЫЙ МАССИВ!!!!!!! +++++++++++++++++++++++++++
            

            $disciplinesArray = [
                'План_id'                => $planId,
                'Дис'                    => isset($item['@attributes']['Дис']) ? $item['@attributes']['Дис'] : null,
                'НовЦикл'                => isset($item['@attributes']['НовЦикл']) ? $item['@attributes']['НовЦикл'] : null,
                'НовИдДисциплины'        => isset($item['@attributes']['НовИдДисциплины']) ? $item['@attributes']['НовИдДисциплины'] : null,
                'Цикл'                   => isset($item['@attributes']['Цикл']) ? $item['@attributes']['Цикл'] : null,
                'ИдетификаторДисциплины' => isset($item['@attributes']['ИдетификаторДисциплины']) ? $item['@attributes']['ИдетификаторДисциплины'] : null,
                'ИдентификаторВидаПлана' => isset($item['@attributes']['ИдентификаторВидаПлана']) ? $item['@attributes']['ИдентификаторВидаПлана'] : null,
                'ГОС'                    => isset($item['@attributes']['ГОС']) ? $item['@attributes']['ГОС'] : null,
                'ЧасовИнтер'             => isset($item['@attributes']['ЧасовИнтер']) ? $item['@attributes']['ЧасовИнтер'] : null,
                'СР'                     => isset($item['@attributes']['СР']) ? $item['@attributes']['СР'] : null,
                'СемЭкз'                 => isset($item['@attributes']['СемЭкз']) ? $item['@attributes']['СемЭкз'] : null,
                'СемЗач'                 => isset($item['@attributes']['СемЗач']) ? $item['@attributes']['СемЗач'] : null,
                'СемКП'                  => isset($item['@attributes']['СемКП']) ? $item['@attributes']['СемКП'] : null,
                'СемКР'                  => isset($item['@attributes']['СемКР']) ? $item['@attributes']['СемКР'] : null,
                'КомпетенцииКоды'        => isset($item['@attributes']['КомпетенцииКоды']) ? $item['@attributes']['КомпетенцииКоды'] : null,
                'Кафедра'                => isset($item['@attributes']['Кафедра']) ? $item['@attributes']['Кафедра'] : null,
                'ДисциплинаДляРазделов'  => isset($item['@attributes']['ДисциплинаДляРазделов']) ? $item['@attributes']['ДисциплинаДляРазделов'] : null,
                'Раздел'                 => isset($item['@attributes']['Раздел']) ? $item['@attributes']['Раздел'] : null,
                'НеСчитатьКонтроль'      => isset($item['@attributes']['НеСчитатьКонтроль']) ? $item['@attributes']['НеСчитатьКонтроль'] : null,
                'ПодлежитИзучению'       => isset($item['@attributes']['ПодлежитИзучению']) ? $item['@attributes']['ПодлежитИзучению'] : null,
                'КредитовНаДисциплину'   => isset($item['@attributes']['КредитовНаДисциплину']) ? $item['@attributes']['КредитовНаДисциплину'] : null,
                'ЧасовВЗЕТ'              => isset($item['@attributes']['ЧасовВЗЕТ']) ? $item['@attributes']['ЧасовВЗЕТ']:null,
            ];
            $disciplines = new Disciplines($disciplinesArray); // Загружаем титул в базу (таблица plans)
            $disciplines->save();
            $disciplineId = $disciplines->id;

            if (isset($item['Курс']['@attributes'])){
                //pullCourseInfo($item['Курс']['@attributes'], $disciplineId);

                $corseArray = [
                   'Дис_id' => $disciplineId
                ];
                $corseArray = array_merge($corseArray, pullCourseInfo($item['Курс']['@attributes']));
                $courses = new Courses($corseArray); // Загружаем титул в базу (таблица plans)
                $courses->save();
            }
            elseif(is_array($item['Курс'])){
                foreach ($item['Курс'] as $kurs){
                    $corseArray = [
                        'Дис_id' => $disciplineId
                    ];
                    $corseArray = array_merge($corseArray, pullCourseInfo($kurs['@attributes']));
                    $courses = new Courses($corseArray); // Загружаем титул в базу (таблица plans)
                    $courses->save();
                }
            }

        }


        return ('Информация успешно загружена в базу данных!');
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
