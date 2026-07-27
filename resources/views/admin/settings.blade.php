@extends('layouts.admin')

@section('title', 'Website Settings')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Website Settings</h2>
            <p class="text-secondary mb-0">Configure overall metadata, contact info, social links, and website features.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="row g-0">
                <!-- Navigation Tabs Side -->
                <div class="col-md-3 border-end border-light">
                    <div class="nav flex-column nav-pills p-4 gap-2" id="settingsTabs" role="tablist">
                        <button class="nav-link active text-start py-3 px-4 border-0 rounded-3" id="general-tab" data-bs-toggle="pill" data-bs-target="#general" type="button" role="tab">
                            <i class="fa-solid fa-sliders me-2"></i> General
                        </button>
                        <button class="nav-link text-start py-3 px-4 border-0 rounded-3" id="contact-tab" data-bs-toggle="pill" data-bs-target="#contact" type="button" role="tab">
                            <i class="fa-regular fa-address-book me-2"></i> Contact Info
                        </button>
                        <button class="nav-link text-start py-3 px-4 border-0 rounded-3" id="social-tab" data-bs-toggle="pill" data-bs-target="#social" type="button" role="tab">
                            <i class="fa-solid fa-share-nodes me-2"></i> Social Links
                        </button>
                        <button class="nav-link text-start py-3 px-4 border-0 rounded-3" id="seo-tab" data-bs-toggle="pill" data-bs-target="#seo" type="button" role="tab">
                            <i class="fa-solid fa-magnifying-glass me-2"></i> SEO & Tracking
                        </button>
                        <button class="nav-link text-start py-3 px-4 border-0 rounded-3" id="features-tab" data-bs-toggle="pill" data-bs-target="#features" type="button" role="tab">
                            <i class="fa-solid fa-toggle-on me-2"></i> Features & Modules
                        </button>
                    </div>
                </div>

                <!-- Form Content Side -->
                <div class="col-md-9 p-4 p-md-5">
                    <div class="tab-content" id="settingsTabsContent">
                        
                        <!-- 1. General Tab -->
                        <div class="tab-pane fade show active" id="general" role="tabpanel">
                            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" novalidate>
                                @csrf
                                <input type="hidden" name="form_type" value="general">
                                
                                <h4 class="fw-bold mb-4">General Settings</h4>
                                
                                <div class="mb-4">
                                    <label for="website_name" class="form-label fw-semibold text-secondary">Website Name</label>
                                    <input type="text" class="form-control py-3 border-light-subtle bg-light bg-opacity-25" id="website_name" name="website_name" value="{{ \App\Models\Setting::get('website_name', 'News Portal') }}" required>
                                </div>

                                <div class="row g-4 mb-4">
                                    <div class="col-md-6">
                                        <label for="logo" class="form-label fw-semibold text-secondary">Website Logo</label>
                                        <input type="file" class="form-control py-3" id="logo" name="logo">
                                        <span class="small text-secondary">Supported: PNG, JPG, WEBP (Max 1MB)</span>
                                        @if($logo = \App\Models\Setting::get('logo'))
                                            <div class="mt-3 p-2 bg-light rounded-3 d-inline-block">
                                                <img src="{{ $logo }}" alt="Logo" style="max-height: 50px;">
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label for="favicon" class="form-label fw-semibold text-secondary">Favicon</label>
                                        <input type="file" class="form-control py-3" id="favicon" name="favicon">
                                        <span class="small text-secondary">Supported: PNG, ICO (Max 512KB)</span>
                                        @if($favicon = \App\Models\Setting::get('favicon'))
                                            <div class="mt-3 p-2 bg-light rounded-3 d-inline-block">
                                                <img src="{{ $favicon }}" alt="Favicon" style="max-height: 32px;">
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="footer_copyright" class="form-label fw-semibold text-secondary">Footer Copyright Text</label>
                                    <input type="text" class="form-control py-3" id="footer_copyright" name="footer_copyright" value="{{ \App\Models\Setting::get('footer_copyright', '© '.now()->format('Y').' News Portal. All Rights Reserved.') }}">
                                </div>

                                <div class="border-top border-light mt-5 pt-4 text-end">
                                    <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill fw-semibold shadow-sm"><i class="fa-solid fa-circle-check me-2"></i> Save General Settings</button>
                                </div>
                            </form>
                        </div>

                        <!-- 2. Contact Tab -->
                        <div class="tab-pane fade" id="contact" role="tabpanel">
                            <form action="{{ route('admin.settings.update') }}" method="POST" novalidate>
                                @csrf
                                <input type="hidden" name="form_type" value="contact">

                                <h4 class="fw-bold mb-4">Contact Information</h4>
                                
                                <div class="row g-4 mb-4">
                                    <div class="col-md-6">
                                        <label for="email" class="form-label fw-semibold text-secondary">Support Email Address</label>
                                        <input type="email" class="form-control py-3" id="email" name="email" value="{{ \App\Models\Setting::get('email') }}" placeholder="support@domain.com">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label fw-semibold text-secondary">Contact Phone Number</label>
                                        <input type="text" class="form-control py-3" id="phone" name="phone" value="{{ \App\Models\Setting::get('phone') }}" placeholder="+88017000000">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="address" class="form-label fw-semibold text-secondary">Office Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter physical location address">{{ \App\Models\Setting::get('address') }}</textarea>
                                </div>

                                <div class="border-top border-light mt-5 pt-4 text-end">
                                    <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill fw-semibold shadow-sm"><i class="fa-solid fa-circle-check me-2"></i> Save Contact Info</button>
                                </div>
                            </form>
                        </div>

                        <!-- 3. Social Tab -->
                        <div class="tab-pane fade" id="social" role="tabpanel">
                            <form action="{{ route('admin.settings.update') }}" method="POST" novalidate>
                                @csrf
                                <input type="hidden" name="form_type" value="social">

                                <h4 class="fw-bold mb-4">Social Media Profile Links</h4>
                                
                                <div class="row g-4 mb-4">
                                    <div class="col-md-6">
                                        <label for="facebook" class="form-label fw-semibold text-secondary"><i class="fa-brands fa-facebook text-primary me-2"></i> Facebook Page URL</label>
                                        <input type="url" class="form-control py-3" id="facebook" name="facebook" value="{{ \App\Models\Setting::get('facebook') }}" placeholder="https://facebook.com/page">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="twitter" class="form-label fw-semibold text-secondary"><i class="fa-brands fa-x-twitter text-dark me-2"></i> X / Twitter Profile URL</label>
                                        <input type="url" class="form-control py-3" id="twitter" name="twitter" value="{{ \App\Models\Setting::get('twitter') }}" placeholder="https://twitter.com/profile">
                                    </div>
                                </div>

                                <div class="row g-4 mb-4">
                                    <div class="col-md-6">
                                        <label for="instagram" class="form-label fw-semibold text-secondary"><i class="fa-brands fa-instagram text-danger me-2"></i> Instagram Profile URL</label>
                                        <input type="url" class="form-control py-3" id="instagram" name="instagram" value="{{ \App\Models\Setting::get('instagram') }}" placeholder="https://instagram.com/profile">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="youtube" class="form-label fw-semibold text-secondary"><i class="fa-brands fa-youtube text-danger me-2"></i> YouTube Channel URL</label>
                                        <input type="url" class="form-control py-3" id="youtube" name="youtube" value="{{ \App\Models\Setting::get('youtube') }}" placeholder="https://youtube.com/channel">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="telegram" class="form-label fw-semibold text-secondary"><i class="fa-brands fa-telegram text-info me-2"></i> Telegram Channel URL</label>
                                    <input type="url" class="form-control py-3" id="telegram" name="telegram" value="{{ \App\Models\Setting::get('telegram') }}" placeholder="https://t.me/channel">
                                </div>

                                <div class="border-top border-light mt-5 pt-4 text-end">
                                    <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill fw-semibold shadow-sm"><i class="fa-solid fa-circle-check me-2"></i> Save Social Links</button>
                                </div>
                            </form>
                        </div>

                        <!-- 4. SEO Tab -->
                        <div class="tab-pane fade" id="seo" role="tabpanel">
                            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" novalidate>
                                @csrf
                                <input type="hidden" name="form_type" value="seo">

                                <h4 class="fw-bold mb-4">SEO & Tracking Integrations</h4>
                                
                                <div class="mb-4">
                                    <label for="default_seo_title" class="form-label fw-semibold text-secondary">Default Meta Title</label>
                                    <input type="text" class="form-control py-3" id="default_seo_title" name="default_seo_title" value="{{ \App\Models\Setting::get('default_seo_title') }}" placeholder="Latest National & International News">
                                </div>

                                <div class="mb-4">
                                    <label for="default_seo_description" class="form-label fw-semibold text-secondary">Default Meta Description</label>
                                    <textarea class="form-control" id="default_seo_description" name="default_seo_description" rows="3" placeholder="Enter default search engine description">{{ \App\Models\Setting::get('default_seo_description') }}</textarea>
                                </div>

                                <div class="mb-4">
                                    <label for="default_seo_image" class="form-label fw-semibold text-secondary">Default SEO Social Share Image</label>
                                    <input type="file" class="form-control py-3" id="default_seo_image" name="default_seo_image">
                                    <span class="small text-secondary">Supported: PNG, JPG, WEBP (Max 2MB)</span>
                                    @if($seo_img = \App\Models\Setting::get('default_seo_image'))
                                        <div class="mt-3 p-2 bg-light rounded-3 d-inline-block">
                                            <img src="{{ $seo_img }}" alt="SEO Default" style="max-height: 80px;">
                                        </div>
                                    @endif
                                </div>

                                <hr class="my-4 border-light">

                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label for="google_analytics_id" class="form-label fw-semibold text-secondary">Google Analytics measurement ID</label>
                                        <input type="text" class="form-control py-3" id="google_analytics_id" name="google_analytics_id" value="{{ \App\Models\Setting::get('google_analytics_id') }}" placeholder="G-XXXXXXXXXX">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="facebook_pixel_id" class="form-label fw-semibold text-secondary">Facebook Pixel ID</label>
                                        <input type="text" class="form-control py-3" id="facebook_pixel_id" name="facebook_pixel_id" value="{{ \App\Models\Setting::get('facebook_pixel_id') }}" placeholder="1234567890">
                                    </div>
                                </div>

                                <div class="border-top border-light mt-5 pt-4 text-end">
                                    <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill fw-semibold shadow-sm"><i class="fa-solid fa-circle-check me-2"></i> Save SEO Settings</button>
                                </div>
                            </form>
                        </div>

                        <!-- 5. Features Tab -->
                        <div class="tab-pane fade" id="features" role="tabpanel">
                            <form action="{{ route('admin.settings.update') }}" method="POST" novalidate>
                                @csrf
                                <input type="hidden" name="form_type" value="features">

                                <h4 class="fw-bold mb-4">Features & Modules Toggles</h4>
                                
                                <div class="card border-0 bg-light bg-opacity-50 p-4 rounded-3 mb-4">
                                    <h5 class="fw-bold text-dark mb-3">Homepage Content Layout</h5>
                                    
                                    @php
                                        $selectedCats = json_decode(\App\Models\Setting::get('homepage_categories', '[]'), true) ?? [];
                                        $techCat = \App\Models\Setting::get('tech_category', 'technology');
                                    @endphp
                                    
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold text-secondary">Quick News Grid Categories</label>
                                        <div class="d-flex flex-wrap gap-3 p-3 bg-white border border-light-subtle rounded-3">
                                            @if(isset($categories))
                                                @foreach($categories as $category)
                                                    <div class="form-check mb-0">
                                                        <input class="form-check-input" type="checkbox" name="homepage_categories[]" id="cat_{{ $category->id }}" value="{{ $category->slug }}" {{ is_array($selectedCats) && in_array($category->slug, $selectedCats) ? 'checked' : '' }}>
                                                        <label class="form-check-label cursor-pointer" for="cat_{{ $category->id }}">{{ $category->name }}</label>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="text-secondary small mt-2">Check the categories you want to appear in the 4-column quick news grid.</div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="tech_category" class="form-label fw-semibold text-secondary">Special/Tech Section Category</label>
                                        <select class="form-select py-3" id="tech_category" name="tech_category">
                                            @if(isset($categories))
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->slug }}" {{ $techCat == $category->slug ? 'selected' : '' }}>{{ $category->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="card border-0 bg-light bg-opacity-50 p-4 rounded-3 mb-4">
                                    <div class="form-check form-switch d-flex justify-content-between align-items-center ps-0 mb-3">
                                        <div>
                                            <label class="form-check-label fw-bold text-dark fs-6" for="breaking_news_status">Breaking News Ticker</label>
                                            <div class="text-secondary small">Toggle the breaking news marquee banner display on frontend.</div>
                                        </div>
                                        <input class="form-check-input ms-0 border-secondary-subtle" type="checkbox" id="breaking_news_status" name="breaking_news_status" value="1" {{ \App\Models\Setting::get('breaking_news_status', '1') === '1' ? 'checked' : '' }}>
                                    </div>
                                </div>

                                <div class="card border-0 bg-light bg-opacity-50 p-4 rounded-3 mb-4">
                                    <div class="form-check form-switch d-flex justify-content-between align-items-center ps-0 mb-3">
                                        <div>
                                            <label class="form-check-label fw-bold text-dark fs-6" for="comments_status">Comments System</label>
                                            <div class="text-secondary small">Enable reader reviews, comment submissions, and nested replies.</div>
                                        </div>
                                        <input class="form-check-input ms-0 border-secondary-subtle" type="checkbox" id="comments_status" name="comments_status" value="1" {{ \App\Models\Setting::get('comments_status', '1') === '1' ? 'checked' : '' }}>
                                    </div>
                                </div>

                                <div class="card border-0 bg-light bg-opacity-50 p-4 rounded-3">
                                    <div class="form-check form-switch d-flex justify-content-between align-items-center ps-0 mb-3">
                                        <div>
                                            <label class="form-check-label fw-bold text-dark fs-6" for="registration_status">User Registration</label>
                                            <div class="text-secondary small">Allow readers to register accounts to bookmarks and join discussion.</div>
                                        </div>
                                        <input class="form-check-input ms-0 border-secondary-subtle" type="checkbox" id="registration_status" name="registration_status" value="1" {{ \App\Models\Setting::get('registration_status', '1') === '1' ? 'checked' : '' }}>
                                    </div>
                                </div>

                                <div class="border-top border-light mt-5 pt-4 text-end">
                                    <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill fw-semibold shadow-sm"><i class="fa-solid fa-circle-check me-2"></i> Save Features</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Settings Tabs pills hover styling */
    #settingsTabs .nav-link {
        color: var(--text-muted);
        background: transparent;
        transition: all 0.2s ease;
    }
    #settingsTabs .nav-link:hover {
        color: var(--dark-color);
        background: #f1f5f9;
    }
    #settingsTabs .nav-link.active {
        color: var(--primary-color);
        background: rgba(30, 60, 114, 0.08);
        font-weight: 600;
    }
    
    /* Toggle Switch sizing adjustment */
    .form-switch .form-check-input {
        width: 3em;
        height: 1.5em;
    }
</style>
@endsection
