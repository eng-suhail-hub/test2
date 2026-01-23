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
        Schema::create('verification_appointments', function (Blueprint $table) {
    $table->id();

    $table->foreignId('application_id')
        ->constrained()
        ->cascadeOnDelete();

    $table->date('attendance_date');
    $table->time('attendance_time')->nullable();

    $table->string('location')->nullable();
    $table->text('instructions')->nullable();

    $table->boolean('attendance_confirmed')->default(false);

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verification_appointments');
    }
};
