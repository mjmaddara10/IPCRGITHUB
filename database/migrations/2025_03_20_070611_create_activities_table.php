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
        Schema::create('activities', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name')->nullable();
            $table->string('successIndicator')->nullable();
            $table->string('quality')->nullable();
            $table->string('efficiency')->nullable();
            $table->string('timeliness')->nullable();
            $table->string('remarks')->nullable();
            $table->string('accountable')->nullable();
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
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
