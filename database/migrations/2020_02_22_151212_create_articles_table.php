<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigInteger('id');

            $table->string('title', 100);
            $table->string('author', 30);
            $table->smallInteger('sort')->default(100);
            $table->text('content');
            $table->unsignedBigInteger('articles_dir_id');
            $table->foreign('articles_dir_id')->references('id')->on('article_dirs')->onDelete('cascade');

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
        Schema::dropIfExists('articles');
    }
}
