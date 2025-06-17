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
            $table->string('name', 100);
            $table->text('successIndicator')->nullable(); 
            $table->text('quality')->nullable(); 
            $table->text('efficiency')->nullable(); 
            $table->text('timeliness')->nullable(); 
            $table->text('remarks')->nullable();
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