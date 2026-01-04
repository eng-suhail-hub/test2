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

    $table->foreignId('university_id')->constrained()->cascadeOnDelete();
    $table->foreignId('college_id')->nullable()->constrained()->nullOnDelete();
    $table->foreignId('major_id')->nullable()->constrained()->nullOnDelete();
    $table->foreignId('study_type_id')->nullable()->constrained()->nullOnDelete();

    $table->date('start_at');
    $table->date('end_at');

    $table->integer('seats')->nullable();
    $table->boolean('is_active')->default(true);

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
