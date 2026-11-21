<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('highlight_text')->nullable();
            $table->text('subtitle')->nullable();
            $table->string('bg_image')->nullable();
            $table->string('book_image')->nullable();
            $table->string('button_text')->default('Explore More');
            $table->string('button_link')->nullable();
            $table->string('slider_type')->default('hero'); // hero, banner
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('sliders');
    }
}

