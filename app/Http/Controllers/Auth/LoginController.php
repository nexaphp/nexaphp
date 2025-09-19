<?php
// app/Controllers/Auth/LoginController.php

namespace App\Http\Controllers\Auth;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Nexacore\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function showLoginForm(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->view($response, 'auth/login.twig');
    }

    public function login(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $request->getParsedBody();
        $credentials = [
            'email' => $data['email'] ?? '',
            'password' => $data['password'] ?? '',
        ];

        $remember = isset($data['remember']);

        if ($this->auth->attempt($credentials, $remember)) {
            return $response->withHeader('Location', '/dashboard')->withStatus(302);
        }

        return $this->view($response, 'auth/login.twig', [
            'error' => 'Invalid credentials',
            'email' => $credentials['email'],
        ]);
    }

    public function logout(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $this->auth->logout();
        return $response->withHeader('Location', '/login')->withStatus(302);
    }
}