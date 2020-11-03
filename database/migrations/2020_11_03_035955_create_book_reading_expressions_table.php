<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookReadingExpressionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_reading_expressions', function (Blueprint $table) {
            $table->increments('expression_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('book_id');
            $table->unsignedInteger('book_current_page');
            $table->string('expression_type');
            $table->string('expression_image_name');
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
        Schema::dropIfExists('book_reading_expressions');
    }
}
