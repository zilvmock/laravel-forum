<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('comment_likes', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('user_id');
      $table->unsignedInteger('comment_id');
//      $table->foreignId('user_id')->constrained();
      $table->foreign('user_id')->references('id')->on('users');
//      $table->foreignId('comment_id')->constrained()->cascadeOnDelete();
      $table->foreign('comment_id')->references('id')->on('comments')->cascadeOnDelete();
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
    Schema::dropIfExists('comment_likes');
  }
};
