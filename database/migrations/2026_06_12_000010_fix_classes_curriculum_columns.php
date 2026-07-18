<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            if (!Schema::hasColumn('classes', 'curriculum_id')) {
                $table->foreignId('curriculum_id')->nullable()->after('teacher_id')->constrained('curriculums')->nullOnDelete();
            }
            if (!Schema::hasColumn('classes', 'grade_level_id')) {
                $table->foreignId('grade_level_id')->nullable()->after('curriculum_id')->constrained()->nullOnDelete();
            }
            if (!Schema::hasColumn('classes', 'academic_year_id')) {
                $table->foreignId('academic_year_id')->nullable()->after('grade_level_id')->constrained()->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            if (Schema::hasColumn('classes', 'curriculum_id')) {
                $table->dropForeign(['curriculum_id']);
                $table->dropColumn('curriculum_id');
            }
            if (Schema::hasColumn('classes', 'grade_level_id')) {
                $table->dropForeign(['grade_level_id']);
                $table->dropColumn('grade_level_id');
            }
            if (Schema::hasColumn('classes', 'academic_year_id')) {
                $table->dropForeign(['academic_year_id']);
                $table->dropColumn('academic_year_id');
            }
        });
    }
};
