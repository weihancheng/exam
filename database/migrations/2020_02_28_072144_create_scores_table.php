<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('exam_room_id'); // 关联考场表
            $table->foreign('exam_room_id')->references('id')->on('exam_rooms')->onDelete('cascade');
            $table->unsignedTinyInteger('questions_mark')->nullable()->default(0); // 选择题总成绩
            $table->unsignedTinyInteger('text_mark')->nullable()->default(0);  // 问答题总成绩
            $table->tinyInteger('type');  // 成绩状态
            $table->unsignedBigInteger('user_id'); // 关联用户表
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scores');
    }
}
