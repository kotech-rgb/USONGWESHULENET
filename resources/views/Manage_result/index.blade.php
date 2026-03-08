@extends('layouts.app')

@section('title', 'Result Preview')

@section('content')
<div class="container-fluid mt-3">

    @php
        $hasQueryParams = request()->has('class_name');
    @endphp

    {{-- Class selection form --}}
    @if(!$hasQueryParams)
        <div class="custom-card shadow-sm p-2 border rounded">
            <form method="GET" action="{{ route('result_index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <div class="form-floating">
                            <select class="form-select select2" name="class_name" required>
                                <option value="" selected></option>
                                <!--@foreach($classes as $row)-->
                                <!--    <option value="{{ $row }}">{{ $row }}</option>-->
                                <!--@endforeach-->
                                <option value="FORM ONE">FORM ONE</option>
                                <option value="FORM TWO">FORM TWO</option>
                                <option value="FORM THREE">FORM THREE</option>
                                <option value="FORM FOUR">FORM FOUR</option>
                                <option value="FORM FIVE">FORM FIVE</option>
                                <option value="FORM SIX">FORM SIX</option>
                                <option value="FORM FOUR GRDADUATE">FORM FOUR GRDADUATE</option>
                                <option value="FORM SIX GRADUATE">FORM SIX GRADUATE</option>
                            </select>
                            <label for="class_name">Select Class</label>
                        </div>
                    </div>
                   @php
                        $years = \App\Models\Year::orderBy('year_name', 'desc')->get();
                        $terms = \App\Models\Term::orderBy('term_name')->get();
                    @endphp
                    <div class="col-md-3">
                        <div class="form-floating">
                            <select class="form-select select2" name="academic_year" required>
                                @foreach($years as $year)
                                    <option value="{{ $year->year_name }}">
                                        {{ $year->year_name }}
                                    </option>
                                @endforeach
                    
                            </select>
                            <label>Academic Year</label>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-floating">
                            <select class="form-select select2" name="term" required>
                                @foreach($terms as $t)
                                    <option value="{{ $t->term_name }}">
                                        {{ $t->term_name }}
                                    </option>
                                @endforeach
                    
                            </select>
                            <label>Select term</label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-search"></i> Search
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endif
    
    @if($hasQueryParams)

        {{-- Print Button --}}
        <div class="mb-3">
        <button class="btn btn-outline-secondary btn-sm" onclick="printReport()"><i class="fa fa-print"></i> Print</button>
        </div>
        @php
        $logoPath = public_path($config->logo ?? 'assets/img/nembo.jpg');
        $logoBase64 = file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : '';
        $logoExt = pathinfo($logoPath, PATHINFO_EXTENSION);
        @endphp

        <div class="card-body shadow-sm border-1 p-2">
        {{-- Report Header --}}
        <div class="report-header text-center mb-4">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <!-- Left: School Logo -->
            <div style="flex:1; text-align:left;">
                <img src="data:image/{{ $logoExt }};base64,{{ $logoBase64 }}" alt="School Logo" class="school-logo" style="width:70px;">
            </div>
            <!-- Center: School Info -->
            <div style="flex:3; text-align:center;">
                <h5 style="font-weight: bold;">
                PRESIDENT'S OFFICE- REGIONAL ADMINISTRATION AND LOCAL GOVERNMENT<br>
                {{ $School_details->location }}<br>
                {{ $School_details->school_name.'-'.$School_details->school_reg }}<br>
                {{ $School_details->report_head }}-{{ request()->get('class_name') ?? '' }} 
                </h5>
            </div>
            <div style="flex:1; text-align:right;">
                <img src="data:image/{{ $logoExt }};base64,{{ $logoBase64 }}" alt="School Logo" class="school-logo" style="width:70px;">
            </div>
        </div>
        </div>
        {{-- Division Summary --}}
        <div class="mb-3" style="width:50%;">
            <table class="table table-bordered table-sm text-center necta-table">
                <thead>
                    <tr>
                        <th style="background-color:#f2f2f2;" colspan="7">DIVISION PERFORMANCE SUMMARY</th>
                    </tr>
                    <tr>
                        <th>SEX</th>
                        <th>DIV I</th>
                        <th>DIV II</th>
                        <th>DIV III</th>
                        <th>DIV IV</th>
                        <th>DIV O</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(['F','M','T'] as $sex)
                        <tr>
                            <td><strong>{{ $sex }}</strong></td>
                            @foreach($allowedDivisions as $div)
                                <td>{{ $divisionSummary[$sex][$div] ?? 0 }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>






        {{-- Student Results --}}
        <div class="table-responsive mb-4" style="margin-top: 10px;">
            <table class="table table-bordered table-sm necta-table printableTable">
                <thead>
                    <tr>
                        <th colspan="11">STUDENT RESULTS SUMMARY</th>
                    </tr>
                    <tr>
                        <th>INDEX</th>
                        <th>NAME</th>
                        <th>SEX</th>
                        <th>STREAM</th>
                        <th>SUBJECTS & GRADES</th>
                        <th>AVG</th>
                        <th>GRADE</th>
                        <th>POINTS</th>
                        <th>DIV</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sortedResults as $st)
                        <tr>
                            <td>{{ str_pad($st['indexNO'],4,'0',STR_PAD_LEFT) }}</td>
                            <td>{{ $st['fullname'] }}</td>
                            <td class="text-center">{{ $st['gender'] }}</td>
                            <td class="text-center">
                            {{ preg_replace('/FORM\s+(ONE|TWO|THREE|FOUR|FIVE|SIX)\s*/i', '', $st['stream']) }}
                            </td>
                            <td style="text-align:left;">{{ $st['subjects'] }}</td>
                            <td>{{ $st['average_score'] }}</td>
                            <td>{{ $st['average_grade'] }}</td>
                            <td>{{ $st['total_points'] ?? '-' }}</td>
                            <td>{{ $st['division'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>



 {{-- Students Summary --}}
<div class="mb-3" style="width:70%; margin-top:10px;">
    <table class="table table-bordered table-sm text-center necta-table">
        <thead>
            <tr>
                <th style="background-color:#e6ffe6;" colspan="9">EXAMINATION DIVISION PERFORMANCE</th>
            </tr>
            <tr>
                <th>REGIST</th>
                <th>ABSENT</th>
                <th>SAT</th>
                <th>CLEAN</th>
                <th>DIV-I</th>
                <th>DIV-II</th>
                <th>DIV-III</th>
                <th>DIV-IV</th>
                <th>DIV-0</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $WanafnziSummary['Registered'] }}</td>
                <td>{{ $WanafnziSummary['ABSENT'] }}</td>
                <td>{{ $WanafnziSummary['SAT'] }}</td>
                <td>{{ $WanafnziSummary['SAT'] - $WanafnziSummary['DIV-0'] - $WanafnziSummary['INC'] }}</td>
                <td>{{ $WanafnziSummary['DIV-I'] }}</td>
                <td>{{ $WanafnziSummary['DIV-II'] }}</td>
                <td>{{ $WanafnziSummary['DIV-III'] }}</td>
                <td>{{ $WanafnziSummary['DIV-IV'] }}</td>
                <td>{{ $WanafnziSummary['DIV-0'] }}</td>
            </tr>
        </tbody>
    </table>
</div>

<table class="table table-bordered table-sm necta-table printableTable" style="margin-top:15px;">
    <thead>
        <tr>
          <th style="background-color:#e6f0ff;" colspan="15">EXAMINATION SUBJECTS PERFORMANCE</th>  
        </tr>
        <tr>
            <th>SUBJECT NAME</th>
            <th>SAT</th>
            @foreach($subjectSummary[array_key_first($subjectSummary)]['grades_count'] as $grade => $count)
            <th>{{ $grade }}</th>
            @endforeach
            <th>SCORE</th>
            <th>GRADE</th>
            <th>GPA</th>
            <th>PASS</th>
            <th>POSTION</th>
            <th>COMPETENCY LEVEL</th>
        </tr>
    </thead>
    <tbody>
        @foreach($subjectSummary as $sub_name => $summary)
            <tr>
                <td style="text-align:left;">{{ $sub_name }}</td>
                <td>{{ $summary['SAT'] }}</td>
                @foreach($summary['grades_count'] as $count)
                    <td>{{ $count }}</td>
                @endforeach
                <td>{{ $summary['average_score'] }}</td>
                 <td>{{ $summary['average_grade'] }}</td>
                <td>{{ number_format($summary['average_gpa'], 4) }}</td>
                <td>{{ $summary['total_pass'] }}</td>
                <td>{{ $summary['position'] }}</td>
                <td style="background-color: {{ $summary['bg'] }}">
                  {{ $summary['remark'] }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>


    </div>
    @endif
</div>

{{-- Styles --}}
<style>
.necta-table { border-collapse: collapse; width: 100%; }
.necta-table th, .necta-table td { border: 1px solid #333; padding: 2px 6px; font-size: 0.6rem; }
.necta-table thead th { font-weight: bold; }
.necta-table tbody tr:nth-child(even) { background-color: #f8f8f8; }

.report-header { 
    border-bottom: 2px solid #333; 
    padding-bottom: 10px; 
    margin-bottom: 20px; 
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
}

@media print {
    button { display: none; }
    .page-break { page-break-after: always; }
    .report-header img { height: 80px; }
    .report-header h3, .report-header p { margin: 0; }
    table td, table th {
        -webkit-print-color-adjust: exact; /* Chrome/Safari */
        print-color-adjust: exact; /* Firefox */
    }
}
</style>

{{-- Print Script --}}
<script>
function printReport() {
    const printContent = document.querySelector('.container-fluid').innerHTML;
    const printWindow = window.open('', '', 'height=800,width=1200');
    printWindow.document.write(`
        <html>
        <head>
            <title>Print Report</title>
            <style>
                body { font-family: Arial, sans-serif; font-size: 12px; }
                table { border-collapse: collapse; width: 100%; }
                table, th, td { border: 1px solid #333; }
                th, td { padding: 4px; text-align: center; font-size: 0.7rem; }
                thead th { font-weight: bold; }
                tr:nth-child(even) { background-color: #f8f8f8; }
                .report-header { border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
                .report-header img { height: 80px; }
                .report-header h3, .report-header p { margin: 0; }
                @media print {
                    button { display: none; }
                    .page-break { page-break-after: always; }
                }
            </style>
        </head>
        <body>
            ${printContent}
        </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    printWindow.close();
}
</script>
@endsection
