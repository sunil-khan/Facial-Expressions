<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookReadingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_readings', function (Blueprint $table) {
            $table->increments('reading_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('book_id');
            $table->unsignedInteger('book_total_pages');
            $table->unsignedInteger('book_current_page');
            $table->unsignedInteger('book_current_paragraph');
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
        Schema::dropIfExists('book_readings');
    }
}
