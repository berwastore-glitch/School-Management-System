<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = ['curriculums', 'academic_years', 'terms', 'grade_levels', 'grading_scales'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->foreignId('school_id')->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        $tables = ['curriculums', 'academic_years', 'terms', 'grade_levels', 'grading_scales'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->foreignId('school_id')->nullable(false)->change();
            });
        }
    }
};
