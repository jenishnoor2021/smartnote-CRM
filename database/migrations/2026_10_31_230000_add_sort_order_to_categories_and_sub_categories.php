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
        if (!Schema::hasColumn('categories', 'sort_order')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->integer('sort_order')->default(0)->after('image');
            });
        }

        if (!Schema::hasColumn('sub_categories', 'sort_order')) {
            Schema::table('sub_categories', function (Blueprint $table) {
                $table->integer('sort_order')->default(0)->after('image');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('categories', 'sort_order')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->dropColumn('sort_order');
            });
        }

        if (Schema::hasColumn('sub_categories', 'sort_order')) {
            Schema::table('sub_categories', function (Blueprint $table) {
                $table->dropColumn('sort_order');
            });
        }
    }
};

