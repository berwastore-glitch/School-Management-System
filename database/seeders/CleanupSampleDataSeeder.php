<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Exam;
use App\Models\Result;
use App\Models\Fee;
use App\Models\Attendance;
use App\Models\School;

class CleanupSampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // Delete seeded students (keep only original ID 1)
        $seededStudents = Student::where('id', '!=', 1)->pluck('id')->toArray();
        $seededStudentUsers = Student::where('id', '!=', 1)->pluck('user_id')->filter()->toArray();

        // Delete seeded teachers (keep only original ID 1)
        $seededTeachers = Teacher::where('id', '!=', 1)->pluck('id')->toArray();
        $seededTeacherUsers = Teacher::where('id', '!=', 1)->pluck('user_id')->filter()->toArray();

        // Delete results, fees, attendance for seeded students
        Result::whereIn('student_id', $seededStudents)->delete();
        Fee::whereIn('student_id', $seededStudents)->delete();
        Attendance::whereIn('student_id', $seededStudents)->delete();

        // Delete seeded students
        Student::whereIn('id', $seededStudents)->delete();

        // Delete seeded teachers
        Teacher::whereIn('id', $seededTeachers)->delete();

        // Delete seeded exams (keep only original 8)
        Exam::where('id', '>', 8)->delete();

        // Delete remaining results/fees/attendance for original student
        Result::where('student_id', 1)->delete();
        Fee::where('student_id', 1)->delete();
        Attendance::where('student_id', 1)->delete();

        // Delete seeded users (students + teachers + school admin)
        $allUserIds = array_merge($seededStudentUsers, $seededTeacherUsers);
        // Also remove school@schoolms.com (school 2 admin if exists)
        $school2Admin = User::where('email', 'school@schoolms.com')->pluck('id')->toArray();
        $allUserIds = array_merge($allUserIds, $school2Admin);
        User::whereIn('id', $allUserIds)->delete();

        // Delete school 2
        School::where('id', '!=', 1)->delete();

        echo "After cleanup:" . PHP_EOL;
        echo "Students: " . Student::count() . PHP_EOL;
        echo "Teachers: " . Teacher::count() . PHP_EOL;
        echo "Exams: " . Exam::count() . PHP_EOL;
        echo "Results: " . Result::count() . PHP_EOL;
        echo "Fees: " . Fee::count() . PHP_EOL;
        echo "Attendance: " . Attendance::count() . PHP_EOL;
        echo "Schools: " . School::count() . PHP_EOL;
        echo "Users: " . User::count() . PHP_EOL;
    }
}
