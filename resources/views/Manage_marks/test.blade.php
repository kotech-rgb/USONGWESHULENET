@php
    $title = 'Search Score';
@endphp

@extends('layouts.app')
@section('title',  $title)

<style>
    label {
        font-size: 0.8rem;
    }
    .card-custom {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }
    .table th {
        background-color: #f8f9fa;
    }
    .summary-box {
        background: #f8f9fa;
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 15px;
        border-left: 4px solid peru;
    }
</style>

@section('content')
@php
    $hasQueryParams = request()->has(['class_name', 'subject_name', 'type']);
@endphp

@if(!$hasQueryParams)
<div class="card card-custom p-3">
    <!-- <h5 class="mb-3 text-secondary"><i class="fa fa-search"></i> Search Scores</h5> -->
    <form method="GET" action="{{ route('test_index') }}" class="w-100">
        <div class="row g-3">
            <!-- Class Select -->
            <div class="col-md-3 col-sm-6">
                <div class="form-floating">
                    <select class="form-select select2" name="class_name" required>
                        <option value="" selected></option>
                        @if(Auth()->user()->role=="Teacher")
                       @foreach($Myclasses as $row)
                        <option value="{{ $row }}">{{ $row }}</option>
                        @endforeach
                        @else
                        @foreach($classes as $row)
                            <option value="{{ $row }}">{{ $row }}</option>
                        @endforeach
                        @endif
                    </select>
                    <label for="class_name">Class</label>
                </div>
            </div>

            <!-- Subject Select -->
            <div class="col-md-3 col-sm-6">
                <div class="form-floating">
                    <select class="form-select select2" name="subject_name" required>
                        <option value="" selected></option>
                        @if(Auth()->user()->role=="Teacher")
                        @foreach($MySubjects as $row)
                        <option value="{{ $row }}">{{ $row }}</option>
                        @endforeach
                        @else
                        @foreach($subjects as $row)
                            <option value="{{ $row->sub_name }}">{{ $row->sub_name }}</option>
                        @endforeach
                        @endif
                    </select>
                    <label for="subject_name">Subject</label>
                </div>
            </div>

            <!-- Type Select -->
            <div class="col-md-3 col-sm-6">
                <div class="form-floating">
                    <select class="form-select select2" name="type" required>
                        <option value="" selected></option>
                        <option value="test">Test</option>
                        <option value="exam">Exam</option>
                    </select>
                    <label for="type">Score type</label>
                </div>
            </div>

            <!-- Button -->
            <div class="col-md-2 col-sm-6">
                <button type="submit" class="btn btn-secondary w-100"> 
                    <i class="fa fa-search"></i> Search
                </button>
            </div>
        </div>
    </form>
</div>

@else
@if(count($tests) > 0)

<!-- Summary -->
<div class="summary-box">
    <strong>Subject:</strong> {{ request()->query('subject_name', 'No Subject Selected') }} <br>
    <strong>Class:</strong> {{ request()->query('class_name', 'No Class Selected') }}
</div>

<!-- Data Table -->
<div class="card card-custom p-3">
    <div class="table-responsive">
        <table id="example" class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Index</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Gender</th>
                    <th>Test 1</th>
                    <th>Test 2</th>
                    <th>Test 3</th>
                    <th>Test 4</th>
                    <th>Test 5</th>
                    <th>Average</th>
                    <th>Term</th>
                    <th>Year</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tests as $test)
                @php
                    $scores = [$test->test1, $test->test2, $test->test3, $test->test4, $test->test5];
                    $validScores = array_filter($scores, fn($score) => is_numeric($score));
                    $average = count($validScores) > 0 ? array_sum($validScores) / count($validScores) : 0;
                @endphp
                <tr>
                    <td><strong>{{$configs->school_reg}}.{{ str_pad($test->index_number, 4, '0', STR_PAD_LEFT) ?? 'N/A' }}</strong></td>
                    <td>{{ $test->firstname ?? 'N/A' }}</td>
                    <td>{{ $test->middlename ?? 'N/A' }}</td>
                    <td>{{ $test->lastname ?? 'N/A' }}</td>
                    <td>{{ $test->gender ?? 'N/A' }}</td>
                    <td>{{ $test->test1 ?? '-' }}</td>
                    <td>{{ $test->test2 ?? '-' }}</td>
                    <td>{{ $test->test3 ?? '-' }}</td>
                    <td>{{ $test->test4 ?? '-' }}</td>
                    <td>{{ $test->test5 ?? '-' }}</td>
                    <td>{{ number_format($average, 1) }}</td>
                    <td>{{ $test->termT ?? '-' }}</td>
                    <td>{{ $test->yearT ?? '-' }}</td>
                    <td>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#register-{{$test->id}}">
                            <i class="fa fa-pencil"></i> EDIT
                        </a>
                    </td>
                </tr>
                @include('Manage_marks.edit_test')
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@else
<div class="alert alert-warning">
    No data found. <a href="{{ url()->previous() }}" class="alert-link">Go back</a>
</div>
@endif
@endif
@endsection
