@php
    $title = 'Students';
@endphp

@extends('layouts.app')
@section('title', 'Students')

@section('content')
<div class="row g-4 mb-3">
  <div class="col-12 col-sm-12">
    <div class="shadow-sm rounded p-1">

    	<div class="mb-3 shadow-sm p-2 border rounded">
          <a href="" class="btn btn-primary btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#register"><i class="fa fa-plus-circle"></i> Add New</a>

          <a href="#" style="float:right;" class="btn btn-primary btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#upload"><i class="fa fa-plus-circle"></i> Import from Excel</a>
        </div>
        <div class="row">
          <div class="col-sm-3 mb-3">
          <form method="GET" action="{{ route('student_index') }}">
            <div class="input-group ms-2">
              <select class="form-control select2" name="class_name">
              <option selected value=""></option>
              @foreach($drs as $row)
              <option value="{{ $row }}">{{$row}}</option>
              @endforeach
              </select>
              <button type="submit" class="btn btn-secondary btn-sm"><i class="fa fa-search"></i></button>
            </div>
          </form>
        </div>

        <div class="col-sm-9 mb-3">
            <form method="GET" action="{{ route('student_index') }}" style="float:right;">
                <div class="input-group ms-2">
                    <input type="text" name="search" placeholder="Search student..."
                           value="{{ request('search') }}">
                    <button type="submit" class="btn btn-secondary btn-sm"><i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>

        </div>      

      <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered border border-1 border-dark table-sm align-middle">
            <thead class="table-dark">
              <tr>
                <th>Index Number</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Class</th>
                <th>Registered At</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
             @if(count($Array))
              <tbody> 
                @foreach($Array as $row)
                @php
                 $modalId = 'edit-' . Str::slug($row->id);
                 $modalDel = 'delete-' . Str::slug($row->id);
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
	            <td>{{ $row->created_at->format('d M Y') }}</td>
              <td>
                @if(isset($maombisData[$row->id]))
                    <span class="badge bg-warning">Pending {{ $maombisData[$row->id]->request_type }}</span>
                @else
                   <span class="badge bg-success">{{ $row->status }}</span>
                @endif
               </td>

                <td>
                <div class="dropdown" style="font-size: 0.8rem; line-height: 1;">
                <a href="#" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none; font-size: 1.2rem; padding: 0 4px;">
                 <i class="fa fa-ellipsis-v"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="min-width: 90px; font-size: 0.85rem; padding: 0;">
                  <li><a class="dropdown-item py-1" href="#" data-bs-toggle="modal" data-bs-target="#{{$modalId}}"><i class="fa fa-pencil"></i> EDIT</a></li>

                   @if(!isset($maombisData[$row->id]))
                   <li><a class="dropdown-item py-1 text-danger" href="#" data-bs-toggle="modal" data-bs-target="#{{$modalDel}}"><i class="fa fa-trash"></i> DELETE</a></li>
                   @endif
                </ul>
              </div>
              </td>
            </tr>
           @include('Manage_student.edit')
           @include('Manage_student.delete')
            @endforeach
          </tbody>
            @endif
        </table>
        <!-- Pagination links -->
        {{ $Array->links() }}
      </div>
    </div>
  </div>

</div>

@include('Manage_student.add')
@include('Manage_student.upload')

@endsection