@extends('layouts.app')

@php
    $title = "Recharge ";
    $subtitle = "Track your previous SMS top-up transactions";
@endphp

@section('content')
<div class="card shadow-sm animate__animated animate__fadeIn">
    <div class="card-body">
        @if($recharge->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-receipt text-light display-1"></i>
                <p class="text-muted mt-3">No recharge records found in your account.</p>
                <a href="{{ route('sms.recharge.home') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg"></i> Buy SMS Now
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-sm align-middle border-top" id="smsTable" style="width:100%;">
                    <thead class="table-light">
                        <tr class="small text-uppercase">
                            <th>Invoice Details</th>
                            <th>SMS Volume</th>
                            <th>Amount Paid</th>
                            <th>Phone Number</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       @if(isset($recharge) && $recharge->count() > 0)
                        @foreach($recharge as $r)
                            <tr>
                                <td>
                                    <div class="fw-bold text-dark">#{{ $r->invoice }}</div>
                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>{{ $r->created_at->format('d M Y, H:i') }}
                                    </small>
                                </td>
                                <td>
                                    <span class="fw-bold">{{ number_format($r->SMS_amount) }}</span>
                                    <small class="text-muted d-block">SMS Units</small>
                                </td>
                                <td>
                                    <span class="text-primary fw-bold">{{ number_format($r->pay_amount) }}</span>
                                    <small class="text-muted">TZS</small>
                                </td>
                                <td>
                                    <div class="small">
                                        <i class="bi bi-phone me-1 text-muted"></i>{{ $r->phone_number }}
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $badgeClass = match(strtoupper($r->status)) {
                                            'PAID' => 'bg-success',
                                            'PENDING' => 'bg-warning text-dark',
                                            'FAILED', 'CANCELLED' => 'bg-danger',
                                            default => 'bg-secondary',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">
                                        {{ strtoupper($r->status) }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('recharge.status', $r->reference) }}" class="btn btn-outline-dark btn-sm">
                                        <i class="bi bi-eye-fill me-1"></i> Details
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        @else
                        <p>No payment details found</p>
                        @endif
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection