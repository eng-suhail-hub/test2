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
        Schema::create('admission_cycles', function (Blueprint $table) {
    $table->id();

    $table->string('name'); // مثال: قبول عام 2026

    // الفترة الزمنية
    $table->timestamp('starts_at');
    $table->timestamp('ends_at');

    // المقاعد
    $table->unsignedInteger('capacity')->nullable(); // null = unlimited
   

    // نوع الدراسة
    $table->foreignId('study_type_id')
        ->constrained()
        ->cascadeOnDelete();

    // Morph: جامعة / كلية / تخصص
    $table->morphs('applicable'); 
    // applicable_type, applicable_id

    $table->unsignedInteger('accepted_count')->default(0);

    $table->boolean('is_open')->default(true);
    $table->boolean('allow_pending')->default(true); // يسمح بالتقديم حتى لو مغلق

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admission_cycles');
    }
};
