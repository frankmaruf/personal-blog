<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("slug")->nullable()->unique();
            $table->string("meta_description")->nullable();
            $table->string("meta_keywords")->nullable();
            $table->string("tags")->nullable();
            $table->string("cover_image");
            $table->text("body");
            $table->boolean('status')->default(0);
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('categories_id')->nullable()->references('id')->on('categories');
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
        Schema::dropIfExists('blogs');
    }
}
