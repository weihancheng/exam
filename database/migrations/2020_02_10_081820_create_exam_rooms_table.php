<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_rooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('paper_id'); // 关联试卷表
            $table->foreign('paper_id')->references('id')->on('papers')->onDelete('cascade');
            $table->string('name');
            $table->tinyInteger('top')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->unsignedBigInteger('user_id')->nullable(); // 关联试卷表
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->datetime('start_at'); // 考场开始时间
            $table->datetime('end_at');  // 考场结束时间
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
        Schema::dropIfExists('exam_rooms');
    }
}
