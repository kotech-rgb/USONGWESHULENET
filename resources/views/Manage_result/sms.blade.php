@php
    $title = 'Send SMS';
    $termName = \DB::table('terms')->where('status', 'active')->value('term_name');
    $yearName = \DB::table('years')->where('status', 'active')->value('year_name');
    $activeYear = ($yearName - 1) . '/' . $yearName;
    $School_details = \DB::table('configurations')->first();
@endphp

@extends('layouts.app')
@section('title', 'Send SMS')

<style>
  label{
    font-size: 0.8rem;
  }
</style>

@section('content')
@php
    $hasQueryParams = request()->has(['class_name']);
@endphp

@if(!$hasQueryParams)
<form method="GET" action="{{ route('sms.index') }}" class="shadow-sm p-2">
	<input type="hidden" name="year" value="{{ $yearName }}">
    <input type="hidden" name="semester" value="{{ $termName }}">
    <div class="row g-2 ms-2 mt-2 align-items-end">
        <!-- Class Select -->
        <div class="col-md-3">
            <div class="form-floating">
                <select class="form-select select2" name="class_name" required>
                    <option value="" selected></option>
                    @foreach($classes as $row)
                        <option value="{{ $row }}">{{ $row }}</option>
                    @endforeach
                </select>
                <label for="class_name">Select class</label>
            </div>
        </div>

        <!-- Button -->
        <div class="col-md-2">
            <button type="submit" class="btn btn-secondary btn-sm"> <i class="fa fa-search"></i> Search</button>
        </div>
    </div>
</form>

@else
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0">
            Sending Results SMS for Class:
            <span class="fw-bold">{{ request()->query('class_name', 'No Subject Selected') }}</span>
        </h6>
        <small>{{ now()->format('F j, Y') }}</small>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('sms.send') }}">
            @csrf
            <input type="hidden" name="year" value="{{ $yearName }}">
            <input type="hidden" name="semester" value="{{ $termName }}">
            <input type="h" name="class_name" value="{{ request()->query('class_name') }}">
            <!-- Select All Checkbox -->
            <div class="form-check mb-3">
                <input type="checkbox" id="selectAll" class="form-check-input">
                <label for="selectAll" class="form-check-label fw-semibold">
                    Select All Students
                </label>
            </div>

            <!-- Students List -->
            @foreach($students as $row)
                <div class="border rounded-3 p-3 mb-2 d-flex align-items-center justify-content-between student-item
                    {{ $row->sms ? 'bg-light' : 'bg-white' }}">
                    
                    <div class="form-check">
                        @if($row->sms==NULL)
                            <input class="form-check-input" type="checkbox" name="selected_students[]" value="{{ $row->id }}">
                            <label class="form-check-label fw-bold">
                              {{ $row->firstname.' '.$row->middlename.' '.$row->lastname }} ({{ $row->gender }})
                            </label>
                        @else
                            
                            <label class="ms-2 fw-bold text-muted">
                                {{ str_pad($row->student_id, 4, '0', STR_PAD_LEFT) }} - {{ $row->firstname.' '.$row->middlename.' '.$row->lastname }} ({{ $row->gender }})
                            </label>
                        @endif
                    </div>

                    <div class="text-end">
                        <small class="text-muted">{{ $row->phone }}</small><br>
                        @if($row->sms==NULL)
                            <span class="text-danger fw-semibold">Not Sent</span>
                        @else
                            <span class="text-success fw-semibold">Sent</span>
                        @endif
                    </div>
                </div>
            @endforeach
            <!-- Send Button -->
            <!--<div class="mt-4">-->
            <!--    <button type="submit" class="btn btn-success btn-sm px-4">Send SMS</button>-->
            <!--</div>-->
            <button type="submit" class="btn btn-success btn-lg px-4 float-end"  onclick="this.disabled=true; this.form.submit();">CLICK TO SEND SMS</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('selectAll').addEventListener('click', function() {
        let checkboxes = document.querySelectorAll('input[name="selected_students[]"]');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });
</script>

    @endif
    <script>
    document.getElementById("selectAll").addEventListener("change", function() {
        let checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });
</script>

@endsection
