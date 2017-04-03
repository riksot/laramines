<?php
/*
|--------------------------------------------------------------------------
| Модель управления документами
|--------------------------------------------------------------------------
*/


namespace App;

use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpWord\PhpWord;

class Document extends Model
{
    function change_files_coding_to_UTF8($file_name) // Конвертируем названия файлов для сохранения на диске
    {
        $coding   = mb_detect_encoding($file_name);
        $new_str  = mb_convert_encoding($file_name, 'Windows-1251' , $coding);
        return $new_str;
    }

    public function makeWordDocument($file) {  // Создание doc файла
        $phpWord = new PhpWord();
        $fontStyleName = 'Style';
        $phpWord->addFontStyle(
            $fontStyleName,
            array('name' => 'Tahoma', 'size' => 6)
        );


        $section = $phpWord->addSection();

//        $section->addText('Выполнение учебного плана',$fontStyleName);
/////////////////////////////////////
//        $section->addTextBreak(1);

        $fancyTableStyleName = 'Fancy Table';
        $fancyTableStyle = array('borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 0, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
        $fancyTableCellStyle = array('valign' => 'center');
        $fancyTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
        $fancyTableFontStyle = array(['valign' => 'center']);

        $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle);
        $table = $section->addTable($fancyTableStyleName);

// 1
        $table->addRow(null);
        $table->addCell(null, ['gridSpan' => 15])->
                addText('Выполнение учебного плана', ['alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER]);
// 2
        $table->addRow(3000);
        $table->addCell(50, ['vMerge' => 'restart','align' => \PhpOffice\PhpWord\Style\Cell::VALIGN_CENTER, 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR])->
                addText('курсы', $fancyTableFontStyle);

        $table->addCell(2000, ['vMerge' => 'restart', 'valign' => 'center'])->
                addText('Дисциплины учебного плана', $fancyTableFontStyle);

        $table->addCell(100, ['vMerge' => 'restart', 'valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR])->
                addText('Количество по учебному плану', $fancyTableFontStyle);

        $table->addCell(100, ['vMerge' => 'restart', 'valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR])->
                addText('Зач. ед.', $fancyTableFontStyle);

        $table->addCell(null, ['gridSpan' => 10])->
                addText('Сдача экзаменов и зачетов', $fancyTableFontStyle);

        $table->addCell(null, ['vMerge' => 'restart', 'valign' => 'center'])->
                addText('Фамилия и инициалы преподавателя', $fancyTableFontStyle);
//3
        $table->addRow(null);
        $table->addCell(null, ['vMerge' => 'continue']);

        $table->addCell(null, ['vMerge' => 'continue']);

        $table->addCell(null, ['vMerge' => 'continue']);

        $table->addCell(null, ['vMerge' => 'continue']);

        $table->addCell(null, ['gridSpan' => 5])->
        addText('I сессия', $fancyTableFontStyle);

        $table->addCell(null, ['gridSpan' => 5])->
        addText('II сессия', $fancyTableFontStyle);

        $table->addCell(null, ['vMerge' => 'continue']);
//5
        $table->addRow(3000);
        $table->addCell(null, ['vMerge' => 'continue']);

        $table->addCell(null, ['vMerge' => 'continue']);

        $table->addCell(null, ['vMerge' => 'continue']);

        $table->addCell(null, ['vMerge' => 'continue']);

        for ($i = 1; $i <= 2; $i++) {

            $table->addCell(null, ['valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR])->
            addText('контр. работы', $fancyTableFontStyle);

            $table->addCell(null, ['valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR])->
            addText('зачет', $fancyTableFontStyle);

            $table->addCell(null, ['valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR])->
            addText('курс. проект', $fancyTableFontStyle);

            $table->addCell(null, ['valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR])->
            addText('дата сдачи', $fancyTableFontStyle);

            $table->addCell(null, ['valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR])->
            addText('оценка', $fancyTableFontStyle);
        }

        $table->addCell(null, ['vMerge' => 'continue']);

// вывод Дисциплин
        for ($i = 1; $i <= 6; $i++) {
            $table->addRow();
            $table->addCell(null)->addText('00');
            $table->addCell(null)->addText('Название дисциплины');
            $table->addCell(null)->addText('000');  // Часы
            $table->addCell(null)->addText('000');  // ЗЕТ
            $table->addCell(null)->addText('000');  // Контр работы
            $table->addCell(null)->addText('000');  // Зачет
            $table->addCell(null)->addText('000');  // Курс проект
            $table->addCell(null)->addText('000');  // Дата сдачи
            $table->addCell(null)->addText('000');  // Оценка
            $table->addCell(null)->addText('000');  // Контр работы
            $table->addCell(null)->addText('000');  // Зачет
            $table->addCell(null)->addText('000');  // Курс проект
            $table->addCell(null)->addText('000');  // Дата сдачи
            $table->addCell(null)->addText('000');  // Оценка
            $table->addCell(null)->addText('Иванов И.И.');  // ФИО
        }

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('uploads\/'.$this->change_files_coding_to_UTF8($file->getClientOriginalName()).'.doc');



// Template processor instance creation
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('uploads/Sample_07_TemplateCloneRow.docx');

// Variables on different parts of document
        $templateProcessor->setValue('weekday', date('l'));            // On section/content
        $templateProcessor->setValue('time', date('H:i'));             // On footer
        $templateProcessor->setValue('serverName', realpath(__DIR__)); // On header

// Simple table
        $templateProcessor->cloneRow('rowValue', 10);

        $templateProcessor->setValue('rowValue#1', 'Sun');
        $templateProcessor->setValue('rowValue#2', 'Mercury');
        $templateProcessor->setValue('rowValue#3', 'Venus');
        $templateProcessor->setValue('rowValue#4', 'Earth');
        $templateProcessor->setValue('rowValue#5', 'Mars');
        $templateProcessor->setValue('rowValue#6', 'Jupiter');
        $templateProcessor->setValue('rowValue#7', 'Saturn');
        $templateProcessor->setValue('rowValue#8', 'Uranus');
        $templateProcessor->setValue('rowValue#9', 'Neptun');
        $templateProcessor->setValue('rowValue#10', 'Pluto');

        $templateProcessor->setValue('rowNumber#1', '1');
        $templateProcessor->setValue('rowNumber#2', '2');
        $templateProcessor->setValue('rowNumber#3', '3');
        $templateProcessor->setValue('rowNumber#4', '4');
        $templateProcessor->setValue('rowNumber#5', '5');
        $templateProcessor->setValue('rowNumber#6', '6');
        $templateProcessor->setValue('rowNumber#7', '7');
        $templateProcessor->setValue('rowNumber#8', '8');
        $templateProcessor->setValue('rowNumber#9', '9');
        $templateProcessor->setValue('rowNumber#10', '10');

// Table with a spanned cell
        $templateProcessor->cloneRow('userId', 3);

        $templateProcessor->setValue('userId#1', '1');
        $templateProcessor->setValue('userFirstName#1', 'James');
        $templateProcessor->setValue('userName#1', 'Taylor');
        $templateProcessor->setValue('userPhone#1', '+1 428 889 773');

        $templateProcessor->setValue('userId#2', '2');
        $templateProcessor->setValue('userFirstName#2', 'Robert');
        $templateProcessor->setValue('userName#2', 'Bell');
        $templateProcessor->setValue('userPhone#2', '+1 428 889 774');

        $templateProcessor->setValue('userId#3', '3');
        $templateProcessor->setValue('userFirstName#3', 'Michael');
        $templateProcessor->setValue('userName#3', 'Ray');
        $templateProcessor->setValue('userPhone#3', '+1 428 889 775');

        $templateProcessor->saveAs('uploads/Sample_07_TemplateCloneRow1.docx');
















        dd($phpWord);
    }

}

