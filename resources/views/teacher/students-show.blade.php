@extends('layouts.teacher')

@section('title', 'Student Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3"><i class="fas fa-user-graduate me-2"></i>Student Details</h1>
    <div class="d-flex gap-2">
        <select id="reportTerm" class="form-select form-select-sm" style="width:auto">
            <option value="">Select Term</option>
            <option value="Term 1">Term 1</option>
            <option value="Term 2">Term 2</option>
            <option value="Term 3">Term 3</option>
        </select>
        <button type="button" class="btn btn-info btn-sm" onclick="printReport()"><i class="fas fa-print me-1"></i>Print Report</button>
        <a href="{{ route('teacher.students.marks', $student) }}" class="btn btn-success btn-sm"><i class="fas fa-pen me-1"></i>Enter Marks</a>
        <a href="{{ route('teacher.students.edit', $student) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit me-1"></i>Edit</a>
        <a href="{{ route('teacher.students') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Name</div>
                    <div class="col-sm-8 fw-semibold">{{ $student->first_name }} {{ $student->last_name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Admission No.</div>
                    <div class="col-sm-8"><span class="badge bg-primary">{{ $student->admission_number }}</span></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Class</div>
                    <div class="col-sm-8">{{ $student->class->class_name ?? 'N/A' }} {{ $student->class->section ?? '' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Gender</div>
                    <div class="col-sm-8">{{ ucfirst($student->gender ?? 'N/A') }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Date of Birth</div>
                    <div class="col-sm-8">{{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('M d, Y') : 'N/A' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Phone</div>
                    <div class="col-sm-8">{{ $student->phone ?? 'N/A' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Address</div>
                    <div class="col-sm-8">{{ $student->address ?? 'N/A' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Email</div>
                    <div class="col-sm-8">{{ $student->user->email ?? 'N/A' }}</div>
                </div>
                <div class="row">
                    <div class="col-sm-4 text-muted">Status</div>
                    <div class="col-sm-8">
                        <span class="badge bg-{{ $student->status ? 'success' : 'danger' }}">
                            {{ $student->status ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="fas fa-clipboard-check me-1"></i>Exam Results</h6>
                <div class="d-flex align-items-center gap-2">
                    <select class="form-select form-select-sm" style="width:auto" id="resultTermFilter" onchange="filterResults()">
                        <option value="">All Terms</option>
                        <option value="Term 1">Term 1</option>
                        <option value="Term 2">Term 2</option>
                        <option value="Term 3">Term 3</option>
                    </select>
                    <a href="{{ route('teacher.students.marks', $student) }}" class="btn btn-sm btn-outline-success"><i class="fas fa-pen me-1"></i>Enter Marks</a>
                </div>
            </div>
            <div class="card-body p-0">
                @php $results = $student->results()->with('exam')->get(); @endphp
                @if($results->count())
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Exam</th>
                                    <th>Subject</th>
                                    <th>Term</th>
                                    <th>Marks</th>
                                    <th>Grade</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($results as $result)
                                <tr data-term="{{ $result->term }}">
                                    <td>{{ $result->exam->exam_name ?? 'N/A' }}</td>
                                    <td><span class="badge bg-info">{{ $result->subject->subject_name ?? 'N/A' }}</span></td>
                                    <td><span class="badge bg-secondary">{{ $result->term ?? 'N/A' }}</span></td>
                                    <td>
                                        <form method="POST" action="{{ route('teacher.students.marks.store', $student) }}" class="d-flex align-items-center gap-1">
                                            @csrf
                                            <input type="hidden" name="exam_id" value="{{ $result->exam_id }}">
                                            <input type="hidden" name="term" value="{{ $result->term }}">
                                            <input type="number" name="marks_obtained"
                                                class="form-control form-control-sm d-inline-block" style="width:80px"
                                                min="0" max="{{ $result->exam->total_marks ?? 100 }}"
                                                value="{{ $result->marks_obtained }}">
                                            <span class="text-muted">/ {{ $result->exam->total_marks ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $result->grade == 'Pass' ? 'success' : 'danger' }}">{{ $result->grade }}</span>
                                    </td>
                                    <td>
                                            <button type="submit" class="btn btn-sm btn-success" title="Save"><i class="fas fa-save"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                <div class="text-center py-4 text-muted">No exam results yet.</div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-light"><h6 class="mb-0"><i class="fas fa-chart-bar me-1"></i>Summary</h6></div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Attendance Records</span>
                    <span class="fw-semibold">{{ $student->attendances->count() }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Exam Results</span>
                    <span class="fw-semibold">{{ $student->results->count() }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Fee Payments</span>
                    <span class="fw-semibold">{{ $student->fees->count() }}</span>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light"><h6 class="mb-0"><i class="fas fa-trash me-1"></i>Danger Zone</h6></div>
            <div class="card-body">
                <form action="{{ route('teacher.students.destroy', $student) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this student?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100"><i class="fas fa-trash me-1"></i>Delete Student</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// ─── Safe Calculation Helpers ───────────────────────────────────────────────

function safeNum(val, fallback) {
    const n = parseFloat(val);
    return (Number.isFinite(n) && n >= 0) ? n : (fallback || 0);
}

function calcPercentage(obtained, total) {
    const o = safeNum(obtained);
    const t = safeNum(total);
    if (t <= 0) return null;
    return parseFloat(((o / t) * 100).toFixed(1));
}

function calcGrade(percentage) {
    const p = safeNum(percentage);
    if (p === null) return '-';
    if (p >= 90) return 'A+';
    if (p >= 80) return 'A';
    if (p >= 70) return 'B';
    if (p >= 60) return 'C';
    if (p >= 50) return 'D';
    return 'F';
}

function getExamType(examName) {
    const name = (examName || '').toLowerCase();
    if (name.includes('mid')) return 'mid';
    if (name.includes('end') || name.includes('final')) return 'end';
    return 'other';
}

function buildSubjectMap(results) {
    const map = {};
    results.forEach(function(r) {
        if (!r || !r.exam || !r.subject) return;
        const subjName = r.subject.subject_name || 'N/A';
        if (!map[subjName]) map[subjName] = { mid: null, end: null, other: [] };
        const type = getExamType(r.exam.exam_name);
        if (type === 'mid') map[subjName].mid = r;
        else if (type === 'end') map[subjName].end = r;
        else map[subjName].other.push(r);
    });
    return map;
}

function calculateSubject(subjData) {
    const m = subjData.mid, e = subjData.end;
    const midMarks = m ? safeNum(m.marks_obtained) : 0, midTotal = m ? safeNum(m.exam.total_marks) : 0;
    const endMarks = e ? safeNum(e.marks_obtained) : 0, endTotal = e ? safeNum(e.exam.total_marks) : 0;
    const marksObtained = midMarks + endMarks, totalMarks = midTotal + endTotal;
    return { midMarks: midMarks, midTotal: midTotal, endMarks: endMarks, endTotal: endTotal, marksObtained: marksObtained, totalMarks: totalMarks, percentage: calcPercentage(marksObtained, totalMarks), grade: calcGrade(calcPercentage(marksObtained, totalMarks)), hasData: m !== null || e !== null };
}

function calculateReport(subjectMap) {
    const subjects = [];
    let totalMidObt = 0, totalMidFull = 0, totalEndObt = 0, totalEndFull = 0, grandObt = 0, grandFull = 0;
    Object.keys(subjectMap).sort().forEach(function(subjName) {
        const calc = calculateSubject(subjectMap[subjName]);
        subjects.push({ name: subjName, calc: calc });
        if (calc.hasData) { totalMidObt += calc.midMarks; totalMidFull += calc.midTotal; totalEndObt += calc.endMarks; totalEndFull += calc.endTotal; grandObt += calc.marksObtained; grandFull += calc.totalMarks; }
    });
    return { subjects: subjects, totalMidObt: totalMidObt, totalMidFull: totalMidFull, totalEndObt: totalEndObt, totalEndFull: totalEndFull, grandObt: grandObt, grandFull: grandFull, overallPct: calcPercentage(grandObt, grandFull), overallGrade: calcGrade(calcPercentage(grandObt, grandFull)) };
}

function calculateRanking(classmates, currentStudentId, term) {
    var rankings = [];
    classmates.forEach(function(stu) {
        var results = (stu.results || []).filter(function(r) { return r && r.term === term && r.exam; });
        var obt = 0, full = 0;
        results.forEach(function(r) { obt += safeNum(r.marks_obtained); full += safeNum(r.exam.total_marks); });
        rankings.push({ id: stu.id, pct: full > 0 ? (obt / full) * 100 : 0 });
    });
    rankings.sort(function(a, b) { return b.pct - a.pct; });
    var pos = 0;
    for (var i = 0; i < rankings.length; i++) { if (rankings[i].id === currentStudentId) { pos = i + 1; break; } }
    return { position: pos, total: rankings.length };
}

function generateQRSVG(text, size) {
    var canvas = document.createElement('canvas'); canvas.width = size; canvas.height = size;
    var ctx = canvas.getContext('2d'); ctx.fillStyle = '#FFF'; ctx.fillRect(0, 0, size, size);
    ctx.fillStyle = '#0F2D52';
    var cells = 21, cellSize = size / cells, seed = 0;
    for (var i = 0; i < text.length; i++) seed = ((seed << 5) - seed + text.charCodeAt(i)) | 0;
    seed = Math.abs(seed) || 1;
    function rng() { seed = (seed * 16807) % 2147483647; return (seed & 0x7FFFFFFF) / 2147483647; }
    function drawFinder(x, y) {
        ctx.fillStyle = '#0F2D52'; ctx.fillRect(x * cellSize, y * cellSize, 7 * cellSize, 7 * cellSize);
        ctx.fillStyle = '#FFF'; ctx.fillRect((x+1) * cellSize, (y+1) * cellSize, 5 * cellSize, 5 * cellSize);
        ctx.fillStyle = '#0F2D52'; ctx.fillRect((x+2) * cellSize, (y+2) * cellSize, 3 * cellSize, 3 * cellSize);
    }
    drawFinder(0, 0); drawFinder(cells - 7, 0); drawFinder(0, cells - 7);
    for (var i = 8; i < cells - 8; i++) { if (i % 2 === 0) { ctx.fillRect(i * cellSize, 6 * cellSize, cellSize, cellSize); ctx.fillRect(6 * cellSize, i * cellSize, cellSize, cellSize); } }
    for (var r = 0; r < cells; r++) for (var c = 0; c < cells; c++) {
        if ((r < 9 && c < 9) || (r < 9 && c >= cells - 8) || (r >= cells - 8 && c < 9) || r === 6 || c === 6) continue;
        if (rng() > 0.55) ctx.fillRect(c * cellSize, r * cellSize, cellSize, cellSize);
    }
    return canvas.toDataURL('image/png');
}

function gradeColor(g) { switch(g) { case 'A+':return'#0F7B3F';case'A':return'#1A8C4E';case'B':return'#2E7D32';case'C':return'#D4A24C';case'D':return'#E67E22';case'F':return'#C0392B';default:return'#999'; } }
function gradeBg(g) { switch(g) { case'A+':case'A':return'#E8F5E9';case'B':return'#F1F8E9';case'C':return'#FFF8E1';case'D':return'#FFF3E0';case'F':return'#FFEBEE';default:return'#F5F5F5'; } }
function ordinalSuffix(n) { var s=['th','st','nd','rd'],v=n%100; return n+(s[(v-20)%10]||s[v]||s[0]); }

function printReport() {
    var term = document.getElementById('reportTerm').value;
    if (!term) { alert('Please select a term first.'); return; }

    var rawResults = @json($student->results->load('exam', 'subject'));
    var filtered = rawResults.filter(function(r) { return r && r.term === term; });
    if (!filtered.length) { alert('No results found for ' + term); return; }

    var subjectMap = buildSubjectMap(filtered);
    var report = calculateReport(subjectMap);
    if (!report.subjects.length) { alert('No valid subject data found for ' + term); return; }

    var classmates = @json($classmates);
    var ranking = calculateRanking(classmates, {{ $student->id }}, term);

    var allAttendance = @json($student->attendances);
    var termAttendance = allAttendance.filter(function(a) { return a && a.status; });
    var totalDays = termAttendance.length;
    var presentDays = termAttendance.filter(function(a) { return a.status === 'present'; }).length;
    var absentDays = termAttendance.filter(function(a) { return a.status === 'absent'; }).length;
    var lateDays = termAttendance.filter(function(a) { return a.status === 'late'; }).length;
    var attendPct = totalDays > 0 ? ((presentDays / totalDays) * 100).toFixed(0) : 0;

    var cls = '{{ $student->class ? $student->class->class_name . " " . ($student->class->section ?? "") : "N/A" }}';
    var studentName = '{{ $student->first_name }} {{ $student->last_name }}';
    var studentId = '{{ $student->admission_number }}';
    var year = '{{ date("Y") }}';
    var profilePic = '{{ $student->user && $student->user->profile_picture ? asset("storage/" . $student->user->profile_picture) : "" }}';
    var gender = '{{ ucfirst($student->gender ?? "N/A") }}';
    var dob = '{{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format("M d, Y") : "N/A" }}';
    var schoolName = '{{ $school ? addslashes($school->name) : "School Management System" }}';
    var schoolLogo = '{{ $school && $school->logo ? asset("storage/" . $school->logo) : "" }}';

    var qrData = 'Student:' + studentId + '|Term:' + term + '|Year:' + year + '|Grade:' + report.overallGrade;
    var qrImg = generateQRSVG(qrData, 120);

    var avatarHTML = profilePic
        ? '<div class="stu-photo" style="background-image:url(\'' + profilePic + '\')"></div>'
        : '<div class="stu-photo stu-photo-placeholder"><span>' + studentName.split(' ').map(function(w){return w[0]}).join('').substring(0,2) + '</span></div>';

    var rankBadge = ranking.position > 0
        ? '<div class="rank-badge"><span class="rank-pos">' + ordinalSuffix(ranking.position) + '</span><span class="rank-of"> of ' + ranking.total + '</span></div>'
        : '<div class="rank-badge"><span class="rank-pos">\u2014</span></div>';

    var rows = '';
    report.subjects.forEach(function(s, i) {
        var c = s.calc, bgColor = i % 2 === 0 ? '#FFFFFF' : '#F8FAFC';
        var midD = c.hasData && c.midTotal > 0 ? c.midMarks + ' / ' + c.midTotal : '\u2014';
        var endD = c.hasData && c.endTotal > 0 ? c.endMarks + ' / ' + c.endTotal : '\u2014';
        var pctD = c.percentage !== null ? c.percentage + '%' : '\u2014';
        var gD = c.hasData ? c.grade : '\u2014';
        var gc = gradeColor(c.grade), gb = gradeBg(c.grade);
        var remark = c.percentage !== null ? (c.percentage >= 80 ? 'Excellent' : c.percentage >= 60 ? 'Good' : c.percentage >= 50 ? 'Satisfactory' : 'Needs Improvement') : '\u2014';
        rows += '<tr style="background:' + bgColor + '">'
            + '<td style="padding:10px 12px;border-bottom:1px solid #E8ECF0;text-align:center;font-size:13px;color:#64748B">' + (i+1) + '</td>'
            + '<td style="padding:10px 12px;border-bottom:1px solid #E8ECF0;font-size:13px;font-weight:500;color:#1E293B">' + s.name + '</td>'
            + '<td style="padding:10px 12px;border-bottom:1px solid #E8ECF0;text-align:center;font-size:13px;color:#475569">' + midD + '</td>'
            + '<td style="padding:10px 12px;border-bottom:1px solid #E8ECF0;text-align:center;font-size:13px;color:#475569">' + endD + '</td>'
            + '<td style="padding:10px 12px;border-bottom:1px solid #E8ECF0;text-align:center;font-size:13px;font-weight:600;color:#0F2D52">' + c.marksObtained + ' / ' + c.totalMarks + '</td>'
            + '<td style="padding:10px 12px;border-bottom:1px solid #E8ECF0;text-align:center;font-size:13px;color:#475569">' + pctD + '</td>'
            + '<td style="padding:10px 12px;border-bottom:1px solid #E8ECF0;text-align:center"><span style="display:inline-block;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600;color:' + gc + ';background:' + gb + '">' + gD + '</span></td>'
            + '<td style="padding:10px 12px;border-bottom:1px solid #E8ECF0;text-align:center;font-size:11px;color:#64748B;font-style:italic">' + remark + '</td></tr>';
    });

    var grandPctD = report.overallPct !== null ? report.overallPct + '%' : '\u2014';
    var grandGD = report.grandFull > 0 ? report.overallGrade : '\u2014';
    var grandGc = gradeColor(report.overallGrade), grandGb = gradeBg(report.overallGrade);
    var distLabel = report.overallPct >= 80 ? 'Distinction' : report.overallPct >= 60 ? 'Merit' : report.overallPct >= 50 ? 'Pass' : 'Below Average';

    var html = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Report Card \u2014 ' + studentName + '</title>'
        + '<link rel="preconnect" href="https://fonts.googleapis.com">'
        + '<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">'
        + '<style>'
        + '@page{size:A4 portrait;margin:10mm 12mm;}*{margin:0;padding:0;box-sizing:border-box;}body{font-family:"Inter",sans-serif;color:#1E293B;background:#FAFAFA;-webkit-print-color-adjust:exact;print-color-adjust:exact;}'
        + '.page{width:100%;max-width:780px;margin:0 auto;background:#FFF;padding:32px 36px;}'
        + '.hdr{display:flex;align-items:center;justify-content:space-between;padding-bottom:16px;border-bottom:3px solid #0F2D52;margin-bottom:20px;}'
        + '.hdr-left{display:flex;align-items:center;gap:14px;}'
        + '.hdr-logo{width:56px;height:56px;background:#0F2D52;border-radius:14px;display:flex;align-items:center;justify-content:center;color:#D4A24C;font-family:"Poppins",sans-serif;font-weight:800;font-size:20px;overflow:hidden;}'
        + '.hdr-logo img{width:100%;height:100%;object-fit:cover;border-radius:14px;}'
        + '.hdr-text h1{font-family:"Poppins",sans-serif;font-size:18px;font-weight:700;color:#0F2D52;}'
        + '.hdr-text p{font-size:10px;color:#94A3B8;letter-spacing:2px;text-transform:uppercase;margin-top:1px;}'
        + '.hdr-right{text-align:right;}'
        + '.hdr-right .term-badge{display:inline-block;background:linear-gradient(135deg,#0F2D52,#1A3A6B);color:#FFF;font-family:"Poppins",sans-serif;font-size:11px;font-weight:600;padding:5px 14px;border-radius:20px;}'
        + '.hdr-right .year{font-size:10px;color:#94A3B8;margin-top:3px;}'
        + '.stu-card{display:flex;gap:20px;background:#F8FAFC;border-radius:12px;padding:16px 20px;margin-bottom:20px;border:1px solid #E8ECF0;align-items:center;}'
        + '.stu-photo{width:72px;height:72px;border-radius:50%;background-size:cover;background-position:center;border:3px solid #D4A24C;flex-shrink:0;}'
        + '.stu-photo-placeholder{background:#0F2D52;display:flex;align-items:center;justify-content:center;}'
        + '.stu-photo-placeholder span{color:#D4A24C;font-family:"Poppins",sans-serif;font-weight:700;font-size:22px;}'
        + '.stu-details{flex:1;}'
        + '.stu-details h3{font-family:"Poppins",sans-serif;font-size:10px;text-transform:uppercase;letter-spacing:1.5px;color:#94A3B8;margin-bottom:8px;font-weight:600;}'
        + '.stu-grid{display:grid;grid-template-columns:1fr 1fr 1fr 1fr 1fr;gap:10px;}'
        + '.stu-item .lbl{font-size:9px;text-transform:uppercase;letter-spacing:0.8px;color:#94A3B8;margin-bottom:2px;}'
        + '.stu-item .val{font-size:12px;font-weight:600;color:#0F2D52;}'
        + '.rank-badge{text-align:center;flex-shrink:0;padding:12px 16px;background:#0F2D52;border-radius:10px;}'
        + '.rank-badge .rank-pos{display:block;font-family:"Poppins",sans-serif;font-size:22px;font-weight:800;color:#D4A24C;line-height:1;}'
        + '.rank-badge .rank-of{display:block;font-size:10px;color:#94A3B8;margin-top:2px;}'
        + '.sec-title{font-family:"Poppins",sans-serif;font-size:12px;font-weight:600;color:#0F2D52;text-transform:uppercase;letter-spacing:1.2px;margin-bottom:10px;padding-bottom:6px;border-bottom:2px solid #D4A24C;display:inline-block;}'
        + '.perf-wrap{margin-bottom:20px;}.perf-table{width:100%;border-collapse:collapse;}'
        + '.perf-table thead th{background:#0F2D52;color:#FFF;font-family:"Poppins",sans-serif;font-size:10px;font-weight:600;padding:8px 10px;text-align:center;letter-spacing:0.5px;text-transform:uppercase;}'
        + '.perf-table thead th:first-child{border-radius:8px 0 0 0;text-align:left;padding-left:14px;}'
        + '.perf-table thead th:last-child{border-radius:0 8px 0 0;}'
        + '.perf-table tbody tr:last-child td{border-bottom:2px solid #E8ECF0;}'
        + '.sum-row{display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:12px;margin-bottom:20px;}'
        + '.sum-card{background:#F8FAFC;border-radius:10px;padding:14px 16px;border:1px solid #E8ECF0;text-align:center;}'
        + '.sum-card h4{font-family:"Poppins",sans-serif;font-size:9px;text-transform:uppercase;letter-spacing:1px;color:#94A3B8;margin-bottom:6px;}'
        + '.sum-card .big{font-family:"Poppins",sans-serif;font-size:24px;font-weight:700;color:#0F2D52;line-height:1;}'
        + '.sum-card .big.gold{color:#D4A24C;}.sum-card .sub{font-size:11px;color:#64748B;margin-top:3px;}'
        + '.sum-card .grade-pill{display:inline-block;padding:4px 12px;border-radius:20px;font-size:13px;font-weight:700;}'
        + '.att-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-bottom:20px;}'
        + '.att-item{background:#F8FAFC;border-radius:8px;padding:12px;text-align:center;border:1px solid #E8ECF0;}'
        + '.att-item .att-num{font-family:"Poppins",sans-serif;font-size:20px;font-weight:700;}'
        + '.att-item .att-lbl{font-size:9px;text-transform:uppercase;letter-spacing:1px;color:#94A3B8;margin-top:3px;}'
        + '.att-present{color:#0F7B3F;}.att-absent{color:#C0392B;}.att-late{color:#D4A24C;}.att-pct{color:#0F2D52;}'
        + '.remarks-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:20px;}'
        + '.remark-box{background:#F8FAFC;border-radius:10px;padding:14px 16px;border:1px solid #E8ECF0;}'
        + '.remark-box h4{font-family:"Poppins",sans-serif;font-size:9px;text-transform:uppercase;letter-spacing:1px;color:#94A3B8;margin-bottom:6px;}'
        + '.remark-box .remark-line{width:100%;border-bottom:1px dashed #CBD5E1;height:16px;margin-top:16px;}'
        + '.bottom-area{display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;margin-top:20px;padding-top:16px;border-top:2px solid #E8ECF0;}'
        + '.sig-box{text-align:center;}.sig-line{border-bottom:2px solid #0F2D52;margin:36px 0 6px 0;}'
        + '.sig-name{font-size:10px;font-weight:600;color:#0F2D52;}.sig-role{font-size:9px;color:#94A3B8;text-transform:uppercase;letter-spacing:1px;}'
        + '.stamp-box{width:90px;height:90px;border:2px dashed #D4A24C;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto;opacity:0.35;}'
        + '.stamp-box span{font-size:8px;color:#D4A24C;text-transform:uppercase;letter-spacing:1px;font-weight:600;text-align:center;}'
        + '.qr-box{text-align:center;}.qr-box img{width:80px;height:80px;border-radius:8px;border:1px solid #E8ECF0;}'
        + '.qr-box .qr-label{font-size:8px;color:#94A3B8;text-transform:uppercase;letter-spacing:1px;margin-top:4px;}'
        + '.ftr{text-align:center;margin-top:16px;padding-top:12px;border-top:1px solid #E8ECF0;font-size:9px;color:#CBD5E1;letter-spacing:0.5px;}'
        + '@media print{body{background:#FFF;}.page{box-shadow:none;padding:0;margin:0;}}'
        + '</style></head><body><div class="page">'

        + '<div class="hdr"><div class="hdr-left"><div class="hdr-logo">' + (schoolLogo ? '<img src="' + schoolLogo + '" alt="Logo">' : 'SMS') + '</div><div class="hdr-text"><h1>' + schoolName + '</h1><p>Official Academic Report</p></div></div>'
        + '<div class="hdr-right"><div class="term-badge">' + term + '</div><div class="year">Academic Year ' + year + '</div></div></div>'

        + '<div class="stu-card">' + avatarHTML
        + '<div class="stu-details"><h3>Student Information</h3><div class="stu-grid">'
        + '<div class="stu-item"><div class="lbl">Full Name</div><div class="val">' + studentName + '</div></div>'
        + '<div class="stu-item"><div class="lbl">Student ID</div><div class="val">' + studentId + '</div></div>'
        + '<div class="stu-item"><div class="lbl">Class</div><div class="val">' + cls + '</div></div>'
        + '<div class="stu-item"><div class="lbl">Gender</div><div class="val">' + gender + '</div></div>'
        + '<div class="stu-item"><div class="lbl">DOB</div><div class="val">' + dob + '</div></div>'
        + '</div></div>' + rankBadge + '</div>'

        + '<div class="perf-wrap"><div class="sec-title">Academic Performance</div>'
        + '<table class="perf-table"><thead><tr>'
        + '<th style="text-align:left;padding-left:14px">#</th><th>Subject</th><th>Mid Term</th><th>End of Term</th><th>Total</th><th>Percentage</th><th>Grade</th><th>Remark</th>'
        + '</tr></thead><tbody>' + rows + '</tbody></table></div>'

        + '<div class="sec-title">Overall Summary</div><div class="sum-row">'
        + '<div class="sum-card"><h4>Mid Term</h4><div class="big">' + report.totalMidObt + '<span style="font-size:13px;color:#94A3B8"> / ' + report.totalMidFull + '</span></div></div>'
        + '<div class="sum-card"><h4>End of Term</h4><div class="big">' + report.totalEndObt + '<span style="font-size:13px;color:#94A3B8"> / ' + report.totalEndFull + '</span></div></div>'
        + '<div class="sum-card"><h4>Grand Total</h4><div class="big gold">' + report.grandObt + '<span style="font-size:13px;color:#94A3B8"> / ' + report.grandFull + '</span></div></div>'
        + '<div class="sum-card"><h4>Overall</h4><div class="grade-pill" style="color:' + grandGc + ';background:' + grandGb + '">' + grandGD + '</div><div class="sub" style="margin-top:4px">' + grandPctD + ' \u2022 ' + distLabel + '</div></div>'
        + '</div>'

        + '<div class="sec-title">Attendance Summary</div><div class="att-grid">'
        + '<div class="att-item"><div class="att-num att-present">' + presentDays + '</div><div class="att-lbl">Present</div></div>'
        + '<div class="att-item"><div class="att-num att-absent">' + absentDays + '</div><div class="att-lbl">Absent</div></div>'
        + '<div class="att-item"><div class="att-num att-late">' + lateDays + '</div><div class="att-lbl">Late</div></div>'
        + '<div class="att-item"><div class="att-num att-pct">' + attendPct + '%</div><div class="att-lbl">Attendance</div></div></div>'

        + '<div class="sec-title">Remarks</div><div class="remarks-grid">'
        + '<div class="remark-box"><h4>Class Teacher\u2019s Remarks</h4><div class="remark-line"></div></div>'
        + '<div class="remark-box"><h4>Principal\u2019s Remarks</h4><div class="remark-line"></div></div></div>'

        + '<div class="bottom-area">'
        + '<div class="sig-box"><div class="sig-line"></div><div class="sig-name">Class Teacher</div><div class="sig-role">Signature & Date</div></div>'
        + '<div style="text-align:center"><div class="stamp-box"><span>School<br>Stamp</span></div></div>'
        + '<div class="sig-box"><div class="sig-line"></div><div class="sig-name">Principal</div><div class="sig-role">Signature & Seal</div></div></div>'

        + '<div style="display:flex;justify-content:space-between;align-items:center;margin-top:16px;padding-top:12px;border-top:1px solid #E8ECF0;">'
        + '<div class="qr-box"><img src="' + qrImg + '" alt="QR"><div class="qr-label">Scan to verify</div></div>'
        + '<div style="text-align:right"><div style="font-size:9px;color:#CBD5E1;">Report generated on ' + new Date().toLocaleDateString('en-US',{year:'numeric',month:'long',day:'numeric'}) + ' \u2022 School Management System</div>'
        + '<div style="font-size:8px;color:#CBD5E1;margin-top:2px;">Verification ID: ' + studentId + '-' + term.replace(/\s/g,'') + '-' + year + '</div></div></div>'

        + '</div></body></html>';

    var pw = window.open('', '_blank', 'width=794,height=1123');
    pw.document.write(html); pw.document.close();
    setTimeout(function() { pw.print(); }, 800);
}

function filterResults() {
    var term = document.getElementById('resultTermFilter').value;
    document.querySelectorAll('tr[data-term]').forEach(function(row) {
        row.style.display = (!term || row.dataset.term === term) ? '' : 'none';
    });
}
</script>
@endpush
