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

    $table->foreignId('requirement_rule_id')
        ->constrained('requirement_rules')
        ->cascadeOnDelete();


    // Polymorphic Morph: يسمح بربط الشرط بـ (University, College, or Major)
    $table->morphs('context');
    
    // السياق الذي تطبق فيه القاعدة
  /*  $table->enum('context_type', [
        'SYSTEM', 'UNIVERSITY', 'COLLEGE', 'MAJOR'
    ]);

    $table->unsignedBigInteger('context_id')->nullable();*/
    // SYSTEM => null
    // UNIVERSITY => university_id
    // COLLEGE => college_id
    // MAJOR => major_id

// نوع الدراسة (nullable = applies to all)
    $table->foreignId('study_type_id')
        ->nullable()
        ->constrained()
        ->nullOnDelete();
    $table->string('applies_to_type'); // Student | Application | SecondaryEducation
    $table->string('applies_to_field'); // gpa | age | governorate_id

    // هل شرط إجباري أم تفضيلي
    $table->boolean('is_required')->default(true);

    // أولوية التنفيذ (الأعلى أولاً)
    $table->unsignedInteger('priority')->default(0);

    $table->boolean('is_active')->default(true);

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
