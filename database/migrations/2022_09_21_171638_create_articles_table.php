<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('articles', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('user_id');
      $table->unsignedInteger('category_id');
      $table->string('title');
      $table->string('slug');
      $table->longText('content');
      $table->string('tags')->nullable();
      $table->timestamp('content_updated_at')->nullable();
      $table->timestamps();
//      $table->foreignId('user_id')->constrained();
      $table->foreign('user_id')->references('id')->on('users');
//      $table->foreignId('category_id')->constrained();
      $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('article');
  }
};
