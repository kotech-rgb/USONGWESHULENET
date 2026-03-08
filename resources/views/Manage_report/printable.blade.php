
@php
function getBase64Data($path)
{
    return file_exists($path) ? base64_encode(file_get_contents($path)) : '';
}

$logoPath   = public_path($config->logo   ?? 'assets/img/nembo.jpg');
$sahihiMkuu = public_path($config->sahihi ?? 'assets/img/mkuu.png');

$logoBase64   = getBase64Data($logoPath);
$mkuu = getBase64Data($sahihiMkuu);

$logoExt   = pathinfo($logoPath, PATHINFO_EXTENSION);
$mkuuExt = pathinfo($sahihiMkuu, PATHINFO_EXTENSION);
 
@endphp

<div id="printArea" style="display:none;">
   {{-- Reports --}}
    @foreach($results as $student)
     @php
    $classTeacher = DB::table('teacher_classes')
    ->join('users', 'teacher_classes.teacher_id', '=', 'users.id')
    ->where('teacher_classes.class_id', $student->class_name)
    ->select('users.fname', 'users.mname', 'users.lname')
    ->first();
     @endphp
         <div class="page-break" style="border:solid; border-color: #007BFF; border-style: double; border-width: 7px; padding: 10px;"> 
                <div style="border: solid; padding: 4px;">

                <table style="border-collapse: collapse; border: none; width: 100%;">
                <tr>
                    <td style="border: none; width: 60px;">
                        <img src="data:image/{{ $logoExt }};base64,{{ $logoBase64 }}" alt="School Logo" class="school-logo" style="width:70px;">
                    </td>
                    <td style="border: none; text-align: center; padding: 10px;">
                        <h3 style="margin: 0; font-size: 15px; font-weight: bold;">
                            PRESIDENT'S OFFICE <br> REGIONAL ADMINISTRATION AND LOCAL GOVERNMENT
                        </h3>
                        <p style="margin: 4px 0; font-size: 14px;">
                            {{ $School_details->location }}
                        </p>
                        <p style="margin: 4px 0; font-size: 14px;">
                            {{ $School_details->school_name }} - {{ $School_details->school_reg }}
                        </p>
                        <p style="margin: 4px 0; font-size: 14px; font-weight: bold;">
                            {{ $School_details->report_head }}
                        </p>
                    </td>
                    <td style="border: none; text-align:center;">
                        {!! QrCode::size(80)->generate(
                            "Student: {$student->firstname} {$student->lastname}\n".
                            "Class: {$student->class_name}\n".
                            "Term: {$student->term}, Year: {$student->year}\n".
                            "Position: {$student->position}\n".
                            "Division: {$student->division}\n".
                            "Total Points: {$student->total_points}\n".
                            "Scores: {$student->score_details}"
                        ) !!}
                    </td>
                </tr>
         </table>
        <hr>
        <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 15px; width: fit-content; font-size: 14px;">
            <p style="margin: 4px 0;">
                <strong style="display: inline-block; width: 120px;">Jina:</strong>
                {{ strtoupper($student->firstname.' '.$student->middlename.' '.$student->lastname) }}
            </p>
            <p style="margin: 4px 0;">
                <strong style="display: inline-block; width: 120px;">Namba:</strong>
                {{ $School_details->school_reg }}.{{ str_pad($student->index_number, 4, '0', STR_PAD_LEFT) }}
            </p>
            <p style="margin: 4px 0;">
                <strong style="display: inline-block; width: 120px;">Darasa:</strong>
                {{ $student->class_name }}
            </p>
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
                        $teacherComment = '';
                    @endphp
                    @if(count($matches) === 4)
                        @php
                            $subject = $matches[1];
                            $score   = $matches[2];
                            $grade   = $matches[3];

                            $subjectData = $student->subject_positions[$subject] ?? null;
                            $pos = $subjectData['position'] ?? '-';
                            $totalInSubject = $subjectData['total'] ?? 0; 
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
                        @php
                            preg_match('/\(([A-F])\)/', $subjectDetail, $matches);
                            $gradeLetter = $matches[1] ?? null;
                        @endphp
                        <tr>
                            <td colspan="5" class="text-start">{{ trim($subjectDetail) }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        @php
        $teacherComment = match($student->division) {
        'I' => 'Amejitahidi sana',
        'II' => 'Amejitahidi aongeze bidii zaidi',
        'III' => 'Aongeze bidii anaweza',
        'IV' => 'Juhudi kubwa zinahitajika aweke juhudi sana',
        'O' => 'Juhudi kubwa zinahitajika aweke juhudi sana',
        default => 'Undefined comment',
    };
    $headComment = match($student->division) {
        'I' => 'Amejitahidi sana, Inaridhisha',
        'II' => 'Amejitahidi aongeze bidii zaidi,anaweza',
        'III' => 'Amejitahidi kawaida,juhudi zaidi zinahitajika',
        'IV' => 'Amefaulu,aongezee bidii zaidi',
        'O' => 'Amefeli! Maendeleo yake sio mazuri',
        default => 'Undefined comment',
    };
        @endphp

        {{-- Summary --}}
        <table style="width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 14px;">
            <thead>
                <tr>
                    <td colspan="2" style="padding: 8px; text-align: center; font-weight: bold; border: 1px solid #ccc;">
                        AMESHIKA NAFASI YA <strong style="color:#007BFF">{{ number_format($student->position) }}</strong> KATI YA WANAFUNZI 
                        <strong style="color:#007BFF">{{ number_format($totalStudentsInClass) }}</strong> KATIKA DARASA LAKE
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ccc; width: 50%; text-align: center;">
                        DIVISION: <strong>{{ $student->division }}</strong>
                    </td>

                    <td style="padding: 8px; border: 1px solid #ccc; width: 50%; text-align: center;">
                        POINTS: <strong>{{ $student->total_points ?? 'Less subjects' }}</strong>
                    </td>
                </tr>
            </thead>
        </table>

    <table style="border-collapse: collapse; width: 100%; margin-top: 10px; font-size: 12px;">
        <tr>
            <!-- Behaviours Section -->
            <td style="vertical-align: top; width: 50%; padding-right: 5px;">
                @php
                $behaviours = [
                    "Bidii ya Kazi","Mahudhulio darasani","Kutunza Mali za Shule","Utii kazini/darasani",
                    "Ushirikiano","Heshima kwa wote","Kumudu uongozi","Adabu","Kujua usafi Binafsi",
                    "Kukubali ushauri","Kuthamini kazi","Kujituma","Kushiriki Michezo"
                ];
                @endphp
                <table style="border-collapse: collapse; table-layout: auto; width: 100%;">
                    <thead>
                        <tr style="background: #e6f0ff; text-align: center; font-weight: bold;">
                            <th colspan="2" style="padding: 4px; border: 1px solid #ccc;">B: TABIA NA MWENENDO</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($behaviours as $subject)
                            <tr>
                                <td style="padding: 2px 4px; border: 1px solid #ccc;">{{ $subject }}</td>
                                <td style="padding: 2px 4px; border: 1px solid #ccc; text-align: center;">
                                    {{ ['A','B','C'][array_rand(['A','B','C'])] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>

            <!-- Grade Interpretation Section -->
            <td style="vertical-align: top; width: 50%; padding-left: 5px;">
                <table style="border-collapse: collapse; table-layout: auto; width: 100%;">
                    <thead>
                        <tr style="background: #e6f0ff; text-align: center; font-weight: bold;">
                            <th colspan="3" style="padding: 4px; border: 1px solid #ccc;">C: TAFSIRI YA VIWANGO VYA UFAULU</th>
                        </tr>
                        <tr style="background: #f2f2f2; text-align: center; font-weight: bold;">
                            <th style="padding: 3px; border: 1px solid #ccc;">ALAMA</th>
                            <th style="padding: 3px; border: 1px solid #ccc;">DARAJA</th>
                            <th style="padding: 3px; border: 1px solid #ccc;">MAELEZO</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $form = request()->query('class');
                            preg_match('/FORM\s+\w+/i', $form ?? '', $matches);
                            $baseForm = $matches[0] ?? '';
                            $level = in_array($baseForm, ['FORM FIVE','FORM SIX']) ? 'A-level' : 'O-level';
                            $grades = \DB::table('grades')->where('level', $level)->get();
                        @endphp
                        @foreach($grades as $row)
                            <tr>
                                <td style="padding: 2px 4px; border: 1px solid #ccc; text-align: center;">
                                    {{ $row->start_form . '-' . $row->end_to }}
                                </td>
                                <td style="padding: 2px 4px; border: 1px solid #ccc; text-align: center;">
                                    {{ $row->name }}
                                </td>
                                <td style="padding: 2px 4px; border: 1px solid #ccc;">
                                    @switch($row->name)
                                        @case('A') Nzuri Sana @break
                                        @case('B') Nzuri @break
                                        @case('C') Kawaida, Aongeze Bidii @break
                                        @case('D') Dhaifu, Amefeli @break
                                        @case('E') Dhaifu, Amefeli @break
                                        @case('S') Dhaifu Sana @break
                                        @case('F') Dhaifu Sana @break
                                        @default Undefined
                                    @endswitch
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
        </tr>
    </table>




<div style="font-size: 12px; line-height: 1.3; margin-top: 15px; width: 100%;">

    <!-- School closure info -->
    <p style="margin: 4px 0; text-align: center;">
        SHULE IMEFUNGA LEO TAREHE 
        <u style="text-decoration-style: dotted; padding: 0 4px;">{{ $School_details->close_school }}</u>
        NA ITAFUNGULIWA TAREHE 
        <u style="text-decoration-style: dotted; padding: 0 4px;">{{ $School_details->open_school }}</u>
    </p>

    <!-- Comments Section -->
    <table style="width: 100%; border-collapse: collapse; margin-top: 5px;">
        <tr>
            <!-- Teacher Comment -->
            <td style="width: 50%; vertical-align: top; padding-right: 10px;">
                <p style="margin: 2px 0;">Maoni ya mwalimu wa darasa:
                    <u style="text-decoration-style: dotted; padding: 0 4px;">{{ $teacherComment }}</u>
                    <br>
                @if($classTeacher)
                  JINA :<strong>{{ strtoupper($classTeacher->fname.' '.$classTeacher->mname.' '.$classTeacher->lname) }}</strong>
                @else
                    JINA : <strong>Not Assigned</strong>
                @endif
                </p>
            </td>

            <td style="width: 50%; vertical-align: top; padding-left: 10px;">
                <table>
                    <tr>
                        <td colspan="2">Maoni ya mkuu wa shule <u style="text-decoration-style: dotted; padding: 0 4px;">{{ $headComment }}</u></td>
                    </tr>
                    <tr>
                        <td>JINA : <strong>{{ $School_details->headmaster_name }}</strong></td>
                        <td style="text-align:center;">Sahihi: <img src="data:image/{{ $mkuuExt }};base64,{{ $mkuu }}" alt="School Logo" class="school-logo" style="height: 20px; display: block; margin-top: 2px; text-align: center; width: 50%;"></td>
                    </tr>
                </table>
            </td>    
        </tr>
    </table>
  </div>
</div>


</div>
    @endforeach
</div>

