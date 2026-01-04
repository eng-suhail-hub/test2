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
        Schema::create('requirement_assignments', function (Blueprint $table) {
    $table->id();

    $table->foreignId('requirement_id')->constrained()->cascadeOnDelete();

    $table->foreignId('university_id')->nullable()->constrained()->nullOnDelete();
    $table->foreignId('college_id')->nullable()->constrained()->nullOnDelete();
    $table->foreignId('major_id')->nullable()->constrained()->nullOnDelete();
    $table->foreignId('study_type_id')->nullable()->constrained()->nullOnDelete();
    $table->foreignId('admission_cycle_id')->nullable()->constrained()->nullOnDelete();

    $table->boolean('is_mandatory')->default(true);
    $table->integer('priority')->default(0);

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requirement_assignments');
    }
};
