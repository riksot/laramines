<?php

namespace App\Http\Controllers;
use App\Competences;
use App\Courses;
use App\Disciplines;
use App\FilesParser;
use App\Plan;
use App\Plans;
use App\Sessions;
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


    public function savePlanToBase(FilesParser $info){  // Загрузка шахтинского xml файла в базу через ajax

        function saveCourseInfo($disciplineId, $item){  // Загружаем курс в базу (таблица courses)
            $corseArray = array_merge(['Дис_id' => $disciplineId], $item);
            $courses = new Courses($corseArray);
            $courses->save();
            return $courses->id;
        }

        function saveSessionInfo($courseId, $item){     // Загружаем сессию в базу (таблица sessions)
            $sessionArray = array_merge(['Курс_id' => $courseId], $item);
            $sessions = new Sessions($sessionArray);
            $sessions->save();
            return $sessions->id;
        }

        $fileXML=\Storage::disk('public')->get('\/'.$_REQUEST['filepath']);
        $parsedFile = $info->parseXMLFile($fileXML);

        // ================================ Загружаем титул в базу ========================================

        $plansArray = $parsedFile['Титул'];
        $plans = new Plans($plansArray); // Загружаем титул в базу (таблица plans)
        $plans->save();
        $planId = $plans->id;  // Получаем id плана

        // ================================ Пробегаем по дисциплинам плана ================================

        foreach ($parsedFile['СтрокиПлана'] as $item){

            $disciplinesArray = ['План_id' => $planId];
            if(isset($item['КурсовойПроект'])){
                $disciplinesArray = array_add($disciplinesArray, 'КурсовойПроект' ,serialize($item['КурсовойПроект']));
            }
            if(isset($item['КурсоваяРабота'])){
                $disciplinesArray = array_add($disciplinesArray, 'КурсоваяРабота' ,serialize($item['КурсоваяРабота']));
            }
            $disciplinesArray = array_merge($disciplinesArray,$item['@attributes']);

            $disciplines = new Disciplines($disciplinesArray); // Загружаем дисциплину в базу (таблица disciplines)
            $disciplines->save();
            $disciplineId = $disciplines->id;

            if(isset($item['Курс']['@attributes'])){
                $courseId = saveCourseInfo($disciplineId, $item['Курс']['@attributes']);
                if(isset($item['Курс']['Сессия']['@attributes'])){
                    $sessionId = saveSessionInfo($courseId, $item['Курс']['Сессия']['@attributes']);
                }
                elseif(isset($item['Курс']['Сессия']) && is_array($item['Курс']['Сессия'])){
                    foreach ($item['Курс']['Сессия'] as $session){
                        $sessionId = saveSessionInfo($courseId, $session['@attributes']);
                    }
                }
            }
            elseif(isset($item['Курс']) && is_array($item['Курс'])){
                foreach ($item['Курс'] as $kurs){
                    $courseId = saveCourseInfo($disciplineId, $kurs['@attributes']);
                    if (isset($item['Курс']['Сессия']['@attributes'])){
                        $sessionId = saveSessionInfo($courseId, $item['Курс']['Сессия']['@attributes']);
                    }
                    elseif(isset($item['Курс']['Сессия']) && is_array($item['Курс']['Сессия'])){
                        foreach ($item['Курс']['Сессия'] as $session){
                            $sessionId = saveSessionInfo($courseId, $session['@attributes']);
                        }
                    }
                }
            }
        }

        // ================================ Пробегаем по компетенциям =====================================

        foreach ($parsedFile['Компетенции'] as $item) {
            $competencesArray = array_merge(['План_id' => $planId], $item['@attributes']);
            $competences = new Competences($competencesArray);
            $competences->save();
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
