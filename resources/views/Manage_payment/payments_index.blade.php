@php 
  $title = 'Payment View'; 
  $hasQueryParams = request()->has(['class_name']);
@endphp

@extends('layouts.app')
@section('title', 'Payment View')

@section('content')
<div class="row g-4 mb-3">
@if(!$hasQueryParams)
  <div class="col-12">
    <div class="shadow-sm rounded p-4 bg-white">
      {{-- Search Form --}}
      <form method="GET" action="{{ route('payments.view') }}">
        <div class="row g-3 align-items-end">
          
          <div class="col-md-3">
             <div class="form-floating">
            <select  class="form-select select2" name="class_name" required>
              <option value="" hidden></option>
              @foreach($classes as $row)
                <option value="{{ $row->name }}">{{ $row->name }}</option>
              @endforeach
            </select>
            <label for="class_name">Select Class</label>
           </div>
          </div>


          <div class="col-md-3">
            <div class="form-floating">
            <select class="form-select select2" name="year" required>
              <option value="" hidden></option>
              @foreach($years as $row)
                <option value="{{ $row->year_name }}">{{ $row->year_name }}</option>
              @endforeach
            </select>
             <label for="class_name">Select Year</label>
          </div>
          </div>

          <div class="col-md-3">
            <div class="form-floating">
            <select  class="form-select select2" name="term" required>
              <option value="" hidden></option>
              @foreach($terms as $row)
                <option value="{{ $row->term_name }}">{{ $row->term_name }}</option>
              @endforeach
            </select>
            <label for="class_name">Select Term</label>
          </div>
          </div>

          <div class="col-md-3">
            <button type="submit" class="btn btn-primary rounded-pill">
              <i class="fa fa-search"></i> Search
            </button>
          </div>

        </div>
      </form>
    </div>
  </div>
  @else

       <div class="table-responsive">
    <table id="example" class="table table-bordered table-sm table-hover printableTable">
        <thead class="table-light">
            <tr>
                <th>Student Name</th>
                <th>Gender</th>
                <th>Payment Date</th>
                <th>Recorded Date</th>
                <th>Amount</th>
                <th>received by</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payment as $row)
                <tr>
                    <td>{{ $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname }}</td>
                    <td>{{ $row->gender }}</td>
                    <td>{{ \Carbon\Carbon::parse($row->payment_date)->format('d M, Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($row->recorded_date)->format('d M, Y') }}</td>
                    <td>{{ number_format($row->amount, 2) }}</td>
                    <td>{{ ucfirst($row->received_by) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-danger">No payment records found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>


  @endif
</div>
@endsection
