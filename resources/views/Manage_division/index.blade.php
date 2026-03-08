@php
    $title = 'Divisions';
@endphp

@extends('layouts.app')
@section('title', $title)

@section('content')
<div class="row g-4 mb-3">
  <div class="col-12 col-sm-12">

    {{-- O-Level Divisions --}}
    @if(count($O_level))
    <div class="shadow-sm rounded p-1 mb-4">
      <h5 class="mb-3 bg-primary text-white p-1 rounded d-inline-block">O-Level Divisions System</h5>
      <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
              <tr>
                <th>Division Name</th>
                <th>Start Point</th>
                <th>End Point</th>
                <th>Issued Date</th>
                <th>Action</th>
              </tr>
            </thead>
              <tbody> 
                @foreach($O_level as $row)
                  <tr>
                    <td>DIV -{{ $row->div_name }}</td>
                    <td>{{ $row->start_point }}</td>
                    <td>{{ $row->end_point }}</td>
                    <td>{{ \Carbon\Carbon::parse($row->created_at)->format('Y-m-d') }}</td>
                    <td>
                      <div class="dropdown" style="font-size: 0.8rem; line-height: 1;">
                        <a href="#" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none; font-size: 1.2rem; padding: 0 4px;">
                          <i class="fa fa-ellipsis-v"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="min-width: 90px; font-size: 0.85rem; padding: 0;">
                          <li>
                            <a class="dropdown-item py-1 bg-dark text-white" href="#" data-bs-toggle="modal" data-bs-target="#edit-{{ $row->id }}">
                              <i class="fa fa-pencil"></i> Edit
                            </a>
                          </li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                  @include('Manage_division.edit')
                @endforeach
              </tbody>
        </table>
      </div>
    </div>
    @endif

    {{-- A-Level Divisions --}}
    @if(count($A_level))
    <div class="shadow-sm rounded p-1">
      <h5 class="mb-3 bg-info text-white p-1 rounded d-inline-block">A-Level Divisions System</h5>
      <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
              <tr>
                <th>Division Name</th>
                <th>Start Point</th>
                <th>End Point</th>
                <th>Issued Date</th>
                <th>Action</th>
              </tr>
            </thead>
              <tbody> 
                @foreach($A_level as $row)
                  <tr>
                    <td>DIV -{{ $row->div_name }}</td>
                    <td>{{ $row->start_point }}</td>
                    <td>{{ $row->end_point }}</td>
                    <td>{{ \Carbon\Carbon::parse($row->created_at)->format('Y-m-d') }}</td>
                    <td>
                      <div class="dropdown" style="font-size: 0.8rem; line-height: 1;">
                        <a href="#" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none; font-size: 1.2rem; padding: 0 4px;">
                          <i class="fa fa-ellipsis-v"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="min-width: 90px; font-size: 0.85rem; padding: 0;">
                          <li>
                            <a class="dropdown-item py-1 bg-dark text-white" href="#" data-bs-toggle="modal" data-bs-target="#edit-{{ $row->id }}">
                              <i class="fa fa-pencil"></i> Edit
                            </a>
                          </li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                  @include('Manage_division.edit')
                @endforeach
              </tbody>
        </table>
      </div>
    </div>
    @endif

  </div>
</div>
@endsection
