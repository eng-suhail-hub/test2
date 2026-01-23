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
        Schema::create('requirement_rules', function (Blueprint $table) {
    $table->id();

    // تعريف القاعدة
    $table->string('code')->unique();        // MIN_GPA, MAX_AGE
    $table->string('name');                  // أقل معدل
    $table->text('description')->nullable();

    // أين تطبق القاعدة (تعريف مجرد)
    $table->string('target_type');           // Student | Application | SecondaryEducation
    $table->string('target_field');          // gpa | age | track | governorate_id

    // كيف يتم التحقق
    $table->enum('operator', [
        '>=', '<=', '=', '!=', 'IN', 'NOT_IN', 'BETWEEN'
    ]);

    // نوع البيانات المتوقع
    $table->enum('value_type', [
        'number', 'string', 'array', 'range'
    ]);

    // خصائص القاعدة
    $table->boolean('is_global')->default(false); // تطبق على كل النظام
    $table->boolean('is_active')->default(true);

    $table->timestamps();

    $table->index(['target_type', 'target_field']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requirement_rules');
    }
};
