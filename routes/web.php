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

Route::redirect('/', '/exam_room')->name('root');
Auth::routes();

Route::group(['middleware' => ['auth', 'verified']], function () {
    // 加载考场页[首页]
    Route::get('/exam_room', 'ExamRoomsController@index')->name('exam_room.index');
    // 加载试卷页[不是正式考试]
//    Route::get('/paper/{paper}', 'PapersController@show')->name('paper.show');
    // 加载考场的试卷
    Route::get('/exam_room/{exam_room}/paper/{paper}', 'ExamRoomsController@exam')->name('exam_room.exam');
    // 提交试卷
    Route::post('/answer', 'AnswersController@store')->name('answers.store');

});

