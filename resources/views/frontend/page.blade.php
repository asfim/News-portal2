@extends('layouts.app')

@section('title', $page->translated_title . ' | NewsHub Pro')

@section('content')
<main class="container-fluid px-lg-5 py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb m-0 small fw-medium">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted"><i class="fa-solid fa-house me-1"></i> @lang('messages.home')</a></li>
                    <li class="breadcrumb-item active text-danger" aria-current="page">{{ $page->translated_title }}</li>
                </ol>
            </nav>

            <div class="glass-card p-4 p-md-5 rounded-4 shadow-sm border" style="background: var(--nh-surface);">
                <h1 class="fw-black mb-4 pb-3 border-bottom text-uppercase" style="color: var(--nh-text);">
                    {{ $page->translated_title }}
                </h1>

                <div class="page-content mb-5" style="color: var(--nh-text); line-height: 1.8; font-size: 1.1rem;">
                    {!! $page->translated_content !!}
                </div>

                @if($page->slug === 'contact')
                    <hr class="my-5">
                    <div class="contact-section mt-4">
                        <h3 class="fw-bold mb-4" style="color: var(--nh-text);">আমাদের কাছে বার্তা পাঠান</h3>
                        
                        <form action="{{ route('contact.submit') }}" method="POST" class="row g-3">
                            @csrf
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold" style="color: var(--nh-text);">আপনার নাম <span class="text-danger">*</span></label>
                                <input type="text" class="form-control py-2 rounded-3 border" id="name" name="name" required placeholder="নাম লিখুন...">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold" style="color: var(--nh-text);">আপনার ইমেইল <span class="text-danger">*</span></label>
                                <input type="email" class="form-control py-2 rounded-3 border" id="email" name="email" required placeholder="ইমেইল লিখুন...">
                            </div>
                            <div class="col-md-12">
                                <label for="phone" class="form-label fw-semibold" style="color: var(--nh-text);">ফোন নম্বর</label>
                                <input type="text" class="form-control py-2 rounded-3 border" id="phone" name="phone" placeholder="ফোন নম্বর লিখুন...">
                            </div>
                            <div class="col-md-12">
                                <label for="subject" class="form-label fw-semibold" style="color: var(--nh-text);">বিষয় <span class="text-danger">*</span></label>
                                <input type="text" class="form-control py-2 rounded-3 border" id="subject" name="subject" required placeholder="বিষয় লিখুন...">
                            </div>
                            <div class="col-md-12">
                                <label for="message" class="form-label fw-semibold" style="color: var(--nh-text);">বার্তা <span class="text-danger">*</span></label>
                                <textarea class="form-control rounded-3 border" id="message" name="message" rows="5" required placeholder="আপনার বার্তা এখানে লিখুন..."></textarea>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-danger px-4 py-2 fw-bold rounded-pill">বার্তা পাঠান <i class="fa-solid fa-paper-plane ms-1"></i></button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection
