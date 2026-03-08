@php
    $title = 'Students';
@endphp

@extends('layouts.app')
@section('title', 'Students')

@section('content')
<div class="row g-4 mb-3">
  <div class="col-12 col-sm-12">
    <div class="shadow-sm rounded p-1">

      <div class="table-responsive">
        <table id="example" class="table table-bordered table-sm">
            <thead>
              <tr>
                <th>Index Number</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Class</th>
                <th>Requested By</th>
                <th>Reason</th>
                <th>Action</th>
              </tr>
            </thead>
             @if(count($wanafunzi))
              <tbody> 
                @foreach($wanafunzi as $row)
                @php
                 $confirm_del = 'futa-' . Str::slug($row->id);
                 @endphp
              <tr>
              <td><strong>{{ $configs->school_reg}}.{{ str_pad($row->index_number, 4, '0', STR_PAD_LEFT) }}</strong></td>
	            <td>{{ $row->firstname }}</td>
	            <td>{{ $row->middlename }}</td>
	            <td>{{ $row->lastname }}</td>
	            <td>{{ $row->gender }}</td>
	            <td>{{ $row->email }}</td>
	            <td>{{ $row->phone }}</td>
	            <td>{{ $row->class_name }}</td>
              <td>{{ $row->requested_by }}</td>
              <td>{{ $row->reason }}</td>
	            <td><a href="" data-bs-toggle="modal" data-bs-target="#{{$confirm_del}}" class="btn btn-sm btn-outline-primary"><i class="fa fa-ellipsis-v"></i> Take action</a></td>
            </tr>
            @include('Manage_student.confirm_delete')
            @endforeach
          </tbody>
            @endif
        </table>
      </div>
    </div>
  </div>

</div>
@endsection