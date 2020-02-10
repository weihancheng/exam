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

});
