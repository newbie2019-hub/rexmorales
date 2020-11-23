<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trackreads', function (Blueprint $table) {
            $table->id();
            $table->string('booktitle');
            $table->string('genre');
            $table->string('author');
            $table->longText('synopsis');
            $table->integer('rating')->default(0);
            $table->longText('review');
            $table->integer('user_id');
            $table->string('status');
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
        Schema::dropIfExists('trackreads');
    }
}
