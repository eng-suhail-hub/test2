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
        Schema::create('requirement_assignment_values', function (Blueprint $table) {
            $table->id();

            $table->foreignId('requirement_assignment_id')
                ->constrained()
                ->cascadeOnDelete();

            /**
             * القيمة الفعلية للشرط
             * يمكن أن تكون:
             * - number   => 85
             * - string   => "علمي"
             * - array    => ["علمي", "أدبي"]
             * - range    => [70, 90]
             */
            $table->json('value');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requirement_assignment_values');
    }
};
