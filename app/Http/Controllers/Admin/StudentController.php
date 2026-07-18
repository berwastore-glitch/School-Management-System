<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Models\SchoolClass;
use App\Services\ActivityLogService;
use App\Traits\NeedsSchool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    use NeedsSchool;
    public function index() { return redirect()->route('admin.students'); }

    public function create()
    {
        $classesQuery = SchoolClass::where('status', true);
        if ($schoolId = $this->getSchoolId()) {
            $classesQuery->where('school_id', $schoolId);
        }
        $classes = $classesQuery->get();
        return view('admin.students-create', compact('classes'));
    }

    public function store(Request $request)
    {
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

        $user = User::create([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'student',
        ]);

        $admissionNumber = 'STU-' . str_pad(Student::max('id') + 1, 5, '0', STR_PAD_LEFT);

        $student = Student::create([
            'user_id' => $user->id,
            'admission_number' => $admissionNumber,
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'gender' => $validated['gender'],
            'date_of_birth' => $validated['date_of_birth'],
            'class_id' => $validated['class_id'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
        ]);

        ActivityLogService::created($student, array_merge($validated, ['admission_number' => $admissionNumber]));
        return redirect()->route('admin.students')->with('success', 'Student added successfully.');
    }

    public function edit(Student $student)
    {
        $classesQuery = SchoolClass::where('status', true);
        if ($schoolId = $this->getSchoolId()) {
            $classesQuery->where('school_id', $schoolId);
        }
        $classes = $classesQuery->get();
        return view('admin.students-edit', compact('student', 'classes'));
    }

    public function update(Request $request, Student $student)
    {
        $oldValues = $student->toArray();
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'class_id' => 'nullable|exists:classes,id',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $student->update($validated);
        $student->user->update([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
        ]);

        ActivityLogService::updated($student, $oldValues, $student->fresh()->toArray());
        return redirect()->route('admin.students.show', $student)->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        ActivityLogService::deleted($student);
        $student->delete();
        return redirect()->route('admin.students')->with('success', 'Student deleted successfully.');
    }
}
