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
        Schema::table('universities', function (Blueprint $table) {

            /**
             * صور الجامعة
             */
            $table->string('front_image')->nullable()->after('logo_path');
            $table->string('background_image')->nullable()->after('front_image');

            /**
             * نوع الجامعة
             * GOVERNMENT = حكومية
             * PRIVATE    = خاصة
             */
            $table->enum('type', ['GOVERNMENT', 'PRIVATE'])
                  ->default('GOVERNMENT')
                  ->after('background_image');

            /**
             * عدد الطلاب
             */
            $table->unsignedInteger('students_count')
                  ->nullable()
                  ->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('universities', function (Blueprint $table) {
            $table->dropColumn([
                'front_image',
                'background_image',
                'type',
                'students_count',
            ]);
        });
    }
};
