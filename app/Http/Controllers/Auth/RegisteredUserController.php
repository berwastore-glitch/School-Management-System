<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\School;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        $schools = School::where('is_active', true)->get();
        return view('auth.register', compact('schools'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:student,teacher'],
            'school_id' => ['required', 'exists:schools,id'],
            'gender' => ['required', 'in:Male,Female'],
            'date_of_birth' => ['required', 'date', 'before:today'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'school_id' => $request->school_id,
            'email_verified_at' => now(),
        ]);

        if ($request->role === 'teacher') {
            $lastEmployee = Teacher::max('employee_id');
            $nextNumber = $lastEmployee ? intval(substr($lastEmployee, -4)) + 1 : 1;
            $nameParts = explode(' ', $request->name, 2);
            Teacher::create([
                'user_id' => $user->id,
                'first_name' => $nameParts[0] ?? $request->name,
                'last_name' => $nameParts[1] ?? '',
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'employee_id' => 'EMP-' . date('Y') . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT),
                'school_id' => $request->school_id,
                'status' => true,
            ]);
        } elseif ($request->role === 'student') {
            $lastAdmission = Student::max('admission_number');
            $nextNumber = $lastAdmission ? intval(substr($lastAdmission, -4)) + 1 : 1;
            $nameParts = explode(' ', $request->name, 2);
            Student::create([
                'user_id' => $user->id,
                'first_name' => $nameParts[0] ?? $request->name,
                'last_name' => $nameParts[1] ?? '',
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'admission_number' => 'ADM-' . date('Y') . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT),
                'school_id' => $request->school_id,
                'status' => true,
            ]);
        }

        event(new Registered($user));
        Auth::login($user);

        return match ($request->role) {
            'teacher' => redirect()->route('teacher.dashboard'),
            'student' => redirect()->route('student.dashboard'),
            default => redirect()->route('dashboard'),
        };
    }
}
