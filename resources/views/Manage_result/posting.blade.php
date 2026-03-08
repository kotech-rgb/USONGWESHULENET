@php
    $title = 'Posting Results';
@endphp

@extends('layouts.app')
@section('title', 'Posting Results')

@section('content')
<div class="row g-4 mb-3">
  <div class="col-12 col-sm-12">
    <div class="shadow-sm rounded p-1">
      <div class="table-responsive">
        <table id="example" class="table table-bordered table-sm">
            <thead>
              <tr>
                <th>Class Name</th> 
                <th>Term</th>
                <th>Year</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            	@if(count($classes)>0)
            	@foreach($classes as $row)
            	<tr>
            		<td>{{ $row }}</td>
            		<td>{{ $termName }}</td>
            		<td>{{ $yearName }}</td>
            		<td>
                    @if(in_array(trim($row), $postedClasses))
                        <span class="badge bg-success">Already approved</span>
                    @else
                        <span class="badge bg-warning">Not approved</span>
                    @endif
                </td>
            		<td>
                    @if(in_array(trim($row), $postedClasses))
                        <form method="POST" action="{{ route('result_deaprove') }}" onsubmit="return confirm('Are you sure you want to De-approve results for selected class')">
                        @csrf
                        <input type="hidden" value="{{ $row }}" name="class">
                        <input type="hidden" value="{{ $termName }}" name="term">
                        <input type="hidden" value="{{ $yearName }}" name="year">
                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa fa-times-circle"></i> Click to De-approve</button>		
                        </form>
                    @else
                   <form method="GET" action="{{ route('result_index') }}" onsubmit="return confirm('Are you sure you want to Approve results for selected class')">
				   <input type="hidden" name="approve" value="yes">
				   <input type="" value="{{ $row }}" name="class_name">
				   <button type="submit" class="btn btn-sm btn-outline-info"><i class="fa fa-check-circle"></i> Click to approve</button>  
					</form>
                    @endif
                </td>
            	</tr>
            	@endforeach
            	@endif
            </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

@endsection