@extends('layouts.app')
@section('title', 'Student Subjects')

@section('content')
<div class="row g-4 mb-3">
  <div class="col-12 col-sm-12">
    <div class="shadow-sm rounded p-2">

    	<div class="col-sm-4 col-12 mb-3">
        	<form method="GET" action="{{ route('student_subject_index') }}">
        		<div class="input-group ms-2">
        			<select class="form-control select2" id="select2" name="class_name">
        			<option selected value="">--Select class--</option>
        			@if(count($C)>0)
        			@foreach($C as $row)
        			<option value="{{ $row->name }}">{{ $row->name }}</option>
        			@endforeach
        			@endif	
        			</select>
        			<button type="submit" class="btn btn-dark btn-sm">Search <i class="fa fa-search"></i></button>
        		</div>
        	</form>
        </div>
        
        @if(count($C) > 0 && count($S) > 0)
        <table id="example" class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>Classes</th>
                    <th>Subjects</th>
                </tr>
            </thead>
            <tbody>
                @foreach($C as $row)
				<tr>
				    <td class="text-center" style="font-size:1rem;">
				        <strong>{{ $row->name }}</strong>
				    </td>
				    <td>
				        <form method="POST" action="{{ route('student_subject.update', $row->name) }}">
				            @csrf
				            @method('PUT')
				            <ul class="list-unstyled">
				                @foreach($S as $subject)
				                    @php
				                        $isChecked = in_array($row->name . '-' . $subject->sub_name, $E);
				                    @endphp
				                    <li>
				                        <input type="checkbox" 
				                               name="subjects[]" 
				                               value="{{ $subject->sub_name }}" 
				                               {{ $isChecked ? 'checked' : '' }}>
				                        {{ $subject->sub_name }}
				                    </li>
				                @endforeach
				            </ul>
				            <button type="submit" class="btn btn-sm float-end btn-outline-secondary">Save changes</button>
				        </form>
				    </td>
				</tr>
				@endforeach
            </tbody>
        </table>
        @endif
    </div>
  </div>
</div>
@endsection
