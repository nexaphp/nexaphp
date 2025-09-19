<?php
// routes/auth.php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

// Authentication Routes
$app->get('/login', [LoginController::class, 'showLoginForm'])->setName('login');
$app->post('/login', [LoginController::class, 'login']);
$app->post('/logout', [LoginController::class, 'logout'])->setName('logout');

// Registration Routes
$app->get('/register', [RegisterController::class, 'showRegistrationForm'])->setName('register');
$app->post('/register', [RegisterController::class, 'register']);

// Password Reset Routes
$app->get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->setName('password.request');
$app->post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->setName('password.email');
$app->get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->setName('password.reset');
$app->post('/reset-password', [ResetPasswordController::class, 'reset'])->setName('password.update');