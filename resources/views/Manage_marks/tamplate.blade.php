@php
    $title = 'Templates';
@endphp

    <!-- Auto-refresh every 30 seconds -->
    <!-- <meta http-equiv="refresh" content="30"> -->
@extends('layouts.app')
@section('title', 'Templates Load')

@section('content')
<div class="row g-4 mb-3">
    <div class="col-12">
        <div class="template-container">
            <h2>Download score sheet *</h2><br>
            <form method="GET" action="{{ route('tamplate_index') }}">
                <div class="row g-2 align-items-end">
                    
                    <!-- Class Select -->
                    <div class="col-md-3 col-sm-6 mb-3">
                        <label for="class_name">Choose class</label>
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
                            
                        </div>
                    </div>

                    <!-- Subject Select -->
                    <div class="col-md-4 col-sm-6 mb-3">
                        <label for="subject_name">Choose subject</label>
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
                            
                        </div>
                    </div>

                    <!-- Type Select -->
                    <div class="col-md-3 col-sm-6 mb-3">
                          <label for="type">Template Type</label>
                        <div class="form-floating">
                            <select class="form-select select2" name="type" required>
                                <option value="" selected></option>
                                <option value="test">Test score sheet</option>
                                <option value="exam">Exam score sheet</option>
                            </select>
                          
                        </div>
                    </div>

                    <!-- Button -->
                    <div class="col-md-2 col-sm-6 mb-3">
                        <button class="btn btn-dark">Download <i class="fa fa-download"></i></button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection
