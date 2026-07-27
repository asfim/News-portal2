@extends('layouts.admin')

@section('title', 'Contact Inbox')

@section('content')
    <div class="container-fluid px-0">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Contact Inbox</h2>
                <p class="text-secondary mb-0">Read and respond to feedback, report issues, and general reader inquiries.</p>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Search & Filter Panel -->
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-body p-4">
                <form action="{{ route('admin.contacts.index') }}" method="GET" class="row g-3">
                    <div class="col-lg-6 col-md-8">
                        <label class="form-label text-secondary small fw-semibold">Search Messages</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 text-secondary"><i
                                    class="fa-solid fa-magnifying-glass"></i></span>
                            <input type="text" class="form-control bg-light border-0" name="search"
                                value="{{ request('search') }}" placeholder="Search by sender name, email or subject...">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <label class="form-label text-secondary small fw-semibold">Status</label>
                        <select class="form-select bg-light border-0" name="status">
                            <option value="">All Statuses</option>
                            <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Unread</option>
                            <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                        </select>
                    </div>

                    <div class="col-lg-3 col-md-12 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-secondary w-100 fw-semibold">Filter</button>
                        @if (request()->anyFilled(['search', 'status']))
                            <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary px-3"><i
                                    class="fa-solid fa-rotate-left"></i></a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Messages Table -->
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light border-0">
                            <tr>
                                <th class="px-4 py-3 border-0" style="width: 80px;">Status</th>
                                <th class="py-3 border-0">Sender Name</th>
                                <th class="py-3 border-0">Email Address</th>
                                <th class="py-3 border-0">Subject Heading</th>
                                <th class="py-3 border-0">Received Date</th>
                                <th class="px-4 py-3 border-0 text-end" style="width: 180px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($contacts->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-secondary">No inquiries found.</td>
                                </tr>
                            @else
                                @foreach ($contacts as $msg)
                                    <tr class="border-bottom border-light {{ $msg->status === 'unread' ? 'fw-bold bg-light bg-opacity-50' : '' }}"
                                        id="msg-row-{{ $msg->id }}">
                                        <td class="px-4 py-3">
                                            @if ($msg->status === 'unread')
                                                <span class="badge bg-danger rounded-circle p-1.5"><span
                                                        class="visually-hidden">New</span></span>
                                            @else
                                                <i class="fa-regular fa-envelope-open text-secondary opacity-50"></i>
                                            @endif
                                        </td>
                                        <td class="py-3 text-dark">{{ $msg->name }}</td>
                                        <td class="py-3 text-secondary small">{{ $msg->email }}</td>
                                        <td class="py-3 text-dark text-truncate" style="max-width: 250px;">
                                            {{ $msg->subject }}</td>
                                        <td class="py-3 text-secondary small">{{ $msg->created_at->format('M d, Y H:i') }}
                                        </td>
                                        <td class="px-4 py-3 text-end">
                                            <div class="d-inline-flex gap-1">
                                                <button type="button"
                                                    class="btn btn-light btn-sm text-primary border-0 inspect-btn"
                                                    data-id="{{ $msg->id }}" data-name="{{ $msg->name }}"
                                                    data-email="{{ $msg->email }}" data-subject="{{ $msg->subject }}"
                                                    data-message="{{ $msg->message }}" data-status="{{ $msg->status }}"
                                                    data-date="{{ $msg->created_at->format('M d, Y H:i') }}"
                                                    title="Read Message"><i class="fa-regular fa-eye"></i></button>

                                                <button type="button"
                                                    class="btn btn-light btn-sm text-secondary border-0 toggle-read-btn"
                                                    data-id="{{ $msg->id }}" title="Toggle read/unread"><i
                                                        class="fa-regular fa-envelope"></i></button>

                                                <form action="{{ route('admin.contacts.destroy', $msg->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this message?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-light btn-sm text-danger border-0"><i
                                                            class="fa-regular fa-trash-can"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                @if ($contacts->hasPages())
                    <div class="p-4 border-top border-light">
                        {{ $contacts->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Message Details Inspector Modal -->
    <div class="modal fade" id="messageInspectModal" tabindex="-1" aria-labelledby="messageInspectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header px-4 py-3 bg-light">
                    <h5 class="modal-title fw-bold text-dark" id="messageInspectModalLabel"><i
                            class="fa-regular fa-envelope me-1"></i> Read Inquiry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3 mb-4 pb-3 border-bottom">
                        <div class="col-md-6">
                            <div class="text-secondary small fw-semibold">Sender Details</div>
                            <h6 class="fw-bold text-dark mb-0" id="inspectName"></h6>
                            <span class="small text-secondary" id="inspectEmail"></span>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="text-secondary small fw-semibold">Received Date</div>
                            <span class="small text-dark fw-medium" id="inspectDate"></span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="text-secondary small fw-semibold mb-1">Subject</div>
                        <h5 class="fw-bold text-dark" id="inspectSubject"></h5>
                    </div>

                    <div class="mb-4 bg-light p-4 rounded-3 border">
                        <div class="text-secondary small fw-semibold mb-2">Message</div>
                        <p class="text-dark mb-0" id="inspectMessage" style="white-space: pre-wrap; line-height: 1.6;">
                        </p>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3 bg-light text-end">
                    <button type="button" class="btn btn-secondary px-4 py-2 rounded-pill fw-semibold"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inspectModal = new bootstrap.Modal(document.getElementById('messageInspectModal'));

            // Load details into modal and trigger read updates
            document.querySelectorAll('.inspect-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    const email = this.getAttribute('data-email');
                    const subject = this.getAttribute('data-subject');
                    const message = this.getAttribute('data-message');
                    const date = this.getAttribute('data-date');
                    const status = this.getAttribute('data-status');

                    document.getElementById('inspectName').textContent = name;
                    document.getElementById('inspectEmail').textContent = email;
                    document.getElementById('inspectSubject').textContent = subject;
                    document.getElementById('inspectMessage').textContent = message;
                    document.getElementById('inspectDate').textContent = date;

                    inspectModal.show();

                    // If unread, mark read instantly on open
                    if (status === 'unread') {
                        triggerReadToggle(id);
                    }
                });
            });

            // Manual read/unread toggler
            document.querySelectorAll('.toggle-read-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    triggerReadToggle(id);
                });
            });

            function triggerReadToggle(id) {
                fetch(`/admin/contacts/${id}/toggle-read`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        }
                    });
            }
        });
    </script>
@endsection
