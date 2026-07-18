<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->index('role');
        });

        Schema::table('students', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('class_id');
            $table->index('status');
        });

        Schema::table('teachers', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('status');
        });

        Schema::table('attendance', function (Blueprint $table) {
            $table->index(['student_id', 'date']);
            $table->index(['class_id', 'date']);
            $table->index('date');
        });

        Schema::table('results', function (Blueprint $table) {
            $table->index(['student_id', 'exam_id']);
            $table->index('exam_id');
            $table->index('student_id');
        });

        Schema::table('fees', function (Blueprint $table) {
            $table->index(['student_id', 'payment_status']);
            $table->index('payment_status');
            $table->index('due_date');
        });

        Schema::table('exams', function (Blueprint $table) {
            $table->index(['class_id', 'subject_id']);
            $table->index('date');
        });

        Schema::table('activity_logs', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('action');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['class_id']);
            $table->dropIndex(['status']);
        });

        Schema::table('teachers', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['status']);
        });

        Schema::table('attendance', function (Blueprint $table) {
            $table->dropIndex(['student_id', 'date']);
            $table->dropIndex(['class_id', 'date']);
            $table->dropIndex(['date']);
        });

        Schema::table('results', function (Blueprint $table) {
            $table->dropIndex(['student_id', 'exam_id']);
            $table->dropIndex(['exam_id']);
            $table->dropIndex(['student_id']);
        });

        Schema::table('fees', function (Blueprint $table) {
            $table->dropIndex(['student_id', 'payment_status']);
            $table->dropIndex(['payment_status']);
            $table->dropIndex(['due_date']);
        });

        Schema::table('exams', function (Blueprint $table) {
            $table->dropIndex(['class_id', 'subject_id']);
            $table->dropIndex(['date']);
        });

        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['action']);
        });
    }
};
