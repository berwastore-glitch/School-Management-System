<?php

namespace Database\Seeders;

use App\Models\{School, User, Teacher, Student, SchoolClass, Subject, Attendance, Exam, Result, Fee, Curriculum, AcademicYear, Term, GradeLevel, GradingScale, ActivityLog};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{Hash, DB};
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    private function log($msg): void
    {
        if ($this->command) {
            $this->command->info($msg);
        } else {
            print "$msg\n";
        }
    }

    public function run(): void
    {
        // School
        $school = School::firstOrCreate(
            ['slug' => 'kigali-international-school'],
            ['name' => 'Kigali International School', 'email' => 'info@kigali-school.com', 'phone' => '+250 788 123 456', 'address' => 'KG 7 Ave, Kigali, Rwanda', 'is_active' => true]
        );
        $sid = $school->id;
        $this->log("OK: School #{$sid}");

        // Users
        $admin = User::firstOrCreate(['email' => 'admin@schoolms.com'], [
            'name' => 'Super Admin', 'password' => Hash::make('password'), 'role' => 'super_admin', 'phone' => '+250788000000', 'school_name' => 'SchoolMS HQ', 'email_verified_at' => now(), 'school_id' => $sid,
        ]);
        User::firstOrCreate(['email' => 'school@schoolms.com'], [
            'name' => 'School Admin', 'password' => Hash::make('password'), 'role' => 'admin', 'phone' => '+250788000001', 'school_name' => 'Kigali International School', 'email_verified_at' => now(), 'school_id' => $sid,
        ]);
        $this->log("OK: Users (" . User::count() . ")");

        // Curriculum
        $curriculum = Curriculum::firstOrCreate(['code' => 'CBC'], [
            'school_id' => $sid, 'name' => 'Competency Based Curriculum', 'description' => 'Rwanda National Curriculum', 'is_active' => true,
        ]);
        $this->log("OK: Curriculum");

        // Academic Year
        $ay = AcademicYear::firstOrCreate(['school_id' => $sid, 'name' => '2025-2026'], [
            'start_date' => '2025-09-01', 'end_date' => '2026-07-15', 'is_current' => true, 'is_active' => true,
        ]);
        $this->log("OK: Academic Year");

        // Terms
        $t3 = Term::firstOrCreate(['academic_year_id' => $ay->id, 'name' => 'Term 3'], [
            'school_id' => $sid, 'start_date' => '2026-04-13', 'end_date' => '2026-07-15', 'is_current' => true, 'is_active' => true,
        ]);
        $this->log("OK: Terms");

        // Grade Levels
        $glS1 = GradeLevel::firstOrCreate(['school_id' => $sid, 'curriculum_id' => $curriculum->id, 'name' => 'S1'], ['sort_order' => 7, 'is_active' => true]);
        $glS2 = GradeLevel::firstOrCreate(['school_id' => $sid, 'curriculum_id' => $curriculum->id, 'name' => 'S2'], ['sort_order' => 8, 'is_active' => true]);
        $glS3 = GradeLevel::firstOrCreate(['school_id' => $sid, 'curriculum_id' => $curriculum->id, 'name' => 'S3'], ['sort_order' => 9, 'is_active' => true]);
        $glS4 = GradeLevel::firstOrCreate(['school_id' => $sid, 'curriculum_id' => $curriculum->id, 'name' => 'S4'], ['sort_order' => 10, 'is_active' => true]);
        $this->log("OK: Grade Levels");

        // Grading Scales
        foreach ([['A',80,100,'Excellent',5],['B',70,79,'Very Good',4],['C',60,69,'Good',3],['D',50,59,'Fair',2],['E',40,49,'Pass',1],['F',0,39,'Fail',0]] as $scale) {
            GradingScale::firstOrCreate(['school_id' => $sid, 'curriculum_id' => $curriculum->id, 'grade_letter' => $scale[0]], [
                'min_percentage' => $scale[1], 'max_percentage' => $scale[2], 'description' => $scale[3], 'grade_points' => $scale[4],
            ]);
        }
        $this->log("OK: Grading Scales");

        // Subjects
        $subjDefs = [['Mathematics','MATH'],['English','ENG'],['Kinyarwanda','KIN'],['Science','SCI'],['Social Studies','SST'],['ICT','ICT'],['Physical Education','PE'],['Arts','ART']];
        $subjects = [];
        foreach ($subjDefs as $sd) {
            $subjects[$sd[1]] = Subject::firstOrCreate(['code' => $sd[1]], ['subject_name' => $sd[0], 'description' => 'Core ' . $sd[0], 'status' => true, 'school_id' => $sid]);
        }
        $this->log("OK: Subjects (" . Subject::count() . ")");

        // Teachers
        $tData = [
            ['Jean-Paul','Habimana','male','MATH','PhD Mathematics','1985-03-15','+250788100001'],
            ['Marie','Uwimana','female','ENG','MA English Lit','1990-07-22','+250788100002'],
            ['Emmanuel','Ndayisaba','male','SCI','MSc Physics','1988-11-08','+250788100003'],
            ['Claudine','Mukamana','female','KIN','BA Kinyarwanda','1992-04-30','+250788100004'],
            ['David','Bizimana','male','SST','MA History','1987-09-12','+250788100005'],
            ['Grace','Niyonsaba','female','ICT','BSc CS','1993-01-18','+250788100006'],
            ['Patrick','Mugisha','male','PE','BSc Sports','1991-06-25','+250788100007'],
            ['Ange','Iradukunda','female','ART','BA Fine Arts','1994-12-03','+250788100008'],
        ];
        $teachers = [];
        foreach ($tData as $i => $td) {
            $fn = $td[0]; $ln = $td[1]; $g = $td[2]; $sk = $td[3]; $q = $td[4]; $dob = $td[5]; $ph = $td[6];
            $email = strtolower($fn) . '.' . strtolower($ln) . '@schoolms.com';
            $u = User::firstOrCreate(['email' => $email], [
                'name' => "$fn $ln", 'password' => Hash::make('password'), 'role' => 'teacher', 'phone' => $ph, 'email_verified_at' => now(), 'school_id' => $sid,
            ]);
            // Check if teacher already exists for this user
            $existing = Teacher::where('user_id', $u->id)->first();
            if ($existing) {
                $teachers[$sk] = $existing;
            } else {
                $empId = 'TCH-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT);
                // Check if employee_id already taken
                if (Teacher::where('employee_id', $empId)->exists()) {
                    $empId = 'TCH-' . str_pad(100 + $i, 3, '0', STR_PAD_LEFT);
                }
                $teachers[$sk] = Teacher::create([
                    'user_id' => $u->id, 'employee_id' => $empId, 'first_name' => $fn, 'last_name' => $ln,
                    'gender' => $g, 'subject' => $subjects[$sk]->subject_name, 'phone' => $ph,
                    'qualification' => $q, 'date_of_birth' => $dob, 'status' => true, 'school_id' => $sid,
                ]);
            }
        }
        $this->log("OK: Teachers (" . Teacher::count() . ")");

        // Classes
        $clsDefs = [
            ['S1', 'A', 40, 'MATH', $glS1],
            ['S1', 'B', 40, 'ENG', $glS1],
            ['S2', 'A', 38, 'SCI', $glS2],
            ['S2', 'B', 35, 'KIN', $glS2],
            ['S3', 'A', 36, 'SST', $glS3],
            ['S4', 'A', 30, 'ICT', $glS4],
        ];
        $classes = [];
        foreach ($clsDefs as $cd) {
            $n = $cd[0]; $s = $cd[1]; $cap = $cd[2]; $sk = $cd[3]; $gl = $cd[4];
            $cn = "$n Section $s";
            $classes["$n$s"] = SchoolClass::firstOrCreate(['school_id' => $sid, 'class_name' => $cn], [
                'section' => $s, 'capacity' => $cap, 'teacher_id' => $teachers[$sk]->id, 'status' => true,
                'curriculum_id' => $curriculum->id, 'grade_level_id' => $gl->id, 'academic_year_id' => $ay->id,
            ]);
        }
        $this->log("OK: Classes (" . SchoolClass::count() . ")");

        // Subject-Teacher pivot
        foreach ($classes as $cls) {
            foreach ($subjects as $subj) {
                $t = $teachers[$subj->code] ?? null;
                if ($t) {
                    DB::table('subject_teacher')->insertOrIgnore([
                        'subject_id' => $subj->id, 'teacher_id' => $t->id, 'class_id' => $cls->id,
                        'created_at' => now(), 'updated_at' => now(),
                    ]);
                }
            }
        }
        $this->log("OK: Subject-Teacher pivots");

        // Students
        $sData = [
            ['Aisha','Mukamunana','female','2008-05-10','S1A'],
            ['Ben','Nshimiyimana','male','2008-08-14','S1A'],
            ['Chantal','Uwera','female','2008-12-01','S1A'],
            ['Daniel','Hakizimana','male','2008-02-20','S1A'],
            ['Ella','Ingabire','female','2008-06-15','S1A'],
            ['Fidele','Nsengimana','male','2008-10-05','S1B'],
            ['Gloria','Nyirahabimana','female','2008-03-22','S1B'],
            ['Hubert','Munyaneza','male','2008-07-18','S1B'],
            ['Isabelle','Kamikazi','female','2008-09-30','S1B'],
            ['Jean','Bizumuremyi','male','2009-11-25','S2A'],
            ['Karen','Dusenge','female','2009-04-12','S2A'],
            ['Lambert','Kayitesi','male','2009-01-08','S2A'],
            ['Melissa','Irakoze','female','2009-08-28','S2A'],
            ['Noah','Sindambiwe','male','2009-05-16','S2B'],
            ['Olivia','Tumukunde','female','2009-07-03','S2B'],
            ['Pierre','Gakumba','male','2009-12-19','S2B'],
            ['Queen','Nyampinga','female','2010-09-11','S3A'],
            ['Robert','Mugabo','male','2010-04-27','S3A'],
            ['Sylvie','Manzi','female','2010-02-14','S3A'],
            ['Thierry','Niyongabo','male','2010-06-09','S3A'],
            ['Uwimana','Annick','female','2010-11-21','S4A'],
            ['Victor','Haguma','male','2010-05-06','S4A'],
            ['Winnie','Uwitonze','female','2010-08-17','S4A'],
            ['Xavier','Nduwumwe','male','2010-03-29','S4A'],
        ];
        $students = [];
        $adm = 1;
        foreach ($sData as $sd) {
            $fn = $sd[0]; $ln = $sd[1]; $g = $sd[2]; $dob = $sd[3]; $ck = $sd[4];
            $email = strtolower($fn) . '.' . strtolower($ln) . '@student.schoolms.com';
            $u = User::firstOrCreate(['email' => $email], [
                'name' => "$fn $ln", 'password' => Hash::make('password'), 'role' => 'student', 'email_verified_at' => now(), 'school_id' => $sid,
            ]);
            $cls = $classes[$ck] ?? null;
            $existing = Student::where('user_id', $u->id)->first();
            if ($existing) {
                $students["$fn$ln"] = $existing;
            } else {
                $admNum = 'ADM-' . str_pad($adm, 4, '0', STR_PAD_LEFT);
                if (Student::where('admission_number', $admNum)->exists()) {
                    $admNum = 'ADM-' . str_pad(1000 + $adm, 4, '0', STR_PAD_LEFT);
                }
                $students["$fn$ln"] = Student::create([
                    'user_id' => $u->id, 'admission_number' => $admNum, 'first_name' => $fn, 'last_name' => $ln,
                    'gender' => $g, 'date_of_birth' => $dob, 'class_id' => $cls ? $cls->id : null,
                    'status' => true, 'school_id' => $sid,
                ]);
            }
            $adm++;
        }
        $this->log("OK: Students (" . Student::count() . ")");

        // Attendance
        $allStudents = array_values($students);
        $today = Carbon::now();
        for ($d = 0; $d < 15; $d++) {
            $date = $today->copy()->subDays($d);
            if ($date->isWeekend()) continue;
            foreach ($allStudents as $s) {
                if (!$s->class_id) continue;
                $st = (rand(1, 10) > 2) ? 'present' : ((rand(1, 10) > 5) ? 'absent' : 'late');
                Attendance::firstOrCreate(
                    ['student_id' => $s->id, 'class_id' => $s->class_id, 'date' => $date->toDateString()],
                    ['status' => $st, 'remark' => null, 'school_id' => $sid]
                );
            }
        }
        $this->log("OK: Attendance (" . Attendance::count() . " records)");

        // Exams
        $examDefs = [
            ['Mid-Term Exam', 'MATH', '2026-02-15'],
            ['Mid-Term Exam', 'ENG', '2026-02-17'],
            ['Mid-Term Exam', 'SCI', '2026-02-19'],
            ['End-Term Exam', 'MATH', '2026-06-10'],
            ['End-Term Exam', 'ENG', '2026-06-12'],
            ['End-Term Exam', 'SCI', '2026-06-14'],
            ['End-Term Exam', 'KIN', '2026-06-16'],
            ['End-Term Exam', 'SST', '2026-06-18'],
        ];
        foreach ($examDefs as $ed) {
            $n = $ed[0]; $sk = $ed[1]; $dt = $ed[2];
            Exam::firstOrCreate(['exam_name' => $n, 'class_id' => $classes['S1A']->id, 'date' => $dt], [
                'subject_id' => $subjects[$sk]->id, 'term' => $t3->id, 'start_time' => '08:00', 'end_time' => '11:00',
                'total_marks' => 100, 'passing_marks' => 40, 'description' => "$n $sk", 'status' => true, 'school_id' => $sid,
            ]);
        }
        $this->log("OK: Exams (" . Exam::count() . ")");

        // Results
        $s1a = [];
        foreach ($allStudents as $s) {
            if ($s->class_id == ($classes['S1A'] ? $classes['S1A']->id : 0)) {
                $s1a[] = $s;
            }
        }
        foreach (Exam::where('class_id', $classes['S1A']->id)->get() as $ex) {
            foreach ($s1a as $s) {
                $mk = rand(25, 98);
                if ($mk >= 80) { $gr = 'A'; }
                elseif ($mk >= 70) { $gr = 'B'; }
                elseif ($mk >= 60) { $gr = 'C'; }
                elseif ($mk >= 50) { $gr = 'D'; }
                elseif ($mk >= 40) { $gr = 'E'; }
                else { $gr = 'F'; }
                Result::firstOrCreate(['exam_id' => $ex->id, 'student_id' => $s->id], [
                    'subject_id' => $ex->subject_id, 'marks_obtained' => $mk, 'grade' => $gr,
                    'status' => true, 'term' => $ex->term, 'school_id' => $sid,
                ]);
            }
        }
        $this->log("OK: Results (" . Result::count() . ")");

        // Fees
        $feeTypes = ['Tuition' => 150000, 'Registration' => 25000, 'Laboratory' => 35000, 'Library' => 15000, 'Sports' => 10000];
        foreach ($allStudents as $s) {
            foreach ($feeTypes as $ft => $amt) {
                $paid = (rand(1, 10) > 3);
                Fee::firstOrCreate(['student_id' => $s->id, 'fee_type' => $ft, 'due_date' => '2026-01-15'], [
                    'amount' => $amt, 'paid_date' => $paid ? '2026-01-10' : null,
                    'payment_method' => $paid ? 'bank_transfer' : null,
                    'payment_status' => $paid ? 'paid' : 'pending',
                    'transaction_id' => $paid ? 'TXN-' . Str::random(8) : null, 'school_id' => $sid,
                ]);
            }
        }
        $this->log("OK: Fees (" . Fee::count() . ")");

        // Activity Logs
        $actions = ['logged_in', 'viewed_students', 'created_class', 'updated_teacher', 'exported_report'];
        foreach ($actions as $a) {
            for ($i = 0; $i < 4; $i++) {
                ActivityLog::create([
                    'user_id' => $admin->id, 'action' => $a, 'description' => "System: $a",
                    'school_id' => $sid, 'created_at' => Carbon::now()->subDays(rand(0, 30)),
                ]);
            }
        }
        $this->log("OK: Activity Logs (" . ActivityLog::count() . ")");

        $this->log("=== SEED COMPLETE ===");
    }
}
