<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Activity name
            $table->string('successIndicator'); // Success indicator
            $table->string('quality'); // Quality
            $table->string('efficiency'); // Efficiency
            $table->string('timeliness'); // Timeliness
            $table->string('remarks'); // Remarks
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
