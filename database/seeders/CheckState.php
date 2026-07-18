<?php
$school = App\Models\School::first();
echo "School: " . ($school ? $school->name : 'NONE') . "\n";
echo "Curriculums: " . App\Models\Curriculum::pluck('name')->implode(', ') . "\n";
echo "Academic Year: " . App\Models\AcademicYear::pluck('name')->implode(', ') . "\n";
echo "Terms: " . App\Models\Term::pluck('name')->implode(', ') . "\n";
echo "Grade Levels: " . App\Models\GradeLevel::pluck('name')->implode(', ') . "\n";
echo "Grading Scales: " . App\Models\GradingScale::pluck('grade_letter')->implode(', ') . "\n";
