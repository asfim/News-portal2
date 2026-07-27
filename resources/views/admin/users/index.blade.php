@extends('layouts.admin')

@section('title', 'Users List')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Users & Accounts</h2>
            <p class="text-secondary mb-0">Manage system administrators, editors, reporters, and registered readers.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary px-4 py-2 rounded-pill fw-semibold shadow-sm">
            <i class="fa-solid fa-plus me-1"></i> Add User
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Search Panel -->
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 text-secondary"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" class="form-control bg-light border-0" name="search" value="{{ request('search') }}" placeholder="Search users by name or email...">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary w-100 fw-semibold rounded-3">Search</button>
                </div>
                @if(request('search'))
                    <div class="col-md-2">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary w-100 fw-semibold rounded-3">Clear</a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light border-0">
                        <tr>
                            <th class="px-4 py-3 border-0" style="width: 80px;">#</th>
                            <th class="py-3 border-0">User Name</th>
                            <th class="py-3 border-0">Email Address</th>
                            <th class="py-3 border-0">Assigned Roles</th>
                            <th class="py-3 border-0">Joined Date</th>
                            <th class="py-3 border-0" style="width: 120px;">Status</th>
                            <th class="px-4 py-3 border-0 text-end" style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($users->isEmpty())
                            <tr>
                                <td colspan="7" class="text-center py-5 text-secondary">No users found.</td>
                            </tr>
                        @else
                            @foreach($users as $index => $usr)
                                <tr class="border-bottom border-light">
                                    <td class="px-4 py-3 text-secondary">{{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}</td>
                                    <td class="py-3 fw-semibold text-dark">{{ $usr->name }}</td>
                                    <td class="py-3 text-secondary">{{ $usr->email }}</td>
                                    <td class="py-3">
                                        @foreach($usr->roles as $role)
                                            <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1.5 rounded-pill me-1 small"><i class="fa-solid fa-shield-halved me-1"></i> {{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                    <td class="py-3 text-secondary small">{{ $usr->created_at->format('M d, Y') }}</td>
                                    <td class="py-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input status-toggle" type="checkbox" data-id="{{ $usr->id }}" {{ $usr->status ? 'checked' : '' }} {{ $usr->id === auth()->id() ? 'disabled' : '' }}>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-end">
                                        <a href="{{ route('admin.users.edit', $usr->id) }}" class="btn btn-light btn-sm text-secondary border-0"><i class="fa-regular fa-pen-to-square"></i></a>
                                        @if($usr->id !== auth()->id())
                                            <form action="{{ route('admin.users.destroy', $usr->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user account?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-light btn-sm text-danger border-0 ms-1"><i class="fa-regular fa-trash-can"></i></button>
                                            </form>
                                        @else
                                            <button class="btn btn-light btn-sm text-secondary border-0 ms-1" disabled><i class="fa-regular fa-trash-can"></i></button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="p-4 border-top border-light">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Handles inline status toggle requests
    document.querySelectorAll('.status-toggle').forEach(element => {
        element.addEventListener('change', function () {
            const id = this.getAttribute('data-id');
            fetch(`/admin/users/${id}/toggle-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if(!data.success) {
                    this.checked = !this.checked;
                    alert(data.message);
                }
            });
        });
    });
</script>
@endsection
