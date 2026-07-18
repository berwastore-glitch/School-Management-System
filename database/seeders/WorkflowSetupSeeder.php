<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Exam;
use App\Models\Result;
use App\Models\Fee;
use App\Models\Attendance;
use App\Models\Curriculum;
use App\Models\AcademicYear;
use App\Models\Term;
use App\Models\GradeLevel;
use App\Models\GradingScale;
use Carbon\Carbon;

class WorkflowSetupSeeder extends Seeder
{
    public function run(): void
    {
        $schoolId = 1;
        $curriculum = Curriculum::where('school_id', $schoolId)->first();
        $year = AcademicYear::where('school_id', $schoolId)->first();
        $term = Term::where('school_id', $schoolId)->first();

        $this->command->info('=== Step 1: Creating Teachers ===');
        $teachers = [
            ['first_name' => 'James', 'last_name' => 'Mukasa', 'phone' => '0700111222', 'qualification' => 'M.Ed Mathematics', 'date_of_birth' => '1985-03-15', 'email' => 'james.mukasa@schoolms.com'],
            ['first_name' => 'Sarah', 'last_name' => 'Nambi', 'phone' => '0700222333', 'qualification' => 'B.Ed English', 'date_of_birth' => '1990-07-22', 'email' => 'sarah.nambi@schoolms.com'],
            ['first_name' => 'David', 'last_name' => 'Okello', 'phone' => '0700333444', 'qualification' => 'M.Sc Physics', 'date_of_birth' => '1988-11-10', 'email' => 'david.okello@schoolms.com'],
            ['first_name' => 'Grace', 'last_name' => 'Auma', 'phone' => '0700444555', 'qualification' => 'B.A History', 'date_of_birth' => '1992-05-30', 'email' => 'grace.auma@schoolms.com'],
            ['first_name' => 'Peter', 'last_name' => 'Ssemwanga', 'phone' => '0700555666', 'qualification' => 'B.Sc Biology', 'date_of_birth' => '1987-09-12', 'email' => 'peter.ssemwanga@schoolms.com'],
        ];

        $teacherIds = [];
        foreach ($teachers as $i => $t) {
            $user = User::create([
                'name' => $t['first_name'] . ' ' . $t['last_name'],
                'email' => $t['email'],
                'password' => Hash::make('password'),
                'role' => 'teacher',
                'school_id' => $schoolId,
            ]);
            $teacher = Teacher::create([
                'employee_id' => 'EMP-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'first_name' => $t['first_name'],
                'last_name' => $t['last_name'],
                'phone' => $t['phone'],
                'qualification' => $t['qualification'],
                'date_of_birth' => $t['date_of_birth'],
                'user_id' => $user->id,
                'status' => true,
                'school_id' => $schoolId,
            ]);
            $teacherIds[] = $teacher->id;
            $this->command->info("  Created: {$t['first_name']} {$t['last_name']} ({$t['email']})");
        }

        $this->command->info("\n=== Step 2: Creating Classes ===");
        $classData = [
            ['name' => 'Senior 1A', 'section' => 'A', 'capacity' => 40, 'teacher_index' => 0],
            ['name' => 'Senior 1B', 'section' => 'B', 'capacity' => 40, 'teacher_index' => 1],
            ['name' => 'Senior 2A', 'section' => 'A', 'capacity' => 35, 'teacher_index' => 2],
            ['name' => 'Senior 3A', 'section' => 'A', 'capacity' => 30, 'teacher_index' => 3],
        ];

        $classIds = [];
        foreach ($classData as $c) {
            $class = SchoolClass::create([
                'name' => $c['name'],
                'section' => $c['section'],
                'capacity' => $c['capacity'],
                'teacher_id' => $teacherIds[$c['teacher_index']],
                'status' => true,
                'school_id' => $schoolId,
            ]);
            $classIds[] = $class->id;
            $this->command->info("  Created: {$c['name']}");
        }

        $this->command->info("\n=== Step 3: Creating Subjects ===");
        $subjectData = [
            ['subject_name' => 'Mathematics', 'code' => 'MATH', 'description' => 'Core mathematics'],
            ['subject_name' => 'English Language', 'code' => 'ENG', 'description' => 'English language and literature'],
            ['subject_name' => 'Physics', 'code' => 'PHY', 'description' => 'General physics'],
            ['subject_name' => 'Biology', 'code' => 'BIO', 'description' => 'General biology'],
            ['subject_name' => 'History', 'code' => 'HIST', 'description' => 'World and local history'],
            ['subject_name' => 'Geography', 'code' => 'GEO', 'description' => 'Physical and human geography'],
        ];

        $subjectIds = [];
        foreach ($subjectData as $s) {
            $subject = Subject::create([
                'subject_name' => $s['subject_name'],
                'code' => $s['code'],
                'description' => $s['description'],
                'status' => true,
                'school_id' => $schoolId,
            ]);
            $subjectIds[] = $subject->id;
            $this->command->info("  Created: {$s['subject_name']}");
        }

        $this->command->info("\n=== Step 4: Creating Students ===");
        $studentData = [
            ['first_name' => 'Alice', 'last_name' => 'Nansubuga', 'gender' => 'Female', 'dob' => '2010-02-14', 'adm' => 'STU-2026-001', 'class' => 0],
            ['first_name' => 'Bob', 'last_name' => 'Tumwine', 'gender' => 'Male', 'dob' => '2009-08-21', 'adm' => 'STU-2026-002', 'class' => 0],
            ['first_name' => 'Cathy', 'last_name' => 'Nanteza', 'gender' => 'Female', 'dob' => '2010-01-05', 'adm' => 'STU-2026-003', 'class' => 0],
            ['first_name' => 'Daniel', 'last_name' => 'Ssemanda', 'gender' => 'Male', 'dob' => '2009-12-12', 'adm' => 'STU-2026-004', 'class' => 0],
            ['first_name' => 'Eva', 'last_name' => 'Atim', 'gender' => 'Female', 'dob' => '2010-06-30', 'adm' => 'STU-2026-005', 'class' => 1],
            ['first_name' => 'Frank', 'last_name' => 'Ochieng', 'gender' => 'Male', 'dob' => '2009-04-18', 'adm' => 'STU-2026-006', 'class' => 1],
            ['first_name' => 'Gloria', 'last_name' => 'Nalubega', 'gender' => 'Female', 'dob' => '2010-09-25', 'adm' => 'STU-2026-007', 'class' => 1],
            ['first_name' => 'Henry', 'last_name' => 'Kizza', 'gender' => 'Male', 'dob' => '2009-11-03', 'adm' => 'STU-2026-008', 'class' => 2],
            ['first_name' => 'Irene', 'last_name' => 'Nassimbwa', 'gender' => 'Female', 'dob' => '2010-03-17', 'adm' => 'STU-2026-009', 'class' => 2],
            ['first_name' => 'John', 'last_name' => 'Byaruhanga', 'gender' => 'Male', 'dob' => '2009-07-08', 'adm' => 'STU-2026-010', 'class' => 2],
            ['first_name' => 'Karen', 'last_name' => 'Akello', 'gender' => 'Female', 'dob' => '2010-10-20', 'adm' => 'STU-2026-011', 'class' => 3],
            ['first_name' => 'Luke', 'last_name' => 'Ssemakula', 'gender' => 'Male', 'dob' => '2009-05-14', 'adm' => 'STU-2026-012', 'class' => 3],
        ];

        $studentIds = [];
        foreach ($studentData as $s) {
            $user = User::create([
                'name' => $s['first_name'] . ' ' . $s['last_name'],
                'email' => strtolower($s['first_name']) . '.' . strtolower($s['last_name']) . '@student.schoolms.com',
                'password' => Hash::make('password'),
                'role' => 'student',
                'school_id' => $schoolId,
            ]);
            $student = Student::create([
                'admission_number' => $s['adm'],
                'first_name' => $s['first_name'],
                'last_name' => $s['last_name'],
                'gender' => $s['gender'],
                'date_of_birth' => $s['dob'],
                'class_id' => $classIds[$s['class']],
                'user_id' => $user->id,
                'status' => true,
                'school_id' => $schoolId,
            ]);
            $studentIds[] = $student->id;
            $this->command->info("  Created: {$s['first_name']} {$s['last_name']} ({$s['adm']})");
        }

        $this->command->info("\n=== Step 5: Creating Exams ===");
        $exams = [
            ['name' => 'CAT 1', 'date' => Carbon::now()->subMonths(2)->format('Y-m-d')],
            ['name' => 'Mid-Term', 'date' => Carbon::now()->subMonth()->format('Y-m-d')],
            ['name' => 'Final Exam', 'date' => Carbon::now()->format('Y-m-d')],
        ];

        foreach ($classIds as $cid) {
            foreach ($subjectIds as $sid) {
                foreach ($exams as $ex) {
                    Exam::create([
                        'exam_name' => $ex['name'],
                        'subject_id' => $sid,
                        'class_id' => $cid,
                        'total_marks' => 100,
                        'passing_marks' => 50,
                        'date' => $ex['date'],
                        'school_id' => $schoolId,
                    ]);
                }
            }
        }
        $this->command->info("  Created " . Exam::count() . " exams");

        $this->command->info("\n=== Step 6: Entering Results ===");
        foreach ($studentIds as $sid) {
            $student = Student::find($sid);
            $exams = Exam::where('class_id', $student->class_id)->get();
            foreach ($exams as $ex) {
                Result::create([
                    'exam_id' => $ex->id,
                    'student_id' => $sid,
                    'subject_id' => $ex->subject_id,
                    'term' => $term->name,
                    'marks_obtained' => rand(35, 98),
                    'school_id' => $schoolId,
                ]);
            }
        }
        $this->command->info("  Created " . Result::count() . " results");

        $this->command->info("\n=== Step 7: Creating Fee Records ===");
        $feeTypes = ['Tuition', 'Registration', 'Activities'];
        foreach ($studentIds as $sid) {
            Fee::create([
                'student_id' => $sid,
                'fee_type' => 'Tuition',
                'amount' => 500000,
                'payment_status' => array_rand(['paid' => 1, 'pending' => 1, 'partial' => 1]),
                'due_date' => Carbon::now()->addMonth()->format('Y-m-d'),
                'school_id' => $schoolId,
            ]);
        }
        $this->command->info("  Created " . Fee::count() . " fee records");

        $this->command->info("\n=== Step 8: Marking Attendance ===");
        $students = Student::whereIn('id', $studentIds)->get();
        foreach (range(0, 19) as $day) {
            $date = Carbon::now()->subDays($day);
            if ($date->isWeekend()) continue;
            foreach ($students as $s) {
                Attendance::create([
                    'student_id' => $s->id,
                    'class_id' => $s->class_id,
                    'date' => $date->format('Y-m-d'),
                    'status' => rand(0, 10) > 2 ? 'present' : 'absent',
                    'school_id' => $schoolId,
                ]);
            }
        }
        $this->command->info("  Created " . Attendance::count() . " attendance records");

        $this->command->info("\n=== DONE ===");
        $this->command->info("Teachers: " . Teacher::count());
        $this->command->info("Classes: " . SchoolClass::count());
        $this->command->info("Subjects: " . Subject::count());
        $this->command->info("Students: " . Student::count());
        $this->command->info("Exams: " . Exam::count());
        $this->command->info("Results: " . Result::count());
        $this->command->info("Fees: " . Fee::count());
        $this->command->info("Attendance: " . Attendance::count());
    }
}
