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
        Schema::dropIfExists('types');
        Schema::create('types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('lang')->default('ja');
            $table->integer('parent_id')->default(0);
            $table->string('label_parent')->nullable();
            $table->string('label_child')->nullable();
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
        Schema::dropIfExists('types');
    }
};
