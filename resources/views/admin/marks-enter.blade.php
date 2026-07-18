@extends('layouts.admin')

@section('title', 'Enter Marks')
@section('page_title', 'Enter Marks - ' . $student->first_name . ' ' . $student->last_name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-1">{{ $student->first_name }} {{ $student->last_name }}</h5>
        <span class="text-muted">{{ $student->admission_number }} | {{ $student->class->class_name ?? 'N/A' }}</span>
    </div>
    <a href="{{ route('admin.students.show', $student) }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>

<div class="row g-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="fas fa-list me-2 text-primary"></i>All Marks</h6>
                <select class="form-select form-select-sm" style="width:auto" id="termFilter" onchange="filterMarks()">
                    <option value="">All Terms</option>
                    <option value="Term 1">Term 1</option>
                    <option value="Term 2">Term 2</option>
                    <option value="Term 3">Term 3</option>
                </select>
            </div>
            <div class="card-body">
                @if($allResults->count())
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Exam</th>
                                    <th>Subject</th>
                                    <th>Term</th>
                                    <th>Date</th>
                                    <th>Max</th>
                                    <th>Marks</th>
                                    <th>Grade</th>
                                    <th width="90">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allResults as $i => $result)
                                @php $exam = $result->exam; @endphp
                                <tr data-term="{{ $result->term ?? '' }}">
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $exam->exam_name ?? 'N/A' }}</td>
                                    <td><small>{{ $result->subject->subject_name ?? 'N/A' }}</small></td>
                                    <td><span class="badge bg-secondary">{{ $result->term ?? 'N/A' }}</span></td>
                                    <td><small>{{ $exam ? \Carbon\Carbon::parse($exam->date)->format('M d, Y') : 'N/A' }}</small></td>
                                    <td>{{ $exam->total_marks ?? 0 }}</td>
                                    <td class="fw-semibold">{{ $result->marks_obtained > 0 ? $result->marks_obtained : '-' }}</td>
                                    <td>
                                        @if($result->grade == 'Pass')
                                            <span class="badge bg-success">Pass</span>
                                        @elseif($result->grade == 'Fail')
                                            <span class="badge bg-danger">Fail</span>
                                        @else
                                            <span class="badge bg-warning text-dark">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <button type="button" class="btn btn-outline-warning btn-sm" title="Edit"
                                                onclick="editMark({{ $exam->id }}, '{{ $exam->exam_name }}', {{ $result->marks_obtained }}, {{ $exam->total_marks ?? 100 }}, '{{ $result->term ?? '' }}')">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('admin.students.marks.remove', [$student, $result]) }}" method="POST" onsubmit="return confirm('Remove this exam?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Remove"><i class="fas fa-times"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-clipboard-list fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">No marks entered yet. Use the form below to add marks.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h6 class="mb-0"><i class="fas fa-plus-circle me-2 text-success"></i>Enter Marks</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.students.marks.store', $student) }}">
                    @csrf
                    <div class="row g-3 align-items-end">
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Term <span class="text-danger">*</span></label>
                            <select name="term" class="form-select" required>
                                <option value="">Choose...</option>
                                <option value="Term 1">Term 1</option>
                                <option value="Term 2">Term 2</option>
                                <option value="Term 3">Term 3</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Subject <span class="text-danger">*</span></label>
                            <select class="form-select" required id="enterSubject">
                                <option value="">Choose...</option>
                                @foreach($allExams->pluck('subject')->unique('id')->filter() as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Exam <span class="text-danger">*</span></label>
                            <select name="exam_id" class="form-select" required id="enterExam">
                                <option value="">Choose subject first...</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Marks <span class="text-danger">*</span></label>
                            <input type="number" name="marks_obtained" class="form-control" min="0" required placeholder="0" id="enterMarks">
                            <small class="text-muted" id="maxMarksHint"></small>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-orange w-100"><i class="fas fa-save me-1"></i>Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editMarkModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.students.marks.store', $student) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Edit Mark</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="exam_id" id="editExamId">
                    <input type="hidden" name="term" id="editTerm">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Exam</label>
                        <input type="text" class="form-control" id="editExamName" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Marks Obtained</label>
                        <input type="number" name="marks_obtained" class="form-control" min="0" id="editMarksInput" required>
                        <small class="text-muted" id="editMaxHint"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-orange">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const allExams = <?php echo $allExams->map(fn($e) => (object)['id'=>$e->id,'name'=>$e->exam_name,'subject_id'=>$e->subject_id,'total'=>$e->total_marks])->toJson(); ?>;
const enterSubject = document.getElementById('enterSubject');
const enterExam = document.getElementById('enterExam');

enterSubject.addEventListener('change', function() {
    const sid = this.value;
    enterExam.innerHTML = '<option value="">Choose exam...</option>';
    if (!sid) return;
    allExams.filter(e => e.subject_id == sid).forEach(e => {
        enterExam.innerHTML += '<option value="'+e.id+'" data-total="'+e.total+'">'+e.name+'</option>';
    });
});

enterExam.addEventListener('change', function() {
    const opt = this.options[this.selectedIndex];
    const total = opt.dataset.total || '';
    document.getElementById('maxMarksHint').textContent = total ? 'Maximum: ' + total + ' marks' : '';
    document.getElementById('enterMarks').max = total || 100;
});

function filterMarks() {
    const term = document.getElementById('termFilter').value;
    document.querySelectorAll('tr[data-term]').forEach(row => {
        row.style.display = (!term || row.dataset.term === term) ? '' : 'none';
    });
}

function editMark(examId, examName, currentMarks, totalMarks, term) {
    document.getElementById('editExamId').value = examId;
    document.getElementById('editExamName').value = examName;
    document.getElementById('editMarksInput').value = currentMarks > 0 ? currentMarks : '';
    document.getElementById('editMarksInput').max = totalMarks;
    document.getElementById('editMaxHint').textContent = 'Maximum: ' + totalMarks + ' marks';
    document.getElementById('editTerm').value = term;
    new bootstrap.Modal(document.getElementById('editMarkModal')).show();
}
</script>
@endpush
