<?php

namespace App\Controllers\Api\V1;

use App\Core\Controller;
use App\Services\AuthService;

class AuthApiController extends Controller {
    private AuthService $authService;

    public function __construct() {
        $this->authService = new AuthService();
    }

    public function login(): void {
        $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $email = $input['email'] ?? '';
        $password = $input['password'] ?? '';

        $result = $this->authService->login($email, $password);
        if ($result['success']) {
            $user = $result['user'];
            unset($user['password']);
            $this->success('Login successful.', ['user' => $user]);
        } else {
            $this->error($result['message'], [], 401);
        }
    }

    public function register(): void {
        $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $result = $this->authService->register($input);

        if ($result['success']) {
            $user = $result['user'];
            unset($user['password']);
            $this->success('Registration successful.', ['user' => $user], 201);
        } else {
            $this->error('Validation failed.', $result['errors'], 422);
        }
    }

    public function me(): void {
        $user = AuthService::user();
        if ($user) {
            $this->success('Authenticated user retrieved.', ['user' => $user]);
        } else {
            $this->error('Unauthenticated.', [], 401);
        }
    }

    public function logout(): void {
        AuthService::logout();
        $this->success('Logged out successfully.');
    }
}
