<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use App\Models\AcademicYear;
use App\Models\Term;
use App\Models\GradeLevel;
use App\Models\GradingScale;
use App\Services\ActivityLogService;
use App\Traits\NeedsSchool;
use Illuminate\Http\Request;

class CurriculumController extends Controller
{
    use NeedsSchool;
    // --- Curriculums ---
    public function curriculums(Request $request)
    {
        $query = Curriculum::query();
        if ($schoolId = $this->getSchoolId()) {
            $query->where('school_id', $schoolId);
        }
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }
        $curriculums = $query->latest()->paginate(15)->withQueryString();
        return view('admin.curriculums', compact('curriculums'));
    }

    public function createCurriculum()
    {
        return view('admin.curriculums-create');
    }

    public function storeCurriculum(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:curriculums,code',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);
        $validated['school_id'] = config('app.current_school_id');
        $curriculum = Curriculum::create($validated);
        ActivityLogService::created($curriculum, $validated);
        return redirect()->route('admin.curriculums')->with('success', 'Curriculum created successfully.');
    }

    public function editCurriculum(Curriculum $curriculum)
    {
        return view('admin.curriculums-edit', compact('curriculum'));
    }

    public function updateCurriculum(Request $request, Curriculum $curriculum)
    {
        $oldValues = $curriculum->toArray();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:curriculums,code,' . $curriculum->id,
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);
        $curriculum->update($validated);
        ActivityLogService::log('updated', "Updated curriculum: {$curriculum->name}", $curriculum, $oldValues, $curriculum->fresh()->toArray());
        return redirect()->route('admin.curriculums')->with('success', 'Curriculum updated successfully.');
    }

    public function destroyCurriculum(Curriculum $curriculum)
    {
        $name = $curriculum->name;
        ActivityLogService::log('deleted', "Deleted curriculum: {$name}", $curriculum, $curriculum->toArray());
        $curriculum->delete();
        return redirect()->route('admin.curriculums')->with('success', 'Curriculum deleted successfully.');
    }

    // --- Academic Years ---
    public function academicYears(Request $request)
    {
        $query = AcademicYear::query();
        if ($schoolId = $this->getSchoolId()) {
            $query->where('school_id', $schoolId);
        }
        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }
        $academicYears = $query->latest()->paginate(15)->withQueryString();
        return view('admin.academic-years', compact('academicYears'));
    }

    public function createAcademicYear()
    {
        return view('admin.academic-years-create');
    }

    public function storeAcademicYear(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'required|boolean',
            'is_current' => 'nullable|boolean',
        ]);
        $validated['school_id'] = config('app.current_school_id');
        $validated['is_current'] = $validated['is_current'] ?? false;
        if ($validated['is_current']) {
            AcademicYear::where('school_id', $validated['school_id'])->update(['is_current' => false]);
        }
        $academicYear = AcademicYear::create($validated);
        ActivityLogService::created($academicYear, $validated);
        return redirect()->route('admin.academic-years')->with('success', 'Academic year created successfully.');
    }

    public function editAcademicYear(AcademicYear $academicYear)
    {
        return view('admin.academic-years-edit', compact('academicYear'));
    }

    public function updateAcademicYear(Request $request, AcademicYear $academicYear)
    {
        $oldValues = $academicYear->toArray();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'required|boolean',
            'is_current' => 'nullable|boolean',
        ]);
        $validated['is_current'] = $validated['is_current'] ?? false;
        if ($validated['is_current']) {
            AcademicYear::where('school_id', $academicYear->school_id)->update(['is_current' => false]);
        }
        $academicYear->update($validated);
        ActivityLogService::log('updated', "Updated academic year: {$academicYear->name}", $academicYear, $oldValues, $academicYear->fresh()->toArray());
        return redirect()->route('admin.academic-years')->with('success', 'Academic year updated successfully.');
    }

    public function destroyAcademicYear(AcademicYear $academicYear)
    {
        $name = $academicYear->name;
        ActivityLogService::log('deleted', "Deleted academic year: {$name}", $academicYear, $academicYear->toArray());
        $academicYear->delete();
        return redirect()->route('admin.academic-years')->with('success', 'Academic year deleted successfully.');
    }

    // --- Terms ---
    public function terms(Request $request)
    {
        $query = Term::with('academicYear');
        if ($schoolId = $this->getSchoolId()) {
            $query->where('school_id', $schoolId);
        }
        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }
        $terms = $query->latest()->paginate(15)->withQueryString();
        return view('admin.terms', compact('terms'));
    }

    public function createTerm()
    {
        $academicYearsQuery = AcademicYear::where('is_active', true)->latest();
        if ($schoolId = $this->getSchoolId()) {
            $academicYearsQuery->where('school_id', $schoolId);
        }
        $academicYears = $academicYearsQuery->get();
        return view('admin.terms-create', compact('academicYears'));
    }

    public function storeTerm(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'academic_year_id' => 'required|exists:academic_years,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'required|boolean',
            'is_current' => 'nullable|boolean',
        ]);
        $validated['school_id'] = config('app.current_school_id');
        $validated['is_current'] = $validated['is_current'] ?? false;
        if ($validated['is_current']) {
            Term::where('school_id', $validated['school_id'])->update(['is_current' => false]);
        }
        $term = Term::create($validated);
        ActivityLogService::created($term, $validated);
        return redirect()->route('admin.terms')->with('success', 'Term created successfully.');
    }

    public function editTerm(Term $term)
    {
        $academicYearsQuery = AcademicYear::where('is_active', true)->latest();
        if ($schoolId = $this->getSchoolId()) {
            $academicYearsQuery->where('school_id', $schoolId);
        }
        $academicYears = $academicYearsQuery->get();
        return view('admin.terms-edit', compact('term', 'academicYears'));
    }

    public function updateTerm(Request $request, Term $term)
    {
        $oldValues = $term->toArray();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'academic_year_id' => 'required|exists:academic_years,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'required|boolean',
            'is_current' => 'nullable|boolean',
        ]);
        $validated['is_current'] = $validated['is_current'] ?? false;
        if ($validated['is_current']) {
            Term::where('school_id', $term->school_id)->update(['is_current' => false]);
        }
        $term->update($validated);
        ActivityLogService::log('updated', "Updated term: {$term->name}", $term, $oldValues, $term->fresh()->toArray());
        return redirect()->route('admin.terms')->with('success', 'Term updated successfully.');
    }

    public function destroyTerm(Term $term)
    {
        $name = $term->name;
        ActivityLogService::log('deleted', "Deleted term: {$name}", $term, $term->toArray());
        $term->delete();
        return redirect()->route('admin.terms')->with('success', 'Term deleted successfully.');
    }

    // --- Grade Levels ---
    public function gradeLevels(Request $request)
    {
        $query = GradeLevel::with('curriculum');
        if ($schoolId = $this->getSchoolId()) {
            $query->where('school_id', $schoolId);
        }
        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }
        $gradeLevels = $query->orderBy('sort_order')->paginate(15)->withQueryString();
        return view('admin.grade-levels', compact('gradeLevels'));
    }

    public function createGradeLevel()
    {
        $curriculumsQuery = Curriculum::where('is_active', true)->latest();
        if ($schoolId = $this->getSchoolId()) {
            $curriculumsQuery->where('school_id', $schoolId);
        }
        $curriculums = $curriculumsQuery->get();
        return view('admin.grade-levels-create', compact('curriculums'));
    }

    public function storeGradeLevel(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'curriculum_id' => 'required|exists:curriculums,id',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'required|boolean',
        ]);
        $validated['school_id'] = config('app.current_school_id');
        $gradeLevel = GradeLevel::create($validated);
        ActivityLogService::created($gradeLevel, $validated);
        return redirect()->route('admin.grade-levels')->with('success', 'Grade level created successfully.');
    }

    public function editGradeLevel(GradeLevel $gradeLevel)
    {
        $curriculumsQuery = Curriculum::where('is_active', true)->latest();
        if ($schoolId = $this->getSchoolId()) {
            $curriculumsQuery->where('school_id', $schoolId);
        }
        $curriculums = $curriculumsQuery->get();
        return view('admin.grade-levels-edit', compact('gradeLevel', 'curriculums'));
    }

    public function updateGradeLevel(Request $request, GradeLevel $gradeLevel)
    {
        $oldValues = $gradeLevel->toArray();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'curriculum_id' => 'required|exists:curriculums,id',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'required|boolean',
        ]);
        $gradeLevel->update($validated);
        ActivityLogService::log('updated', "Updated grade level: {$gradeLevel->name}", $gradeLevel, $oldValues, $gradeLevel->fresh()->toArray());
        return redirect()->route('admin.grade-levels')->with('success', 'Grade level updated successfully.');
    }

    public function destroyGradeLevel(GradeLevel $gradeLevel)
    {
        $name = $gradeLevel->name;
        ActivityLogService::log('deleted', "Deleted grade level: {$name}", $gradeLevel, $gradeLevel->toArray());
        $gradeLevel->delete();
        return redirect()->route('admin.grade-levels')->with('success', 'Grade level deleted successfully.');
    }

    // --- Grading Scales ---
    public function gradingScales(Request $request)
    {
        $query = GradingScale::with('curriculum');
        if ($schoolId = $this->getSchoolId()) {
            $query->where('school_id', $schoolId);
        }
        if ($search = $request->input('search')) {
            $query->where('grade_letter', 'like', "%{$search}%");
        }
        $gradingScales = $query->latest()->paginate(15)->withQueryString();
        $curriculumsQuery = Curriculum::where('is_active', true);
        if ($schoolId = $this->getSchoolId()) {
            $curriculumsQuery->where('school_id', $schoolId);
        }
        $curriculums = $curriculumsQuery->get();
        return view('admin.grading-scales', compact('gradingScales', 'curriculums'));
    }

    public function storeGradingScale(Request $request)
    {
        $validated = $request->validate([
            'curriculum_id' => 'required|exists:curriculums,id',
            'grade_letter' => 'required|string|max:10',
            'min_percentage' => 'required|integer|min:0|max:100',
            'max_percentage' => 'required|integer|min:0|max:100',
            'description' => 'nullable|string',
            'grade_points' => 'nullable|integer|min:0',
        ]);
        $validated['school_id'] = config('app.current_school_id');
        $scale = GradingScale::create($validated);
        ActivityLogService::created($scale, $validated);
        return redirect()->route('admin.grading-scales')->with('success', 'Grading scale added successfully.');
    }

    public function destroyGradingScale(GradingScale $gradingScale)
    {
        $name = $gradingScale->grade_letter;
        ActivityLogService::log('deleted', "Deleted grading scale: {$name}", $gradingScale, $gradingScale->toArray());
        $gradingScale->delete();
        return redirect()->route('admin.grading-scales')->with('success', 'Grading scale deleted successfully.');
    }
}
