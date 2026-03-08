@php
    $title = 'Upload';
@endphp

@extends('layouts.app')
@section('title', 'Upload Marks')

<style>
    label {
        font-size: 0.8rem;
    }
</style>

@section('content')
<div class="card-body shadow-sm p-2 border rounded">
<form method="POST" action="{{ route('upload_save') }}" enctype="multipart/form-data" class="w-100">
    @csrf
    <div class="row g-2 ms-0 mt-2 align-items-end"> 
     <h6 style="font-size:0.8rem; color: peru;">Upload marks Score here  *</h6>        
        <!-- Class Select -->
        <div class="col-md-2 col-sm-6">
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
        <div class="col-md-2 col-sm-6">
            <div class="form-floating">
                <select class="form-select select2" name="type" required>
                    <option value="" selected></option>
                    <option value="test">Test Marks</option>
                    <option value="exam">Exam Marks</option>
                </select>
                <label for="type">Type</label>
            </div>
        </div>

        <!-- File Input -->
        <div class="col-md-3 col-sm-6">
        <label class="text-danger" for="type">Click here to upload *</label>
        <input type="file" class="form-control" accept=".xls,.xlsx" name="file" required>
        </div>

        <!-- Button -->
        <div class="col-md-2 col-sm-6">
            <button type="submit" class="btn btn-secondary w-100"> Save Scores</button>
        </div>
    </div>
</form>
</div>
@endsection
