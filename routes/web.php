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

Route::get('/', 'StudentsController@index')->name('index');

// Страница со студентами

Route::get('/students', 'StudentsController@index')->name('students'); // выбор студента по группе
Route::post('/getListGroupsForStudents', 'StudentsController@getListGroupsForStudents');        // ajax
Route::post('/getListStudentsForStudents', 'StudentsController@getListStudentsForStudents');    // ajax

Route::get('/student/{id}', 'StudentsController@showStudent')->name('student'); // Один студент

// работа с планами

Route::get('/plan', 'PlanController@index')->name('plans');     // Главная страница планов
Route::post('/uploadfile', 'PlanController@uploadPlan');              // Предварительный просмотр плана
Route::post('/uploadfiletobase', 'PlanController@savePlanToBase');    // Загрузка плана в базу


//Route::get('/uploadfile', 'PlanController@index')->name('uploadplan');


// Выбор учебного плана по факультету - тестовое
Route::get('/pak', 'PakController@selectFaculty')->name('pak');
Route::get('/ajax-plans', 'PakController@jqueryResponse');
Route::get('/paklist', 'PakController@selectPak')->name('paklist');



// Утилиты

Route::get('/tools',    'ToolsController@index')->name('tools');
Route::post('/uploadxmlfile', 'ToolsController@showUploadFile');        // Создание КСР
Route::post('/makestudentcard', 'ToolsController@makeWordDocument');   // Создание карточки




//Route::post('/uploadfile', 'PlanController@showUploadFile');

//Route::get('/ajax-xml', 'ToolsController@showUploadFile');
//Route::get('/stud', 'PakController@selectStudent')->name('stud');
//Route::get('pdf', 'PdfController@pdf');
//Route::get('pdf', function(){
//    $pdf = app('dompdf.wrapper');
//    $pdf->loadView('pdf');
//    return $pdf->download('pdf.pdf');
//});
//Route::get('/test/{studid?}', 'PakController@getStudentInfo')->name('test');
//Route::get('/test/{studid?}', function ($studid = null) {
//    return view('test',['studid' => $studid]);
//})->name('test');

//Route::get('/getRequest',function(){
//    if(Request::ajax()){
//        return 'getRequest has loaded completely';
//
//    }
//});

//Route::get('/getRequest', 'PakController@testJquery'); // Обработка jquery в контроллере pak
//Route::get('/home', 'HomeController@index');


