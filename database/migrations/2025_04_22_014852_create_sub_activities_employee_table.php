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
        Schema::create('sub_activity_employee', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_activity_id')->nullable()->constrained('sub_activities')->onDelete('cascade');
            $table->foreignId('employee_id')->nullable()->constrained('tbl_employee')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_activities_employee');
    }
};
