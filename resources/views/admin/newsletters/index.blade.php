@extends('layouts.admin')

@section('title', 'Newsletter Subscribers')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Newsletter Subscribers</h2>
            <p class="text-secondary mb-0">Manage registered email list subscribers for daily/weekly digests.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Search Panel -->
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.subscribers.index') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 text-secondary"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" class="form-control bg-light border-0" name="search" value="{{ request('search') }}" placeholder="Search subscribers by email address...">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary w-100 fw-semibold rounded-3">Search</button>
                </div>
                @if(request('search'))
                    <div class="col-md-2">
                        <a href="{{ route('admin.subscribers.index') }}" class="btn btn-outline-secondary w-100 fw-semibold rounded-3">Clear</a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Subscribers Table -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light border-0">
                        <tr>
                            <th class="px-4 py-3 border-0" style="width: 80px;">#</th>
                            <th class="py-3 border-0">Email Address</th>
                            <th class="py-3 border-0">Subscription Date</th>
                            <th class="py-3 border-0" style="width: 120px;">Status</th>
                            <th class="px-4 py-3 border-0 text-end" style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($subscribers->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center py-5 text-secondary">No subscribers found.</td>
                            </tr>
                        @else
                            @foreach($subscribers as $index => $sub)
                                <tr class="border-bottom border-light">
                                    <td class="px-4 py-3 text-secondary">{{ ($subscribers->currentPage() - 1) * $subscribers->perPage() + $index + 1 }}</td>
                                    <td class="py-3 fw-semibold text-dark">
                                        <i class="fa-regular fa-envelope text-primary opacity-50 me-2"></i> {{ $sub->email }}
                                    </td>
                                    <td class="py-3 text-secondary small">{{ $sub->created_at->format('M d, Y H:i') }}</td>
                                    <td class="py-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input status-toggle" type="checkbox" data-id="{{ $sub->id }}" {{ $sub->status ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-end">
                                        <form action="{{ route('admin.subscribers.destroy', $sub->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this subscriber?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-light btn-sm text-danger border-0"><i class="fa-regular fa-trash-can"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            @if($subscribers->hasPages())
                <div class="p-4 border-top border-light">
                    {{ $subscribers->links() }}
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
            fetch(`/admin/subscribers/${id}/toggle-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    // Feedback hook
                }
            });
        });
    });
</script>
@endsection
