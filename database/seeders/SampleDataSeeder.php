<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Exam;
use App\Models\Result;
use App\Models\Fee;
use App\Models\Attendance;
use Carbon\Carbon;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        $schoolId = 1;

        $teacherData = [
            ['first_name' => 'James', 'last_name' => 'Mukasa', 'phone' => '0700111222', 'qualification' => 'Masters Education', 'date_of_birth' => '1985-03-15'],
            ['first_name' => 'Sarah', 'last_name' => 'Nambi', 'phone' => '0700222333', 'qualification' => 'B.Ed Mathematics', 'date_of_birth' => '1990-07-22'],
            ['first_name' => 'David', 'last_name' => 'Okello', 'phone' => '0700333444', 'qualification' => 'M.Sc Physics', 'date_of_birth' => '1988-11-10'],
            ['first_name' => 'Grace', 'last_name' => 'Auma', 'phone' => '0700444555', 'qualification' => 'B.A English', 'date_of_birth' => '1992-05-30'],
        ];

        $teacherIds = Teacher::pluck('id')->toArray();
        foreach ($teacherData as $t) {
            if (Teacher::where('first_name', $t['first_name'])->where('last_name', $t['last_name'])->exists()) continue;
            $email = strtolower($t['first_name']) . '@schoolms.com';
            $user = User::create([
                'name' => $t['first_name'] . ' ' . $t['last_name'],
                'email' => $email,
                'password' => bcrypt('password'),
                'role' => 'teacher',
                'school_id' => $schoolId,
            ]);
            $teacher = Teacher::create(array_merge($t, [
                'employee_id' => 'EMP-' . str_pad(Teacher::count() + 1, 4, '0', STR_PAD_LEFT),
                'user_id' => $user->id,
                'status' => true,
                'school_id' => $schoolId,
            ]));
            $teacherIds[] = $teacher->id;
        }

        $classIds = SchoolClass::where('school_id', $schoolId)->pluck('id')->toArray();
        if (empty($classIds)) {
            $classIds = [SchoolClass::first()->id];
        }

        $studentData = [
            ['first_name' => 'Alice', 'last_name' => 'Nansubuga', 'gender' => 'Female', 'date_of_birth' => '2010-02-14', 'admission_number' => 'ADM-2024-002', 'phone' => '0710111111'],
            ['first_name' => 'Bob', 'last_name' => 'Tumwine', 'gender' => 'Male', 'date_of_birth' => '2009-08-21', 'admission_number' => 'ADM-2024-003', 'phone' => '0710222222'],
            ['first_name' => 'Cathy', 'last_name' => 'Nanteza', 'gender' => 'Female', 'date_of_birth' => '2010-01-05', 'admission_number' => 'ADM-2024-004', 'phone' => '0710333333'],
            ['first_name' => 'Daniel', 'last_name' => 'Ssemanda', 'gender' => 'Male', 'date_of_birth' => '2009-12-12', 'admission_number' => 'ADM-2024-005', 'phone' => '0710444444'],
            ['first_name' => 'Eva', 'last_name' => 'Atim', 'gender' => 'Female', 'date_of_birth' => '2010-06-30', 'admission_number' => 'ADM-2024-006', 'phone' => '0710555555'],
            ['first_name' => 'Frank', 'last_name' => 'Ochieng', 'gender' => 'Male', 'date_of_birth' => '2009-04-18', 'admission_number' => 'ADM-2024-007', 'phone' => '0710666666'],
            ['first_name' => 'Gloria', 'last_name' => 'Nalubega', 'gender' => 'Female', 'date_of_birth' => '2010-09-25', 'admission_number' => 'ADM-2024-008', 'phone' => '0710777777'],
            ['first_name' => 'Henry', 'last_name' => 'Kizza', 'gender' => 'Male', 'date_of_birth' => '2009-11-03', 'admission_number' => 'ADM-2024-009', 'phone' => '0710888888'],
            ['first_name' => 'Irene', 'last_name' => 'Nassimbwa', 'gender' => 'Female', 'date_of_birth' => '2010-03-17', 'admission_number' => 'ADM-2024-010', 'phone' => '0710999999'],
            ['first_name' => 'John', 'last_name' => 'Byaruhanga', 'gender' => 'Male', 'date_of_birth' => '2009-07-08', 'admission_number' => 'ADM-2024-011', 'phone' => '0711000000'],
            ['first_name' => 'Karen', 'last_name' => 'Akello', 'gender' => 'Female', 'date_of_birth' => '2010-10-20', 'admission_number' => 'ADM-2024-012', 'phone' => '0711111111'],
            ['first_name' => 'Luke', 'last_name' => 'Ssemakula', 'gender' => 'Male', 'date_of_birth' => '2009-05-14', 'admission_number' => 'ADM-2024-013', 'phone' => '0711222222'],
        ];

        $studentIds = [];
        foreach ($studentData as $s) {
            if (Student::where('admission_number', $s['admission_number'])->exists()) {
                $studentIds[] = Student::where('admission_number', $s['admission_number'])->first()->id;
                continue;
            }
            $email = strtolower($s['first_name']) . '@student.com';
            $user = User::create([
                'name' => $s['first_name'] . ' ' . $s['last_name'],
                'email' => $email,
                'password' => bcrypt('password'),
                'role' => 'student',
                'school_id' => $schoolId,
            ]);
            $classId = $classIds[array_rand($classIds)];
            $student = Student::create(array_merge($s, [
                'user_id' => $user->id,
                'class_id' => $classId,
                'status' => true,
                'school_id' => $schoolId,
            ]));
            $studentIds[] = $student->id;
        }

        // Exams per class + subject
        $subjects = Subject::where('school_id', $schoolId)->get();
        $examDates = [
            Carbon::now()->subMonths(2)->format('Y-m-d'),
            Carbon::now()->subMonth()->format('Y-m-d'),
            Carbon::now()->format('Y-m-d'),
        ];
        $examNames = ['Mid-Term 1', 'End-Term 1', 'Mid-Term 2'];

        foreach ($classIds as $cid) {
            foreach ($subjects as $sub) {
                foreach ($examNames as $i => $ename) {
                    Exam::updateOrCreate(
                        ['exam_name' => $ename, 'subject_id' => $sub->id, 'class_id' => $cid],
                        ['total_marks' => 100, 'passing_marks' => 50, 'date' => $examDates[$i], 'school_id' => $schoolId]
                    );
                }
            }
        }

        // Results
        $terms = ['Term 1', 'Term 2', 'Term 3'];
        foreach ($studentIds as $sid) {
            $student = Student::find($sid);
            $exams = Exam::where('class_id', $student->class_id)->get();
            foreach ($exams as $ex) {
                $term = $terms[array_rand($terms)];
                Result::updateOrCreate(
                    ['exam_id' => $ex->id, 'student_id' => $sid, 'term' => $term],
                    ['marks_obtained' => rand(30, 98), 'school_id' => $schoolId]
                );
            }
        }

        // Fees
        $amounts = [500000, 300000, 200000];
        $statuses = ['paid', 'pending', 'partial'];
        foreach ($studentIds as $idx => $sid) {
            Fee::updateOrCreate(
                ['student_id' => $sid, 'fee_type' => 'Tuition'],
                ['amount' => $amounts[$idx % 3], 'payment_status' => $statuses[$idx % 3], 'due_date' => Carbon::now()->addMonth()->format('Y-m-d'), 'school_id' => $schoolId]
            );
        }

        // Attendance (15 weekdays)
        $students = Student::whereIn('id', $studentIds)->get();
        foreach (range(0, 20) as $day) {
            $date = Carbon::now()->subDays($day);
            if ($date->isWeekend()) continue;
            foreach ($students as $s) {
                Attendance::updateOrCreate(
                    ['student_id' => $s->id, 'date' => $date->format('Y-m-d')],
                    ['status' => rand(0, 10) > 2 ? 'present' : 'absent', 'class_id' => $s->class_id, 'school_id' => $schoolId]
                );
            }
        }

        echo "Done!\n";
        echo "Teachers: " . Teacher::count() . "\n";
        echo "Students: " . Student::count() . "\n";
        echo "Exams: " . Exam::count() . "\n";
        echo "Results: " . Result::count() . "\n";
        echo "Fees: " . Fee::count() . "\n";
        echo "Attendance: " . Attendance::count() . "\n";
    }
}
