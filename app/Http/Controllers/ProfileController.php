<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $isTeacher = $user->role === 'teacher';
        $isStudent = $user->role === 'student';

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        if ($isTeacher) {
            $rules['first_name'] = 'nullable|string|max:255';
            $rules['last_name'] = 'nullable|string|max:255';
            $rules['gender'] = 'nullable|in:Male,Female';
            $rules['phone'] = 'nullable|string|max:20';
            $rules['subject'] = 'nullable|string|max:255';
            $rules['qualification'] = 'nullable|string|max:255';
            $rules['date_of_birth'] = 'nullable|date';
            $rules['address'] = 'nullable|string|max:500';
        } elseif ($isStudent) {
            $rules['gender'] = 'nullable|in:Male,Female';
            $rules['date_of_birth'] = 'nullable|date';
            $rules['phone'] = 'nullable|string|max:20';
        }

        $validated = $request->validate($rules);

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                $oldPath = str_replace('storage/', '', $user->profile_picture);
                Storage::disk('public')->delete($oldPath);
            }
            $validated['profile_picture'] = $request->file('profile_picture')->store('profile-pictures', 'public');
        } else {
            unset($validated['profile_picture']);
        }

        $user->update(collect($validated)->only(['name', 'email', 'profile_picture'])->toArray());

        if ($isTeacher && $user->teacher) {
            $fields = ['first_name', 'last_name', 'gender', 'phone', 'subject', 'qualification', 'date_of_birth', 'address'];
            $teacherData = collect($validated)->only($fields)->filter()->toArray();

            if (!empty($teacherData)) {
                $user->teacher->update($teacherData);
            }

            if (isset($validated['first_name']) || isset($validated['last_name'])) {
                $first = $validated['first_name'] ?? $user->teacher->first_name;
                $last = $validated['last_name'] ?? $user->teacher->last_name;
                $user->update(['name' => trim($first . ' ' . $last)]);
            }
        }

        if ($isStudent && $user->student) {
            $studentData = collect($validated)->only(['gender', 'date_of_birth', 'phone'])->filter()->toArray();
            if (!empty($studentData)) {
                $user->student->update($studentData);
            }
        }

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The provided password does not match your current password.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.edit')->with('success', 'Password updated successfully.');
    }
}
