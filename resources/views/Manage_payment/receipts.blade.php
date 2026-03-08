@php
    $title = 'Generate Receipts';
    $heading = "RECEIPT YA MALIPO YA ADA YA MWANAFUNZI";
@endphp

@extends('layouts.app')
@section('title', $title)

@section('content')
<style>
    .print-area {
        background: #fff;
        padding: 25px;
        border: 1px solid #ccc;
        font-family: 'Segoe UI', Arial, sans-serif;
        font-size: 14px;
    }
    @media print {
        body * { visibility: hidden; }
        .print-area, .print-area * { visibility: visible; }
        .print-area {
            position: absolute; left: 0; top: 0; width: 100%;
        }
        .no-print { display: none !important; }
    }
   
    .receipt-info table {
        width: 100%;
        font-size: 13px;
    }
    .receipt-info td {
        padding: 3px 5px;
    }

    .normal-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;      /* compact font */
    margin-top: 5px;      /* reduce top margin */
    }

    .normal-table th,
    .normal-table td {
        border: 1px solid #333;
        padding: 3px 5px;     /* reduced padding for compact look */
        vertical-align: top;  /* align content to top for neatness */
    }

    .normal-table th {
        background: #f2f2f2;
        font-weight: bold;
        text-align: left;
    }


    .totals {
        margin-top: 15px;
        font-size: 15px;
        font-weight: bold;
    }

    .receipt-footer {
        margin-top: 40px;
        display: flex;
        justify-content: space-between;
        font-size: 13px;
    }
</style>

<div class="container">
    @if(!request()->has('student_id'))
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="GET" action="{{ route('generate_receipts') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select class="form-select select2" name="student_id" required>
                                <option value="" selected disabled></option>
                                @foreach($students as $row)
                                    <option value="{{ $row->id }}">
                                        {{ $row->firstname.' '.$row->middlename.' '.$row->lastname.' => '.$row->class_name }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="student_id">Select Student</label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-search me-1"></i> Search
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif

    @if($feeItemsByTerm->count() > 0)
    <div class="print-area">
        <div class="d-flex justify-content-end mb-3 no-print">
            <button onclick="window.print()" class="btn btn-outline-secondary btn-sm">
                <i class="fa fa-print me-1"></i> Print
            </button>
        </div>

         @include('print_header')
        <!-- Receipt Info -->
        <div class="receipt-info">
            <table>
                <tr>
                    <td><strong>Receipt No:</strong> RCP-{{ str_pad($feeItemsByTerm->first()->first()->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td><strong>Tarehe:</strong> {{ now()->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td><strong>Jina Kamili:</strong> 
                        {{ $feeItemsByTerm->first()->first()->firstname }} 
                        {{ $feeItemsByTerm->first()->first()->middlename }} 
                        {{ $feeItemsByTerm->first()->first()->lastname }}
                    </td>
                    <td><strong>Darasa:</strong> {{ $feeItemsByTerm->first()->first()->class_name }}</td>
                </tr>
                <tr>
                    <td><strong>Reg Number:</strong> {{ str_pad($feeItemsByTerm->first()->first()->index_number, 4, '0', STR_PAD_LEFT) }}</td>
                    <td><strong>Jinsia:</strong> {{ $feeItemsByTerm->first()->first()->gender }}</td>
                </tr>
            </table>
        </div>

        <!-- Fee Tables by Term -->
        @foreach($feeItemsByTerm as $term => $items)
        <h5 style="margin-top:15px;">Malipo Awamu ya {{ $term }}</h5>
        <table class="normal-table">
            <thead>
                <tr>
                    <th style="width:5%">SN</th>
                    <th>Tarehe</th>
                    <th>Kiasi (TZS)</th>
                    <th>Maelezo ya Malipo</th>
                </tr>
            </thead>
            <tbody>
                @php $termTotal = 0; @endphp
                @foreach($items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->recorded_date }}</td>
                    <td style="text-align:right;">{{ number_format($item->amount) }}</td>
                    <td>{{ $item->method ?? '-' }}</td>
                </tr>
                @php $termTotal += $item->amount; @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align:right;">
                        <span style="text-decoration:underline;">Jumla kwa awamu ya {{ $term }} umelipa kiasi cha: <strong>(TZS {{ number_format($termTotal) }})</strong></span><br>
                        <span>Kiasi unachodaiwa kwa awamu ya {{ $term }} ni: <strong>(TZS {{ number_format($item->required_amount-$termTotal) }} )</strong></span>
                    </td>
                </tr>
            </tfoot>
        </table>
        @endforeach

        <!-- Receipt Footer -->
        <div class="receipt-footer">
            <div>
                ________________________ <br>
                Head of School
            </div>
            <div>
                ________________________ <br>
                Accountant
            </div>
        </div>
        <div style="display: flex; justify-content: center;">
            {!! $qrCode !!}
    </div>
    </div>
    @endif
</div>
@endsection
