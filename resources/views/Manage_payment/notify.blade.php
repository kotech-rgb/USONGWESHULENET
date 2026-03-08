@php
    $title = 'Notify Debtors';
    $heading = "MGAWANYO WA MALIPO YA ADA KWA MWANAFUNZI";
    $hasQueryParams = request()->has(['class_name','term']);
@endphp

@extends('layouts.app')
@section('title', $title)

@section('content')
<style>
    label { font-size: 0.85rem; }

    .print-area {
        background: #fff;
        padding: 25px;
        border: 1px solid #ccc;
    }

    @media print {
        body * {
            visibility: hidden;
        }
        .print-area, .print-area * {
            visibility: visible;
        }
        .print-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .no-print {
            display: none !important;
        }
    }

    .report-title {
        text-align: center;
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 5px;
        text-transform: uppercase;
    }
    .report-subtitle {
        text-align: center;
        font-size: 14px;
        margin-bottom: 20px;
        color: #555;
    }

    h5.term-title {
        color: #05738E;
        margin-top: 30px;
        margin-bottom: 10px;
    }

    /* Plain Table Styles */
    .normal-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
        background: #fff;
        margin-bottom: 20px;
    }
    .normal-table th,
    .normal-table td {
        border: 1px solid #333;
        padding: 6px 8px;
        text-align: left;
    }
    .normal-table th {
        background: #f2f2f2;
        font-weight: bold;
    }
    .normal-table tfoot th {
        background: #fafafa;
    }

    .report-footer {
        margin-top: 40px;
        font-size: 13px;
        display: flex;
        justify-content: space-between;
    }
</style>

<div class="container">

    <!-- Search Form -->
    @if(!$hasQueryParams)
    <div style="border:1px solid #ddd; background:#fff; padding:15px; margin-bottom:20px;">
        <form method="GET" action="{{ route('debtors.index') }}">
            <div style="display:flex; gap:15px; align-items:flex-end; flex-wrap:wrap;">
                <div>
                    <label for="class_named">Select Class</label><br>
                    <select class="form-control select2" name="class_name" required style="width:300px;">
                        <option value="" selected disabled></option>
                        @foreach($classes as $row)
                            <option value="{{ $row->name }}">{{ $row->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="class_named">Select term</label><br>
                    <select class="form-control select2" name="term" required style="width:300px;">
                        <option value="" selected disabled></option>
                            <option value="{{ $terms }}">Term -{{ $terms }}</option>
                    </select>
                </div>
                <div>
                    <button type="submit" style="padding:6px 12px; background:#05738E; color:#fff; border:none; cursor:pointer;">
                        <i class="fa fa-search me-1"></i> Search
                    </button>
                </div>
            </div>
        </form>
    </div>
    @endif

    <!-- Fee Structure Report -->
    @if($hasQueryParams && $debtors->count() > 0)

    <div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Notify Debitors for:
            <span class="fw-bold">{{ request()->query('class_name', 'No Subject Selected') }}</span>
        </h6>
        <small>{{ now()->format('F j, Y') }}</small>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('notify_debitors') }}">
            @csrf
            <input type="hidden" name="class_name" value="{{ request()->query('class_name') }}">
            <input type="hidden" name="term" value="{{ request()->query('term') }}">
        <div class="table-responsive">
        <table class="table  table-striped table-sm">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll" class="form-check-input"> All </th>
                    <th>First name</th>
                    <th>Middle name</th>
                    <th>Last name</th>
                    <th>Parent Phone</th>
                    <th>is notified?</th>
                </tr>
            </thead>
            <tbody>

                @foreach($debtors as $row)
                <tr>
                    <td>
                        @if($row->last_notified==NULL || $row->last_notified < now()->format('F j, Y'))
                        <input class="form-check-input" type="checkbox" name="selected_students[]" value="{{ $row->id }}">
                        {{ str_pad($row->index_number, 4, '0', STR_PAD_LEFT) }}
                        @else
                        <i class="fa fa-check"></i>Message Sent
                        @endif
                    </td>
                    <td>{{ $row->firstname }}</td>
                    <td>{{ $row->middlename }}</td>
                    <td>{{ $row->lastname }}</td>
                    <td>{{ $row->phone }}</td>
                    <td>
                      @if($row->last_notified==NULL || $row->last_notified < now()->format('F j, Y'))
                      <span class="text-danger fw-semibold" style="font-size:10px;">Not notified for today {{ now()->format('F j, Y') }}</span>
                      @else
                      <span class="text-success fw-semibold" style="font-size:10px;">Notified today</span>
                      @endif   
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        <div class="mt-4">
                <button type="submit" class="btn btn-secondary btn-sm px-4">SEND SMS <i class="fa fa-angle-double-right"></i></button>
        </div>
    </form>
    </div>
</div>

<script>
    document.getElementById('selectAll').addEventListener('click', function() {
        let checkboxes = document.querySelectorAll('input[name="selected_students[]"]');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });
</script>


    <script>
    document.getElementById("selectAll").addEventListener("change", function() {
        let checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });
</script>

@endif
@endsection
