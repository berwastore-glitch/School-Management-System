<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Result;
use App\Models\Attendance;
use App\Models\Fee;
use App\Models\Exam;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private function getStudent()
    {
        return auth()->user()->student;
    }

    public function dashboard()
    {
        $student = $this->getStudent();
        if (!$student) {
            return view('student.no-record');
        }

        $totalResults = Result::where('student_id', $student->id)->count();
        $attendanceCount = Attendance::where('student_id', $student->id)->count();
        $presentCount = Attendance::where('student_id', $student->id)->where('status', 'present')->count();
        $attendancePct = $attendanceCount > 0 ? round(($presentCount / $attendanceCount) * 100, 1) : 0;

        $totalFees = Fee::where('student_id', $student->id)->sum('amount');
        $paidFees = Fee::where('student_id', $student->id)->where('payment_status', 'paid')->sum('amount');
        $pendingFees = Fee::where('student_id', $student->id)->where('payment_status', 'pending')->sum('amount');

        $recentResults = Result::where('student_id', $student->id)
            ->with(['exam', 'subject'])
            ->latest()
            ->take(5)
            ->get();

        $recentAttendance = Attendance::where('student_id', $student->id)
            ->latest('date')
            ->take(5)
            ->get();

        $upcomingExams = Exam::where('class_id', $student->class_id)
            ->where('date', '>=', now())
            ->where('status', 'active')
            ->orderBy('date')
            ->take(3)
            ->get();

        return view('student.dashboard', compact(
            'student', 'totalResults', 'attendancePct', 'attendanceCount',
            'totalFees', 'paidFees', 'pendingFees',
            'recentResults', 'recentAttendance', 'upcomingExams'
        ));
    }

    public function classInfo()
    {
        $student = $this->getStudent();
        if (!$student) {
            return view('student.no-record');
        }

        $class = $student->class;
        $teacher = $class ? $class->teacher : null;
        $classmates = $student->class_id
            ? Student::where('class_id', $student->class_id)->where('id', '!=', $student->id)->with('user')->get()
            : collect();

        $subjects = ($teacher) ? $teacher->subjects : collect();

        return view('student.class', compact('student', 'class', 'teacher', 'classmates', 'subjects'));
    }

    public function results()
    {
        $student = $this->getStudent();
        if (!$student) {
            return view('student.no-record');
        }

        $results = Result::where('student_id', $student->id)
            ->with(['exam', 'subject'])
            ->latest()
            ->get();

        $grouped = $results->groupBy('exam.exam_name');

        return view('student.results', compact('student', 'results', 'grouped'));
    }

    public function attendance()
    {
        $student = $this->getStudent();
        if (!$student) {
            return view('student.no-record');
        }

        $attendances = Attendance::where('student_id', $student->id)
            ->orderByDesc('date')
            ->paginate(30);

        $totalCount = Attendance::where('student_id', $student->id)->count();
        $presentCount = Attendance::where('student_id', $student->id)->where('status', 'present')->count();
        $absentCount = Attendance::where('student_id', $student->id)->where('status', 'absent')->count();
        $lateCount = Attendance::where('student_id', $student->id)->where('status', 'late')->count();

        return view('student.attendance', compact(
            'student', 'attendances', 'totalCount', 'presentCount', 'absentCount', 'lateCount'
        ));
    }

    public function exams()
    {
        $student = $this->getStudent();
        if (!$student) {
            return view('student.no-record');
        }

        $exams = Exam::where('class_id', $student->class_id)
            ->with('subject')
            ->orderByDesc('date')
            ->get();

        return view('student.exams', compact('student', 'exams'));
    }

    public function fees()
    {
        $student = $this->getStudent();
        if (!$student) {
            return view('student.no-record');
        }

        $fees = Fee::where('student_id', $student->id)
            ->orderByDesc('due_date')
            ->get();

        $totalAmount = $fees->sum('amount');
        $paidAmount = $fees->where('payment_status', 'paid')->sum('amount');
        $pendingAmount = $fees->where('payment_status', 'pending')->sum('amount');
        $overdueAmount = $fees->where('payment_status', 'overdue')->sum('amount');

        return view('student.fees', compact(
            'student', 'fees', 'totalAmount', 'paidAmount', 'pendingAmount', 'overdueAmount'
        ));
    }
}
