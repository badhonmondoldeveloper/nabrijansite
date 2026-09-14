<?php

namespace App\Services;

use App\Models\User;
use App\Helpers\Security;

class AuthService {
    private User $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    /**
     * Register a new merchant or customer.
     */
    public function register(array $data): array {
        $errors = [];

        // Validation
        if (empty($data['name'])) {
            $errors['name'] = 'Full Name is required.';
        }
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Valid Email Address is required.';
        } elseif ($this->userModel->findByEmail($data['email'])) {
            $errors['email'] = 'This email address is already registered.';
        }

        if (empty($data['phone'])) {
            $errors['phone'] = 'Phone number is required.';
        }

        if (empty($data['password']) || strlen($data['password']) < 6) {
            $errors['password'] = 'Password must be at least 6 characters long.';
        }

        if (($data['password'] ?? '') !== ($data['confirm_password'] ?? '')) {
            $errors['confirm_password'] = 'Passwords do not match.';
        }

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        $hashedPassword = Security::hashPassword($data['password']);
        $userId = $this->userModel->createCustomerOrMerchant([
            'name' => trim($data['name']),
            'email' => trim(strtolower($data['email'])),
            'phone' => trim($data['phone']),
            'password' => $hashedPassword,
            'role' => $data['role'] ?? 'merchant'
        ]);

        $user = $this->userModel->find($userId);
        $this->loginUserSession($user);

        return ['success' => true, 'user' => $user];
    }

    /**
     * Attempt login with email and password.
     */
    public function login(string $email, string $password): array {
        $user = $this->userModel->findByEmail(trim(strtolower($email)));

        if (!$user) {
            return ['success' => false, 'message' => 'Invalid email or password.'];
        }

        if ($user['status'] !== 'active') {
            return ['success' => false, 'message' => 'Your account has been suspended or deactivated.'];
        }

        if (!Security::verifyPassword($password, $user['password'])) {
            return ['success' => false, 'message' => 'Invalid email or password.'];
        }

        $this->loginUserSession($user);
        return ['success' => true, 'user' => $user];
    }

    /**
     * Set secure user session upon authentication.
     */
    private function loginUserSession(array $user): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];
    }

    /**
     * Destroy authentication session.
     */
    public static function logout(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }

    /**
     * Get currently logged-in user array or null.
     */
    public static function user(): ?array {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!empty($_SESSION['user_id'])) {
            return [
                'id' => $_SESSION['user_id'],
                'name' => $_SESSION['user_name'] ?? '',
                'email' => $_SESSION['user_email'] ?? '',
                'role' => $_SESSION['user_role'] ?? 'customer'
            ];
        }
        return null;
    }

    /**
     * Check if user is authenticated.
     */
    public static function check(): bool {
        return self::user() !== null;
    }

    /**
     * Check if user has specified role.
     */
    public static function hasRole(string $role): bool {
        $user = self::user();
        return $user && $user['role'] === $role;
    }
}
