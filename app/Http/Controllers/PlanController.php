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
    // =================== Отображение плана или его загрузка ==========================================================
    public function index($idPlan = null){
        if (isset($idPlan)){
            //$planAll=array();

            // Достаем список дисциплин
            $disciplines = Disciplines::all()->where('План_id',$idPlan);

            // Достаем список практик
            $practics = Plans::all()->where('id',$idPlan)->first();
            $tempArray = array();
            $practics = unserialize($practics['СпецВидыРаботНов']);
            //dd($practics);
//            for($i=0; $i < count($practics)-1; $i++){
                if(isset($practics['УчебПрактики'])){
                    if (isset($practics['УчебПрактики']['ПрочаяПрактика']['@attributes'])){
                        $practics['УчебПрактики']['ПрочаяПрактика']['@attributes']['Индекс'] = 'Б2.У.1';
                        $practics['УчебПрактики']['ПрочаяПрактика']['@attributes'] =
                            array_merge(
                                $practics['УчебПрактики']['ПрочаяПрактика']['@attributes'],
                                $practics['УчебПрактики']['ПрочаяПрактика']['Семестр']['@attributes']);
                        $tempArray[] = $practics['УчебПрактики']['ПрочаяПрактика']['@attributes'];
                    }
                    else
                        foreach ($practics['УчебПрактики']['ПрочаяПрактика'] as $id => $practic){
                            $practic['@attributes']['Индекс'] = 'Б2.У.'.($id+1);
                            $practic['@attributes'] = array_merge($practic['@attributes'], $practic['Семестр']['@attributes']);
                            $tempArray[] = $practic['@attributes'];
                        }
                }
                if(isset($practics['НИР'])){
                    if (isset($practics['НИР']['ПрочаяПрактика']['@attributes'])){
                        $practics['НИР']['ПрочаяПрактика']['@attributes']['Индекс'] = 'Б2.Н.1';
                        $practics['НИР']['ПрочаяПрактика']['@attributes'] =
                            array_merge(
                                $practics['НИР']['ПрочаяПрактика']['@attributes'],
                                $practics['НИР']['ПрочаяПрактика']['Семестр']['@attributes']);
                        $tempArray[] = $practics['НИР']['ПрочаяПрактика']['@attributes'];
                    }
                    else
                        foreach ($practics['НИР']['ПрочаяПрактика'] as $id => $practic){
                            $practic['@attributes']['Индекс'] = 'Б2.Н.'.($id+1);
                            $practic['@attributes'] = array_merge($practic['@attributes'], $practic['Семестр']['@attributes']);
                            $tempArray[] = $practic['@attributes'];
                        }
                }
                if(isset($practics['ПрочиеПрактики'])){
                    if (isset($practics['ПрочиеПрактики']['ПрочаяПрактика']['@attributes'])){
                        $practics['ПрочиеПрактики']['ПрочаяПрактика']['@attributes']['Индекс'] = 'Б2.П.1';
                        $practics['ПрочиеПрактики']['ПрочаяПрактика']['@attributes'] =
                            array_merge(
                                $practics['ПрочиеПрактики']['ПрочаяПрактика']['@attributes'],
                                $practics['ПрочиеПрактики']['ПрочаяПрактика']['Семестр']['@attributes']);
                        $tempArray[] = $practics['ПрочиеПрактики']['ПрочаяПрактика']['@attributes'];
                    }
                    else
                        foreach ($practics['ПрочиеПрактики']['ПрочаяПрактика'] as $id => $practic){
                            $practic['@attributes']['Индекс'] = 'Б2.П.'.($id+1);
                            $practic['@attributes'] = array_merge($practic['@attributes'], $practic['Семестр']['@attributes']);
                            $tempArray[] = $practic['@attributes'];
                        }
                }
//          }
           // dd($tempArray);
            $practics = $tempArray;



/*            foreach ($disciplines as $discipline){
                $courses = Courses::all()->where('Дис_id', $discipline['id']);
                foreach ($courses as $course){
                    $sessions = Sessions::all()->where('Курс_id', $course['id']);
                    $setupArray = null;
                    foreach ($sessions as $session){

                        if($session['Ном'] == 1){
                            $setupArray = [
                                'Лек'             => $session['Лек'],
                                'Лаб'             => $session['Лаб'],
                                'Пр'            => $session['Пр'],
                            ];
                            continue;
                        }

                        $counterCheckPoints = 0;
                        if (isset($session['Экз'])) $counterCheckPoints = +9;
                        if (isset($session['Зач'])) $counterCheckPoints = +4;
                        if (isset($session['ЗачО'])) $counterCheckPoints = +4;
                        $tempArray = [
                            'НовИдДисциплины' => $discipline['НовИдДисциплины'],
                            'Дис'             => $discipline['Дис'],
                            'Курс'            => $course['Ном'],
                            'Сессия'          => $session['Ном'],
                            'Экз'             => $session['Экз'],
                            'Зач'             => $session['Зач'],
                            'ЗачО'            => $session['ЗачО'],
                            'КП'              => $session['КП'],
                            'КР'              => $session['КР'],
                            'КонтрРаб'        => $session['КонтрРаб'],
                            'Лек'             => $session['Лек']+$setupArray['Лек'],
                            'Лаб'             => $session['Лаб']+$setupArray['Лаб'],
                            'Пр'              => $session['Пр']+$setupArray['Пр'],
                        ];
                        if (isset($setupArray)) $setupArray = null;

                        $tempArray = array_add($tempArray, 'Часов',
                            $tempArray['Лек'] + $tempArray['Лаб'] + $tempArray['Пр'] + $session['КСР'] + $session['СРС'] + $counterCheckPoints);

                        $tempArray = array_add($tempArray, 'ЗЕТ',($tempArray['Часов'])/36);

                        if ($tempArray['Сессия'] == 2) {
                            $tempArray = array_add($tempArray, 'Семестр',($tempArray['Курс']*2-1));
                        }
                        elseif ($tempArray['Сессия'] == 3) {
                            $tempArray = array_add($tempArray, 'Семестр',($tempArray['Курс']*2));
                        }

                        $planAll[] = $tempArray;
                    }


                }


            }*/

            return view('plan.mainPlan', ['disciplines' => $disciplines, 'practics' => $practics]);
        }
        else return view('plan.uploadPlan');
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

    // ============================= Загрузка шахтинского xml файла ====================================================
    public function uploadPlan(Request $request, FilesParser $info){
        $file = $request->file('uploadfile');
        \Storage::disk('public')->put('\/'.$file->getFilename(),file_get_contents($file->getRealPath()));  // Убираем файл в публичную папку

        $fileName = $file->getFilename();
        $fileXML=\Storage::disk('public')->get('\/'.$fileName);

        $mainPlanInfo = $info->parseXMLFile($fileXML,1);
        return view('plan.planToBase', ['planAll' => $mainPlanInfo['Титул'], 'fileName' => $fileName]);

    }


    // ============================ Загрузка шахтинского xml файла в базу через ajax ===================================
    public function savePlanToBase(FilesParser $info){

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

//        dd($parsedFile);
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

            return ('Информация успешно загружена в базу данных!' .' ('. $planId .')');
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
