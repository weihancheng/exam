<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaperQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paper_question', function (Blueprint $table) {
            $table->unsignedBigInteger('paper_id'); // 关联分类表
            $table->foreign('paper_id')->references('id')->on('papers')->onDelete('cascade');
            $table->unsignedBigInteger('question_id'); // 关联分类表
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
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
        Schema::dropIfExists('paper_question');
    }
}
