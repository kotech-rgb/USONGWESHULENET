@php
    $title = 'Student Transfer';
@endphp

@extends('layouts.app')
@section('title', $title)

@section('content')
<form id="transferForm" method="POST" action="{{ route('student_transfer_save') }}">
	@csrf
<div class="row g-4 mb-3">
  <div class="col-md-6">
  	<div class="card">
  		<div class="card-header">Source Students</div>
  		<div class="card-body shadow-sm p-3">
  
  		<div class="table-responsive">
        <table id="example" class="table table-striped table-sm">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll" class="form-check-input"> All </th>
                    <th>First name</th>
                    <th>Middle name</th>
                    <th>Last name</th>
                    <th>Gender</th>
                    <th>Class Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $row)
                <tr>
                    <td class="text-center">
                        <input class="form-check-input" type="checkbox" name="selected_students[]" value="{{ $row->id }}">
                    </td>
	                <td>{{ $row->firstname }}</td>
	                <td>{{ $row->middlename }}</td>
	                <td>{{ $row->lastname }}</td>
	                <td>{{ $row->gender }}</td>
	                <td>{{ $row->class_name }}</td>
	            </tr>
                @endforeach
            </tbody>
        </table>
        </div>

  	    </div>
  	</div>
  </div>

  <div class="col-md-6">
  	<div class="card">
  		<div class="card-header">Destination Class</div>
  		<div class="card-body shadow-sm p-3">
			<select class="form-control select2" name="class_name" required>
				<option selected value=""></option>
				@foreach($classes as $row)
				<option value="{{ $row->name }}"> {{ $row->name }} </option>
				@endforeach
			</select>
			<button class="btn btn-secondary w-100 mt-3">
                <i class="fa fa-check-circle me-1"></i> Migrate Selected Students
            </button>
  	    </div>
  	</div>
  </div>
</div>
</form>
{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Select All
    document.getElementById('selectAll').addEventListener('change', function() {
        let checkboxes = document.querySelectorAll('input[name="selected_students[]"]');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    // SweetAlert confirm
    document.getElementById("transferForm").addEventListener("submit", function(e) {
        e.preventDefault(); // stop normal submit

        Swal.fire({
            title: "Confirm Migration",
            text: "Are you sure you want to transfer the selected students this action will not be undone?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Transfer"
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit(); // continue with form submit
            }
        });
    });
</script>
@endsection
