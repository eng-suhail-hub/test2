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
        Schema::table('university_media', function (Blueprint $table) {
    $table->integer('order')
        ->default(0)
        ->after('path')
        ->comment('Display order in frontend');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('university_media', function (Blueprint $table) {
            //
        });
    }
};
