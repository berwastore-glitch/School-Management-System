<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use App\Models\AcademicYear;
use App\Models\Term;
use App\Models\GradeLevel;
use App\Models\GradingScale;

class AcademicController extends Controller
{
    public function curriculums()
    {
        $curriculums = Curriculum::orderBy('name')->get();
        return view('teacher.academics.curriculums', compact('curriculums'));
    }

    public function academicYears()
    {
        $academicYears = AcademicYear::orderBy('start_date', 'desc')->get();
        return view('teacher.academics.academic-years', compact('academicYears'));
    }

    public function terms()
    {
        $terms = Term::with('academicYear')->orderBy('start_date', 'desc')->get();
        return view('teacher.academics.terms', compact('terms'));
    }

    public function gradeLevels()
    {
        $gradeLevels = GradeLevel::with('curriculum')->orderBy('sort_order')->get();
        return view('teacher.academics.grade-levels', compact('gradeLevels'));
    }

    public function gradingScales()
    {
        $gradingScales = GradingScale::with('curriculum')->orderBy('grade_letter')->get();
        return view('teacher.academics.grading-scales', compact('gradingScales'));
    }
}
