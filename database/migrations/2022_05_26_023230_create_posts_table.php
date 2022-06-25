<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('content');
            $table->text('phato')->nullable();
            $table->string('likes');
            $table->string('comments');
            $table->string('shares');
            $table->string('comment_open');
            $table->string('share_open');
            $table->string('reach_to');
            $table->string('text_color');
            $table->string('feeling');
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
        Schema::dropIfExists('posts');
    }
};
