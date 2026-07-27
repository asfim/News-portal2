@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Dashboard</h2>
            <p class="text-secondary mb-0">Overview of your News Portal activity and performance.</p>
        </div>
        <div class="text-secondary small fw-semibold">
            <i class="fa-regular fa-calendar me-1"></i> Today: {{ now()->format('l, M d, Y') }}
        </div>
    </div>

    <!-- 1. Statistics Grid Row -->
    <div class="row g-4 mb-4">
        <!-- Total News Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stat bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-secondary small fw-semibold text-uppercase">Total News</span>
                        <h2 class="fw-bold mb-0 mt-1">{{ number_format($stats['total_news']) }}</h2>
                    </div>
                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3">
                        <i class="fa-regular fa-newspaper fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Published News Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stat bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-secondary small fw-semibold text-uppercase">Published News</span>
                        <h2 class="fw-bold text-success mb-0 mt-1">{{ number_format($stats['published_news']) }}</h2>
                    </div>
                    <div class="bg-success bg-opacity-10 text-success p-3 rounded-3">
                        <i class="fa-regular fa-circle-check fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending News Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stat bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-secondary small fw-semibold text-uppercase">Pending Approval</span>
                        <h2 class="fw-bold text-warning mb-0 mt-1">{{ number_format($stats['pending_news']) }}</h2>
                    </div>
                    <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3">
                        <i class="fa-solid fa-hourglass-half fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Draft News Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stat bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-secondary small fw-semibold text-uppercase">Drafts</span>
                        <h2 class="fw-bold text-info mb-0 mt-1">{{ number_format($stats['draft_news']) }}</h2>
                    </div>
                    <div class="bg-info bg-opacity-10 text-info p-3 rounded-3">
                        <i class="fa-regular fa-file-lines fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Row 2 -->
    <div class="row g-4 mb-4">
        <!-- Total Views -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stat bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-secondary small fw-semibold text-uppercase">Total Page Views</span>
                        <h2 class="fw-bold mb-0 mt-1">{{ number_format($stats['total_views']) }}</h2>
                    </div>
                    <div class="bg-secondary bg-opacity-10 text-secondary p-3 rounded-3">
                        <i class="fa-regular fa-eye fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Views -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stat bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-secondary small fw-semibold text-uppercase">Today's Page Views</span>
                        <h2 class="fw-bold text-danger mb-0 mt-1">{{ number_format($stats['todays_views']) }}</h2>
                    </div>
                    <div class="bg-danger bg-opacity-10 text-danger p-3 rounded-3">
                        <i class="fa-solid fa-chart-line fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories & Authors -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stat bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-secondary small fw-semibold text-uppercase">Categories</span>
                        <h2 class="fw-bold mb-0 mt-1">{{ number_format($stats['total_categories']) }}</h2>
                    </div>
                    <div class="bg-dark bg-opacity-10 text-dark p-3 rounded-3">
                        <i class="fa-solid fa-folder-tree fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stat bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-secondary small fw-semibold text-uppercase">Total Users</span>
                        <h2 class="fw-bold mb-0 mt-1">{{ number_format($stats['total_users']) }}</h2>
                    </div>
                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3">
                        <i class="fa-solid fa-users fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Row 3 -->
    <div class="row g-4 mb-4">
        <!-- Authors -->
        <div class="col-md-4">
            <div class="card card-stat bg-white">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-secondary small fw-semibold text-uppercase">Total Authors</span>
                        <h2 class="fw-bold mb-0 mt-1">{{ number_format($stats['total_authors']) }}</h2>
                    </div>
                    <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3">
                        <i class="fa-solid fa-user-tie fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Comments -->
        <div class="col-md-4">
            <div class="card card-stat bg-white">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-secondary small fw-semibold text-uppercase">Total Comments</span>
                        <h2 class="fw-bold mb-0 mt-1">{{ number_format($stats['total_comments']) }}</h2>
                    </div>
                    <div class="bg-success bg-opacity-10 text-success p-3 rounded-3">
                        <i class="fa-regular fa-comment-dots fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Advertisements -->
        <div class="col-md-4">
            <div class="card card-stat bg-white">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-secondary small fw-semibold text-uppercase">Advertisements</span>
                        <h2 class="fw-bold mb-0 mt-1">{{ number_format($stats['total_ads']) }}</h2>
                    </div>
                    <div class="bg-info bg-opacity-10 text-info p-3 rounded-3">
                        <i class="fa-solid fa-rectangle-ad fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Charts Section -->
    <div class="row g-4 mb-4">
        <!-- Traffic Analysis: Line Chart -->
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-bottom p-4">
                    <h5 class="fw-bold text-dark mb-0">Traffic & Publication Trend</h5>
                </div>
                <div class="card-body p-4">
                    <div style="height: 350px; position: relative;">
                        <canvas id="trafficTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Popular Categories: Pie/Donut Chart -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white border-bottom p-4">
                    <h5 class="fw-bold text-dark mb-0">Popular Categories</h5>
                </div>
                <div class="card-body p-4 d-flex flex-column align-items-center justify-content-center">
                    <div style="width: 100%; max-width: 250px; height: 250px; position: relative;" class="mb-3">
                        <canvas id="categoriesChart"></canvas>
                    </div>
                    <div class="w-100 mt-2 text-center" id="categoriesChartLegend">
                        <!-- Custom legend labels inside loop if needed -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- User Registration & Most Viewed -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-bottom p-4">
                    <h5 class="fw-bold text-dark mb-0">User Registrations (Last 7 Days)</h5>
                </div>
                <div class="card-body p-4">
                    <div style="height: 250px; position: relative;">
                        <canvas id="registrationsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-bottom p-4">
                    <h5 class="fw-bold text-dark mb-0">Most Viewed News</h5>
                </div>
                <div class="card-body p-4">
                    @if($mostViewedNews->isEmpty())
                        <div class="text-center py-5 text-secondary">No views tracked yet.</div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($mostViewedNews as $item)
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-bottom border-light">
                                    <div class="text-truncate me-3" style="max-width: 80%;">
                                        <h6 class="mb-1 fw-semibold text-dark text-truncate">{{ $item->title }}</h6>
                                        <span class="small text-secondary">{{ $item->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <span class="badge bg-primary rounded-pill px-3 py-2"><i class="fa-regular fa-eye me-1"></i> {{ number_format($item->views) }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Recent News & Recent Comments -->
    <div class="row g-4">
        <!-- Recent News Table -->
        <div class="col-xl-7">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-bottom p-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">Recent News</h5>
                    <a href="#" class="btn btn-outline-primary btn-sm px-3 rounded-pill fw-semibold">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light border-0">
                                <tr>
                                    <th class="px-4 py-3 border-0">Title</th>
                                    <th class="py-3 border-0">Category</th>
                                    <th class="py-3 border-0">Author</th>
                                    <th class="py-3 border-0">Status</th>
                                    <th class="py-3 border-0 text-center">Views</th>
                                    <th class="px-4 py-3 border-0 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($recentNews->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-secondary">No news articles found.</td>
                                    </tr>
                                @else
                                    @foreach($recentNews as $news)
                                        <tr class="border-bottom border-light">
                                            <td class="px-4 py-3" style="max-width: 250px;">
                                                <div class="fw-semibold text-dark text-truncate">{{ $news->title }}</div>
                                                <span class="small text-secondary">{{ $news->created_at->format('M d, Y H:i') }}</span>
                                            </td>
                                            <td class="py-3">
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $news->category->name }}</span>
                                            </td>
                                            <td class="py-3 text-secondary">{{ $news->author->name }}</td>
                                            <td class="py-3">
                                                @switch($news->status)
                                                    @case('published')
                                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">Published</span>
                                                        @break
                                                    @case('pending')
                                                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-2">Pending</span>
                                                        @break
                                                    @case('draft')
                                                        <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-2">Draft</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-2">{{ ucfirst($news->status) }}</span>
                                                @endswitch
                                            </td>
                                            <td class="py-3 text-center fw-semibold text-secondary">{{ number_format($news->views) }}</td>
                                            <td class="px-4 py-3 text-end">
                                                <a href="#" class="btn btn-light btn-sm text-secondary border-0"><i class="fa-regular fa-pen-to-square"></i></a>
                                                <a href="#" class="btn btn-light btn-sm text-danger border-0 ms-1"><i class="fa-regular fa-trash-can"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Comments -->
        <div class="col-xl-5">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-bottom p-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">Recent Comments</h5>
                    <a href="#" class="btn btn-outline-primary btn-sm px-3 rounded-pill fw-semibold">View All</a>
                </div>
                <div class="card-body p-4">
                    @if($recentComments->isEmpty())
                        <div class="text-center py-5 text-secondary">No comments yet.</div>
                    @else
                        <div class="d-flex flex-column gap-4">
                            @foreach($recentComments as $comment)
                                <div class="d-flex align-items-start gap-3 border-bottom border-light pb-3">
                                    <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px; flex-shrink: 0;">
                                        {{ substr($comment->user ? $comment->user->name : $comment->name, 0, 1) }}
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0 fw-bold text-dark small">{{ $comment->user ? $comment->user->name : $comment->name }}</h6>
                                            <span class="small text-secondary" style="font-size: 0.75rem;">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="text-secondary small mt-1 text-wrap text-break" style="max-height: 48px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                            "{{ $comment->comment }}"
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-2">
                                            <span class="small text-muted text-truncate" style="max-width: 60%; font-size: 0.75rem;">
                                                On: <span class="text-dark fw-medium">{{ $comment->news->title }}</span>
                                            </span>
                                            <div class="d-flex gap-1">
                                                @if($comment->status === 'pending')
                                                    <button class="btn btn-success btn-sm py-1 px-2 border-0" style="font-size: 0.75rem;"><i class="fa-solid fa-check"></i> Approve</button>
                                                @else
                                                    <span class="badge bg-success bg-opacity-10 text-success py-1 px-2">{{ ucfirst($comment->status) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Config Chart Labels
    const chartLabels = {!! json_encode($chartLabels) !!};

    // 1. Traffic & Publication Trend Chart
    const trafficTrendCtx = document.getElementById('trafficTrendChart').getContext('2d');
    new Chart(trafficTrendCtx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [
                {
                    label: 'Page Views',
                    data: {!! json_encode($pageViewsChart) !!},
                    borderColor: '#2a5298',
                    backgroundColor: 'rgba(42, 82, 152, 0.05)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                },
                {
                    label: 'News Published',
                    data: {!! json_encode($newsPublishedChart) !!},
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.05)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        boxWidth: 12,
                        font: { family: "'Inter', sans-serif" }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' },
                    ticks: { font: { family: "'Inter', sans-serif" } }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { family: "'Inter', sans-serif" } }
                }
            }
        }
    });

    // 2. Popular Categories Donut Chart
    const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
    const popularCategories = {!! json_encode($popularCategories) !!};
    
    new Chart(categoriesCtx, {
        type: 'doughnut',
        data: {
            labels: popularCategories.map(c => c.name),
            datasets: [{
                data: popularCategories.map(c => c.news_count),
                backgroundColor: [
                    '#1e3c72',
                    '#10b981',
                    '#f59e0b',
                    '#ef4444',
                    '#06b6d4'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 8,
                        padding: 10,
                        font: { family: "'Inter', sans-serif", size: 11 }
                    }
                }
            },
            cutout: '70%'
        }
    });

    // 3. User Registrations Bar Chart
    const registrationsCtx = document.getElementById('registrationsChart').getContext('2d');
    new Chart(registrationsCtx, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'New Registrations',
                data: {!! json_encode($userRegistrationsChart) !!},
                backgroundColor: '#3b82f6',
                borderRadius: 4,
                barThickness: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' },
                    ticks: { font: { family: "'Inter', sans-serif" } }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { family: "'Inter', sans-serif" } }
                }
            }
        }
    });
</script>
@endsection
