<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     *
     */
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('successIndicator', 500)->nullable(); 
            $table->string('quality', 500)->nullable(); 
            $table->string('efficiency', 500)->nullable(); 
            $table->string('timeliness', 500)->nullable(); 
            $table->string('remarks', 500)->nullable();
            $table->string('budget', 11)->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     *
     */
    public function down()
    {
        Schema::dropIfExists('programs');
    }
};