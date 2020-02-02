<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id'); // 用户id
            $table->string('username', 190)->unique();  // 用户姓名
            $table->string('password', 60); // 用户密码
            $table->string('mobile'); // 用户手机号
            $table->string('id_card'); // 用户身份证号码
            $table->timestamp('admin_verified_at')->nullable(); // 手机验证时间
            $table->rememberToken();
            $table->timestamps();  // 自动时间戳
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
