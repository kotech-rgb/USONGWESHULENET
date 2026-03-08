@php
    $title = 'Configuration';
    $termName = \DB::table('terms')->where('status', 'active')->value('term_name');
    $yearName = \DB::table('years')->where('status', 'active')->value('year_name');
    $School_details = \DB::table('configurations')->first();
    $currentYear = date('Y');
@endphp

@extends('layouts.app')
@section('title', $title)

<style>
  label{
    font-size: 0.8rem;
  }
</style>

@section('content')

<div class="card-body shadow-sm p-1 mb-3">
    <form method="GET" action="{{ route('configuration.index') }}">
        <div class="row mb-3">
            <div class="col-md-4 col-12">
                <label>School Name</label>
                <input type="text" class="form-control" value="{{ $School_details->school_name }}" name="shule">
            </div>

            <div class="col-md-4 col-12">
                <label>Registration Number</label>
                <input type="text" class="form-control" value="{{ $School_details->school_reg }}" name="reg_number">
            </div>  

            <div class="col-md-4 col-12">
                <label>Location</label>
                <input type="text" class="form-control" value="{{ $School_details->location }}" name="mahali">
            </div>  
        </div>

        <div class="row">
            <div class="col-md-4 col-12">
                <label>Address</label>
                <input type="text" class="form-control" value="{{ $School_details->box }}" name="anuani">
            </div>  

            <div class="col-4">
                <label>Active Year</label>
                <select class="form-control" name="year">
                    <option value="{{ $currentYear }}" {{ $yearName == $currentYear ? 'selected' : '' }}>
                        {{ $currentYear }}
                    </option>  
                </select>
            </div>  

            <div class="col-4 mb-3">
                <label>Active Term</label>
                <select class="form-control" name="term">
                    <option value="{{ $termName }}">{{ $termName }}</option>  
                    @foreach(\DB::table('terms')->get() as $term)
                        <option value="{{ $term->term_name }}" {{ request('term') == $term->term_name ? 'selected' : '' }}>
                            {{ $term->term_name }}
                        </option>
                    @endforeach
                </select>
            </div>  
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label>Headmaster/Headministres</label>
                <input type="text" class="form-control" value="{{ $School_details->headmaster_name }}" name="headmaster_name">
            </div>
            <div class="col-md-4">
                <label>Closing school date</label>
                <input type="text" class="form-control" value="{{ $School_details->close_school }}" name="close_school">
            </div>
             <div class="col-md-4">
                <label>Opening school date</label>
                <input type="text" class="form-control" value="{{ $School_details->open_school }}" name="open_school">
            </div>
        </div>
        
         <div class="row mb-3">
            <div class="col-md-6">
                <label>Report Head</label>
                <input type="text" name="report_head" value="{{ $School_details->report_head }}" class="form-control" value="{{ $School_details->headmaster_name }}" name="headmaster_name">
            </div>
            <div class="col-md-6">
                <label>SMS Tamplate</label>
                <textarea name="sms_temp" style="width:100%; text-align:left">{{ $School_details->sms_temp }}</textarea>
            </div>
            
        </div>
        <button type="submit" class="btn btn-sm btn-primary">Save changes</button>
    </form>
</div>

@endsection
