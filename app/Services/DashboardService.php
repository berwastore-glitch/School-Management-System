<?php

namespace App\Services;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\SchoolClass;
use App\Models\Fee;
use App\Models\Attendance;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public static function getTeacherStats($teacherId): array
    {
        $cacheKey = "teacher_dashboard_{$teacherId}";
        $ttl = 300; // 5 minutes

        return Cache::remember($cacheKey, $ttl, function () use ($teacherId) {
            $assignedClassIds = SchoolClass::where('teacher_id', $teacherId)
                ->pluck('id')
                ->toArray();

            $studentIds = Student::whereIn('class_id', $assignedClassIds)
                ->pluck('id')
                ->toArray();

            $feeQuery = Fee::whereIn('student_id', $studentIds);

            $totalStudents = count($studentIds);
            $totalClasses = count($assignedClassIds);
            $totalTeachers = Teacher::count();

            $paidAmount = (clone $feeQuery)->where('payment_status', 'paid')->sum('amount');

            $feeStats = [
                'paid' => (clone $feeQuery)->where('payment_status', 'paid')->count(),
                'pending' => (clone $feeQuery)->where('payment_status', 'pending')->count(),
                'overdue' => (clone $feeQuery)->where('payment_status', 'overdue')->count(),
            ];

            $monthExpr = DB::getDriverName() === 'pgsql'
                ? "EXTRACT(MONTH FROM created_at)"
                : "MONTH(created_at)";

            $monthlyFees = (clone $feeQuery)
                ->selectRaw("{$monthExpr} as month, SUM(amount) as total")
                ->where('payment_status', 'paid')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->pluck('total', 'month')
                ->toArray();

            $recentStudents = Student::whereIn('class_id', $assignedClassIds)
                ->with('class')
                ->latest()
                ->take(5)
                ->get();

            $recentActivity = ActivityLog::with('user')
                ->latest()
                ->take(10)
                ->get();

            return [
                'totalStudents' => $totalStudents,
                'totalTeachers' => $totalTeachers,
                'totalClasses' => $totalClasses,
                'totalFees' => $paidAmount,
                'recentStudents' => $recentStudents,
                'feeStats' => $feeStats,
                'monthlyFees' => $monthlyFees,
                'recentActivity' => $recentActivity,
            ];
        });
    }

    public static function getAdminStats(): array
    {
        $cacheKey = 'admin_dashboard_stats';
        $ttl = 300;

        return Cache::remember($cacheKey, $ttl, function () {
            $monthExpr = DB::getDriverName() === 'pgsql'
                ? "EXTRACT(MONTH FROM created_at)"
                : "MONTH(created_at)";

            $feeStats = [
                'paid' => Fee::where('payment_status', 'paid')->count(),
                'pending' => Fee::where('payment_status', 'pending')->count(),
                'overdue' => Fee::where('payment_status', 'overdue')->count(),
            ];

            $attendanceMonths = [];
            $attendancePcts = [];
            for ($i = 5; $i >= 0; $i--) {
                $month = now()->subMonths($i);
                $monthStart = $month->copy()->startOfMonth();
                $monthEnd = $month->copy()->endOfMonth();
                $total = Attendance::whereBetween('date', [$monthStart, $monthEnd])->count();
                $present = Attendance::whereBetween('date', [$monthStart, $monthEnd])->where('status', 'present')->count();
                $attendanceMonths[] = $month->format('M');
                $attendancePcts[] = $total > 0 ? round(($present / $total) * 100) : 0;
            }

            return [
                'totalStudents' => Student::count(),
                'totalTeachers' => Teacher::count(),
                'totalClasses' => SchoolClass::count(),
                'totalFees' => Fee::where('payment_status', 'paid')->sum('amount'),
                'paidFees' => $feeStats['paid'],
                'pendingFees' => $feeStats['pending'],
                'overdueFees' => $feeStats['overdue'],
                'feeStats' => $feeStats,
                'attendanceMonths' => $attendanceMonths,
                'attendancePcts' => $attendancePcts,
                'monthlyFees' => Fee::selectRaw("{$monthExpr} as month, SUM(amount) as total")
                    ->where('payment_status', 'paid')
                    ->whereYear('created_at', date('Y'))
                    ->groupBy('month')
                    ->pluck('total', 'month')
                    ->toArray(),
                'recentStudents' => Student::with('class')->latest()->take(5)->get(),
                'recentActivity' => ActivityLog::with('user')->latest()->take(10)->get(),
            ];
        });
    }

    public static function clearTeacherCache($teacherId): void
    {
        Cache::forget("teacher_dashboard_{$teacherId}");
    }

    public static function clearAdminCache(): void
    {
        Cache::forget('admin_dashboard_stats');
    }
}
