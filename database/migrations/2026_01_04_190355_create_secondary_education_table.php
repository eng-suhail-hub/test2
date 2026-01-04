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
        Schema::create('secondary_educations', function (Blueprint $table) {
    $table->id();

    $table->foreignId('student_id')
        ->constrained()
        ->cascadeOnDelete();

    $table->string('school_name');

    $table->foreignId('school_governorate_id')
        ->constrained('governorates')
        ->restrictOnDelete();

    $table->string('certificate_type');
    $table->decimal('grade', 5, 2);
    $table->year('graduation_year');

    $table->string('certificate_file_path');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('secondary_education');
    }
};
