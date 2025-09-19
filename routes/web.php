<?php
// routes/web.php

use App\Http\Controllers\{
    HomeController,
    UserController,
    PostController,
    ProfileController
};
use App\Http\Controllers\Auth\{
    LoginController,
    RegisterController
};

// Apply route macros
Nexacore\Routing\RouteMacros::register($app);

// Home routes
$app->get('/', [HomeController::class, 'index'])->name('home');
$app->view('/about', 'pages/about.twig')->name('about');
$app->view('/contact', 'pages/contact.twig')->name('contact');

// Auth routes with guest middleware
$app->group('', function ($group) {
    $group->get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    $group->post('/login', [LoginController::class, 'login']);
    $group->get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    $group->post('/register', [RegisterController::class, 'register']);
})->middleware('guest');

// Protected routes with auth middleware
$app->group('', function ($group) {
    $group->post('/logout', [LoginController::class, 'logout'])->name('logout');
    $group->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile resource
    $group->resource('/profile', ProfileController::class)->only(['show', 'update']);
    
    // Users resource with admin middleware
    $group->resource('/users', UserController::class)
          ->middleware('admin')
          ->names('users');
    
    // Posts resource with custom constraints
    $group->resource('/posts', PostController::class)
          ->where(['post' => '[a-z0-9-]+'])
          ->names('posts');
    
    // API-like routes within web group
    $group->group('/api', function ($api) {
        $api->get('/stats', [StatsController::class, 'index'])->name('api.stats');
        $api->post('/upload', [UploadController::class, 'store'])->name('api.upload');
    })->middleware('auth.api');
    
})->middleware('auth');

// Redirects
$app->redirect('/home', '/');
$app->redirect('/old-page', '/new-page', 301);

// Fallback route (must be last)
$app->get('/{path:.*}', function ($request, $response, $args) {
    return $response->withHeader('Location', '/')->withStatus(302);
})->name('fallback');