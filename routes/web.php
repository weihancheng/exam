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
    // 文档界面首页
    Route::get('/article_dir', 'ArticleDirsController@index')->name('article_dir.index');
    // 更新自己的用户信息
    Route::put('users/{user}/own', 'UsersController@updateOwn')->name('users.update.own');
    // 错题集界面
    Route::get('score/{score}/error_collection', 'ScoresController@showErrorCollection')->name('score.show.error_collection');
});

Route::group(['middleware' => ['auth', 'verified', 'pjax']], function () {
    // 文章界面
    Route::get('/article_dir/{articleDir}/article/{id?}', 'ArticlesController@show')->name('article.show');
   // 返回json
    Route::get('/article_dir/{id}', 'ArticleDirsController@show')->name('article_dir.show');
});

