@php
    $title = 'Fee Structure';
    $heading = "MGAWANYO WA MALIPO YA ADA KWA MWANAFUNZI";
    $hasQueryParams = request()->has(['class_name']);
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

<div class="container my-4">

    <!-- Search Form -->
    @if(!$hasQueryParams)
    <div style="border:1px solid #ddd; background:#fff; padding:15px; margin-bottom:20px;">
        <form method="GET" action="{{ route('fees.fee_structure') }}">
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
                    <button type="submit" style="padding:6px 12px; background:#05738E; color:#fff; border:none; cursor:pointer;">
                        <i class="fa fa-search me-1"></i> Search
                    </button>
                </div>
            </div>
        </form>
    </div>
    @endif

    <!-- Fee Structure Report -->
    @if($hasQueryParams && $feeItemsByTerm->count() > 0)

    <div class="print-area">
        <!-- Print Button -->
        <div class="no-print" style="text-align:right; margin-bottom:10px;">
            <button onclick="window.print()" style="padding:6px 12px; border:1px solid #ccc; background:#f9f9f9; cursor:pointer;">
                <i class="fa fa-print me-1"></i> Print
            </button>
        </div>

        <!-- Report Header -->
        @include('print_header')

        <!-- Fee Tables by Term -->
        @foreach($feeItemsByTerm as $term => $items)
        <h5 class="term-title">MALIPO YA AWAMU YA {{ $term }}</h5>
        <table class="normal-table">
            <thead>
                <tr>
                    <th style="width:5%">SN</th>
                    <th>Maelezo</th>
                    <th style="text-align:right;">Kiasi (TZS)</th>
                </tr>
            </thead>
            <tbody>
                @php $termTotal = 0; @endphp
                @foreach($items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->maelezo }}</td>
                    <td style="text-align:right;">{{ number_format($item->amount) }}</td>
                </tr>
                @php $termTotal += $item->amount; @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" style="text-align:right;">Jumla Awamu ya {{ $term }}</th>
                    <th style="text-align:right; color:darkred;">{{ number_format($termTotal) }}</th>
                </tr>
            </tfoot>
        </table>
        @endforeach

        <!-- Overall Total -->
        @php $overallTotal = $feeItemsByTerm->flatten()->sum('amount'); @endphp
        <div style="margin-top:10px; font-weight:bold;">
            Jumla kwa Mwaka: <strong>{{ number_format($overallTotal) }}</strong> TZS
        </div>

        <!-- Note -->
        <div style="margin-top:15px; padding:10px;">
            <i class="fa fa-info-circle me-2"></i>
            Ada zimegawanywa kwa awamu. Tafadhali lipa ada za kila muhula ipasavyo.
        </div>

        <!-- Report Footer -->
        <div class="report-footer">
            <div>
                ________________________ <br>
                Head of School
            </div>
            <div>
                ________________________ <br>
                Accountant
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
