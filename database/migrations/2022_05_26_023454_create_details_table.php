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
        Schema::create('details', function (Blueprint $table) {
            $table->id(); 
            $table->string('user_id');
            $table->string('work')->default('none');
            $table->string('phone_number')->default('none');
            $table->string('nickname')->default('none');
            $table->string('links')->default('none');
            $table->string('website')->default('none');
            $table->string('relationship_status')->default('none');
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
        Schema::dropIfExists('details');
    }
};
