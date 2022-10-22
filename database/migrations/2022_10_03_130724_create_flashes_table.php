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
        Schema::create('flashes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('front_title');
            $table->string('front_description')->nullable();
            $table->string('front_image_small')->nullable();
            $table->string('front_image_medium')->nullable();
            $table->string('front_image_large')->nullable();
            $table->string('back_title');
            $table->string('back_description')->nullable();
            $table->string('back_image_small')->nullable();
            $table->string('back_image_medium')->nullable();
            $table->string('back_image_large')->nullable();
            $table->foreignUuid('material_id')->constrained();
            $table->foreignId('user_id')->constrained();
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
        Schema::dropIfExists('flashes');
    }
};
