<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Attendance;
use App\Models\Exam;
use App\Models\Result;
use App\Models\Fee;
use App\Models\Curriculum;
use App\Models\AcademicYear;
use App\Models\Term;
use App\Models\GradeLevel;
use App\Models\GradingScale;
use App\Models\ActivityLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $school = School::firstOrCreate(
            ['slug' => 'kigali-international-school'],
            [
                'name' => 'Kigali International School',
                'email' => 'info@kigali-school.com',
                'phone' => '+250 788 123 456',
                'address' => 'KG 7 Ave, Kigali, Rwanda',
                'is_active' => true,
            ]
        );
        $sid = $school->id;

        // ── Users ──
        $admin = User::firstOrCreate(['email' => 'admin@schoolms.com'], [
            'name' => 'Super Admin', 'password' => Hash::make('password'),
            'role' => 'super_admin', 'phone' => '+250788000000',
            'school_name' => 'SchoolMS HQ', 'email_verified_at' => now(), 'school_id' => $sid,
        ]);
        User::firstOrCreate(['email' => 'school@schoolms.com'], [
            'name' => 'School Admin', 'password' => Hash::make('password'),
            'role' => 'admin', 'phone' => '+250788000001',
            'school_name' => 'Kigali International School', 'email_verified_at' => now(), 'school_id' => $sid,
        ]);

        // ── Curriculums ──
        $curriculum = Curriculum::firstOrCreate(['code' => 'CBC'], [
            'school_id' => $sid, 'name' => 'Competency Based Curriculum',
            'description' => 'Rwanda National Curriculum', 'is_active' => true,
        ]);
        $ibCurriculum = Curriculum::firstOrCreate(['code' => 'IB'], [
            'school_id' => $sid, 'name' => 'International Baccalaureate',
            'description' => 'IB Diploma Programme', 'is_active' => true,
        ]);

        // ── Academic Year ──
        $ay = AcademicYear::firstOrCreate(['school_id' => $sid, 'name' => '2025-2026'], [
            'start_date' => '2025-09-01', 'end_date' => '2026-07-15',
            'is_current' => true, 'is_active' => true,
        ]);

        // ── Terms ──
        $t1 = Term::firstOrCreate(['academic_year_id' => $ay->id, 'name' => 'Term 1'], [
            'school_id' => $sid, 'start_date' => '2025-09-01', 'end_date' => '2025-12-20',
            'is_current' => false, 'is_active' => true,
        ]);
        $t2 = Term::firstOrCreate(['academic_year_id' => $ay->id, 'name' => 'Term 2'], [
            'school_id' => $sid, 'start_date' => '2026-01-06', 'end_date' => '2026-03-27',
            'is_current' => false, 'is_active' => true,
        ]);
        $t3 = Term::firstOrCreate(['academic_year_id' => $ay->id, 'name' => 'Term 3'], [
            'school_id' => $sid, 'start_date' => '2026-04-13', 'end_date' => '2026-07-15',
            'is_current' => true, 'is_active' => true,
        ]);

        // ── Grade Levels ──
        $gradeNames = ['P1','P2','P3','P4','P5','P6','S1','S2','S3','S4','S5','S6'];
        $gradeLevels = [];
        foreach ($gradeNames as $i => $g) {
            $gradeLevels[$g] = GradeLevel::firstOrCreate(['school_id' => $sid, 'curriculum_id' => $curriculum->id, 'name' => $g], [
                'sort_order' => $i + 1, 'is_active' => true,
            ]);
        }

        // ── Grading Scales ──
        $scales = [
            ['A', 80, 100, 'Excellent', 5],
            ['B', 70, 79, 'Very Good', 4],
            ['C', 60, 69, 'Good', 3],
            ['D', 50, 59, 'Fair', 2],
            ['E', 40, 49, 'Pass', 1],
            ['F', 0, 39, 'Fail', 0],
        ];
        foreach ($scales as [$letter, $min, $max, $desc, $pts]) {
            GradingScale::firstOrCreate(['school_id' => $sid, 'curriculum_id' => $curriculum->id, 'grade_letter' => $letter], [
                'min_percentage' => $min, 'max_percentage' => $max,
                'description' => $desc, 'grade_points' => $pts,
            ]);
        }

        // ── Subjects ──
        $subjectDefs = [
            ['Mathematics', 'MATH', 'Core mathematics'],
            ['English', 'ENG', 'English language and literature'],
            ['Kinyarwanda', 'KIN', 'Kinyarwanda language'],
            ['Science', 'SCI', 'General science'],
            ['Social Studies', 'SST', 'History, geography, civics'],
            ['ICT', 'ICT', 'Information and communication technology'],
            ['Physical Education', 'PE', 'Sports and fitness'],
            ['Arts', 'ART', 'Visual and performing arts'],
        ];
        $subjects = [];
        foreach ($subjectDefs as [$name, $code, $desc]) {
            $subjects[$code] = Subject::firstOrCreate(['code' => $code], [
                'subject_name' => $name, 'description' => $desc,
                'status' => true, 'school_id' => $sid,
            ]);
        }

        // ── Teachers ──
        $teacherData = [
            ['Jean-Paul', 'Habimana', 'male',   'MATH', 'PhD Mathematics',     '1985-03-15', '+250788100001'],
            ['Marie',     'Uwimana',  'female', 'ENG',  'MA English Literature','1990-07-22', '+250788100002'],
            ['Emmanuel',  'Ndayisaba','male',   'SCI',  'MSc Physics',          '1988-11-08', '+250788100003'],
            ['Claudine',  'Mukamana', 'female', 'KIN',  'BA Kinyarwanda',       '1992-04-30', '+250788100004'],
            ['David',     'Bizimana', 'male',   'SST',  'MA History',           '1987-09-12', '+250788100005'],
            ['Grace',     'Niyonsaba','female', 'ICT',  'BSc Computer Science', '1993-01-18', '+250788100006'],
            ['Patrick',   'Mugisha',  'male',   'PE',   'BSc Sports Science',   '1991-06-25', '+250788100007'],
            ['Ange',      'Iradukunda','female','ART',  'BA Fine Arts',         '1994-12-03', '+250788100008'],
        ];
        $teachers = [];
        foreach ($teacherData as [$fn, $ln, $gender, $subj, $qual, $dob, $phone]) {
            $user = User::firstOrCreate(['email' => strtolower($fn).'.'.strtolower($ln).'@schoolms.com'], [
                'name' => "$fn $ln", 'password' => Hash::make('password'),
                'role' => 'teacher', 'phone' => $phone,
                'email_verified_at' => now(), 'school_id' => $sid,
            ]);
            $teachers[$subj] = Teacher::firstOrCreate(['user_id' => $user->id], [
                'employee_id' => 'TCH-' . str_pad(array_search([$fn,$ln,$gender,$subj,$qual,$dob,$phone], $teacherData) + 1, 3, '0', STR_PAD_LEFT),
                'first_name' => $fn, 'last_name' => $ln, 'gender' => $gender,
                'subject' => $subjects[$subj]->subject_name ?? $subj,
                'phone' => $phone, 'qualification' => $qual,
                'date_of_birth' => $dob, 'status' => true, 'school_id' => $sid,
            ]);
        }

        // ── Classes ──
        $classDefs = [
            ['S1', 'A', 40, 'MATH'],
            ['S1', 'B', 40, 'ENG'],
            ['S2', 'A', 38, 'SCI'],
            ['S2', 'B', 35, 'KIN'],
            ['S3', 'A', 36, 'SST'],
            ['S4', 'A', 30, 'ICT'],
        ];
        $classes = [];
        foreach ($classDefs as [$name, $sec, $cap, $subjKey]) {
            $className = "$name Section $sec";
            $gl = $gradeLevels[$name] ?? null;
            $classes["$name$sec"] = SchoolClass::firstOrCreate(
                ['school_id' => $sid, 'class_name' => $className],
                [
                    'section' => $sec, 'capacity' => $cap,
                    'teacher_id' => $teachers[$subjKey]->id ?? null,
                    'status' => true, 'curriculum_id' => $curriculum->id,
                    'grade_level_id' => $gl?->id, 'academic_year_id' => $ay->id,
                ]
            );
        }

        // ── Subject-Teacher pivot ──
        foreach ($classes as $cls) {
            foreach ($subjects as $subj) {
                $teacherForSubject = $teachers[$subj->code] ?? $teachers[array_key_first($teachers)];
                if ($teacherForSubject) {
                    \Illuminate\Support\Facades\DB::table('subject_teacher')->firstOrCreate(
                        ['subject_id' => $subj->id, 'teacher_id' => $teacherForSubject->id, 'class_id' => $cls->id]
                    );
                }
            }
        }

        // ── Students ──
        $studentNames = [
            ['Aisha',     'Mukamunana', 'female', '1990-05-10', 'S1A'],
            ['Ben',       'Nshimiyimana','male',  '1991-08-14', 'S1A'],
            ['Chantal',   'Uwera',      'female', '1990-12-01', 'S1A'],
            ['Daniel',    'Hakizimana', 'male',   '1992-02-20', 'S1A'],
            ['Ella',      'Ingabire',   'female', '1991-06-15', 'S1A'],
            ['Fidele',    'Nsengimana', 'male',   '1990-10-05', 'S1B'],
            ['Gloria',    'Nyirahabimana','female','1991-03-22', 'S1B'],
            ['Hubert',    'Munyaneza',  'male',   '1992-07-18', 'S1B'],
            ['Isabelle',  'Kamikazi',   'female', '1990-09-30', 'S1B'],
            ['Jean',      'Bizumuremyi','male',   '1991-11-25', 'S2A'],
            ['Karen',     'Dusenge',    'female', '1992-04-12', 'S2A'],
            ['Lambert',   'Kayitesi',   'male',   '1990-01-08', 'S2A'],
            ['Melissa',   'Irakoze',    'female', '1991-08-28', 'S2A'],
            ['Noah',      'Sindambiwe', 'male',   '1992-05-16', 'S2B'],
            ['Olivia',    'Tumukunde',  'female', '1990-07-03', 'S2B'],
            ['Pierre',    'Gakumba',    'male',   '1991-12-19', 'S2B'],
            ['Queen',     'Nyampinga',  'female', '1992-09-11', 'S3A'],
            ['Robert',    'Mugabo',     'male',   '1990-04-27', 'S3A'],
            ['Sylvie',    'Manzi',      'female', '1991-02-14', 'S3A'],
            ['Thierry',   'Niyongabo',  'male',   '1992-06-09', 'S3A'],
            ['Uwimana',   'Annick',     'female', '1990-11-21', 'S4A'],
            ['Victor',    'Haguma',     'male',   '1991-05-06', 'S4A'],
            ['Winnie',    'Uwitonze',   'female', '1992-08-17', 'S4A'],
            ['Xavier',    'Nduwumwe',   'male',   '1990-03-29', 'S4A'],
        ];
        $students = [];
        $admCounter = 1;
        foreach ($studentNames as [$fn, $ln, $gender, $dob, $classKey]) {
            $user = User::firstOrCreate(['email' => strtolower($fn).'.'.$ln.'@student.schoolms.com'], [
                'name' => "$fn $ln", 'password' => Hash::make('password'),
                'role' => 'student', 'email_verified_at' => now(), 'school_id' => $sid,
            ]);
            $cls = $classes[$classKey] ?? null;
            $students["$fn$ln"] = Student::firstOrCreate(['user_id' => $user->id], [
                'admission_number' => 'ADM-' . str_pad($admCounter, 4, '0', STR_PAD_LEFT),
                'first_name' => $fn, 'last_name' => $ln,
                'gender' => $gender, 'date_of_birth' => $dob,
                'class_id' => $cls?->id, 'status' => true, 'school_id' => $sid,
            ]);
            $admCounter++;
        }

        // ── Attendance (last 5 school days) ──
        $allStudents = array_values($students);
        $today = Carbon::now();
        for ($d = 0; $d < 10; $d++) {
            $date = $today->copy()->subDays($d);
            if ($date->isWeekend()) continue;
            foreach ($allStudents as $s) {
                $cls = $s->class_id;
                $status = (rand(1, 10) > 2) ? 'present' : ((rand(1, 10) > 5) ? 'absent' : 'late');
                Attendance::firstOrCreate(
                    ['student_id' => $s->id, 'class_id' => $cls, 'date' => $date->toDateString()],
                    ['status' => $status, 'remark' => null, 'school_id' => $sid]
                );
            }
        }

        // ── Exams ──
        $examDefs = [
            ['Mid-Term Exam',   $t2->id, 'MATH', '2026-02-15', 100, 40],
            ['Mid-Term Exam',   $t2->id, 'ENG',  '2026-02-17', 100, 40],
            ['Mid-Term Exam',   $t2->id, 'SCI',  '2026-02-19', 100, 40],
            ['End-Term Exam',   $t3->id, 'MATH', '2026-06-10', 100, 40],
            ['End-Term Exam',   $t3->id, 'ENG',  '2026-06-12', 100, 40],
            ['End-Term Exam',   $t3->id, 'SCI',  '2026-06-14', 100, 40],
            ['End-Term Exam',   $t3->id, 'KIN',  '2026-06-16', 100, 40],
            ['End-Term Exam',   $t3->id, 'SST',  '2026-06-18', 100, 40],
        ];
        $exams = [];
        foreach ($examDefs as [$name, $termId, $subjKey, $date, $total, $pass]) {
            $cls = $classes['S1A'];
            $exams["$name-$subjKey-$termId"] = Exam::firstOrCreate(
                ['exam_name' => $name, 'class_id' => $cls->id, 'date' => $date],
                [
                    'subject_id' => $subjects[$subjKey]->id, 'term' => $termId,
                    'start_time' => '08:00', 'end_time' => '11:00',
                    'total_marks' => $total, 'passing_marks' => $pass,
                    'description' => "$name for $subjKey",
                    'status' => true, 'school_id' => $sid,
                ]
            );
        }

        // ── Results (S1A students) ──
        $s1aStudents = array_filter($allStudents, fn($s) => $s->class_id === ($classes['S1A']?->id));
        foreach ($exams as $exam) {
            foreach ($s1aStudents as $s) {
                $marks = rand(25, 98);
                $grade = match(true) {
                    $marks >= 80 => 'A', $marks >= 70 => 'B', $marks >= 60 => 'C',
                    $marks >= 50 => 'D', $marks >= 40 => 'E', default => 'F',
                };
                Result::firstOrCreate(
                    ['exam_id' => $exam->id, 'student_id' => $s->id],
                    [
                        'subject_id' => $exam->subject_id, 'marks_obtained' => $marks,
                        'grade' => $grade, 'remark' => null, 'status' => true,
                        'term' => $exam->term, 'school_id' => $sid,
                    ]
                );
            }
        }

        // ── Fees ──
        $feeTypes = ['Tuition', 'Registration', 'Laboratory', 'Library', 'Sports'];
        foreach ($allStudents as $s) {
            foreach ($feeTypes as $i => $ft) {
                $amount = match($ft) {
                    'Tuition' => 150000, 'Registration' => 25000,
                    'Laboratory' => 35000, 'Library' => 15000, 'Sports' => 10000,
                    default => 20000,
                };
                $paid = ($i < 3 && rand(1, 10) > 3);
                Fee::firstOrCreate(
                    ['student_id' => $s->id, 'fee_type' => $ft, 'due_date' => '2026-01-15'],
                    [
                        'amount' => $amount, 'paid_date' => $paid ? '2026-01-10' : null,
                        'payment_method' => $paid ? 'bank_transfer' : null,
                        'payment_status' => $paid ? 'paid' : 'pending',
                        'transaction_id' => $paid ? 'TXN-' . strtoupper(Str::random(8)) : null,
                        'school_id' => $sid,
                    ]
                );
            }
        }

        // ── Activity Logs ──
        $actions = ['logged_in', 'viewed_students', 'created_class', 'updated_teacher', 'exported_report'];
        for ($i = 0; $i < 20; $i++) {
            ActivityLog::create([
                'user_id' => $admin->id, 'action' => $actions[array_rand($actions)],
                'description' => 'System activity: ' . $actions[array_rand($actions)],
                'school_id' => $sid,
                'created_at' => Carbon::now()->subDays(rand(0, 30)),
            ]);
        }

        echo "\n=== SEED COMPLETE ===\n";
        echo "Users: " . User::count() . "\n";
        echo "Teachers: " . Teacher::count() . "\n";
        echo "Students: " . Student::count() . "\n";
        echo "Classes: " . SchoolClass::count() . "\n";
        echo "Subjects: " . Subject::count() . "\n";
        echo "Attendances: " . Attendance::count() . "\n";
        echo "Exams: " . Exam::count() . "\n";
        echo "Results: " . Result::count() . "\n";
        echo "Fees: " . Fee::count() . "\n";
    }
}
