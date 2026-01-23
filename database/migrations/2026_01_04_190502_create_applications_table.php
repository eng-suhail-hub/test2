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
        Schema::create('applications', function (Blueprint $table) {
    $table->id();

    $table->foreignId('student_id')
        ->constrained()
        ->cascadeOnDelete();

    $table->foreignId('admission_cycle_id')
        ->constrained()
        ->cascadeOnDelete();

    $table->enum('status', [
        'DRAFT',        // أثناء التعبئة
        'SUBMITTED',    // تم الإرسال
        'UNDER_REVIEW', // تحت المراجعة
        'PENDING',      // مستوفٍ جزئياً / بدون مقاعد
        'ACCEPTED',     // مقبول
        'REJECTED'      // مرفوض
    ])->default('DRAFT');

    $table->decimal('completion_rate', 5, 2)->default(0);

    $table->timestamp('submitted_at')->nullable();
    $table->timestamp('reviewed_at')->nullable();

    $table->timestamps();

    $table->unique([
        'student_id',
        'admission_cycle_id'
    ]);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
