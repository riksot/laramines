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

//        dd($courses);
        $excel = Excel::load('templatesdoc/file.xls');
        $sheet = $excel->sheet('Лист1');

        $sheet->setCellValue('A2', $info->makeDataForDonePlanWordDocument($file)['Направление']."\n".$info->makeDataForDonePlanWordDocument($file)['Профиль']);

        $startRow = 6;
        $currentRow = 6;

        $style_exclude = array(
            'font'=>array(
//                'italic' => true,
//                'name' => 'Times New Roman',
                'size' => 5,
//                'color'=>array(
//                    'rgb' => '808080'
//                )
            ),

            'alignment'=>array(
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_BOTTOM,
            ),

//            'fill' => array(
//                'type' => \PHPExcel_STYLE_FILL::FILL_SOLID,
//                'color'=>array(
//                    'rgb' => 'CCCCCC'
//                )
//            ),

            // рамки
//            'borders'=>array(
//                // внешняя рамка
//                'outline' => array(
//                    'style'=>\PHPExcel_Style_Border::BORDER_THICK,
//                    'color' => array(
//                        'rgb'=>'006464'
//                    )
//                ),
//                // внутренняя
//                'allborders'=>array(
//                    'style'=>\PHPExcel_Style_Border::BORDER_THIN,
//                    'color' => array(
//                        'rgb'=>'CCCCCC'
//                    )
//                )
//            )
        );

        for ($course = 1; $course < count($courses)+1; $course++){
            foreach ($courses[$course] as $id => $item){
                $sheet->appendRow($currentRow, array(
                    $item['Курс'],
                    $item['Дисциплина'],
                    isset($item['ЗЕТ_Зима'])?$item['ЗЕТ_Зима']:null,
                    isset($item['Часы_Зима'])?$item['Часы_Зима']:null,
                    isset($item['КонтрРаб_Зима'])?$item['КонтрРаб_Зима']:null,
                    isset($item['Зач_Зима'])?$item['Зач_Зима']:null,
                    isset($item['КП_Зима'])?$item['КП_Зима']:null,
                    isset($item['Экз_Зима'])?$item['Экз_Зима']:null,
                    isset($item['ЗЕТ_Лето'])?$item['ЗЕТ_Лето']:null,
                    isset($item['Часы_Лето'])?$item['Часы_Лето']:null,
                    isset($item['КонтрРаб_Лето'])?$item['КонтрРаб_Лето']:null,
                    isset($item['Зач_Лето'])?$item['Зач_Лето']:null,
                    isset($item['КП_Лето'])?$item['КП_Лето']:null,
                    isset($item['Экз_Лето'])?$item['Экз_Лето']:null,
                ));
                $sheet->setBorder('A'.$currentRow.':O'.$currentRow, 'thin');

                $excel->getActiveSheet()->getRowDimension($currentRow)->setRowHeight(-1); // автовыравнивание по высоте

//                dd($excel->getActiveSheet()->getRowDimension($currentRow));
                // меняем стили у оценок и кп/кр
                if($sheet->getCellByColumnAndRow(5, $currentRow)->getValue() == 'оценка'){
                    $sheet->getStyle('F'.$currentRow)->applyFromArray($style_exclude);
//                    $excel->getActiveSheet()->getRowDimension($currentRow)->setRowHeight(20);
                }

                if($sheet->getCellByColumnAndRow(6, $currentRow)->getValue() != null){
                    $sheet->getStyle('G'.$currentRow)->applyFromArray($style_exclude);
//                    $excel->getActiveSheet()->getRowDimension($currentRow)->setRowHeight(20);
                }


                if($sheet->getCellByColumnAndRow(11, $currentRow)->getValue() == 'оценка'){
                    $sheet->getStyle('L'.$currentRow)->applyFromArray($style_exclude);
//                    $excel->getActiveSheet()->getRowDimension($currentRow)->setRowHeight(20);
                }

                if($sheet->getCellByColumnAndRow(12, $currentRow)->getValue() != null){
                    $sheet->getStyle('M'.$currentRow)->applyFromArray($style_exclude);
//                    $excel->getActiveSheet()->getRowDimension($currentRow)->setRowHeight(20);
                }



//                    dd($sheet->getCellByColumnAndRow(5, $currentRow)->getValue(), $currentRow);

                // Проверяем, выбранные дисциплины, если индекс 2, то выделяем курсивом
//                if(isset($item['НовИдДисциплины']))
//                if(count(explode('.',$item['НовИдДисциплины'])) > 3)
//                    if((explode('.',$item['НовИдДисциплины'])[2] == 'ДВ') AND(explode('.',$item['НовИдДисциплины'])[count(explode('.',$item['НовИдДисциплины']))-1] == '2'))
//                        $sheet->getStyle('A'.$currentRow.':O'.$currentRow)->applyFromArray($style_exclude);

                $currentRow++;
            };

            $sheet->mergeCells('A'.($startRow).':A'.($currentRow-1));  // Объединяем курсы
            $sheet->getStyle('A'.($startRow))->applyFromArray([
                'alignment'=>array(
                    'horizontal' => 'center',
                    'rotation' => '90',
                ),
            ]);
            //dd($sheet->getCellByColumnAndRow(0, $startRow)->getValue());
            switch ($sheet->getCellByColumnAndRow(0, $startRow)->getValue()){
                case '0':
                    $sheet->setCellValue('A'.$startRow, 'Перезачёт');
                    break;
                case '1':
                    $sheet->setCellValue('A'.$startRow, 'Первый курс');
                    break;
                case '2':
                    $sheet->setCellValue('A'.$startRow, 'Второй курс');
                    break;
                case '3':
                    $sheet->setCellValue('A'.$startRow, 'Третий курс');
                    break;
                case '4':
                    $sheet->setCellValue('A'.$startRow, 'Четвертый курс');
                    break;
                case '5':
                    $sheet->setCellValue('A'.$startRow, 'Пятый курс');
                    break;
                case '6':
                    $sheet->setCellValue('A'.$startRow, 'Шестой курс');
                    break;
            }


//                ->getAlignment()->applyFromArray(
//                array('horizontal' => 'center')
//            );

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
