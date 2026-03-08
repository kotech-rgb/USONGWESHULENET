@php $title='Fee payment'; @endphp
@extends('layouts.app')
@section('title','Fee payment')

@section('content')
<div class="row g-4 mb-3">
  <div class="col-12">
    <div class="shadow-sm rounded p-3">
      <div class="mb-3">
        <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addFee">
          <i class="fa fa-plus-circle"></i> Add Fee Item
        </a>
      </div>
      <div class="table-responsive">
        <table id="example" class="table table-bordered table-sm">
          <thead>
            <tr>
              <th>Student</th>
              <th>Year</th>
              <th>Term</th>
              <th>Payment Date</th>
              <th>Amount</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($students as $p)
            <tr>
                <td>{{ $p->firstname }} {{ $p->lastname }}</td>
				<td>{{ $p->ac_year }}</td>
				<td>{{ $p->mhula }}</td>
				<td>{{ $p->payment_date }}</td>
				<td>{{ number_format($p->amount,0) }}</td>
              <td>
                <div class="dropdown">
                  <a href="#" data-bs-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Edit</a></li>
                    <li>
                      <form action="#" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="dropdown-item text-danger">Delete</button>
                      </form>
                    </li>
                  </ul>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

{{-- Add Fee Modal --}}
<style>
	.modal-content {transition: transform 0.3s ease-out;}
	.modal.fade .modal-dialog {transform: translateY(-30px);}
	.modal.fade.show .modal-dialog {transform: translateY(0);}
</style>

<div class="modal fade" id="addFee" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content shadow-lg rounded-4 border-0">
      <div class="modal-header text-white rounded-top-4" style="background: #05738E;">
        <h5 class="modal-title">Add Payement</h5>
      </div>
      <div class="modal-body p-4">
        <form method="POST" action="{{ route('fees.store') }}">
          @csrf
          <div class="row">
            <div class="col-sm-6 mb-3">
            	<label>Student name <strong class="text-danger">*</strong></label>
            	<select id="select2" class="form-control" name="class_id" required>
            		<option value=""></option>
            		@foreach($students as $row)
            		<option value="{{ $row->id }}">{{ $row->firstname.' '.$row->middlename.' '.$row->lastname }}</option>
            		@endforeach
            	</select>
            </div>
            <div class="col-sm-6 mb-3">
            	<label>Year <strong class="text-danger">*</strong></label>
            	<select class="form-control" name="academic_year" required>
            		<option value=""></option>
            		<option value="{{ $active_year }}">{{ $active_year }}</option>
            	</select>
            </div>
            <div class="col-sm-6 mb-3"><label>Amount <strong class="text-danger">*</strong></label><input type="number" name="amount" class="form-control" required></div>

            <div class="col-sm-6 mb-3">
            	<label>Term <strong class="text-danger">*</strong></label>
            	<select class="form-control" name="term_id" required>
            		<option value=""></option>
            		@foreach($active_term as $row)
            		<option value="{{ $row->term_name }}">{{ $row->term_name }}</option>
            		@endforeach
            	</select>
            </div>
            <div class="col-sm-12 mb-3">
            	<label>Description <strong class="text-danger">*</strong></label>
            	<textarea class="form-control" name="maelezo" style="height:20px;" required>
            		
            	</textarea>
          </div>
          <div class="mt-4 d-flex justify-content-end">
            <a href="#" class="btn btn-outline-secondary rounded-pill px-4 btn-sm me-2" data-bs-dismiss="modal">Close</a>
            <button type="submit" class="btn btn-primary rounded-pill px-4 btn-sm">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
