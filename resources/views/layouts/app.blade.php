<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'দৈনিক জনকথা | সংবাদপত্র')</title>
    
    <!-- Favicon -->
    @if($favicon = \App\Models\Setting::get('favicon'))
        <link rel="shortcut icon" href="{{ asset($favicon) }}" type="image/x-icon">
    @else
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    @endif

    <!-- Google Fonts (Bengali & English) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+Bengali:wght@600;700;800&family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Third-Party CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <!-- Toast style logic -->
    <style>
        .custom-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #fff;
            color: #1b1b1b;
            border-left: 4px solid var(--red);
            padding: 16px 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border-radius: 4px;
            z-index: 99999;
            font-family: var(--sans);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .custom-toast.success {
            border-left-color: #0b6e4f;
        }
        .custom-toast .close-toast {
            cursor: pointer;
            font-weight: bold;
            opacity: 0.5;
            margin-left: auto;
        }
        .custom-toast .close-toast:hover {
            opacity: 1;
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Dynamic Session Alerts -->
    @if(session('success'))
        <div class="custom-toast success" id="success-toast">
            <span>✅ {{ session('success') }}</span>
            <span class="close-toast" onclick="document.getElementById('success-toast').remove()">×</span>
        </div>
        <script>setTimeout(() => document.getElementById('success-toast')?.remove(), 5000);</script>
    @endif

    @if($errors->any())
        <div class="custom-toast" id="error-toast">
            <div>
                @foreach($errors->all() as $error)
                    <div>⚠️ {{ $error }}</div>
                @endforeach
            </div>
            <span class="close-toast" onclick="document.getElementById('error-toast').remove()">×</span>
        </div>
        <script>setTimeout(() => document.getElementById('error-toast')?.remove(), 6000);</script>
    @endif

    <!-- Header Section -->
    @include('frontend.partials.header')

    <!-- Navigation Section -->
    @include('frontend.partials.navbar')

    <!-- Main Content Section -->
    @yield('content')

    <!-- Footer Section -->
    @include('frontend.partials.footer')

    <!-- JavaScript Bundle Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <!-- Custom Frontend JS -->
    <script src="{{ asset('js/frontend.js') }}"></script>
    @stack('scripts')
</body>
</html>
