@extends('layouts.app')
@section('title', 'Student Subjects')

@section('content')
<style>
    .table-sm td { vertical-align: top !important; padding: 0.4rem !important; }
    
    /* Micro Subject Card */
    .sub-item-card {
        background: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        padding: 5px;
        margin-bottom: 5px;
        height: 100%;
        border-left: 3px solid #dee2e6;
        transition: all 0.2s;
    }

    /* Highlight card when checked */
    .sub-item-card:has(.sub-check:checked) {
        border-left-color: black;
        background-color: #f8f9ff;
        border-color: #FFC014;
    }

    .sub-name-label {
        font-size: 10px;
        font-weight: 700;
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 2px;
        cursor: pointer;
        color: #333;
    }

    .status-select-micro {
        font-size: 9px;
        height: 22px;
        padding: 0 2px;
        width: 100%;
        border-radius: 2px;
        background-color: #6c757d; /* Darkgray */
        font-weight: bold;
        color: white;
        cursor: pointer;
    }

    .sub-check {
        width: 13px;
        height: 13px;
        cursor: pointer;
    }
    
    
</style>

<div class="row g-3 mb-3">
  <div class="col-12">
    <div class="shadow-sm rounded p-3 bg-white border">

        <div class="col-md-5 mb-3"> {{-- Increased column width slightly to fit both buttons --}}
    <form method="GET" action="{{ route('student_subject_index') }}">
        <div class="input-group">
            <select class="form-select form-select-sm select2" name="class_name">
                <option value="">[ Select Class ]</option>
                @foreach($C as $row)
                    <option value="{{ $row->name }}" {{ request('class_name') == $row->name ? 'selected' : '' }}>
                        {{ $row->name }}
                    </option>
                @endforeach
            </select>
            
            <button type="submit" class="btn btn-dark btn-sm px-3">
                <i class="fa fa-search"></i> Search
            </button>

            @if(request()->filled('class_name'))
                <a href="{{ route('student_subject_index') }}" class="btn btn-outline-danger btn-sm px-3">
                    <i class="fa fa-refresh"></i> Go Back
                </a>
            @endif
        </div>
    </form>
</div>
        
        @if(count($C) > 0 && count($S) > 0)
        <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead class="table-dark small text-center">
                <tr>
                    <th>CLASS LEVEL</th>
                    <th>CHOOSE SUBJECTS UNDER TAKEN</th>
                </tr>
            </thead>
            <tbody>
                @foreach($C as $row)
                <tr>
                    <td class="text-center align-middle">
                        <h2 style="font-size: 1.2rem; margin-top: 12vh; font-weight: bold;">{{ $row->name }}</h2>
                    </td>
                    <td class="p-2">
                        {{-- Use class name as the route parameter --}}
                        <form method="POST" action="{{ route('student_subject.update', $row->name) }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="row g-1">
                               @foreach($S as $subject)
							    @php
							        // Create the unique key for this specific pair
							        $key = $row->name . '-' . $subject->sub_name;
							        
							        // 1. Check if the subject is assigned to this class
							        $isChecked = array_key_exists($key, $E);
							        
							        // 2. Get the ACTUAL status from our associative array
							        // If it exists in $E and the value is 'optional', then it's optional
							        $currentStatus = $isChecked ? $E[$key] : 'core'; 
							        $safeId = str_replace([' ', '/', '.'], '_', $row->name . $subject->sub_name);
							    @endphp

							    <div class="col-md-2 col-sm-4 col-6">
							        <div class="sub-item-card">
							            <div class="d-flex align-items-start gap-1">
							                <input type="checkbox" 
							                       class="form-check-input sub-check"
							                       name="subjects[{{ $subject->sub_name }}][selected]" 
							                       value="1"
							                       id="chk_{{ $safeId }}"
							                       {{ $isChecked ? 'checked' : '' }}>
							                
							                <div class="flex-grow-1 overflow-hidden">
							                    <label class="sub-name-label" for="chk_{{ $safeId }}">
							                        {{ $subject->sub_name }}
							                    </label>
							                    
							                    <select name="subjects[{{ $subject->sub_name }}][status]" class="form-select status-select-micro border-0">
							                        {{-- This now pulls the REAL status from the database --}}
							                        <option value="core" {{ $currentStatus == 'core' ? 'selected' : '' }}>CORE</option>
							                        <option value="optional" {{ $currentStatus == 'optional' ? 'selected' : '' }}>OPTIONAL</option>
							                    </select>
							                </div>
							            </div>
							        </div>
							    </div>
							@endforeach
                            </div>
                            <div class="mt-2 text-end border-top p-2 bg-light rounded">
                                <button type="submit" class="btn btn-dark">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        @endif
    </div>
  </div>
</div>
@endsection