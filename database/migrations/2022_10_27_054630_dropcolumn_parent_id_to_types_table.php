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
        Schema::table('types', function (Blueprint $table) {
            if (Schema::hasColumn('types', 'parent_id')) {
                $table->dropColumn('parent_id');
            }
            if (!Schema::hasColumn('types', 'label_contents')) {
                $table->renameColumn('label_parent', 'label_contents');
            }
            if (!Schema::hasColumn('types', 'label_chapters')) {
                $table->renameColumn('label_child', 'label_chapters');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('types', function (Blueprint $table) {
            $table->integer('parent_id')->default(0);
            $table->string('label_parent')->nullable();
            $table->string('label_child')->nullable();
        });
    }
};
