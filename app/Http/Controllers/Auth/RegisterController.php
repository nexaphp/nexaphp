<?php
// app/Controllers/Auth/RegisterController.php

namespace App\Http\Controllers\Auth;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Nexacore\Http\Controllers\Controller;
use App\Models\User;

class RegisterController extends Controller
{
    public function showRegistrationForm(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->view($response, 'auth/register.twig');
    }

    public function register(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $request->getParsedBody();
        
        // Validate data
        $errors = $this->validateRegistration($data);
        
        if (!empty($errors)) {
            return $this->view($response, 'auth/register.twig', [
                'errors' => $errors,
                'data' => $data,
            ]);
        }

        // Create user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        // Auto-login after registration
        $this->auth->login($user);

        return $response->withHeader('Location', '/dashboard')->withStatus(302);
    }

    protected function validateRegistration(array $data): array
    {
        $errors = [];

        if (empty($data['name'])) {
            $errors['name'] = 'Name is required';
        }

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Valid email is required';
        }

        if (empty($data['password']) || strlen($data['password']) < 8) {
            $errors['password'] = 'Password must be at least 8 characters';
        }

        if ($data['password'] !== $data['password_confirmation']) {
            $errors['password_confirmation'] = 'Passwords do not match';
        }

        // Check if email exists
        if (User::where('email', $data['email'])->exists()) {
            $errors['email'] = 'Email already exists';
        }

        return $errors;
    }
}