<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\AdvertisementController;
use App\Http\Controllers\Admin\MenuController;

use App\Http\Controllers\Frontend\HomeController;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/latest-news', [HomeController::class, 'latestNews'])->name('news.latest');
Route::get('/quick-news', [HomeController::class, 'quickNews'])->name('news.quick');
Route::get('/news/{slug}', [HomeController::class, 'showNews'])->name('news.show');
Route::get('/category/{slug}', [HomeController::class, 'category'])->name('category');
Route::get('/api/category/{id}/layout/{layout_type}', [HomeController::class, 'getCategoryNewsHtml'])->name('api.category.layout');
Route::get('/tag/{slug}', [HomeController::class, 'tag'])->name('tag');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::post('/newsletter/subscribe', [HomeController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/page/{slug}', [HomeController::class, 'showPage'])->name('page.show');
Route::post('/contact/submit', [HomeController::class, 'submitContact'])->name('contact.submit');

Route::middleware('guest')->group(function () {
    // Login
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);

    // Register
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    // Password Reset
    Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // User dashboard
    Route::get('dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

    // Admin panel
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('settings', [SettingController::class, 'index'])->name('settings');
        Route::post('settings', [SettingController::class, 'update'])->name('settings.update');

        // Categories CRUD
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::post('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');

        // Subcategories CRUD
        Route::resource('subcategories', SubcategoryController::class)->except(['show']);
        Route::post('subcategories/{subcategory}/toggle-status', [SubcategoryController::class, 'toggleStatus'])->name('subcategories.toggle-status');

        // News CRUD
        Route::get('categories/{category}/subcategories', [NewsController::class, 'getSubcategories'])->name('categories.subcategories');
        Route::resource('news', NewsController::class)->except(['show']);
        Route::post('editor-upload', [\App\Http\Controllers\Admin\EditorUploadController::class, 'upload'])->name('editor.upload');

        // Tags CRUD
        Route::resource('tags', TagController::class)->except(['show']);
        Route::post('tags/{tag}/toggle-status', [TagController::class, 'toggleStatus'])->name('tags.toggle-status');

        // Menu Management CRUD (Disabled as per user request)
        // Route::resource('menus', MenuController::class)->except(['show']);
        // Route::post('menus/{menu}/toggle-status', [MenuController::class, 'toggleStatus'])->name('menus.toggle-status');

        // Static Pages CRUD
        Route::resource('pages', PageController::class)->except(['show']);
        Route::post('pages/{page}/toggle-status', [PageController::class, 'toggleStatus'])->name('pages.toggle-status');

        // Authors CRUD
        Route::resource('authors', AuthorController::class)->except(['show']);
        Route::post('authors/{author}/toggle-status', [AuthorController::class, 'toggleStatus'])->name('authors.toggle-status');

        // Users CRUD
        Route::resource('users', UserController::class)->except(['show']);
        Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

        // Comments Moderation
        Route::get('comments', [CommentController::class, 'index'])->name('comments.index');
        Route::post('comments/{comment}/status', [CommentController::class, 'updateStatus'])->name('comments.status');
        Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

        // Media Library CRUD
        Route::resource('media', MediaController::class)->only(['index', 'store', 'update', 'destroy']);

        // Advertisements CRUD
        Route::resource('advertisements', AdvertisementController::class)->except(['show']);
        Route::post('advertisements/{advertisement}/toggle-status', [AdvertisementController::class, 'toggleStatus'])->name('advertisements.toggle-status');

        // Newsletter Subscribers
        Route::get('subscribers', [NewsletterController::class, 'index'])->name('subscribers.index');
        Route::delete('subscribers/{subscriber}', [NewsletterController::class, 'destroy'])->name('subscribers.destroy');
        Route::post('subscribers/{subscriber}/toggle-status', [NewsletterController::class, 'toggleStatus'])->name('subscribers.toggle-status');

        // Contact Inbox
        Route::get('contacts', [ContactController::class, 'index'])->name('contacts.index');
        Route::delete('contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
        Route::post('contacts/{contact}/toggle-read', [ContactController::class, 'toggleRead'])->name('contacts.toggle-read');
    });
});
