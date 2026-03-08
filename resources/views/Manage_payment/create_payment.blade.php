@php $title='Fee Structures'; @endphp
@extends('layouts.app')
@section('title','Fee Structures')

@section('content')
<div class="row g-4 mb-3">
  <div class="col-12">
    <div class="shadow-sm rounded p-4 bg-white">
      <form method="POST" action="{{ route('payments.store') }}" id="confirmDialog">
        @csrf
        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label">Student <strong class="text-danger">*</strong></label>
            <select class="form-select select2" name="student_id" required>
              <option value="" hidden></option>
              @foreach($students as $row)
                <option value="{{ $row->id }}">{{ $row->firstname.' '.$row->middlename.' '.$row->lastname.'=>'.$row->class_name }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-md-4 col-6 d-none">
            <label class="form-label">Academic Year <strong class="text-danger">*</strong></label>
            <select class="form-select select2" name="ac_year">
              <option value="{{ $active_year }}">{{ $active_year }}</option>
            </select>
          </div>

          <div class="col-md-4 col-6">
            <label class="form-label">Payment date <strong class="text-danger">*</strong></label>
            <input type="date" class="form-control" name="payment_date" required>
          </div>

          <div class="col-md-4 col-6">
            <label class="form-label">Term <strong class="text-danger">*</strong></label>
            <select class="form-select select2" name="mhula" required>
              <option value="" hidden></option>
              @foreach($active_term as $row)
                <option value="{{ $row->term_name }}">{{ $row->term_name }}</option>
              @endforeach
            </select>
          </div>


          <div class="col-md-4">
            <label class="form-label">Amount received <strong class="text-danger">*</strong></label>
            <input type="number" name="amount" class="form-control" required>
          </div>


          <div class="col-md-8">
          	<label class="form-label">Description <strong class="text-danger">*</strong></label>
            <textarea class="form-control" name="method" style="height: 50px;"></textarea>
          </div>

          <div class="col-12 mt-4 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary rounded-pill px-4 btn-sm">Save Payment</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
