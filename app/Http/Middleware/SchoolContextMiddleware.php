<?php

namespace App\Http\Middleware;

use App\Models\School;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SchoolContextMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $schoolId = Session::get('school_id');

        if ($schoolId) {
            $school = School::find($schoolId);
            if ($school && $school->is_active) {
                view()->share('currentSchool', $school);
                config(['app.current_school_id' => $schoolId]);
            } else {
                Session::forget('school_id');
                return redirect()->route('school.select');
            }
        }

        return $next($request);
    }
}
