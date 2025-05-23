<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name', 255)->nullable();
            $table->string('successIndicator', 500)->nullable();
            $table->string('quality', 500)->nullable();
            $table->string('efficiency', 500)->nullable();
            $table->string('timeliness', 500)->nullable();
            $table->string('remarks', 500)->nullable();
            
            $table->unsignedBigInteger('program_id')->nullable();
            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');
            
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
