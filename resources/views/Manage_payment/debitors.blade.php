@php
    $title = 'All Debtors';
    $heading = "ALL STUDENTS WHO DID NOT COMPLETED SCHOOL FEES TERM ($term)";
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
    <!-- Fee Structure Report -->
    @if($debtors->count() > 0)
    <div class="card shadow-sm border-0 mb-4 print-area">
    	<div class="d-flex justify-content-end mb-3 no-print">
            <button onclick="window.print()" class="btn btn-outline-secondary btn-sm">
                <i class="fa fa-print me-1"></i> Print
            </button>
        </div>
     @include('print_header')
    <div class="card-body">
        <div class="table-responsive">
        <table class="table  table-striped table-sm">
            <thead>
                <tr>
                    <th>Index</th>
                    <th>First name</th>
                    <th>Middle name</th>
                    <th>Last name</th>
                    <th>Gender</th>
                    <th>Amount required(TZS)</th>
                    <th>Amount Payed(TZS)</th>
                    <th>Remain balance</th>
                </tr>
            </thead>
            <tbody>

                @foreach($debtors as $row)
                <tr>
                	<td> {{ str_pad($row->index_number, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $row->firstname }} </td>
                    <td>{{ $row->middlename }} </td>
                    <td>{{ $row->lastname }} </td>
                    <td>{{ $row->gender }} </td>
                    <td>{{ number_format($row->required_amount) }}</td>
                    <td>{{ number_format($row->total_paid) }}</td>
                    <td>{{ number_format($row->required_amount-$row->total_paid)}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>

@endif
@endsection
