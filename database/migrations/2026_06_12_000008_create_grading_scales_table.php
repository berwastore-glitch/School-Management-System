<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grading_scales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('curriculum_id')->constrained('curriculums')->cascadeOnDelete();
            $table->string('grade_letter');
            $table->integer('min_percentage');
            $table->integer('max_percentage');
            $table->string('description')->nullable();
            $table->integer('grade_points')->nullable();
            $table->timestamps();

            $table->unique(['school_id', 'curriculum_id', 'grade_letter']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grading_scales');
    }
};
