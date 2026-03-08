@extends('layouts.app')

@php
    $title = 'My Profile';
    $user = auth()->user();
@endphp

@section('title', $title)

@section('content')
<div class="container-fluid">
    <div class="row g-4">

        <!-- Profile Info Card -->
        <div class="col-lg-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                	<center>
                    <img src="{{ $user->profile_photo ?? '/assets/img/user.png' }}" 
                         class="rounded-circle mb-3 border" 
                         style="width: 120px; height:120px; object-fit: cover;">
                     </center>    
                    <h5 class="mb-1">{{ $user->fname }} {{ $user->lname }}</h5>
                    <p class="text-muted mb-2"><i class="fa fa-envelope me-2 text-primary"></i>{{ $user->email }}</p>
                    <span class="badge bg-info px-3 py-2">{{ ucfirst($user->role) }}</span>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
        	<!-- Edit Info + Change Password -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0"><i class="fa fa-user me-2 text-primary"></i>Edit Profile</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">First Name</label>
                                <input type="text" name="fname" value="{{ $user->fname }}" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="lname" value="{{ $user->lname }}" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                        	<div class="col-md-6 mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" readonly value="{{ $user->email }}" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="number" name="phone" value="{{ $user->phone }}" class="form-control">
                        </div>
                        </div>
                        
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

       </div>

       <div class="col-md-4">
       	<div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0"><i class="fa fa-lock me-2 text-danger"></i>Change Password</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.change-password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" name="new_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" class="form-control" required>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
       </div>     
@endsection
