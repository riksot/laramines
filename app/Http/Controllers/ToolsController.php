<?php

namespace App\Http\Controllers;

use App\Document;
use App\FilesParser;
use App\Tool;
use Illuminate\Http\Request;
use Excel;
use phpDocumentor\Reflection\Types\This;
use Illuminate\Support\Facades\Input;

class ToolsController extends Controller
{
    public function index(){
        return view('tools');
    }

    public function showUploadFile(Request $request, Tool $toolsModel){
        $file = $request->file('uploadxmlfile');
        if ($file->getMimeType() == 'application/xml') {
            $toolsModel->getXMLtoXML($file);  // Обрабатываем файл и записываем его на диск
            echo 'Готово! Файл: <a href="\uploads\\'.$file->getClientOriginalName().'">'.$file->getClientOriginalName().'</a><br/>';
            $resp = 'Готово';
        }
        else $resp = 'Не тот тип файла. Загрузите правильный файл!';
        return view('tools',['fileName' => $file->getClientOriginalName(), 'resp' => $resp]);
    }

    public function makeWordDocument(Request $request, Document $document, FilesParser $info){
        $file = $request->file('file'); // получили файл
        $courses =  $info->makeDataForDonePlanWordDocument($file)['Курсы']; // из xml в array

//        dd($info->makeDataForDonePlanWordDocument($file));
        $excel = Excel::load('templatesdoc/file.xls');
        $sheet = $excel->sheet('Лист1');

        $sheet->setCellValue('A2', $info->makeDataForDonePlanWordDocument($file)['Направление'].' '.$info->makeDataForDonePlanWordDocument($file)['Профиль']);

        $newFile = array_values(array_sort($courses, function($value)  // сортируем
            {
                return $value['Курс'];
            }));
        $startRow = 7;
        $currentRow = 7;
        foreach ($newFile as $id => $item){

                if (($id > 1) AND ((string)$sheet->getCell('A'.($currentRow-1)) !== $item['Курс'])){
                    $sheet->mergeCells('A'.($startRow).':A'.($currentRow-1));  // Объединяем курсы

                    $sheet->getStyle('A'.($startRow))->getAlignment()->applyFromArray(
                        array('horizontal' => 'center')
                    );

                    $sheet->prependRow($currentRow, array(
                        'Декан факультета',
                    ));
                    $sheet->cells('A'.($currentRow).':O'.($currentRow), function($cell) {
                        $cell->setFont(array(
                            'size'       => '11',
                            'bold'       =>  true
                        ));
                    });

                    $sheet->mergeCells('A'.($currentRow).':O'.($currentRow)); // Объединяем строку Декан

                    $sheet->getStyle('A'.($currentRow))->getAlignment()->applyFromArray([
                            'horizontal' => 'center']
                    );

                    $currentRow++;
                    $startRow = $currentRow;
                }

            $sheet->appendRow($currentRow, array(
                $item['Курс'],
                $item['Дисциплина'],
                $item['ПодлежитИзучениюВсего'],
                $item['ЗЕТ'],
            ));

            $sheet->setBorder('A'.$currentRow.':O'.$currentRow++, 'thin');
        }

        $sheet->mergeCells('A'.($startRow).':A'.($currentRow-1));
        $sheet->getStyle('A'.($startRow))->getAlignment()->applyFromArray(
            array('horizontal' => 'center')
        );

        $sheet->prependRow($currentRow, array(
            'Декан факультета',
        ));
        $sheet->getStyle('A'.($currentRow))->getAlignment()->applyFromArray([
                'horizontal' => 'center']
        );
        $sheet->mergeCells('A'.($currentRow).':O'.($currentRow));


//        $excel->saveAs('uploads\/'.$document->change_files_coding($file->getClientOriginalName()).'.xls');
        $excel->store('xls');


        $newFile=\Storage::disk('public')->get('file.xls');
        \Storage::move('public/file.xls', 'public/'.$document->change_files_coding($file->getClientOriginalName()).'.xls');

//        $newFile->move('uploads\/'.$document->change_files_coding($file->getClientOriginalName()).'.xls');

//        dd(Input::file('public\file.xls'));

        //$fffile = file('uploads\/file.xls')->store('your_path','your_disk');
        //move_uploaded_file ( string $filename , string $destination );

//        $excel->export('xls');

//        dd($excel->get());

//        dd($file->getClientOriginalName(), $info->makeDataForDonePlanWordDocument($file));

//        $document->divideInfoForKurses($info->makeDataForDonePlanWordDocument($file));
//        $document   ->makeDonePlanWordDocument($info->makeDataForDonePlanWordDocument($file))
//                    ->saveAs('uploads\/'.$document->change_files_coding($file->getClientOriginalName()).'.doc');

        return view('tools');
    }
}
