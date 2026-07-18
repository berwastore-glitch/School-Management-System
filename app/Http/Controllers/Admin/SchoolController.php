<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SchoolController extends Controller
{
    public function index(Request $request)
    {
        $query = School::query();
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        $schools = $query->latest()->paginate(15)->withQueryString();
        return view('admin.schools', compact('schools'));
    }

    public function create()
    {
        return view('admin.schools-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'domain' => 'nullable|string|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $school = School::create($validated);
        ActivityLogService::created($school, $validated);
        return redirect()->route('admin.schools')->with('success', 'School created successfully.');
    }

    public function show(School $school)
    {
        $school->loadCount(['students', 'teachers', 'classes']);
        ActivityLogService::viewed("Viewed school: {$school->name}");
        return view('admin.schools-show', compact('school'));
    }

    public function edit(School $school)
    {
        return view('admin.schools-edit', compact('school'));
    }

    public function update(Request $request, School $school)
    {
        $oldValues = $school->toArray();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'domain' => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $school->update($validated);
        ActivityLogService::log('updated', "Updated school: {$school->name}", $school, $oldValues, $school->fresh()->toArray());
        return redirect()->route('admin.schools')->with('success', 'School updated successfully.');
    }

    public function destroy(School $school)
    {
        $name = $school->name;
        ActivityLogService::log('deleted', "Deleted school: {$name}", $school, $school->toArray());
        $school->delete();
        return redirect()->route('admin.schools')->with('success', 'School deleted successfully.');
    }

    public function select(School $school)
    {
        session(['school_id' => $school->id]);
        return redirect()->route('admin.dashboard')->with('success', "Switched to {$school->name}");
    }
}
