<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Orchestra\Parser\XmlServiceProvider;

class PlanController extends Controller
{
    public function index(){
        return view('plan');
    }

    public function showUploadFile(Request $request){
        $file = $request->file('uploadfile');

        if ($file->getMimeType() == 'application/xml') {

            $xml = \XmlParser::load($file->getPathname());
            $plan = $xml->parse([
                'Головная' => ['uses' => 'План.Титул::Головная'],
                'ОбразовательноеУчреждение' => ['uses' => 'План.Титул::ИмяВуза'],
                'СтруктурноеПодразделение' => ['uses' => 'План.Титул::ИмяВуза2'],
                'Кафедра' => ['uses' => 'План.Титул::КодКафедры'],
                'Факультет' => ['uses' => 'План.Титул::Факультет'],
                'WhoRatif' => ['uses' => 'План.Титул::WhoRatif'],
                'КодНаправления' => ['uses' => 'План.Титул::ПоследнийШифр'],
                'ГодНачалаПодготовки' => ['uses' => 'План.Титул::ГодНачалаПодготовки'],
                'ТипГОСа' => ['uses' => 'План.Титул::ТипГОСа'],
                'ДокументГОСа' => ['uses' => 'План.Титул::ДокументГОСа'],
                'ДатаГОСа' => ['uses' => 'План.Титул::ДатаГОСа'],
                'Квалификация' => ['uses' => 'План.Титул.Квалификации.Квалификация::Название'],
                'СрокОбучения' => ['uses' => 'План.Титул.Квалификации.Квалификация::СрокОбучения'],
                'ВидыДеятельности' => ['uses' => 'План.Титул.ВидыДеятельности.ВидДеятельности[::Ном>Ном,::Название>Название]', 'default' => null],
                'Разработчики' => ['uses' => 'План.Титул.Разработчики.Разработчик[::Ном>Ном,::ФИО>ФИО,::Должность>Должность,::Активный>Активный]', 'default' => null],
                'Специальности' => ['uses' => 'План.Титул.Специальности.Специальность[::Ном>Ном,::Название>Название]', 'default' => null],
                'Дисциплины' => ['uses' => 'План.СтрокиПлана.Строка[::Дис>Дисциплина,::НовИдДисциплины>ИдДисциплины,::Цикл>Цикл,::НовЦикл>НовЦикл,::Кафедра>Кафедра,Курс::Ном>НомерКурса]', 'default' => null],

            ]);
            dd($plan);

            //Display File Name
            echo 'File Name: '.$file->getClientOriginalName();
            echo '<br>';

            //Display File Extension
            echo 'File Extension: '.$file->getClientOriginalExtension();
            echo '<br>';

            //Display File Real Path
            echo 'File Real Path: '.$file->getRealPath();
            echo '<br>';

            //Display File Size
            echo 'File Size: '.$file->getSize();
            echo '<br>';

            //Display File Mime Type
            echo 'File Mime Type: '.$file->getMimeType();

            //Move Uploaded File
            $destinationPath = 'uploads';
            $file->move($destinationPath,$file->getClientOriginalName());
        }
        else echo 'Не тот тип файла. Загрузите xml!';

       // $xml = \XmlParser::load($file->getPathname());



    }
}
