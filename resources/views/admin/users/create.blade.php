@extends('layouts.admin')

@section('title', 'Add User')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Add User</h2>
            <p class="text-secondary mb-0">Create a new login credential and assign roles.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-pill fw-semibold">
            <i class="fa-solid fa-arrow-left me-1"></i> Back
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm mb-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-5">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold text-secondary">User Full Name</label>
                            <input type="text" class="form-control py-3" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. John Doe" required autofocus>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold text-secondary">Email Address</label>
                            <input type="email" class="form-control py-3" id="email" name="email" value="{{ old('email') }}" placeholder="e.g. john@newsportal.com" required>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold text-secondary">Login Password</label>
                                <input type="password" class="form-control py-3" id="password" name="password" placeholder="Min. 8 characters" required>
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-semibold text-secondary">Confirm Password</label>
                                <input type="password" class="form-control py-3" id="password_confirmation" name="password_confirmation" placeholder="Re-type password" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card bg-light bg-opacity-25 border-0 p-4 rounded-3 mb-4">
                            <h5 class="fw-bold text-dark mb-4">Roles & Settings</h5>

                            <!-- Role selections -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-secondary d-block mb-3">Assign Security Roles</label>
                                @foreach($roles as $role)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}" {{ is_array(old('roles')) && in_array($role->id, old('roles')) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark small cursor-pointer" for="role_{{ $role->id }}">{{ $role->name }}</label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="form-check form-switch ps-0">
                                <label class="form-check-label fw-semibold text-dark fs-6" for="status">Active Account</label>
                                <div class="text-secondary small mb-2">Toggle to enable/disable user login.</div>
                                <input class="form-check-input ms-0 border-secondary-subtle" style="width: 2.5em; height: 1.25em;" type="checkbox" id="status" name="status" value="1" {{ old('status', '1') == '1' ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-top border-light mt-5 pt-4 text-end">
                    <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill fw-semibold shadow-sm"><i class="fa-solid fa-circle-check me-2"></i> Save User Account</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
