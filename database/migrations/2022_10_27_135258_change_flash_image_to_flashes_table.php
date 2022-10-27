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
        Schema::table('flashes', function (Blueprint $table) {
            $table->longText('front_image_small')->nullable()->change();
            $table->longText('back_image_small')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('flashes', function (Blueprint $table) {
            $table->string('front_image_small')->nullable()->change();
            $table->string('back_image_small')->nullable()->change();
        });
    }
};
