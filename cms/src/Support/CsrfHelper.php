<?php

namespace App\Support;

use Exception;

class CsrfValidationException extends Exception {}

class CsrfHelper
{
    /**
     * Validates CSRF token for POST requests.
     *
     * @param string $key Session key for CSRF token.
     * @throws CsrfValidationException If validation fails.
     */
    public function handle(string $key = 'csrfToken'): void
    {
        $this->ensureSession();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['_csrf'] ?? '';
            $sessionToken = $_SESSION[$key] ?? '';

            if (hash_equals($sessionToken, $token)) {
                $this->clearToken($key); // Optional: Clear token after validation
                return;
            }

            throw new CsrfValidationException('Error: Invalid CSRF', 419);
        }
    }

    /**
     * Ensures the session is started.
     */
    private function ensureSession(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    /**
     * Generates a CSRF token and stores it in the session.
     *
     * @param string $key Session key for CSRF token.
     * @return string The CSRF token.
     */
    public function generateToken(string $key = 'csrfToken'): string
    {
        $this->ensureSession();

        if (empty($_SESSION[$key])) {
            $_SESSION[$key] = bin2hex(random_bytes(32));
        }

        return $_SESSION[$key];
    }

    /**
     * Clears the CSRF token from the session.
     *
     * @param string $key Session key for CSRF token.
     */
    private function clearToken(string $key): void
    {
        unset($_SESSION[$key]);
    }
}
