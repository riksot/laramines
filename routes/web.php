<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Barryvdh\DomPDF\Facade as PDF;

/*Route::get('/', function () {
    return view('plan');
});*/

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/', 'PlanController@index')->name('plan');

Route::get('/uploadplan', 'PlanController@index')->name('uploadplan');

Route::get('/tools',    'ToolsController@index')->name('tools');
Route::get('/ajax-xml', 'ToolsController@showUploadFile');

Route::post('/makestudentcard', 'ToolsController@makeWordDocument');


Route::post('/uploadfile', 'PlanController@showUploadFile');

Route::post('/uploadxmlfile', 'ToolsController@showUploadFile');

Route::get('/pak', 'PakController@selectFaculty')->name('pak');

Route::get('/paklist', 'PakController@selectPak')->name('paklist');

Route::get('/stud', 'PakController@selectStudent')->name('stud');

Route::get('pdf', 'PdfController@pdf');
//Route::get('pdf', function(){
//    $pdf = app('dompdf.wrapper');
//    $pdf->loadView('pdf');
//    return $pdf->download('pdf.pdf');
//});

Route::get('/test/{studid?}', 'PakController@getStudentInfo')->name('test');


//Route::get('/test/{studid?}', function ($studid = null) {
//    return view('test',['studid' => $studid]);
//})->name('test');

//Route::get('/getRequest',function(){
//    if(Request::ajax()){
//        return 'getRequest has loaded completely';
//
//    }
//});

Route::get('/getRequest', 'PakController@testJquery'); // Обработка jquery в контроллере pak

Route::get('/ajax-plans', 'PakController@jqueryResponse');


