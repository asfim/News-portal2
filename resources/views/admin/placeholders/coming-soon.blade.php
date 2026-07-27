@extends('layouts.admin')

@section('title', $module)

@section('content')
<div class="container-fluid px-0">
    <div class="row justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="col-md-6 text-center">
            <div class="card border-0 shadow-sm rounded-4 p-5 bg-white">
                <div class="card-body">
                    <div class="mb-4 text-primary">
                        <i class="fa-solid fa-screwdriver-wrench display-1 opacity-75"></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-2">{{ $module }}</h3>
                    <p class="text-secondary mb-4">This module is part of the development plan and is currently under construction. Click below to return to the main dashboard.</p>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary px-4 py-2.5 rounded-pill fw-semibold shadow-sm">
                        <i class="fa-solid fa-house me-1"></i> Go to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
