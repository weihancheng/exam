<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('post_id')->nullable(); // 关联分类表
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('set null');
            $table->string('question_status')->default(\App\Models\Question::SINGLE_CHOICE_QUESTION);  // 默认题型单选题
            $table->text('title');  // 题名称
            $table->text('memo')->nullable();
            $table->string('answer')->nullable()->comment('如果本题是选择题: answer不为空');
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
        Schema::dropIfExists('questions');
    }
}
