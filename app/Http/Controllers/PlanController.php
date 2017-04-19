<?php

namespace App\Http\Controllers;
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

        $parsedFile = $info->parseXMLFile($fileXML);

        $mainPlanInfo = array();
        $mainPlanInfo = array_add($mainPlanInfo, 'Головная', $parsedFile['Головная']);
        $mainPlanInfo = array_add($mainPlanInfo, 'ИмяВуза', $parsedFile['ИмяВуза']);
        $mainPlanInfo = array_add($mainPlanInfo, 'ИмяВуза2', $parsedFile['ИмяВуза2']);
        $mainPlanInfo = array_add($mainPlanInfo, 'ГодНачалаПодготовки', $parsedFile['ГодНачалаПодготовки']);
        $mainPlanInfo = array_add($mainPlanInfo, 'ПоследнийШифр', $parsedFile['ПоследнийШифр']);

        $mainPlanInfo = array_add($mainPlanInfo, 'Направление', unserialize($parsedFile['Специальности'])['Специальность'][0]['@attributes']['Название']);
        $mainPlanInfo = array_add($mainPlanInfo, 'Профиль',     unserialize($parsedFile['Специальности'])['Специальность'][1]['@attributes']['Название']);


        $mainPlanInfo = array_add($mainPlanInfo, 'Квалификация',     unserialize($parsedFile['Квалификации'])['Квалификация']['@attributes']['Название']);
        $mainPlanInfo = array_add($mainPlanInfo, 'СрокОбучения',     unserialize($parsedFile['Квалификации'])['Квалификация']['@attributes']['СрокОбучения']);

//       dump($mainPlanInfo, $fileName);
            return view('plan.planToBase', ['planAll' => $mainPlanInfo, 'fileName' => $fileName]);

    }


    public function savePlanToBase(FilesParser $info, Plans $plans){ // Загрузка шахтинского xml файла
        $fileXML=\Storage::disk('public')->get('\/'.$_REQUEST['filepath']);
        $parsedFile = $info->parseXMLFile($fileXML);
        $plans->insert($parsedFile);

        return ('Информация загружена в базу данных!');

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
