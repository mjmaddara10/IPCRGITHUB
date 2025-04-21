<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('selected_activities', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name')->nullable();
            $table->string('successIndicator')->nullable();
            $table->string('quality')->nullable();
            $table->string('efficiency')->nullable();
            $table->string('timeliness')->nullable();
            $table->string('remarks')->nullable();

            $table->unsignedBigInteger('accountable_id')->nullable();
            $table->foreign('accountable_id')->references('id')->on('tbl_employee')->onDelete('cascade');

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
        Schema::dropIfExists('selected_activities');
    }
};
