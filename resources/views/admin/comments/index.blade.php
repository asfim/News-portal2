@extends('layouts.admin')

@section('title', 'Comments Moderation')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Comments Moderation</h2>
            <p class="text-secondary mb-0">Approve, reject, spam, or delete reader comments on news articles.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Search & Filter Panel -->
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.comments.index') }}" method="GET" class="row g-3">
                <div class="col-lg-6 col-md-8">
                    <label class="form-label text-secondary small fw-semibold">Search Comment Content or User details</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 text-secondary"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" class="form-control bg-light border-0" name="search" value="{{ request('search') }}" placeholder="Search comment, author name or email...">
                    </div>
                </div>

                <div class="col-lg-3 col-md-4">
                    <label class="form-label text-secondary small fw-semibold">Status</label>
                    <select class="form-select bg-light border-0" name="status">
                        <option value="">All Statuses</option>
                        @foreach(['pending', 'approved', 'rejected', 'spam'] as $st)
                            <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-3 col-md-12 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-secondary w-100 fw-semibold">Filter</button>
                    @if(request()->anyFilled(['search', 'status']))
                        <a href="{{ route('admin.comments.index') }}" class="btn btn-outline-secondary px-3"><i class="fa-solid fa-rotate-left"></i></a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Comments Table -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light border-0">
                        <tr>
                            <th class="px-4 py-3 border-0" style="width: 80px;">#</th>
                            <th class="py-3 border-0">Reader / User Details</th>
                            <th class="py-3 border-0">Target News Article</th>
                            <th class="py-3 border-0" style="max-width: 350px;">Comment Text</th>
                            <th class="py-3 border-0">Posted Date</th>
                            <th class="py-3 border-0">Status</th>
                            <th class="px-4 py-3 border-0 text-end" style="width: 250px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($comments->isEmpty())
                            <tr>
                                <td colspan="7" class="text-center py-5 text-secondary">No comments found.</td>
                            </tr>
                        @else
                            @foreach($comments as $index => $cmt)
                                <tr class="border-bottom border-light" id="comment-row-{{ $cmt->id }}">
                                    <td class="px-4 py-3 text-secondary">{{ ($comments->currentPage() - 1) * $comments->perPage() + $index + 1 }}</td>
                                    <td class="py-3">
                                        <div class="fw-semibold text-dark">{{ $cmt->user->name ?? 'Guest User' }}</div>
                                        <span class="small text-secondary">{{ $cmt->user->email ?? 'no-email' }}</span>
                                    </td>
                                    <td class="py-3 small text-secondary" style="max-width: 200px;">
                                        @if($cmt->news)
                                            <div class="text-truncate text-dark fw-medium">{{ $cmt->news->title }}</div>
                                        @else
                                            <span class="text-secondary small">Deleted Article</span>
                                        @endif
                                    </td>
                                    <td class="py-3 text-dark text-wrap small" style="max-width: 350px;">
                                        {{ $cmt->comment }}
                                    </td>
                                    <td class="py-3 text-secondary small">{{ $cmt->created_at->format('M d, Y H:i') }}</td>
                                    <td class="py-3" id="status-badge-container-{{ $cmt->id }}">
                                        @switch($cmt->status)
                                            @case('approved')
                                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1.5">Approved</span>
                                                @break
                                            @case('pending')
                                                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-1.5">Pending</span>
                                                @break
                                            @case('spam')
                                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1.5">Spam</span>
                                                @break
                                            @case('rejected')
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-1.5">Rejected</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td class="px-4 py-3 text-end">
                                        <div class="d-inline-flex gap-1">
                                            @if($cmt->status !== 'approved')
                                                <button type="button" class="btn btn-light btn-sm text-success border-0 action-btn" data-id="{{ $cmt->id }}" data-status="approved" title="Approve"><i class="fa-solid fa-check"></i></button>
                                            @endif
                                            @if($cmt->status !== 'rejected')
                                                <button type="button" class="btn btn-light btn-sm text-secondary border-0 action-btn" data-id="{{ $cmt->id }}" data-status="rejected" title="Reject"><i class="fa-solid fa-ban"></i></button>
                                            @endif
                                            @if($cmt->status !== 'spam')
                                                <button type="button" class="btn btn-light btn-sm text-danger border-0 action-btn" data-id="{{ $cmt->id }}" data-status="spam" title="Spam"><i class="fa-solid fa-triangle-exclamation"></i></button>
                                            @endif
                                            
                                            <button type="button" class="btn btn-light btn-sm text-danger border-0 delete-btn ms-1" data-id="{{ $cmt->id }}" title="Delete"><i class="fa-regular fa-trash-can"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            @if($comments->hasPages())
                <div class="p-4 border-top border-light">
                    {{ $comments->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Handles comment status updates
    document.querySelectorAll('.action-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const status = this.getAttribute('data-status');

            fetch(`/admin/comments/${id}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: status })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Reload to refresh table states easily
                }
            });
        });
    });

    // Delete comment
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if(!confirm('Are you sure you want to permanently delete this comment?')) return;
            const id = this.getAttribute('data-id');

            fetch(`/admin/comments/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`comment-row-${id}`).remove();
                }
            });
        });
    });
</script>
@endsection
