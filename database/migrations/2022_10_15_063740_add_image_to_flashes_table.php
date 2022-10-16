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
            $table->string('front_image_small')->nullable();
            $table->string('front_image_medium')->nullable();
            $table->string('front_image_large')->nullable();
            $table->string('back_image_small')->nullable();
            $table->string('back_image_medium')->nullable();
            $table->string('back_image_large')->nullable();
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
            $table->dropColumn('front_image_small');
            $table->dropColumn('front_image_medium');
            $table->dropColumn('front_image_large');
            $table->dropColumn('back_image_small');
            $table->dropColumn('back_image_medium');
            $table->dropColumn('back_image_large');
        });
    }
};
