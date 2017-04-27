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

    // ============= Создаем документ для печати в папке \storage\app\public\ =====================
    public function makeWordDocument(Request $request, Document $document, FilesParser $info){
        $file = $request->file('file'); // получили файл
        $courses =  $info->makeDataForDonePlanWordDocument($file)['Курсы']; // из xml в array

        $excel = Excel::load('templatesdoc/file.xls');
        $sheet = $excel->sheet('Лист1');

        $sheet->setCellValue('A2', $info->makeDataForDonePlanWordDocument($file)['Направление']."\n".$info->makeDataForDonePlanWordDocument($file)['Профиль']);

        $startRow = 7;
        $currentRow = 7;

        for ($course = 1; $course < count($courses)+1; $course++){
            foreach ($courses[$course] as $id => $item){
                $sheet->appendRow($currentRow, array(
                    $item['Курс'],
                    $item['Дисциплина'],
                    $item['Часов'],
                    $item['ЗЕТ'],
                ));
                $sheet->setBorder('A'.$currentRow.':O'.$currentRow++, 'thin');
                $excel->getActiveSheet()->getRowDimension($currentRow)->setRowHeight(-1);
            };
            $sheet->mergeCells('A'.($startRow).':A'.($currentRow-1));  // Объединяем курсы

            $sheet->getStyle('A'.($startRow))->getAlignment()->applyFromArray(
                array('horizontal' => 'center')
            );

            $sheet->prependRow($currentRow, array(
                'Декан факультета                              Л.М.Инаходова',
            ));
            $sheet->mergeCells('A'.($currentRow).':O'.($currentRow)); // Объединяем строку Декан
            $sheet->setSize('A'.($currentRow), 3, 20);
            $sheet->getStyle('A'.($currentRow))->getAlignment()->applyFromArray([
                    'horizontal' => 'center']
            );
//            $excel->getActiveSheet()->setBreak( 'A'.$currentRow , \PHPExcel_Worksheet::BREAK_ROW ); // Разрыв страницы
            $currentRow++;
            $startRow = $currentRow;
        }

/*
foreach ($courses as $id => $course){
            if (($id > 1) AND ((string)$sheet->getCell('A'.($currentRow-1)) !== $item['Курс'])){
                $sheet->mergeCells('A'.($startRow).':A'.($currentRow-1));  // Объединяем курсы

                $sheet->getStyle('A'.($startRow))->getAlignment()->applyFromArray(
                    array('horizontal' => 'center')
                );

                $sheet->prependRow($currentRow, array(
                    'Декан факультета                              Л.М.Инаходова',
                ));

                $sheet->mergeCells('A'.($currentRow).':O'.($currentRow)); // Объединяем строку Декан
                $sheet->setSize('A'.($currentRow), 3, 20);
                $sheet->getStyle('A'.($currentRow))->getAlignment()->applyFromArray([
                        'horizontal' => 'center']
                );
                $currentRow++;
                $startRow = $currentRow;
            }
        }

//        $sheet->mergeCells('A'.($startRow).':A'.($currentRow-1));
//        $sheet->getStyle('A'.($startRow))->getAlignment()->applyFromArray(
//            array('horizontal' => 'center')
//        );
//
//        $sheet->prependRow($currentRow, array(
//            'Декан факультета                              Л.М.Инаходова',
//        ));
//        $sheet->mergeCells('A'.($currentRow).':O'.($currentRow));
//        $sheet->setSize('A'.($currentRow), 3, 20);
//        $sheet->getStyle('A'.($currentRow))->getAlignment()->applyFromArray([
//                'horizontal' => 'center']
//        );

*/
        $excel->store('xls');

        if (\Storage::disk('public')->exists($document->change_files_coding($file->getClientOriginalName()).'.xls')){
            \Storage::disk('public')->delete($document->change_files_coding($file->getClientOriginalName()).'.xls');
        }
            \Storage::move('public/file.xls', 'public/'.$document->change_files_coding($file->getClientOriginalName()).'.xls');

//        $document->divideInfoForKurses($info->makeDataForDonePlanWordDocument($file));
//        $document   ->makeDonePlanWordDocument($info->makeDataForDonePlanWordDocument($file))
//                    ->saveAs('uploads\/'.$document->change_files_coding($file->getClientOriginalName()).'.doc');

        return view('tools');
    }
}
