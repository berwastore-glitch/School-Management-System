<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use App\Services\ActivityLogService;
use App\Traits\NeedsSchool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    use NeedsSchool;
    public function index() { return redirect()->route('admin.teachers'); }

    public function create()
    {
        return view('admin.teachers-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'subject' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'qualification' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'teacher',
        ]);

        $empId = 'TCH-' . str_pad(Teacher::max('id') + 1, 4, '0', STR_PAD_LEFT);

        $teacher = Teacher::create([
            'user_id' => $user->id,
            'employee_id' => $empId,
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'subject' => $validated['subject'],
            'phone' => $validated['phone'],
            'qualification' => $validated['qualification'],
            'date_of_birth' => $validated['date_of_birth'],
            'address' => $validated['address'],
        ]);

        ActivityLogService::created($teacher, array_merge($validated, ['employee_id' => $empId]));
        return redirect()->route('admin.teachers')->with('success', 'Teacher added successfully.');
    }

    public function edit(Teacher $teacher)
    {
        return view('admin.teachers-edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $oldValues = $teacher->toArray();
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'subject' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'qualification' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $teacher->update($validated);
        $teacher->user->update([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
        ]);

        ActivityLogService::updated($teacher, $oldValues, $teacher->fresh()->toArray());
        return redirect()->route('admin.teachers.show', $teacher)->with('success', 'Teacher updated successfully.');
    }

    public function destroy(Teacher $teacher)
    {
        ActivityLogService::deleted($teacher);
        $teacher->delete();
        return redirect()->route('admin.teachers')->with('success', 'Teacher deleted successfully.');
    }
}
