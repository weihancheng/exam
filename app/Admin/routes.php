<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    // 后台首页
    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->name('admin')->resource('users', 'UsersController');
    $router->name('admin')->resource('posts', 'PostsController');
    $router->name('admin')->resource('questions', 'QuestionsController');
    $router->name('admin')->resource('papers', 'PapersController');
    $router->name('admin')->resource('examrooms', 'ExamRoomsController');
    $router->name('admin')->resource('article-dirs', ArticleDirsController::class);
    $router->name('admin')->resource('articles', ArticlesController::class);
    $router->name('admin')->resource('options', OptionsController::class);
    $router->name('admin')->resource('scores', ScoresController::class);
    // 试卷批改界面
    $router->get('scores/{score}/correction', 'ScoresController@correction')->name('admin.scores.correction');
    // 试卷批改数据更新
    $router->put('scores/{score}/correction', 'ScoresController@correctionUpdate')->name('admin.scores.correction.update');
    // 将试卷题目往上
    $router->post('papers/{paper}/delete-question', 'PapersController@deleteQuestion')->name('admin.papers.delete_question');
    $router->get('papers/{paper}/create-question', 'PapersController@createQuestion')->name('admin.papers.create_question');


});
