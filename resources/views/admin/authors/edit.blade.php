@extends('layouts.admin')

@section('title', 'Edit Author')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Edit Author</h2>
            <p class="text-secondary mb-0">Modify author settings and linked details.</p>
        </div>
        <a href="{{ route('admin.authors.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-pill fw-semibold">
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
            <form action="{{ route('admin.authors.update', $author->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row g-4">
                    <!-- General Details Column -->
                    <div class="col-lg-8">
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold text-secondary">Author Full Name</label>
                                <input type="text" class="form-control py-3" id="name" name="name" value="{{ old('name', $author->name) }}" placeholder="e.g. John Doe" required autofocus>
                            </div>
                            <div class="col-md-6">
                                <label for="username" class="form-label fw-semibold text-secondary">Username (Unique Slug)</label>
                                <input type="text" class="form-control py-3" id="username" name="username" value="{{ old('username', $author->username) }}" placeholder="e.g. john_doe" required>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold text-secondary">Email Address</label>
                                <input type="email" class="form-control py-3" id="email" name="email" value="{{ old('email', $author->email) }}" placeholder="e.g. john@newsportal.com" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold text-secondary">Phone Number</label>
                                <input type="text" class="form-control py-3" id="phone" name="phone" value="{{ old('phone', $author->phone) }}" placeholder="e.g. +88017XXXXXXXX">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="designation" class="form-label fw-semibold text-secondary">Designation</label>
                            <input type="text" class="form-control py-3" id="designation" name="designation" value="{{ old('designation', $author->designation) }}" placeholder="e.g. Senior Investigative Reporter">
                        </div>

                        <div class="mb-4">
                            <label for="bio" class="form-label fw-semibold text-secondary">Biography</label>
                            <textarea class="form-control" id="bio" name="bio" rows="5" placeholder="Enter short bio details...">{{ old('bio', $author->bio) }}</textarea>
                        </div>

                        <h5 class="fw-bold text-dark border-top pt-4 mt-5 mb-4">Social Media Profile Links</h5>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="facebook" class="form-label text-secondary small fw-semibold"><i class="fa-brands fa-facebook text-primary me-2"></i> Facebook URL</label>
                                <input type="url" class="form-control py-3" id="facebook" name="facebook" value="{{ old('facebook', $author->facebook) }}" placeholder="https://facebook.com/username">
                            </div>
                            <div class="col-md-6">
                                <label for="twitter" class="form-label text-secondary small fw-semibold"><i class="fa-brands fa-x-twitter text-dark me-2"></i> X / Twitter URL</label>
                                <input type="url" class="form-control py-3" id="twitter" name="twitter" value="{{ old('twitter', $author->twitter) }}" placeholder="https://twitter.com/username">
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="instagram" class="form-label text-secondary small fw-semibold"><i class="fa-brands fa-instagram text-danger me-2"></i> Instagram URL</label>
                                <input type="url" class="form-control py-3" id="instagram" name="instagram" value="{{ old('instagram', $author->instagram) }}" placeholder="https://instagram.com/username">
                            </div>
                            <div class="col-md-6">
                                <label for="linkedin" class="form-label text-secondary small fw-semibold"><i class="fa-brands fa-linkedin text-primary me-2"></i> LinkedIn URL</label>
                                <input type="url" class="form-control py-3" id="linkedin" name="linkedin" value="{{ old('linkedin', $author->linkedin) }}" placeholder="https://linkedin.com/in/username">
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Configurations Column -->
                    <div class="col-lg-4">
                        <div class="card bg-light bg-opacity-25 border-0 p-4 rounded-3 mb-4">
                            <h5 class="fw-bold text-dark mb-4">Configurations</h5>

                            <div class="mb-4">
                                <label for="user_id" class="form-label fw-semibold text-secondary">Link User Account Login</label>
                                <select class="form-select py-3" id="user_id" name="user_id">
                                    <option value="">No Linked User (Standalone Profile)</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id', $author->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                                    @endforeach
                                </select>
                                <span class="small text-secondary">Associates this author profile to a registered user for writing news articles.</span>
                            </div>

                            <div class="mb-4">
                                <label for="profile_photo_upload" class="form-label fw-semibold text-secondary">Profile Image</label>
                                <input type="file" class="form-control mb-3" id="profile_photo_upload" name="profile_photo_upload">
                                @if($author->profile_photo)
                                    <div class="p-2 bg-white rounded-3 border d-inline-block">
                                        <img src="{{ $author->profile_photo }}" alt="Profile photo" style="max-height: 80px;">
                                    </div>
                                @endif
                            </div>

                            <div class="form-check form-switch ps-0">
                                <label class="form-check-label fw-semibold text-dark fs-6" for="status">Active Status</label>
                                <div class="text-secondary small mb-2">Toggle to enable/disable this author profile.</div>
                                <input class="form-check-input ms-0 border-secondary-subtle" style="width: 2.5em; height: 1.25em;" type="checkbox" id="status" name="status" value="1" {{ old('status', $author->status ? '1' : '0') == '1' ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-top border-light mt-5 pt-4 text-end">
                    <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill fw-semibold shadow-sm"><i class="fa-solid fa-circle-check me-2"></i> Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
