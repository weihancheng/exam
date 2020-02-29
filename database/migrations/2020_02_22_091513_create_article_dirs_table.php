<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleDirsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_dirs', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('category', 45);
            $table->smallInteger('sort')->default(100);
            $table->unsignedBigInteger('pid');
            $table->string('memo')->nullable();
            $table->tinyInteger('is_cover')->default(0);
            // 关联用户
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

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
        Schema::dropIfExists('article_dirs');
    }
}
