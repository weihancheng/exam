<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('content');  // 选项内容
            $table->unsignedTinyInteger('sort')->default(100);  // 选项排序
            $table->tinyInteger('is_answer')->default(0);  // 是否是答案
            $table->text('memo')->nullable(); // 选项备注
            $table->unsignedBigInteger('question_id'); // 关联选项表 (如果不是选择题则为空)
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
        Schema::dropIfExists('items');
    }
}
