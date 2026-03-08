@php
    $title = 'Classes';
@endphp

@extends('layouts.app')
@section('title', 'Classes')

@section('content')
<div class="row g-4 mb-3">
  <div class="col-12 col-sm-12">
    <div class="shadow-sm rounded p-1">
      <div class="table-responsive">
        <div class="mb-3">
          <a href="" class="btn btn-primary btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#register"><i class="fa fa-plus-circle"></i> Add New</a>
        </div>
        
        <table id="example" class="table table-bordered table-sm">
            <thead>
              <tr>
                <th>Class Name</th>
                <th>Issued date</th>
                <th>Action</th>
              </tr>
            </thead>
             @if(count($Array))
              <tbody> 
                @foreach($Array as $row)
              <tr>
              <td>{{ $row->name}}</td>
              <td>{{ $row->created_at->format('Y-m-d') }}</td>
              <td>
                <div class="dropdown" style="font-size: 0.8rem; line-height: 1;">
                <a href="#" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none; font-size: 1.2rem; padding: 0 4px;">
                 <i class="fa fa-ellipsis-v"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="min-width: 90px; font-size: 0.85rem; padding: 0;">
                  <li><a class="dropdown-item py-1" href="#" data-bs-toggle="modal" data-bs-target="#edit"><i class="fa fa-pencil"></i> Edit</a></li>
                  <li>
                    <form action="{{ route('class_remove') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete?');">
                      @csrf
                      <input type="hidden" name="Class_Name" value="{{ $row->name }}">
                      <button type="submit" class="dropdown-item text-danger"><i class="fa fa-trash"></i> Delete</button>
                    </form>
                  </li>
                </ul>
              </div>
              </td>
            </tr>
           
            @endforeach
          </tbody>
            @endif
        </table>
      </div>
    </div>
  </div>

</div>

@include('Manage_class.add')
@endsection