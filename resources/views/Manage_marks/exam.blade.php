@php
    $title = 'Exam Score';
@endphp

@extends('layouts.app')
@section('title', 'Exam Score')

<style>
  label{
    font-size: 0.8rem;
  }
</style>
 
@section('content')
@php
    $hasQueryParams = request()->has(['class_name', 'subject_name', 'type']);
@endphp

@if(!$hasQueryParams)
<form method="GET" action="{{ route('test_index') }}">
     <div class="row g-2 ms-2 mt-2 align-items-end">
    <!-- Class Select -->
    <div class="col-md-2">
        <div class="form-floating">
            <select class="form-select select2" name="class_name" required>
                <option value="" selected></option>
                 @if(Auth()->user()->role=="Teacher") 
                    @foreach($Myclasses->pluck('class')->unique() as $row)
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
    <div class="col-md-3">
        <div class="form-floating">
            <select class="form-select" name="subject_name" required>
                <option value="" selected></option>
                 @if(Auth()->user()->role=="Teacher")
                    @foreach($Myclasses->pluck('subject')->unique() as $row)
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
    <div class="col-md-2">
        <div class="form-floating">
            <select class="form-select" name="type" required>
                <option value="" selected></option>
                <option value="test">Test</option>
                <option value="exam">Exam</option>
            </select>
            <label for="type">Score type</label>
        </div>
    </div>

    <!-- Button -->
    <div class="col-md-2">
        <button type="submit" class="btn btn-secondary"> <i class="fa fa-search"></i> Search</button>
    </div>
</div>

 </form>

@else
@if(count($exam) > 0)
<p style="display: grid; grid-template-columns: max-content auto; gap: 4px 10px; max-width: 300px;">
  <span>Subject:</span>
  <strong>{{ request()->query('subject_name', 'No Subject Selected') }}</strong>
  
  <span>Class:</span>
  <strong>{{ request()->query('class_name', 'No Subject Selected') }}</strong>
</p>


  <div class="table-responsive">
    <table id="example" class="table table-bordered table-sm">
      <thead>
        <tr>
            <th>Index</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Gender</th>
            <th>Tests</th>
            <th>Exam</th>
            <th>Average</th>
            <th>Term</th>
            <th>Year</th>
            <th>Action</th>
        </tr>
	    </thead>
	    <tbody>
	    	@foreach($exam as $student)
	            <tr>
	                <td><strong>{{$configs->school_reg}}.{{ str_pad($student->index_number, 4, '0', STR_PAD_LEFT) ?? 'N/A' }}</strong></td>
	                <td>{{ $student->firstname }}</td>
	                <td>{{ $student->middlename }}</td>
	                <td>{{ $student->lastname }}</td>
	                <td>{{ $student->gender }}</td>
                    <td>{{ $student->test }}</td>
	                <td>{{ $student->score }}</td>
	                <td>{{ $student->total_average }}</td>
	                <td>{{ $student->termE }}</td>
	                <td>{{ $student->yearE }}</td>
	                <td>
		              <a href="#" data-bs-toggle="modal" data-bs-target="#register-{{$student->id}}" class="text-decoration-none" ><i class="fa fa-pencil"></i> EDIT</a>
		            </td>
	            </tr>
	            @include('Manage_marks.edit_exam')
	        @endforeach
	    </tbody>
	    </table>
  </div>
@else
  <a href="{{ url()->previous() }}" class="text-danger">No data found, click here to go back</a>
@endif

@endif
@endsection