<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamRoomUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_room_user', function (Blueprint $table) {
            $table->unsignedBigInteger('exam_room_id'); // 关联分类表
            $table->foreign('exam_room_id')->references('id')->on('exam_rooms')->onDelete('cascade');
            $table->unsignedBigInteger('user_id'); // 关联分类表
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
        Schema::dropIfExists('exam_room_user');
    }
}
