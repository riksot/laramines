<?php

namespace App\Http\Controllers;

use App\Document;
use App\FilesParser;
use App\Tool;
use Illuminate\Http\Request;

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
        $info->makeDataForDonePlanWordDocument($file); // из xml в array
        $document   ->makeDonePlanWordDocument($info->makeDataForDonePlanWordDocument($file))
                    ->saveAs('uploads\/'.$document->change_files_coding($file->getClientOriginalName()).'.doc');
        dd('Done');
    }
}
