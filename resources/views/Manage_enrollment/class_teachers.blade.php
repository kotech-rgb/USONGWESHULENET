@php
    $title = 'Class teachers';
    $School_details = \DB::table('configurations')->first();
@endphp

@extends('layouts.app')
@section('title', $title)

@section('content')
<div id="printableReport" class="container-fluid"> 
    
    <!-- Card: Assign Teacher Subjects -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fa fa-chalkboard-teacher me-2"></i> Assign teachers to class</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('class_teachers_save') }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-6">
                    <label for="teacher" class="form-label">Select Teacher <span class="text-danger">*</span></label>
                    <select name="teacher_id" class="form-select select2" required>
                        <option value=""></option>
                        @foreach($U as $row)
                           <option value="{{ $row->id }}">{{ $row->fname.' '.$row->mname.' '.$row->lname }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="class" class="form-label">Select Class <span class="text-danger">*</span></label>
                    <select name="class_id" class="form-select select2" required>
                        <option value=""></option>
                        @foreach($C as $row)
                           <option value="{{ $row->name }}">{{ $row->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-plus-circle me-1"></i> Assign
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Card: Assigned Subjects List -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fa fa-list-alt me-2 text-primary"></i> Assigned class Teachers</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                        	<th><i class="fa fa-chalkboard me-1"></i> Class</th>
                            <th><i class="fa fa-user me-1"></i> Teacher</th>
                            <th><i class="fa fa-book me-1"></i> Date issued</th>
                            <th class="text-center"><i class="fa fa-cogs me-1"></i> Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($TS as $row)
                        <tr>
                        	<td> <strong class="text-primary">{{ $row->class_id }}</strong></td>
                            <td> <strong class="text-success">{{ $row->fname.' '.$row->mname.' '.$row->lname }}</strong></td>
                            <td>{{ $row->created_at }}</td>
                            <td class="text-center">
                                <form onsubmit="return confirm('Are you sure you want to remove this subject assignment?');" method="POST" action="{{ route('class_teachers_remove') }}">
                                    @csrf
                                    <input type="hidden" value="{{ $row->id }}" name="id">  
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fa fa-times-circle"></i> Remove
                                    </button>  
                                </form>
                            </td>
                        </tr>
                        @endforeach 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
