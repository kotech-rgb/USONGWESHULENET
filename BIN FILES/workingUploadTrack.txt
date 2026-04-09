@extends('layouts.app')
@section('title', 'Upload Tracking')

@php
$teacher = auth()->user();
$teacherClasses = DB::table('teacher_subjects')
    ->where('teacher', $teacher->id)
    ->pluck('class')
    ->map(fn($c) => trim(strtoupper($c)))
    ->toArray();
@endphp

@section('content')
<div class="container-fluid p-2 rounded shadow-sm border-2">

    @foreach($classSubjects as $class => $subjects)
        @php $classNormalized = trim(strtoupper($class)); @endphp

        {{-- Teacher sees only their classes --}}
        @if($teacher->role == "Teacher" && !in_array($classNormalized, $teacherClasses))
            @continue
        @endif

        <div class="mb-2">
            <h6 class="fw-bold px-2 py-1 bg-light border rounded" style="font-size:0.75rem;">{{ $class }}</h6>
            <div class="table-responsive">
                <table class="table table-bordered table-sm text-center mb-2" style="border-collapse: collapse; font-size:0.7rem;">
                    <thead>
                        <tr>
                            <th style="width:50px; font-weight:600; padding:0.2rem;">Type</th>
                            @foreach($subjects->unique() as $subject)
                                <th style="padding:0.2rem; white-space:nowrap;">{{ $subject }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-bold" style="padding:0.2rem;">Test</td>
                            @foreach($subjects->unique() as $subject)
                                @php $key = $class.'|'.$subject; @endphp
                                <td style="padding:0.2rem;">
                                    @if(in_array($key, $testsUploaded))
                                        <i class="fa fa-check text-white" style="font-size:0.65rem; background-color:#28a745; padding:2px 6px; border-radius:50px;"></i>
                                    @else
                                        <i class="fa fa-times text-white" style="font-size:0.65rem; background-color:#dc3545; padding:2px 6px; border-radius:50px;"></i>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="fw-bold" style="padding:0.2rem;">Exam</td>
                            @foreach($subjects->unique() as $subject)
                                @php $key = $class.'|'.$subject; @endphp
                                <td style="padding:0.2rem;">
                                    @if(in_array($key, $examsUploaded))
                                        <i class="fa fa-check text-white" style="font-size:0.65rem; background-color:#28a745; padding:2px 6px; border-radius:50px;"></i>
                                        @if($teacher->role=="Academic")
                                            <form class="reverseForm" action="{{ route('marks.reverse') }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="class" value="{{ $class }}">
                                                <input type="hidden" name="subject" value="{{ $subject }}">
                                                <input type="hidden" name="term" value="{{ $currentTerm }}">
                                                <input type="hidden" name="year" value="{{ $currentYear }}">
                                                <button class="btn btn-link btn-sm p-0 m-0 align-baseline" style="font-size:0.65rem;">
                                                    Reverse <i class="fa fa-undo"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <i class="fa fa-times text-white" style="font-size:0.65rem; background-color:#dc3545; padding:2px 6px; border-radius:50px;"></i>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach

</div>

<style>
.table th, .table td {
    padding: 0.15rem 0.25rem !important;
    border: 1px solid #000 !important;
    font-size: 0.7rem;
    white-space: nowrap;
}
.table-responsive { overflow-x: auto; }
h6.fw-bold { margin-bottom: 0.15rem; }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll(".reverseForm").forEach(form => {
    form.addEventListener("submit", function(e) {
        e.preventDefault();
        Swal.fire({
            title: "Confirm Reversal",
            text: "Are you sure you want to reverse this exam upload? This action cannot be undone.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Reverse"
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
});
</script>
@endsection
