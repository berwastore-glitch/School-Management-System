<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Models\Student;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\CurriculumController;

// Frontend Routes
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/features', 'features')->name('features');
    Route::get('/about', 'about')->name('about');
    Route::get('/pricing', 'pricing')->name('pricing');
    Route::get('/contact', 'contact')->name('contact');
});

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Authenticated User Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->role === 'admin' || $user->role === 'super_admin') {
            return redirect()->route('admin.dashboard');
        }
        if ($user->role === 'teacher') {
            return redirect()->route('teacher.dashboard');
        }
        if ($user->role === 'student') {
            return redirect()->route('student.dashboard');
        }
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// School Selection (Super Admin)
Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {
    Route::get('/school/select', function () {
        $schools = \App\Models\School::where('is_active', true)->get();
        return view('admin.school-select', compact('schools'));
    })->name('school.select');

    Route::post('/school/select', function (\Illuminate\Http\Request $request) {
        $request->validate(['school_id' => 'required|exists:schools,id']);
        $school = \App\Models\School::find($request->school_id);
        if ($school && $school->is_active) {
            session(['school_id' => $school->id]);
            config(['app.current_school_id' => $school->id]);
            return redirect()->route('admin.dashboard');
        }
        return back()->withErrors(['school_id' => 'Invalid school selected.']);
    })->name('school.select.store');

    Route::post('/school/deselect', function () {
        session()->forget('school_id');
        config()->offsetUnset('app.current_school_id');
        return redirect()->route('school.select');
    })->name('school.deselect');

    Route::post('/school/create', function (\Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email|max:255',
            'phone'   => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
        ]);

        $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);
        $validated['is_active'] = true;

        $school = \App\Models\School::create($validated);

        session(['school_id' => $school->id]);
        config(['app.current_school_id' => $school->id]);

        \App\Services\ActivityLogService::log('created', 'New school created: ' . $school->name, $school);

        return redirect()->route('admin.dashboard')->with('success', 'School "' . $school->name . '" created successfully.');
    })->name('school.create');

    Route::get('/school/settings', function () {
        $schoolId = session('school_id');
        $school = $schoolId ? \App\Models\School::findOrFail($schoolId) : \App\Models\School::firstOrFail();
        return view('admin.school-settings', compact('school'));
    })->name('school.settings');

    Route::post('/school/settings', function (\Illuminate\Http\Request $request) {
        $schoolId = session('school_id');
        $school = $schoolId ? \App\Models\School::findOrFail($schoolId) : \App\Models\School::firstOrFail();

        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email|max:255',
            'phone'   => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'logo'    => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        } else {
            unset($data['logo']);
        }

        $school->update($data);
        \App\Services\ActivityLogService::log('updated', 'School settings updated: ' . $school->name, $school);
        return back()->with('success', 'School settings updated successfully.');
    })->name('school.settings.update');
});

// Admin Routes (Super Authorization)
Route::middleware(['auth', 'role:admin,super_admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Students
    Route::get('/students', [AdminController::class, 'students'])->name('students');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students/{student}', [AdminController::class, 'showStudent'])->name('students.show');
    Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');

    // Teachers
    Route::get('/teachers', [AdminController::class, 'teachers'])->name('teachers');
    Route::get('/teachers/create', [TeacherController::class, 'create'])->name('teachers.create');
    Route::post('/teachers', [TeacherController::class, 'store'])->name('teachers.store');
    Route::get('/teachers/{teacher}', [AdminController::class, 'showTeacher'])->name('teachers.show');
    Route::get('/teachers/{teacher}/edit', [TeacherController::class, 'edit'])->name('teachers.edit');
    Route::put('/teachers/{teacher}', [TeacherController::class, 'update'])->name('teachers.update');
    Route::delete('/teachers/{teacher}', [TeacherController::class, 'destroy'])->name('teachers.destroy');

    // Classes
    Route::get('/classes', [AdminController::class, 'classes'])->name('classes');
    Route::get('/classes/create', [AdminController::class, 'createClass'])->name('classes.create');
    Route::post('/classes', [AdminController::class, 'storeClass'])->name('classes.store');
    Route::get('/classes/{class}', [AdminController::class, 'showClass'])->name('classes.show');
    Route::get('/classes/{class}/edit', [AdminController::class, 'editClass'])->name('classes.edit');
    Route::put('/classes/{class}', [AdminController::class, 'updateClass'])->name('classes.update');
    Route::delete('/classes/{class}', [AdminController::class, 'destroyClass'])->name('classes.destroy');

    // Attendance
    Route::get('/attendance', [AdminController::class, 'attendance'])->name('attendance');
    Route::get('/attendance/mark', [AdminController::class, 'markAttendance'])->name('attendance.mark');
    Route::post('/attendance', [AdminController::class, 'storeAttendance'])->name('attendance.store');
    Route::get('/attendance/{attendance}/edit', [AdminController::class, 'editAttendance'])->name('attendance.edit');
    Route::put('/attendance/{attendance}', [AdminController::class, 'updateAttendance'])->name('attendance.update');
    Route::delete('/attendance/{attendance}', [AdminController::class, 'destroyAttendance'])->name('attendance.destroy');

    // Fees
    Route::get('/fees', [AdminController::class, 'fees'])->name('fees');
    Route::get('/fees/record', [AdminController::class, 'recordPayment'])->name('fees.record');
    Route::post('/fees', [AdminController::class, 'storePayment'])->name('fees.store');

    Route::get('/fees/{fee}/edit', [AdminController::class, 'editPayment'])->name('fees.edit');
    Route::put('/fees/{fee}', [AdminController::class, 'updatePayment'])->name('fees.update');
    Route::delete('/fees/{fee}', [AdminController::class, 'destroyPayment'])->name('fees.destroy');

    // Exams (Admin can create)
    Route::get('/exams/create', function () {
        $subjects = \App\Models\Subject::where('status', true)->get();
        return view('admin.exams-create', compact('subjects'));
    })->name('exams.create');

    Route::post('/exams', function (\Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'exam_name' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'total_marks' => 'required|integer|min:1',
            'passing_marks' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);
        $validated['date'] = date('Y-m-d');
        $classId = \App\Models\SchoolClass::where('status', true)->first()->id ?? 1;
        $validated['class_id'] = $classId;
        $exam = \App\Models\Exam::create($validated);
        \App\Services\ActivityLogService::created($exam, $validated);
        return redirect()->route('admin.students')->with('success', 'Exam created successfully.');
    })->name('exams.store');

    Route::get('/exams', function () {
        $query = \App\Models\Exam::with(['class', 'subject']);
        if ($search = request('search')) {
            $query->where('exam_name', 'like', "%{$search}%");
        }
        $exams = $query->latest('date')->paginate(15)->withQueryString();
        return view('admin.exams', compact('exams'));
    })->name('exams');

    Route::get('/exams/{exam}/edit', function (\App\Models\Exam $exam) {
        $subjects = \App\Models\Subject::where('status', true)->get();
        $classes = \App\Models\SchoolClass::where('status', true)->get();
        return view('admin.exams-edit', compact('exam', 'subjects', 'classes'));
    })->name('exams.edit');

    Route::put('/exams/{exam}', function (\Illuminate\Http\Request $request, \App\Models\Exam $exam) {
        $oldValues = $exam->toArray();
        $validated = $request->validate([
            'exam_name' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
            'total_marks' => 'required|integer|min:1',
            'passing_marks' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);
        $exam->update($validated);
        \App\Services\ActivityLogService::log('updated', "Admin updated exam: {$exam->exam_name}", $exam, $oldValues, $exam->fresh()->toArray());
        return redirect()->route('admin.students')->with('success', 'Exam updated successfully.');
    })->name('exams.update');

    Route::delete('/exams/{exam}', function (\App\Models\Exam $exam) {
        $name = $exam->exam_name;
        \App\Services\ActivityLogService::log('deleted', "Admin deleted exam: {$name}", $exam, $exam->toArray());
        $exam->delete();
        return redirect()->route('admin.students')->with('success', 'Exam deleted successfully.');
    })->name('exams.destroy');

    // Per-student marks (Admin)
    Route::get('/students/{student}/marks', function (\App\Models\Student $student) {
        $student->load('class');
        $allResults = \App\Models\Result::where('student_id', $student->id)
            ->with('exam', 'subject')
            ->get();
        $allExams = \App\Models\Exam::where('class_id', $student->class_id)->with('subject')->get();
        return view('admin.marks-enter', compact('student', 'allResults', 'allExams'));
    })->name('students.marks');

    Route::post('/students/{student}/marks/add', function (\Illuminate\Http\Request $request, \App\Models\Student $student) {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
        ]);
        $exam = \App\Models\Exam::find($request->exam_id);
        $exists = \App\Models\Result::where('student_id', $student->id)->where('exam_id', $exam->id)->exists();
        if (!$exists) {
            \App\Models\Result::create([
                'student_id' => $student->id,
                'exam_id' => $exam->id,
                'subject_id' => $exam->subject_id,
                'marks_obtained' => 0,
                'grade' => 'Pending',
            ]);
        }
        return redirect()->route('admin.students.marks', $student)->with('success', 'Exam added for marks entry.');
    })->name('students.marks.add');

    Route::post('/students/{student}/marks', function (\Illuminate\Http\Request $request, \App\Models\Student $student) {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'term' => 'required|string',
            'marks_obtained' => 'required|numeric|min:0',
        ]);
        $exam = \App\Models\Exam::find($request->exam_id);
        $grade = $request->marks_obtained >= $exam->passing_marks ? 'Pass' : 'Fail';
        \App\Models\Result::updateOrCreate(
            ['exam_id' => $exam->id, 'student_id' => $student->id, 'term' => $request->term],
            [
                'subject_id' => $exam->subject_id,
                'marks_obtained' => $request->marks_obtained,
                'grade' => $grade,
                'term' => $request->term,
            ]
        );
        \App\Services\ActivityLogService::log('updated', "Admin updated marks for {$student->first_name} {$student->last_name} - {$exam->exam_name}: {$request->marks_obtained}");
        return redirect()->route('admin.students.marks', $student)->with('success', 'Mark saved for ' . $exam->exam_name . '.');
    })->name('students.marks.store');

    Route::delete('/students/{student}/marks/{result}', function (\App\Models\Student $student, \App\Models\Result $result) {
        $result->delete();
        return redirect()->route('admin.students.marks', $student)->with('success', 'Exam removed from student marks.');
    })->name('students.marks.remove');

    // Subjects (Admin full access)
    Route::get('/subjects', function () {
        $query = \App\Models\Subject::with('teachers');
        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('subject_name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }
        $subjects = $query->latest()->paginate(15)->withQueryString();
        return view('admin.subjects', compact('subjects'));
    })->name('subjects');

    Route::get('/subjects/create', function () {
        $classes = \App\Models\SchoolClass::where('status', true)->get();
        $teachers = \App\Models\Teacher::latest()->get();
        return view('admin.subjects-create', compact('classes', 'teachers'));
    })->name('subjects.create');

    Route::post('/subjects', function (\Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'subject_name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:subjects,code',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);
        $subject = \App\Models\Subject::create([
            'subject_name' => $validated['subject_name'],
            'code' => $validated['code'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
        ]);
        $teachers = $request->input('teachers', []);
        if (!empty($teachers)) {
            foreach ($teachers as $pair) {
                if (!empty($pair['teacher_id']) && !empty($pair['class_id'])) {
                    $subject->teachers()->attach($pair['teacher_id'], ['class_id' => $pair['class_id']]);
                }
            }
        }
        \App\Services\ActivityLogService::created($subject, $validated);
        return redirect()->route('admin.subjects')->with('success', 'Subject created successfully.');
    })->name('subjects.store');

    Route::get('/subjects/{subject}/edit', function (\App\Models\Subject $subject) {
        $subject->load('teachers');
        $classes = \App\Models\SchoolClass::where('status', true)->get();
        $teachers = \App\Models\Teacher::latest()->get();
        return view('admin.subjects-edit', compact('subject', 'classes', 'teachers'));
    })->name('subjects.edit');

    Route::put('/subjects/{subject}', function (\Illuminate\Http\Request $request, \App\Models\Subject $subject) {
        $oldValues = $subject->toArray();
        $validated = $request->validate([
            'subject_name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:subjects,code,' . $subject->id,
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);
        $subject->update($validated);
        $subject->teachers()->detach();
        $teachers = $request->input('teachers', []);
        if (!empty($teachers)) {
            foreach ($teachers as $pair) {
                if (!empty($pair['teacher_id']) && !empty($pair['class_id'])) {
                    $subject->teachers()->attach($pair['teacher_id'], ['class_id' => $pair['class_id']]);
                }
            }
        }
        \App\Services\ActivityLogService::log('updated', "Updated subject: {$subject->subject_name}", $subject, $oldValues, $subject->fresh()->toArray());
        return redirect()->route('admin.subjects')->with('success', 'Subject updated successfully.');
    })->name('subjects.update');

    Route::delete('/subjects/{subject}', function (\App\Models\Subject $subject) {
        $name = $subject->subject_name;
        \App\Services\ActivityLogService::log('deleted', "Deleted subject: {$name}", $subject, $subject->toArray());
        $subject->delete();
        return redirect()->route('admin.subjects')->with('success', 'Subject deleted successfully.');
    })->name('subjects.destroy');

    // Activity Log (Admin only)
    Route::get('/activity-log', [AdminController::class, 'activityLog'])->name('activity-log');

    // Curriculum Management
    Route::get('/curriculums', [CurriculumController::class, 'curriculums'])->name('curriculums');
    Route::get('/curriculums/create', [CurriculumController::class, 'createCurriculum'])->name('curriculums.create');
    Route::post('/curriculums', [CurriculumController::class, 'storeCurriculum'])->name('curriculums.store');
    Route::get('/curriculums/{curriculum}/edit', [CurriculumController::class, 'editCurriculum'])->name('curriculums.edit');
    Route::put('/curriculums/{curriculum}', [CurriculumController::class, 'updateCurriculum'])->name('curriculums.update');
    Route::delete('/curriculums/{curriculum}', [CurriculumController::class, 'destroyCurriculum'])->name('curriculums.destroy');

    // Academic Years
    Route::get('/academic-years', [CurriculumController::class, 'academicYears'])->name('academic-years');
    Route::get('/academic-years/create', [CurriculumController::class, 'createAcademicYear'])->name('academic-years.create');
    Route::post('/academic-years', [CurriculumController::class, 'storeAcademicYear'])->name('academic-years.store');
    Route::get('/academic-years/{academicYear}/edit', [CurriculumController::class, 'editAcademicYear'])->name('academic-years.edit');
    Route::put('/academic-years/{academicYear}', [CurriculumController::class, 'updateAcademicYear'])->name('academic-years.update');
    Route::delete('/academic-years/{academicYear}', [CurriculumController::class, 'destroyAcademicYear'])->name('academic-years.destroy');

    // Terms
    Route::get('/terms', [CurriculumController::class, 'terms'])->name('terms');
    Route::get('/terms/create', [CurriculumController::class, 'createTerm'])->name('terms.create');
    Route::post('/terms', [CurriculumController::class, 'storeTerm'])->name('terms.store');
    Route::get('/terms/{term}/edit', [CurriculumController::class, 'editTerm'])->name('terms.edit');
    Route::put('/terms/{term}', [CurriculumController::class, 'updateTerm'])->name('terms.update');
    Route::delete('/terms/{term}', [CurriculumController::class, 'destroyTerm'])->name('terms.destroy');

    // Grade Levels
    Route::get('/grade-levels', [CurriculumController::class, 'gradeLevels'])->name('grade-levels');
    Route::get('/grade-levels/create', [CurriculumController::class, 'createGradeLevel'])->name('grade-levels.create');
    Route::post('/grade-levels', [CurriculumController::class, 'storeGradeLevel'])->name('grade-levels.store');
    Route::get('/grade-levels/{gradeLevel}/edit', [CurriculumController::class, 'editGradeLevel'])->name('grade-levels.edit');
    Route::put('/grade-levels/{gradeLevel}', [CurriculumController::class, 'updateGradeLevel'])->name('grade-levels.update');
    Route::delete('/grade-levels/{gradeLevel}', [CurriculumController::class, 'destroyGradeLevel'])->name('grade-levels.destroy');

    // Grading Scales
    Route::get('/grading-scales', [CurriculumController::class, 'gradingScales'])->name('grading-scales');
    Route::post('/grading-scales', [CurriculumController::class, 'storeGradingScale'])->name('grading-scales.store');
    Route::delete('/grading-scales/{gradingScale}', [CurriculumController::class, 'destroyGradingScale'])->name('grading-scales.destroy');

    // API
    Route::get('/api/students-by-class/{classId}', function ($classId) {
        $students = \App\Models\Student::where('class_id', $classId)->get(['id', 'first_name', 'last_name', 'admission_number']);
        return response()->json($students);
    });
});

// Teacher Routes (Limited Write Authorization)
Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    // Dashboard (same as admin, scoped to teacher's class)
    Route::get('/dashboard', function () {
        $user = auth()->user();
        $teacher = $user->teacher;
        $data = \App\Services\DashboardService::getTeacherStats($teacher->id ?? 0);
        $data['teacher'] = $teacher;
        return view('teacher.dashboard', $data);
    })->name('dashboard');

    // API
    Route::get('/api/students-by-class/{classId}', function ($classId) {
        $students = \App\Models\Student::where('class_id', $classId)->get(['id', 'first_name', 'last_name', 'admission_number']);
        return response()->json($students);
    });

    // Subjects (Teacher can view all)
    Route::get('/subjects', function () {
        $query = \App\Models\Subject::with('teachers');
        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('subject_name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }
        $subjects = $query->latest()->paginate(15)->withQueryString();
        return view('teacher.subjects', compact('subjects'));
    })->name('subjects');

    Route::get('/subjects/create', function () {
        $classes = \App\Models\SchoolClass::where('status', true)->get();
        $teachers = \App\Models\Teacher::latest()->get();
        return view('teacher.subjects-create', compact('classes', 'teachers'));
    })->name('subjects.create');

    Route::post('/subjects', function (\Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'subject_name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:subjects,code',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);
        $subject = \App\Models\Subject::create([
            'subject_name' => $validated['subject_name'],
            'code' => $validated['code'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
        ]);
        $teachers = $request->input('teachers', []);
        if (!empty($teachers)) {
            foreach ($teachers as $pair) {
                if (!empty($pair['teacher_id']) && !empty($pair['class_id'])) {
                    $subject->teachers()->attach($pair['teacher_id'], ['class_id' => $pair['class_id']]);
                }
            }
        }
        $teacher = auth()->user()->teacher;
        \App\Services\ActivityLogService::log('created', "Teacher {$teacher->first_name} {$teacher->last_name} created subject: {$validated['subject_name']}", $subject);
        return redirect()->route('teacher.subjects')->with('success', 'Subject created successfully.');
    })->name('subjects.store');

    Route::get('/subjects/{subject}/edit', function (\App\Models\Subject $subject) {
        $subject->load('teachers');
        $classes = \App\Models\SchoolClass::where('status', true)->get();
        $teachers = \App\Models\Teacher::latest()->get();
        return view('teacher.subjects-edit', compact('subject', 'classes', 'teachers'));
    })->name('subjects.edit');

    Route::put('/subjects/{subject}', function (\Illuminate\Http\Request $request, \App\Models\Subject $subject) {
        $oldValues = $subject->toArray();
        $validated = $request->validate([
            'subject_name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:subjects,code,' . $subject->id,
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);
        $subject->update($validated);
        $subject->teachers()->detach();
        $teachers = $request->input('teachers', []);
        if (!empty($teachers)) {
            foreach ($teachers as $pair) {
                if (!empty($pair['teacher_id']) && !empty($pair['class_id'])) {
                    $subject->teachers()->attach($pair['teacher_id'], ['class_id' => $pair['class_id']]);
                }
            }
        }
        $teacher = auth()->user()->teacher;
        \App\Services\ActivityLogService::log('updated', "Teacher {$teacher->first_name} {$teacher->last_name} updated subject: {$subject->subject_name}", $subject, $oldValues, $subject->fresh()->toArray());
        return redirect()->route('teacher.subjects')->with('success', 'Subject updated successfully.');
    })->name('subjects.update');

    Route::delete('/subjects/{subject}', function (\App\Models\Subject $subject) {
        $name = $subject->subject_name;
        $teacher = auth()->user()->teacher;
        \App\Services\ActivityLogService::log('deleted', "Teacher {$teacher->first_name} {$teacher->last_name} deleted subject: {$name}", $subject, $subject->toArray());
        $subject->delete();
        return redirect()->route('teacher.subjects')->with('success', 'Subject deleted successfully.');
    })->name('subjects.destroy');

    // Exams (Teacher can create for their assigned classes)
    Route::get('/exams/create', function () {
        $subjects = \App\Models\Subject::where('status', true)->get();
        return view('teacher.exams-create', compact('subjects'));
    })->name('exams.create');

    Route::post('/exams', function (\Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'exam_name' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'total_marks' => 'required|integer|min:1',
            'passing_marks' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);
        $validated['date'] = date('Y-m-d');
        $teacher = auth()->user()->teacher;
        $classId = \App\Models\SchoolClass::where('teacher_id', $teacher->id)->first()->id ?? 1;
        $validated['class_id'] = $classId;
        $exam = \App\Models\Exam::create($validated);
        \App\Services\ActivityLogService::log('created', "Teacher {$teacher->first_name} {$teacher->last_name} created exam: {$validated['exam_name']}", $exam);
        return redirect()->route('teacher.students')->with('success', 'Exam created successfully.');
    })->name('exams.store');

    // Per-student marks
    Route::get('/students/{student}/marks', function (\App\Models\Student $student) {
        $student->load('class');
        $allResults = \App\Models\Result::where('student_id', $student->id)
            ->with('exam', 'subject')
            ->get();
        $allExams = \App\Models\Exam::where('class_id', $student->class_id)->with('subject')->get();
        return view('teacher.marks-enter', compact('student', 'allResults', 'allExams'));
    })->name('students.marks');

    Route::post('/students/{student}/marks/add', function (\Illuminate\Http\Request $request, \App\Models\Student $student) {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
        ]);
        $exam = \App\Models\Exam::find($request->exam_id);
        $exists = \App\Models\Result::where('student_id', $student->id)->where('exam_id', $exam->id)->exists();
        if (!$exists) {
            \App\Models\Result::create([
                'student_id' => $student->id,
                'exam_id' => $exam->id,
                'subject_id' => $exam->subject_id,
                'marks_obtained' => 0,
                'grade' => 'Pending',
            ]);
        }
        return redirect()->route('teacher.students.marks', $student)->with('success', 'Exam added for marks entry.');
    })->name('students.marks.add');

    Route::post('/students/{student}/marks', function (\Illuminate\Http\Request $request, \App\Models\Student $student) {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'term' => 'required|string',
            'marks_obtained' => 'required|numeric|min:0',
        ]);
        $exam = \App\Models\Exam::find($request->exam_id);
        $grade = $request->marks_obtained >= $exam->passing_marks ? 'Pass' : 'Fail';
        \App\Models\Result::updateOrCreate(
            ['exam_id' => $exam->id, 'student_id' => $student->id, 'term' => $request->term],
            [
                'subject_id' => $exam->subject_id,
                'marks_obtained' => $request->marks_obtained,
                'grade' => $grade,
                'term' => $request->term,
            ]
        );
        $teacher = auth()->user()->teacher;
        \App\Services\ActivityLogService::log('updated', "Teacher {$teacher->first_name} {$teacher->last_name} updated marks for {$student->first_name} {$student->last_name} - {$exam->exam_name}: {$request->marks_obtained}");
        return redirect()->route('teacher.students.marks', $student)->with('success', 'Mark saved for ' . $exam->exam_name . '.');
    })->name('students.marks.store');

    Route::delete('/students/{student}/marks/{result}', function (\App\Models\Student $student, \App\Models\Result $result) {
        $result->delete();
        return redirect()->route('teacher.students.marks', $student)->with('success', 'Exam removed from student marks.');
    })->name('students.marks.remove');

    // Students (Teacher has full admin access)
    Route::get('/students', function () {
        $query = \App\Models\Student::with('class');
        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('admission_number', 'like', "%{$search}%");
            });
        }
        $students = $query->latest()->paginate(15)->withQueryString();
        return view('teacher.students', compact('students'));
    })->name('students');

    Route::get('/students/create', function () {
        $classes = \App\Models\SchoolClass::where('status', true)->get();
        return view('teacher.students-create', compact('classes'));
    })->name('students.create');

    Route::post('/students', function (\Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'class_id' => 'nullable|exists:classes,id',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);
        $user = \App\Models\User::create([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'role' => 'student',
        ]);
        $admissionNumber = 'STU-' . str_pad(\App\Models\Student::max('id') + 1, 5, '0', STR_PAD_LEFT);
        $student = \App\Models\Student::create([
            'user_id' => $user->id, 'admission_number' => $admissionNumber,
            'first_name' => $validated['first_name'], 'last_name' => $validated['last_name'],
            'gender' => $validated['gender'], 'date_of_birth' => $validated['date_of_birth'],
            'class_id' => $validated['class_id'], 'phone' => $validated['phone'], 'address' => $validated['address'],
        ]);
        $teacher = auth()->user()->teacher;
        \App\Services\ActivityLogService::log('created', "Teacher {$teacher->first_name} {$teacher->last_name} created student: {$student->first_name} {$student->last_name}", $student);
        return redirect()->route('teacher.students')->with('success', 'Student added successfully.');
    })->name('students.store');

    Route::get('/students/{student}', function (\App\Models\Student $student) {
        $student->load(['class', 'user', 'attendances', 'results.exam', 'fees']);
        $classmates = \App\Models\Student::where('class_id', $student->class_id)
            ->with(['results.exam', 'user'])
            ->get();
        $school = \App\Models\School::find(session('school_id')) ?? \App\Models\School::first();
        return view('teacher.students-show', compact('student', 'classmates', 'school'));
    })->name('students.show');

    Route::get('/students/{student}/edit', function (\App\Models\Student $student) {
        $classes = \App\Models\SchoolClass::where('status', true)->get();
        return view('teacher.students-edit', compact('student', 'classes'));
    })->name('students.edit');

    Route::put('/students/{student}', function (\Illuminate\Http\Request $request, \App\Models\Student $student) {
        $oldValues = $student->toArray();
        $validated = $request->validate([
            'first_name' => 'required|string|max:255', 'last_name' => 'required|string|max:255',
            'gender' => 'nullable|string', 'date_of_birth' => 'nullable|date',
            'class_id' => 'nullable|exists:classes,id', 'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string', 'status' => 'required|boolean',
        ]);
        $student->update($validated);
        $student->user->update(['name' => $validated['first_name'] . ' ' . $validated['last_name']]);
        $teacher = auth()->user()->teacher;
        \App\Services\ActivityLogService::log('updated', "Teacher {$teacher->first_name} {$teacher->last_name} updated student: {$student->first_name} {$student->last_name}", $student, $oldValues, $student->fresh()->toArray());
        return redirect()->route('teacher.students.show', $student)->with('success', 'Student updated successfully.');
    })->name('students.update');

    Route::delete('/students/{student}', function (\App\Models\Student $student) {
        $teacher = auth()->user()->teacher;
        \App\Services\ActivityLogService::log('deleted', "Teacher {$teacher->first_name} {$teacher->last_name} deleted student: {$student->first_name} {$student->last_name}", $student, $student->toArray());
        $student->delete();
        return redirect()->route('teacher.students')->with('success', 'Student deleted successfully.');
    })->name('students.destroy');

    // Attendance (Teacher has full admin access - all classes)
    Route::get('/attendance', function () {
        $query = \App\Models\Attendance::with('student', 'class');
        if ($classId = request('class_id')) { $query->where('class_id', $classId); }
        if ($date = request('date')) { $query->where('date', $date); }
        $attendanceRecords = $query->latest('date')->paginate(15)->withQueryString();
        $classes = \App\Models\SchoolClass::where('status', true)->get();
        return view('teacher.attendance', compact('attendanceRecords', 'classes'));
    })->name('attendance');

    Route::get('/attendance/mark', function () {
        $classes = \App\Models\SchoolClass::where('status', true)->get();
        return view('teacher.attendance-mark', compact('classes'));
    })->name('attendance.mark');

    Route::post('/attendance', function (\Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id', 'date' => 'required|date', 'students' => 'required|array',
        ]);

        $records = [];
        foreach ($validated['students'] as $studentId => $data) {
            $records[] = [
                'student_id' => $studentId,
                'class_id' => $validated['class_id'],
                'date' => $validated['date'],
                'status' => $data['status'],
                'remark' => $data['remark'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        foreach ($records as $record) {
            \App\Models\Attendance::updateOrCreate(
                ['student_id' => $record['student_id'], 'date' => $record['date']],
                $record
            );
        }

        $teacher = auth()->user()->teacher;
        \App\Services\ActivityLogService::log('created', "Teacher {$teacher->first_name} {$teacher->last_name} marked attendance for " . count($records) . " students on {$validated['date']}");
        return redirect()->route('teacher.attendance')->with('success', 'Attendance marked successfully.');
    })->name('attendance.store');

    Route::get('/attendance/{attendance}/edit', function (\App\Models\Attendance $attendance) {
        $classes = \App\Models\SchoolClass::where('status', true)->get();
        $students = \App\Models\Student::where('class_id', $attendance->class_id)->get();
        return view('admin.attendance-edit', compact('attendance', 'classes', 'students'));
    })->name('attendance.edit');

    Route::put('/attendance/{attendance}', function (\Illuminate\Http\Request $request, \App\Models\Attendance $attendance) {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'class_id' => 'required|exists:classes,id',
            'date' => 'required|date',
            'status' => 'required|in:present,absent,late,excused',
            'remark' => 'nullable|string|max:500',
        ]);

        $attendance->update($validated);

        $teacher = auth()->user()->teacher;
        \App\Services\ActivityLogService::log('updated', "Teacher {$teacher->first_name} {$teacher->last_name} updated attendance for student #{$validated['student_id']} on {$validated['date']}");
        return redirect()->route('teacher.attendance')->with('success', 'Attendance updated successfully.');
    })->name('attendance.update');

    Route::delete('/attendance/{attendance}', function (\App\Models\Attendance $attendance) {
        $teacher = auth()->user()->teacher;
        \App\Services\ActivityLogService::log('deleted', "Teacher {$teacher->first_name} {$teacher->last_name} deleted attendance for student #{$attendance->student_id} on {$attendance->date}");
        $attendance->delete();
        return redirect()->route('teacher.attendance')->with('success', 'Attendance deleted successfully.');
    })->name('attendance.destroy');

    // Teachers (Teacher can view other teachers)
    Route::get('/teachers', function () {
        $teachers = \App\Models\Teacher::latest()->paginate(15);
        return view('teacher.teachers', compact('teachers'));
    })->name('teachers');

    // Classes (Teacher can view classes)
    Route::get('/classes', function () {
        $query = \App\Models\SchoolClass::with('teacher')->withCount('students');
        $classes = $query->latest()->paginate(15);
        return view('teacher.classes', compact('classes'));
    })->name('classes');

    // Fees (Teacher can view fees)
    Route::get('/fees', function () {
        $user = auth()->user();
        $teacher = $user->teacher;
        $assignedClassIds = \App\Models\SchoolClass::where('teacher_id', $teacher->id ?? 0)->pluck('id');
        $studentIds = \App\Models\Student::whereIn('class_id', $assignedClassIds)->pluck('id');
        $query = \App\Models\Fee::with('student');
        if ($studentIds->count()) {
            $query->whereIn('student_id', $studentIds);
        }
        $fees = $query->latest()->paginate(15);
        return view('teacher.fees', compact('fees'));
    })->name('fees');

    // Academics (view-only)
    Route::get('/academics/curriculums', [\App\Http\Controllers\Teacher\AcademicController::class, 'curriculums'])->name('academics.curriculums');
    Route::get('/academics/academic-years', [\App\Http\Controllers\Teacher\AcademicController::class, 'academicYears'])->name('academics.academic-years');
    Route::get('/academics/terms', [\App\Http\Controllers\Teacher\AcademicController::class, 'terms'])->name('academics.terms');
    Route::get('/academics/grade-levels', [\App\Http\Controllers\Teacher\AcademicController::class, 'gradeLevels'])->name('academics.grade-levels');
    Route::get('/academics/grading-scales', [\App\Http\Controllers\Teacher\AcademicController::class, 'gradingScales'])->name('academics.grading-scales');
});

// Student Portal Routes
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Student\DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/class', [\App\Http\Controllers\Student\DashboardController::class, 'classInfo'])->name('class');
    Route::get('/results', [\App\Http\Controllers\Student\DashboardController::class, 'results'])->name('results');
    Route::get('/attendance', [\App\Http\Controllers\Student\DashboardController::class, 'attendance'])->name('attendance');
    Route::get('/exams', [\App\Http\Controllers\Student\DashboardController::class, 'exams'])->name('exams');
    Route::get('/fees', [\App\Http\Controllers\Student\DashboardController::class, 'fees'])->name('fees');
});

require __DIR__.'/auth.php';
