@php
    $title = 'Subjects';
@endphp

@extends('layouts.app')
@section('title', 'Subjects')

@section('content')
<div class="row g-4 mb-3">
  <div class="col-12 col-sm-12">
    <div class="shadow-sm rounded p-1">

    	<div class="mb-3">
          <a href="" class="btn btn-primary btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#register"><i class="fa fa-plus-circle"></i> Add New</a>
        </div>

      <div class="table-responsive">
        <table id="example" class="table table-bordered table-sm">
             <thead class="table-primary">
		        <tr>
		          <th>#</th>
		          <th>Subject Name</th>
		          <th>Created At</th>
		          <th>Actions</th>
		        </tr>
		      </thead>   
             @if(count($subjects))
              <tbody> 
              @forelse($subjects as $key => $subject)
              @php
              $modalId = 'edit-' . Str::slug($subject->sub_name);
              @endphp
              <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $subject->sub_name }}</td>
	            <td>{{ $subject->created_at->format('d M Y') }}</td>
                <td>
                <div class="dropdown" style="font-size: 0.8rem; line-height: 1;">
                <a href="#" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none; font-size: 1.2rem; padding: 0 4px;">
                 <i class="fa fa-ellipsis-v"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="min-width: 90px; font-size: 0.85rem; padding: 0;">
                  <li><a class="dropdown-item py-1" href="#" data-bs-toggle="modal" data-bs-target="#{{$modalId}}"><i class="fa fa-pencil"></i> EDIT</a></li>
                  <li>
                    <form action="{{ route('subject_remove') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete?');">
                      @csrf
                      <input type="hidden" name="sub_name" value="{{ $subject->sub_name }}">
                      <button type="submit" class="dropdown-item text-danger"><i class="fa fa-trash"></i> Delete</button>
                    </form>
                  </li>
                </ul>
              </div>
              </td>
            </tr>
           @include('Manage_subject.edit')
            @endforeach
          </tbody>
            @endif
        </table>
      </div>
    </div>
  </div>

</div>

@include('Manage_subject.add')
@endsection