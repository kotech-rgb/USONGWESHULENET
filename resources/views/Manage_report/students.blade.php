<div class="report-card">
    {{-- Header --}}
    <div class="row align-items-center mb-3">
        <div class="col-2 text-start">
            <img src="{{ $School_details->logo ?? '/assets/img/nembo.jpg' }}" class="school-logo">
        </div>
        <div class="col-8 text-center">
            <div class="header-title">PRESIDENT'S OFFICE - REGIONAL ADMINISTRATION AND LOCAL GOVERNMENT</div>
            <p>{{ $School_details->location }}</p>
            <p class="fw-bold">{{ $School_details->school_name.'-'.$School_details->school_reg }}</p>
            <p class="fw-bold mb-0">{{ $School_details->report_head }} </p>
        </div>
        <div class="col-2 text-center">
            {!! QrCode::size(80)->generate(
                "Student: {$student->firstname} {$student->lastname}\n".
                "Class: {$student->class_name}\n".
                "Term: {$student->term}, Year: {$student->year}\n".
                "Position: {$student->position}\n".
                "Division: {$student->division}\n".
                "Total Points: {$student->total_points}\n".
                "Scores: {$student->score_details}"
            ) !!}
        </div>
    </div>
    <hr>

    {{-- Student Info --}}
    <div class="row mb-2 mt-2">
        <div class="col-6">
            <p>Jina Kamili: <strong>{{ strtoupper($student->firstname.' '.$student->middlename.' '.$student->lastname) }}</strong></p>
            <p>Namba ya Mtihani: <strong>{{ $School_details->school_reg }}.{{ str_pad($student->index_number, 4, '0', STR_PAD_LEFT) }}</strong></p>
            <p>Darasa: <strong>{{ $student->class_name }}</strong></p>
        </div>
    </div>

    {{-- Results Table --}}
    <table class="table table-sm table-compact text-center align-middle necta-table">
        <thead>
            <tr><td colspan="5"><strong>A: MATOKEO YA MTIHANI</strong></td></tr>
            <tr>
                <th>SOMO</th>
                <th>ALAMA</th>
                <th>DARAJA</th>
                 @if (!Str::startsWith($student->class_name, ['FORM FIVE', 'FORM SIX']))
                <th>NAFASI KATIKA SOMO</th>
                @endif
                <th>MAONI</th>
            </tr>
        </thead>
        <tbody>
            @foreach(explode(',', $student->score_details) as $subjectDetail)
                @php
                    preg_match('/^(.+)-(\d+)\(([A-Z])\)$/', trim($subjectDetail), $matches);
                    $teacherComment = 'Aongeze bidii';
                @endphp
                @if(count($matches) === 4)
                    @php
                        $subject = $matches[1];
                        $score   = $matches[2];
                        $grade   = $matches[3];
                        $subjectData = $student->subject_positions[$subject] ?? null;
                        $pos = $subjectData['position'] ?? '-';
                         $totalInSubject = $subjectData['total'] ?? 0; // total students in this subject
                    @endphp
                    <tr>
                        <td style="text-align:left;">{{ $subject }}</td>
                        <td>{{ $score }}</td>
                        <td>{{ $grade }}</td>
                         @if (!Str::startsWith($student->class_name, ['FORM FIVE', 'FORM SIX']))
                        <td>{{ $pos }}/{{ $totalInSubject }}</td>
                        @endif
                        <td style="text-align:left;">
                            @switch($grade)
                                @case('A') Nzuri Sana @break
                                @case('B') Nzuri @break
                                @case('C') Kawaida, Aongeze Bidii @break
                                @case('D') Dhaifu, Amefeli @break
                                @case('E') Dhaifu Sana @break
                                @case('S') Dhaifu Sana @break
                                @case('F') Dhaifu Sana @break
                                @default Undefined
                            @endswitch
                        </td>
                    </tr>
                @else
                    <tr>
                        <td colspan="5" class="text-start">{{ trim($subjectDetail) }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    {{-- Summary --}}
    <table class="table table-sm table-compact">
        <thead>
            <tr>
                <td colspan="2">AMESHIKA NAFASI YA <strong>{{ $student->position }}</strong> KATI YA WANAFUNZI <strong>{{ $totalStudentsInClass }}</strong> KATIKA DARASA LAKE</td>
            </tr>
            <tr>
                <td>DIVISION: <strong>{{ $student->division }}</strong></td>
                <td>POINTS: <strong>{{ $student->total_points ?? 'Less subjects' }}</strong></td>
            </tr>
        </thead>
    </table>
</div>
