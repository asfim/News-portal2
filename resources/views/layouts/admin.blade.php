<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Favicon -->
    @if($favicon = \App\Models\Setting::get('favicon'))
        <link rel="shortcut icon" href="{{ asset($favicon) }}" type="image/x-icon">
    @else
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    @endif

    <title>@yield('title', 'Admin Panel') - News Portal</title>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Custom Admin Dashboard CSS -->
    <style>
        :root {
            --sidebar-width: 260px;
            --primary-color: #1e3c72;
            --secondary-color: #2a5298;
            --dark-color: #0f172a;
            --light-color: #f8fafc;
            --border-color: #e2e8f0;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(180deg, var(--dark-color) 0%, #1e293b 100%);
            color: #94a3b8;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            padding: 24px;
            font-size: 1.25rem;
            font-weight: 700;
            color: #fff;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-brand i {
            color: #38bdf8;
        }

        .sidebar-menu {
            list-style: none;
            padding: 15px 0;
            margin: 0;
            overflow-y: auto;
            flex-grow: 1;
        }

        .menu-header {
            padding: 10px 24px 5px 24px;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #475569;
            font-weight: 600;
        }

        .menu-item a {
            display: flex;
            align-items: center;
            padding: 12px 24px;
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.25s ease;
            border-left: 4px solid transparent;
            gap: 12px;
        }

        .menu-item a i {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
            transition: all 0.25s ease;
        }

        .menu-item a:hover, .menu-item.active a {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.05);
        }

        .menu-item.active a {
            border-left-color: #38bdf8;
            color: #fff;
        }

        .menu-item.active a i {
            color: #38bdf8;
        }

        /* Main Content Wrapper */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        /* Header / Navbar Styling */
        .top-navbar {
            background-color: #fff;
            height: 70px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 999;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .nav-toggle {
            font-size: 1.25rem;
            color: var(--text-muted);
            cursor: pointer;
            border: none;
            background: none;
            display: none;
        }

        .user-dropdown .dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            border: none;
            background: none;
            padding: 0;
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            background-color: var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--primary-color);
        }

        .content-area {
            padding: 30px;
            flex-grow: 1;
        }

        /* Responsive Layouts */
        @media (max-width: 991.98px) {
            .sidebar {
                left: calc(-1 * var(--sidebar-width));
            }
            .sidebar.active {
                left: 0;
            }
            .main-wrapper {
                margin-left: 0;
            }
            .nav-toggle {
                display: block;
            }
        }

        /* Cards & Styling Utilities */
        .card-stat {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card-stat:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08);
        }
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        /* Mobile Responsive Adjustments */
        @media (max-width: 767.98px) {
            .content-area {
                padding: 15px !important;
            }
            .top-navbar {
                padding: 0 15px !important;
                height: 60px !important;
            }
            .sidebar-brand {
                padding: 15px 20px !important;
            }
            .menu-item a {
                padding: 10px 20px !important;
            }
            /* Form input spacing and container adjustments */
            .card-body.p-md-5, .p-md-5 {
                padding: 1.5rem !important;
            }
            /* Responsive table formatting */
            .table th, .table td {
                padding: 0.5rem !important;
                font-size: 0.85rem !important;
            }
            /* Buttons and typography sizing */
            .btn {
                padding: 0.375rem 0.75rem !important;
                font-size: 0.85rem !important;
            }
            h2 {
                font-size: 1.5rem !important;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar Navigation -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand d-flex justify-content-between align-items-center">
            <div>
                <i class="fa-solid fa-newspaper"></i>
                News Admin
            </div>
            <button class="btn btn-link text-white d-lg-none p-0" id="sidebarClose">
                <i class="fa-solid fa-xmark fs-4"></i>
            </button>
        </div>
        
        <ul class="sidebar-menu">
            <li class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa-solid fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="menu-header">News Management</li>
            <li class="menu-item {{ request()->routeIs('admin.news.index') ? 'active' : '' }}">
                <a href="{{ route('admin.news.index') }}">
                    <i class="fa-regular fa-file-lines"></i>
                    <span>All Articles</span>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('admin.news.create') ? 'active' : '' }}">
                <a href="{{ route('admin.news.create') }}">
                    <i class="fa-solid fa-plus"></i>
                    <span>Create Article</span>
                </a>
            </li>


            <li class="menu-header">Structure</li>
            <li class="menu-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <a href="{{ route('admin.categories.index') }}">
                    <i class="fa-solid fa-folder-tree"></i>
                    <span>Categories</span>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('admin.subcategories.*') ? 'active' : '' }}">
                <a href="{{ route('admin.subcategories.index') }}">
                    <i class="fa-solid fa-folder-open"></i>
                    <span>Subcategories</span>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                <a href="{{ route('admin.pages.index') }}">
                    <i class="fa-solid fa-file-invoice"></i>
                    <span>Dynamic Pages</span>
                </a>
            </li>


            <li class="menu-header">Users & Authors</li>
            <li class="menu-item {{ request()->routeIs('admin.authors.index') ? 'active' : '' }}">
                <a href="{{ route('admin.authors.index') }}">
                    <i class="fa-solid fa-user-tie"></i>
                    <span>Authors</span>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                <a href="{{ route('admin.users.index') }}">
                    <i class="fa-solid fa-users"></i>
                    <span>Users List</span>
                </a>
            </li>

            <li class="menu-header">Interactions & Media</li>
            <li class="menu-item {{ request()->routeIs('admin.comments.index') ? 'active' : '' }}">
                <a href="{{ route('admin.comments.index') }}">
                    <i class="fa-solid fa-comments"></i>
                    <span>Comments</span>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('admin.media.index') ? 'active' : '' }}">
                <a href="{{ route('admin.media.index') }}">
                    <i class="fa-solid fa-images"></i>
                    <span>Media Library</span>
                </a>
            </li>

            <li class="menu-header">Marketing & Settings</li>
            <li class="menu-item {{ request()->routeIs('admin.advertisements.index') ? 'active' : '' }}">
                <a href="{{ route('admin.advertisements.index') }}">
                    <i class="fa-solid fa-rectangle-ad"></i>
                    <span>Advertisements</span>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('admin.subscribers.index') ? 'active' : '' }}">
                <a href="{{ route('admin.subscribers.index') }}">
                    <i class="fa-regular fa-envelope"></i>
                    <span>Subscribers</span>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('admin.contacts.index') ? 'active' : '' }}">
                <a href="{{ route('admin.contacts.index') }}">
                    <i class="fa-solid fa-inbox"></i>
                    <span>Contact Inbox</span>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                <a href="{{ route('admin.settings') }}">
                    <i class="fa-solid fa-gears"></i>
                    <span>Settings</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Top Navbar -->
        <nav class="top-navbar">
            <button class="nav-toggle" id="sidebarCollapse">
                <i class="fa-solid fa-bars"></i>
            </button>
            
            <div class="ms-auto d-flex align-items-center gap-3">
                <!-- Notifications dropdown placeholder -->
                <div class="dropdown me-2">
                    <button class="btn btn-link position-relative p-0 text-secondary" data-bs-toggle="dropdown">
                        <i class="fa-regular fa-bell fs-5"></i>
                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="width: 280px;">
                        <li class="dropdown-header text-dark fw-bold border-bottom">Notifications</li>
                        <li><a class="dropdown-item py-2 text-wrap small" href="#">No new notifications</a></li>
                    </ul>
                </div>

                <!-- User Dropdown -->
                <div class="dropdown user-dropdown">
                    <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <div class="user-avatar">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="text-start d-none d-sm-block">
                            <div class="fw-semibold text-dark leading-tight">{{ auth()->user()->name }}</div>
                            <div class="text-secondary small leading-none">{{ auth()->user()->roles->first()?->name ?? 'Staff' }}</div>
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                        <li><a class="dropdown-item py-2" href="#"><i class="fa-regular fa-user me-2 text-secondary"></i> My Profile</a></li>
                        <li><a class="dropdown-item py-2" href="/"><i class="fa-solid fa-globe me-2 text-secondary"></i> Visit Website</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Dynamic Content Area -->
        <div class="content-area">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        function toggleSidebar() {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }
        
        document.getElementById('sidebarCollapse').addEventListener('click', toggleSidebar);
        document.getElementById('sidebarClose').addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        // Global Image & Video Preview Handler
        document.addEventListener('change', function(e) {
            if (e.target && e.target.type === 'file') {
                const file = e.target.files[0];
                if (file && (file.type.startsWith('image/') || file.type.startsWith('video/'))) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const isVideo = file.type.startsWith('video/');
                        const tagName = isVideo ? 'video' : 'img';
                        
                        let existingMedia = e.target.parentNode.querySelector('img, video');
                        
                        if (existingMedia && existingMedia.tagName.toLowerCase() === tagName) {
                            existingMedia.src = event.target.result;
                            const container = existingMedia.closest('.d-none');
                            if(container) container.classList.remove('d-none');
                        } else {
                            if(existingMedia) {
                                // If type changed (img -> video), remove old wrapper
                                const oldContainer = existingMedia.closest('.image-preview-container');
                                if(oldContainer) oldContainer.remove();
                            }
                            
                            let previewContainer = document.createElement('div');
                            previewContainer.className = 'mt-3 p-2 bg-light border border-light-subtle rounded-3 d-inline-block image-preview-container shadow-sm';
                            
                            const mediaEl = document.createElement(tagName);
                            mediaEl.style.maxHeight = '120px';
                            mediaEl.className = 'rounded object-fit-contain';
                            mediaEl.src = event.target.result;
                            if(isVideo) {
                                mediaEl.controls = true;
                                mediaEl.autoplay = true;
                                mediaEl.muted = true;
                            }
                            
                            previewContainer.appendChild(mediaEl);
                            e.target.parentNode.appendChild(previewContainer);
                        }
                    }
                    reader.readAsDataURL(file);
                }
            }
        });
    </script>
</body>
</html>
