<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            // 关联用户
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // 关联试题
            $table->unsignedBigInteger('question_id');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            // 关联试卷
            $table->unsignedBigInteger('paper_id')->nullable();
            $table->foreign('paper_id')->references('id')->on('papers')->onDelete('cascade');
            // 关联考场
            $table->unsignedBigInteger('exam_room_id')->nullable();
            $table->foreign('exam_room_id')->references('id')->on('exam_rooms')->onDelete('cascade');
            // 用户选择题答案
            $table->text('question_answer')->nullable()->comment('选择题答案');
            // 用户问答题答案
            $table->text('text_answer')->nullable()->comment('问答题答案');
            // 题目类型
            $table->string('type', 20);
            // 题目状态
            $table->tinyInteger('status');
            // 用户改题是否正确
            $table->tinyInteger('is_true')->nullable();
            // 本题得分
            $table->unsignedTinyInteger('mark')->nullable();
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
        Schema::dropIfExists('answers');
    }
}
