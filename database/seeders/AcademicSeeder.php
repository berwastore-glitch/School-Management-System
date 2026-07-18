<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\Curriculum;
use App\Models\AcademicYear;
use App\Models\Term;
use App\Models\GradeLevel;
use App\Models\GradingScale;
use Illuminate\Database\Seeder;

class AcademicSeeder extends Seeder
{
    public function run(): void
    {
        $school = School::firstOrCreate(
            ['slug' => 'default-school'],
            [
                'name' => 'Default School',
                'email' => 'admin@defaultschool.edu',
                'phone' => '+1234567890',
                'address' => '123 Education Street',
                'is_active' => true,
            ]
        );

        // Curriculums
        $nc = Curriculum::firstOrCreate(
            ['code' => 'NC'],
            ['school_id' => $school->id, 'name' => 'National Curriculum', 'description' => 'Standard national curriculum', 'is_active' => true]
        );
        $cbse = Curriculum::firstOrCreate(
            ['code' => 'CBSE'],
            ['school_id' => $school->id, 'name' => 'CBSE', 'description' => 'Central Board of Secondary Education', 'is_active' => true]
        );
        $cambridge = Curriculum::firstOrCreate(
            ['code' => 'CAM'],
            ['school_id' => $school->id, 'name' => 'Cambridge International', 'description' => 'Cambridge IGCSE curriculum', 'is_active' => true]
        );

        // Academic Year
        $year2026 = AcademicYear::firstOrCreate(
            ['name' => '2025-2026'],
            ['school_id' => $school->id, 'start_date' => '2025-09-01', 'end_date' => '2026-07-31', 'is_current' => true, 'is_active' => true]
        );

        // Terms
        Term::firstOrCreate(
            ['name' => 'First Term', 'academic_year_id' => $year2026->id],
            ['school_id' => $school->id, 'start_date' => '2025-09-01', 'end_date' => '2025-12-20', 'is_current' => true, 'is_active' => true]
        );
        Term::firstOrCreate(
            ['name' => 'Second Term', 'academic_year_id' => $year2026->id],
            ['school_id' => $school->id, 'start_date' => '2026-01-06', 'end_date' => '2026-04-10', 'is_current' => false, 'is_active' => true]
        );
        Term::firstOrCreate(
            ['name' => 'Third Term', 'academic_year_id' => $year2026->id],
            ['school_id' => $school->id, 'start_date' => '2026-04-20', 'end_date' => '2026-07-31', 'is_current' => false, 'is_active' => true]
        );

        // Grade Levels for National Curriculum
        $grades = ['Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10'];
        foreach ($grades as $i => $gradeName) {
            GradeLevel::firstOrCreate(
                ['name' => $gradeName, 'curriculum_id' => $nc->id],
                ['school_id' => $school->id, 'sort_order' => $i + 1, 'is_active' => true]
            );
        }

        // Grading Scales
        $scales = [
            ['grade_letter' => 'A+', 'min_percentage' => 90, 'max_percentage' => 100, 'grade_points' => 4.0, 'description' => 'Excellent'],
            ['grade_letter' => 'A',  'min_percentage' => 80, 'max_percentage' => 89,  'grade_points' => 3.5, 'description' => 'Very Good'],
            ['grade_letter' => 'B',  'min_percentage' => 70, 'max_percentage' => 79,  'grade_points' => 3.0, 'description' => 'Good'],
            ['grade_letter' => 'C',  'min_percentage' => 60, 'max_percentage' => 69,  'grade_points' => 2.0, 'description' => 'Average'],
            ['grade_letter' => 'D',  'min_percentage' => 50, 'max_percentage' => 59,  'grade_points' => 1.0, 'description' => 'Below Average'],
            ['grade_letter' => 'F',  'min_percentage' => 0,  'max_percentage' => 49,  'grade_points' => 0.0, 'description' => 'Fail'],
        ];
        foreach ($scales as $scale) {
            GradingScale::firstOrCreate(
                ['grade_letter' => $scale['grade_letter'], 'curriculum_id' => $nc->id],
                array_merge($scale, ['school_id' => $school->id])
            );
        }

        $this->command->info("Academic data seeded: 1 school, 3 curriculums, 1 academic year, 3 terms, 10 grade levels, 6 grading scales");
    }
}
