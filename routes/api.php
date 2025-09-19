<?php
// routes/api.php

use App\Http\Controllers\Api\{
    UserController,
    PostController,
    AuthController
};

// API routes with versioning and middleware
$app->group('/api/v1', function ($group) {
    
    // Auth routes
    $group->post('/auth/login', [AuthController::class, 'login'])->name('api.auth.login');
    $group->post('/auth/register', [AuthController::class, 'register'])->name('api.auth.register');
    $group->post('/auth/refresh', [AuthController::class, 'refresh'])->name('api.auth.refresh');
    
    // Protected routes
    $group->group('', function ($protected) {
        
        // Auth management
        $protected->post('/auth/logout', [AuthController::class, 'logout'])->name('api.auth.logout');
        $protected->get('/auth/me', [AuthController::class, 'me'])->name('api.auth.me');
        
        // API resources
        $protected->apiResource('/users', UserController::class)->names('api.users');
        $protected->apiResource('/posts', PostController::class)->names('api.posts');
        
        // Custom API endpoints
        $protected->get('/dashboard', [DashboardController::class, 'apiIndex'])->name('api.dashboard');
        $protected->get('/search', [SearchController::class, 'apiSearch'])->name('api.search');
        
    })->middleware(['auth:api', 'throttle:60,1']);
    
    // Public API endpoints
    $group->get('/public/posts', [PostController::class, 'publicIndex'])->name('api.public.posts');
    $group->get('/public/posts/{slug}', [PostController::class, 'publicShow'])->name('api.public.posts.show');
    
})->middleware(['api', 'cors']);

// API v2 routes
$app->group('/api/v2', function ($group) {
    $group->apiResource('/users', \App\Controllers\Api\V2\UserController::class);
    $group->apiResource('/posts', \App\Controllers\Api\V2\PostController::class);
})->middleware(['api', 'cors']);