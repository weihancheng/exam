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
    // 用户模块
    $router->get('users', 'UsersController@index');
    $router->get('users/create', 'UsersController@create');
    $router->get('users/{user}', 'UsersController@show');
    $router->post('users', 'UsersController@store');
    $router->put('users/{user}', 'UsersController@edit');

});
