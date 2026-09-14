<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\AuthService;
use App\Middleware\CSRFMiddleware;

class AuthController extends Controller {
    private AuthService $authService;

    public function __construct() {
        $this->authService = new AuthService();
    }

    public function showLogin(): void {
        if (AuthService::check()) {
            redirect('/dashboard');
        }
        $this->view('auth.login', [
            'pageTitle' => 'Merchant & Customer Login - Nabrijan',
            'error' => $_SESSION['flash_error'] ?? null,
            'success' => $_SESSION['flash_success'] ?? null
        ]);
        unset($_SESSION['flash_error'], $_SESSION['flash_success']);
    }

    public function handleLogin(): void {
        CSRFMiddleware::handle();
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $result = $this->authService->login($email, $password);
        if ($result['success']) {
            $user = $result['user'];
            if ($user['role'] === 'super_admin' || $user['role'] === 'admin') {
                redirect('/admin');
            } else {
                redirect('/dashboard');
            }
        } else {
            $_SESSION['flash_error'] = $result['message'];
            redirect('/login');
        }
    }

    public function showRegister(): void {
        if (AuthService::check()) {
            redirect('/dashboard');
        }
        $this->view('auth.register', [
            'pageTitle' => 'Create Your Online Store - Nabrijan',
            'errors' => $_SESSION['flash_errors'] ?? [],
            'old' => $_SESSION['flash_old'] ?? []
        ]);
        unset($_SESSION['flash_errors'], $_SESSION['flash_old']);
    }

    public function handleRegister(): void {
        CSRFMiddleware::handle();
        $data = [
            'name' => $_POST['name'] ?? '',
            'email' => $_POST['email'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'password' => $_POST['password'] ?? '',
            'confirm_password' => $_POST['confirm_password'] ?? '',
            'role' => 'merchant'
        ];

        $result = $this->authService->register($data);
        if ($result['success']) {
            $_SESSION['flash_success'] = 'Account created successfully! Let\'s setup your store.';
            redirect('/onboarding');
        } else {
            $_SESSION['flash_errors'] = $result['errors'];
            $_SESSION['flash_old'] = $data;
            redirect('/register');
        }
    }

    public function showForgotPassword(): void {
        $this->view('auth.forgot-password', [
            'pageTitle' => 'Forgot Password - Nabrijan',
            'message' => $_SESSION['flash_message'] ?? null
        ]);
        unset($_SESSION['flash_message']);
    }

    public function handleForgotPassword(): void {
        CSRFMiddleware::handle();
        $email = $_POST['email'] ?? '';
        $_SESSION['flash_message'] = 'If an account exists for ' . sanitize($email) . ', a password reset link has been sent.';
        redirect('/forgot-password');
    }

    public function logout(): void {
        AuthService::logout();
        redirect('/login');
    }
}
