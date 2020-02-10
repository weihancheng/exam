<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('papers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('author')->nullable();  // 出题人
            $table->unsignedSmallInteger('total');  // 题目总数
            $table->string('description')->nullable();  // 试卷备注
            $table->string('title');  // 试卷标题
            $table->tinyInteger('type')->default(0);  // 试卷类型  0:只有选择题  1:有选择题,问答题,填空题
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
        Schema::dropIfExists('papers');
    }
}
