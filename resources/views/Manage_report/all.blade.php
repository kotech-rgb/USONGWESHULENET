@php
    $title = 'Student Report';
    $School_details = \DB::table('configurations')->first();
    $hasQueryParams = request()->has(['class','year','term']);
    $terms = \DB::table('terms')->get();
    $years = \DB::table('years')->get();
@endphp

@extends('layouts.app')
@section('title', $title)

@section('content')

{{-- ================== FILTER FORM (Initial Search) ================== --}}
@if(!$hasQueryParams)
    <div class="mb-3 p-3 shadow-sm rounded border-2">
        <form action="{{ route('report.allStudentsReport') }}" method="GET" class="row g-3">
            {{-- Term --}}
            <div class="col-md-4">
                <label class="form-label"><strong>Term</strong></label>
                <select name="term" class="form-select" required>
                    <option value=""></option>
                    @foreach($terms as $term)
                        <option value="{{ $term->term_name }}" {{ (isset($termName) && $termName == $term->term_name) ? 'selected' : '' }}>
                            {{ $term->term_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Year --}}
            <div class="col-md-4">
                <label class="form-label"><strong>Year</strong></label>
                <select name="year" class="form-select" required>
                    <option value=""></option>
                    @foreach($years as $year)
                        <option value="{{ $year->year_name }}" {{ (isset($yearName) && $yearName == $year->year_name) ? 'selected' : '' }}>
                            {{ $year->year_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Class --}}
            <div class="col-md-4">
                <label class="form-label"><strong>Class</strong></label>
                <select name="class" class="form-select select2" required>
                    <option value="">-</option>
                    @foreach($classes as $row)
                        <option value="{{ $row }}" {{ (isset($className) && $className == $row) ? 'selected' : '' }}>
                            {{ $row }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Submit --}}
            <div class="col-12 text-end mt-2">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
    </div>

{{-- ================== RESULTS + EXTRA SEARCH ================== --}}
@else

    {{-- Student Search Bar --}}
    <div class="mb-3 p-3 shadow-sm rounded border">
        <form method="GET" action="{{ route('report.allStudentsReport') }}" class="row g-2 align-items-center">
            {{-- keep existing filters --}}
            <input type="hidden" name="term" value="{{ request('term') }}">
            <input type="hidden" name="year" value="{{ request('year') }}">
            <input type="hidden" name="class" value="{{ request('class') }}">

            <div class="col-md-9">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       class="form-control" 
                       placeholder="Search student by Firstname, Middlename or Lastname">
            </div>

            <div class="col-md-3 text-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fa fa-search"></i> Search
                </button>
            </div>
        </form>
    </div>

    {{-- Card Container --}}
    <div class="row align-items-center mb-4 shadow-card">
        
        {{-- Print Button --}}
        <div class="col-12 d-flex mb-3">
            <button onclick="printTable()" class="btn btn-sm btn-outline-dark"><i class="fa fa-print"></i> Print Reports</button>
        </div>

        {{-- Report Card --}}
        @include('Manage_report.report_card')


         {{-- Pagination --}}
        <div class="col-12 d-flex justify-content-center" id="myContainer">
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-rounded shadow-sm">
                    {{ $results->links('pagination::bootstrap-5') }}
                </ul>
            </nav>
        </div>
    </div>

    {{-- Print Layout --}}
    @include('Manage_report.printable')
    @include('Manage_report.printScript')

@endif
@endsection


{{-- ================== CUSTOM STYLES ================== --}}
<style>
    .pagination li.active span {
        position: relative;
        padding: 8px 14px;
        border-radius: 8px;
        z-index: 1;
        color: #d00;
        font-weight: 600;
        background-color: #fff;
        overflow: hidden;
    }

    /* Animated rotating border */
    .pagination li.active span::after {
        content: "";
        position: absolute;
        inset: 0;
        border: 2px solid red;
        border-radius: 10px;
        box-sizing: border-box;
        z-index: -1;
        animation: spin 1.5s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Card Styling */
    .shadow-card {
        background: linear-gradient(145deg, #ffffff, #f7f7f7);
        border-radius: 15px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.08), 0 6px 6px rgba(0,0,0,0.05);
        padding: 2rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        overflow: hidden;
        animation: fadeInUp 0.8s ease forwards;
    }

    .shadow-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 25px rgba(0,0,0,0.12), 0 10px 10px rgba(0,0,0,0.08);
    }

    /* Button Styling */
    .btn-gradient-warning {
        background: linear-gradient(90deg, #000000, #007BFF);
        color: #fff;
        font-weight: 600;
        border: none;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-gradient-warning:hover {
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(255, 152, 0, 0.4);
    }

    /* Pagination Styling */
    .pagination-rounded .page-item .page-link {
        border-radius: 50px;
        transition: all 0.3s;
        color: #495057;
    }

    .pagination-rounded .page-item.active .page-link {
        background: linear-gradient(90deg, #FFC107, #FF9800);
        border: none;
        color: white;
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(255, 152, 0, 0.3);
    }

    .pagination-rounded .page-item .page-link:hover {
        background: #ffe082;
        color: #212529;
        transform: scale(1.1);
    }

    /* Fade-in animation */
    @keyframes fadeInUp {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
</style>


{{-- ================== CUSTOM SCRIPT ================== --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Remove "Showing X to Y of Z results"
    document.querySelectorAll('p, div, span').forEach(el => {
        if(el.textContent.trim().match(/^Showing\s+\d+\s+to\s+\d+\s+of\s+\d+ results$/)) {
            el.remove();
        }
    });

    // Highlight current page
    const urlParams = new URLSearchParams(window.location.search);
    const currentPage = urlParams.get('page') || '1';

    document.querySelectorAll('.pagination li span, .pagination li a').forEach(el => {
        if(el.textContent.trim() === currentPage) {
            el.parentElement.classList.add('active');
        }
    });
});
</script>
