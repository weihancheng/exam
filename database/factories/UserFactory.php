<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'username' => $faker->name,
        'password' => bcrypt('123456'), // password 所有用户默认密码为123456
        'remember_token' => Str::random(10),
        'id_card' => identity(),  // 生成随机的身份证
        'mobile' => $faker->phoneNumber
    ];
});
