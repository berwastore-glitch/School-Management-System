<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Attendance;
use App\Models\Exam;
use App\Models\Fee;
use App\Models\User;
use App\Models\ActivityLog;
use App\Services\ActivityLogService;
use App\Services\DashboardService;
use App\Traits\NeedsSchool;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    use NeedsSchool;
    public function dashboard()
    {
        ActivityLogService::viewed('Viewed admin dashboard');
        $data = DashboardService::getAdminStats();
        return view('admin.dashboard', $data);
    }

    // --- Students ---
    public function students(Request $request)
    {
        ActivityLogService::viewed('Viewed students list');
        $query = Student::with('class');
        if ($schoolId = $this->getSchoolId()) {
            $query->where('school_id', $schoolId);
        }
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('admission_number', 'like', "%{$search}%");
            });
        }
        $students = $query->latest()->paginate(15)->withQueryString();
        return view('admin.students', compact('students'));
    }

    public function showStudent(Student $student)
    {
        $student->load(['class', 'user', 'attendances', 'results.exam', 'fees']);
        $classmates = \App\Models\Student::where('class_id', $student->class_id)
            ->with(['results.exam', 'user'])
            ->get();
        $school = \App\Models\School::find(session('school_id')) ?? \App\Models\School::first();
        ActivityLogService::viewed("Viewed student: {$student->first_name} {$student->last_name}");
        return view('admin.students-show', compact('student', 'classmates', 'school'));
    }

    // --- Teachers ---
    public function teachers(Request $request)
    {
        ActivityLogService::viewed('Viewed teachers list');
        $query = Teacher::query();
        if ($schoolId = $this->getSchoolId()) {
            $query->where('school_id', $schoolId);
        }
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('employee_id', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }
        $teachers = $query->latest()->paginate(15)->withQueryString();
        return view('admin.teachers', compact('teachers'));
    }

    public function showTeacher(Teacher $teacher)
    {
        $teacher->load(['user', 'classes', 'subjects']);
        ActivityLogService::viewed("Viewed teacher: {$teacher->first_name} {$teacher->last_name}");
        return view('admin.teachers-show', compact('teacher'));
    }

    // --- Classes ---
    public function classes(Request $request)
    {
        ActivityLogService::viewed('Viewed classes list');
        $query = SchoolClass::with('teacher')->withCount('students');
        if ($schoolId = $this->getSchoolId()) {
            $query->where('school_id', $schoolId);
        }
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('class_name', 'like', "%{$search}%")
                  ->orWhere('section', 'like', "%{$search}%");
            });
        }
        $classes = $query->latest()->paginate(15)->withQueryString();
        return view('admin.classes', compact('classes'));
    }

    public function createClass()
    {
        $teachersQuery = Teacher::where('status', true);
        if ($schoolId = $this->getSchoolId()) {
            $teachersQuery->where('school_id', $schoolId);
        }
        $teachers = $teachersQuery->get();
        $curriculumsQuery = \App\Models\Curriculum::orderBy('name');
        if ($schoolId = $this->getSchoolId()) {
            $curriculumsQuery->where('school_id', $schoolId);
        }
        $curriculums = $curriculumsQuery->get();
        $gradeLevelsQuery = \App\Models\GradeLevel::orderBy('name');
        if ($schoolId = $this->getSchoolId()) {
            $gradeLevelsQuery->where('school_id', $schoolId);
        }
        $gradeLevels = $gradeLevelsQuery->get();
        return view('admin.classes-create', compact('teachers', 'curriculums', 'gradeLevels'));
    }

    public function storeClass(Request $request)
    {
        $validated = $request->validate([
            'class_name' => 'required|string|max:255',
            'section' => 'nullable|string|max:255',
            'capacity' => 'required|integer|min:1',
            'teacher_id' => 'nullable|exists:teachers,id',
            'curriculum_id' => 'nullable|exists:curriculums,id',
            'grade_level_id' => 'nullable|exists:grade_levels,id',
        ]);
        $class = SchoolClass::create($validated);
        ActivityLogService::created($class);
        return redirect()->route('admin.classes')->with('success', 'Class created successfully.');
    }

    public function showClass(SchoolClass $class)
    {
        $class->load(['teacher', 'students', 'exams', 'subjects']);
        ActivityLogService::viewed("Viewed class: {$class->class_name}");
        return view('admin.classes-show', compact('class'));
    }

    public function editClass(SchoolClass $class)
    {
        $teachersQuery = Teacher::where('status', true);
        if ($schoolId = $this->getSchoolId()) {
            $teachersQuery->where('school_id', $schoolId);
        }
        $teachers = $teachersQuery->get();
        $curriculumsQuery = \App\Models\Curriculum::orderBy('name');
        if ($schoolId = $this->getSchoolId()) {
            $curriculumsQuery->where('school_id', $schoolId);
        }
        $curriculums = $curriculumsQuery->get();
        $gradeLevelsQuery = \App\Models\GradeLevel::orderBy('name');
        if ($schoolId = $this->getSchoolId()) {
            $gradeLevelsQuery->where('school_id', $schoolId);
        }
        $gradeLevels = $gradeLevelsQuery->get();
        return view('admin.classes-edit', compact('class', 'teachers', 'curriculums', 'gradeLevels'));
    }

    public function updateClass(Request $request, SchoolClass $class)
    {
        $oldValues = $class->toArray();
        $validated = $request->validate([
            'class_name' => 'required|string|max:255',
            'section' => 'nullable|string|max:255',
            'capacity' => 'required|integer|min:1',
            'teacher_id' => 'nullable|exists:teachers,id',
            'curriculum_id' => 'nullable|exists:curriculums,id',
            'grade_level_id' => 'nullable|exists:grade_levels,id',
            'status' => 'required|boolean',
        ]);
        $class->update($validated);
        ActivityLogService::updated($class, $oldValues, $class->fresh()->toArray());
        return redirect()->route('admin.classes')->with('success', 'Class updated successfully.');
    }

    public function destroyClass(SchoolClass $class)
    {
        ActivityLogService::deleted($class);
        $class->delete();
        return redirect()->route('admin.classes')->with('success', 'Class deleted successfully.');
    }

    // --- Attendance ---
    public function attendance(Request $request)
    {
        ActivityLogService::viewed('Viewed attendance records');
        $query = Attendance::with('student', 'class');
        if ($schoolId = $this->getSchoolId()) {
            $query->where('school_id', $schoolId);
        }
        if ($classId = $request->input('class_id')) {
            $query->where('class_id', $classId);
        }
        if ($date = $request->input('date')) {
            $query->where('date', $date);
        }
        $attendanceRecords = $query->latest('date')->paginate(15)->withQueryString();
        $classesQuery = SchoolClass::where('status', true);
        if ($schoolId = $this->getSchoolId()) {
            $classesQuery->where('school_id', $schoolId);
        }
        $classes = $classesQuery->get();
        return view('admin.attendance', compact('attendanceRecords', 'classes'));
    }

    public function markAttendance()
    {
        $classesQuery = SchoolClass::where('status', true);
        if ($schoolId = $this->getSchoolId()) {
            $classesQuery->where('school_id', $schoolId);
        }
        $classes = $classesQuery->get();
        return view('admin.attendance-mark', compact('classes'));
    }

    public function storeAttendance(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'date' => 'required|date',
            'students' => 'required|array',
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
            Attendance::updateOrCreate(
                ['student_id' => $record['student_id'], 'date' => $record['date']],
                $record
            );
        }

        ActivityLogService::log(
            'created',
            "Marked attendance for " . count($records) . " students on {$validated['date']}"
        );
        return redirect()->route('admin.attendance')->with('success', 'Attendance marked successfully.');
    }

    public function editAttendance(Attendance $attendance)
    {
        $classesQuery = SchoolClass::where('status', true);
        if ($schoolId = $this->getSchoolId()) {
            $classesQuery->where('school_id', $schoolId);
        }
        $classes = $classesQuery->get();
        $students = \App\Models\Student::where('class_id', $attendance->class_id)->get();
        return view('admin.attendance-edit', compact('attendance', 'classes', 'students'));
    }

    public function updateAttendance(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'class_id' => 'required|exists:classes,id',
            'date' => 'required|date',
            'status' => 'required|in:present,absent,late,excused',
            'remark' => 'nullable|string|max:500',
        ]);

        $attendance->update($validated);

        ActivityLogService::log('updated', "Updated attendance for student #{$validated['student_id']} on {$validated['date']}");
        return redirect()->route('admin.attendance')->with('success', 'Attendance updated successfully.');
    }

    public function destroyAttendance(Attendance $attendance)
    {
        $info = "Deleted attendance for student #{$attendance->student_id} on {$attendance->date}";
        $attendance->delete();

        ActivityLogService::log('deleted', $info);
        return redirect()->route('admin.attendance')->with('success', 'Attendance deleted successfully.');
    }

    // --- Exams ---
    public function exams(Request $request)
    {
        ActivityLogService::viewed('Viewed exams list');
        $query = Exam::with('class', 'subject');
        if ($schoolId = $this->getSchoolId()) {
            $query->where('school_id', $schoolId);
        }
        if ($classId = $request->input('class_id')) {
            $query->where('class_id', $classId);
        }
        $exams = $query->latest()->paginate(15)->withQueryString();
        $classesQuery = SchoolClass::where('status', true);
        if ($schoolId = $this->getSchoolId()) {
            $classesQuery->where('school_id', $schoolId);
        }
        $classes = $classesQuery->get();
        return view('admin.exams', compact('exams', 'classes'));
    }

    public function createExam()
    {
        $classesQuery = SchoolClass::where('status', true);
        if ($schoolId = $this->getSchoolId()) {
            $classesQuery->where('school_id', $schoolId);
        }
        $classes = $classesQuery->get();
        $subjects = Subject::where('status', true)->get();
        return view('admin.exams-create', compact('classes', 'subjects'));
    }

    public function storeExam(Request $request)
    {
        $validated = $request->validate([
            'exam_name' => 'required|string|max:255',
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'total_marks' => 'required|integer|min:1',
            'passing_marks' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);
        $exam = Exam::create($validated);
        ActivityLogService::created($exam);
        return redirect()->route('admin.exams')->with('success', 'Exam created successfully.');
    }

    // --- Fees ---
    public function fees(Request $request)
    {
        ActivityLogService::viewed('Viewed fees records');
        $query = Fee::with('student');
        if ($schoolId = $this->getSchoolId()) {
            $query->where('school_id', $schoolId);
        }
        if ($status = $request->input('status')) {
            $query->where('payment_status', $status);
        }
        if ($search = $request->input('search')) {
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('admission_number', 'like', "%{$search}%");
            });
        }
        $fees = $query->latest()->paginate(15)->withQueryString();
        $paidCountQuery = Fee::where('payment_status', 'paid');
        $pendingCountQuery = Fee::where('payment_status', 'pending');
        $overdueCountQuery = Fee::where('payment_status', 'overdue');
        $totalCollectedQuery = Fee::where('payment_status', 'paid');
        if ($schoolId = $this->getSchoolId()) {
            $paidCountQuery->where('school_id', $schoolId);
            $pendingCountQuery->where('school_id', $schoolId);
            $overdueCountQuery->where('school_id', $schoolId);
            $totalCollectedQuery->where('school_id', $schoolId);
        }
        $paidCount = $paidCountQuery->count();
        $pendingCount = $pendingCountQuery->count();
        $overdueCount = $overdueCountQuery->count();
        $totalCollected = $totalCollectedQuery->sum('amount');
        return view('admin.fees', compact('fees', 'paidCount', 'pendingCount', 'overdueCount', 'totalCollected'));
    }

    public function recordPayment()
    {
        $studentsQuery = Student::with('class');
        if ($schoolId = $this->getSchoolId()) {
            $studentsQuery->where('school_id', $schoolId);
        }
        $students = $studentsQuery->get();
        return view('admin.fees-create', compact('students'));
    }

    public function storePayment(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'fee_type' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'paid_date' => 'nullable|date',
            'payment_method' => 'nullable|string',
            'payment_status' => 'required|in:pending,paid,overdue',
            'transaction_id' => 'nullable|string|max:255',
            'remark' => 'nullable|string',
        ]);
        $fee = Fee::create($validated);
        ActivityLogService::created($fee, $validated);
        return redirect()->route('admin.fees')->with('success', 'Payment recorded successfully.');
    }

    public function editPayment(Fee $fee)
    {
        $studentsQuery = Student::with('class');
        if ($schoolId = $this->getSchoolId()) {
            $studentsQuery->where('school_id', $schoolId);
        }
        $students = $studentsQuery->get();
        return view('admin.fees-edit', compact('fee', 'students'));
    }

    public function updatePayment(Request $request, Fee $fee)
    {
        $oldValues = $fee->toArray();
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'fee_type' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'paid_date' => 'nullable|date',
            'payment_method' => 'nullable|string',
            'payment_status' => 'required|in:pending,paid,overdue',
            'transaction_id' => 'nullable|string|max:255',
            'remark' => 'nullable|string',
        ]);
        $fee->update($validated);
        ActivityLogService::log('updated', "Updated fee record for student #{$fee->student_id}", $fee, $oldValues, $fee->fresh()->toArray());
        return redirect()->route('admin.fees')->with('success', 'Payment updated successfully.');
    }

    public function destroyPayment(Fee $fee)
    {
        $feeName = $fee->fee_type . ' - RWF ' . number_format($fee->amount, 0);
        ActivityLogService::log('deleted', "Deleted fee record: {$feeName}", $fee, $fee->toArray());
        $fee->delete();
        return redirect()->route('admin.fees')->with('success', 'Payment deleted successfully.');
    }

    // --- Activity Log ---
    public function activityLog(Request $request)
    {
        $query = ActivityLog::with('user');
        if ($schoolId = $this->getSchoolId()) {
            $query->where('school_id', $schoolId);
        }

        if ($userId = $request->input('user_id')) {
            $query->where('user_id', $userId);
        }
        if ($action = $request->input('action')) {
            $query->where('action', $action);
        }
        if ($dateFrom = $request->input('date_from')) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo = $request->input('date_to')) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $logs = $query->latest()->paginate(20)->withQueryString();
        $usersQuery = User::orderBy('name');
        if ($schoolId = $this->getSchoolId()) {
            $usersQuery->where('school_id', $schoolId);
        }
        $users = $usersQuery->get();

        return view('admin.activity-log', compact('logs', 'users'));
    }
}
