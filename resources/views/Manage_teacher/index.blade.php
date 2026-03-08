@php
    $title = 'Teachers';
@endphp

@extends('layouts.app')
@section('title', 'Teachers')

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
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Region</th>
                <th>Role</th>
                <th>Issued date</th>
                <th>Action</th>
              </tr>
            </thead>
             @if(count($users))
              <tbody> 
                @foreach($users as $row)
                 @php
                 $modalId = 'edit-' . Str::slug($row->id);
                 @endphp
              <tr>
              <td>{{ $row->fname}}</td>
              <td>{{ $row->mname}}</td>
              <td>{{ $row->lname}}</td>
              <td>{{ $row->gender}}</td>
              <td>{{ $row->phone}}</td>
              <td>{{ $row->email}}</td>
              <td>{{ $row->region}}</td>
              <td>{{ $row->role }}</td>
              <td>{{ $row->created_at->format('Y-m-d') }}</td>
              <td>
                <div class="dropdown" style="font-size: 0.8rem; line-height: 1;">
                <a href="#" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none; font-size: 1.2rem; padding: 0 4px;">
                 <i class="fa fa-ellipsis-v"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="min-width: 90px; font-size: 0.85rem; padding: 0;">
                  <li><a class="dropdown-item py-1" href="#" data-bs-toggle="modal" data-bs-target="#{{$modalId}}"><i class="fa fa-pencil"></i> Edit</a></li>
                  <li>
                    <form action="/delete/123" method="POST" onsubmit="return confirm('Are you sure?');">
                      <input type="hidden" name="_method" value="DELETE" />
                      <button type="submit" class="dropdown-item text-danger"><i class="fa fa-trash"></i> Suspend</button>
                    </form>
                  </li>
                </ul>
              </div>
              </td>
            </tr>
            @include('Manage_teacher.edit')
            @endforeach
          </tbody>
            @endif
        </table>
      </div>
    </div>
  </div>

</div>
 @include('Manage_teacher.add')  
@endsection