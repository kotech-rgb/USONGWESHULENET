@php
    $config = \DB::table('configurations')->first();
    $activeYear = \DB::table('years')->where('status','active')->value('year_name');
    $class_name = request()->filled('class_name') ? request()->query('class_name') : null;
@endphp

<style>
    .report-header-container {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px 15px; /* reduced padding */
        margin-bottom: 10px; /* tighter margin */
        background-color: #f8f9fa;
        border-bottom: 2px solid #05738E;
        border-radius: 6px;
    }
    .report-header-logo {
        margin-right: 15px; /* smaller gap */
        text-align: center;
    }
    .report-header-logo img {
        width: 80px; /* smaller logo */
        border-radius: 50%;
        box-shadow: 0 1px 4px rgba(0,0,0,0.2);
    }
    .report-header-details {
        text-align: center;
    }
    .report-header-details h3 {
        color: #05738E;
        letter-spacing: 1px;
        margin: 0; /* removed extra margin */
        font-size: 1.2rem; /* slightly smaller */
    }
    .report-header-details h2 {
        margin: 5px 0; /* reduced */
        font-size: 1rem; /* smaller */
    }
    .report-header-details p {
        font-size: 0.85rem; /* smaller text */
        color: black;
        margin: 2px 0; /* tighter spacing */
    }
</style>

<div class="report-header-container">
    <!-- School Logo -->
    <div class="report-header-logo">
        <img src="{{ $config->logo ?? '/assets/img/nembo.jpg' }}" alt="School Logo">
    </div>

    <!-- School Details -->
    <div class="report-header-details">
        <h3><strong>{{ $config->school_name ?? 'ISUTO SECONDARY SCHOOL' }}</strong></h3>
        <p>SCHOOL ADDRESS - {{ $config->box ?? 'N/A' }}</p>
        <h2>{{ $heading ?? 'Undefined header' }}</h2>
        @if(!request()->has('student_id'))
        <p>Mwaka wa Masomo: <strong>{{ $activeYear-1 }} / {{ $activeYear }}</strong></p>
        <p>DARASA: {{ $class_name ?? 'Undefined class name' }}</p>
        @endif
    </div>
</div>
