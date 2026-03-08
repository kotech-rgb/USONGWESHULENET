@php
    $title = 'Templates';
@endphp

    <!-- Auto-refresh every 30 seconds -->
    <!-- <meta http-equiv="refresh" content="30"> -->
@extends('layouts.app')
@section('title', 'Templates Load')

<style>
    label {
        font-size: 0.8rem;
    }
    .template-container {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        padding: 15px;
    }
    .template-container h6 {
        color: peru;
        font-size: 0.9rem;
        font-weight: bold;
    }
    .form-floating label {
        font-size: 0.75rem;
    }
    .btn-dark {
        background: #333;
        border: none;
    }
    .btn-dark:hover {
        background: #555;
    }
</style>

@section('content')
<div class="row g-4 mb-3">
    <div class="col-12">
        <div class="template-container">
            <h6>Download score sheet *</h6>
            <form method="GET" action="{{ route('tamplate_index') }}">
                <div class="row g-2 align-items-end">
                    
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
                            <label for="class_name">Choose class</label>
                        </div>
                    </div>

                    <!-- Subject Select -->
                    <div class="col-md-4 col-sm-6">
                        <div class="form-floating">
                            <select class="form-select select2" name="subject_name" required>
                                <option value="" selected></option>
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
                            <label for="subject_name">Choose subject</label>
                        </div>
                    </div>

                    <!-- Type Select -->
                    <div class="col-md-3 col-sm-6">
                        <div class="form-floating">
                            <select class="form-select select2" name="type" required>
                                <option value="" selected></option>
                                <option value="test">Test score sheet</option>
                                <option value="exam">Exam score sheet</option>
                            </select>
                            <label for="type">Template Type</label>
                        </div>
                    </div>

                    <!-- Button -->
                    <div class="col-md-2 col-sm-6">
                        <button class="btn btn-secondary">Download <i class="fa fa-download"></i></button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection
