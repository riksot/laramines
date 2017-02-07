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

Route::get('/', function () {
    return view('test');
});

Route::get('/pak', 'Pak@selectFaculty');

// Route::get('/test', 'Pak@selectPlans');

Route::get('/test', function () {
    return view('test');
});

//Route::get('/getRequest',function(){
//    if(Request::ajax()){
//        return 'getRequest has loaded completely';
//
//    }
//});

Route::get('/getRequest', 'Pak@testJquery'); // Обработка jquery в контроллере pak

Route::get('/ajax-plans', 'Pak@jqueryResponse');
