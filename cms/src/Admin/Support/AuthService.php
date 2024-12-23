<?php

namespace App\Admin\Support;

use PDO;

class AuthService
{
    public function __construct(private PDO $pdo)
    {

    }

    private function ensureSession(): void
    {
        if (session_id() === '') {
            session_start();
        }

    }

    public function handleLogin(string $username, string $password): bool
    {
        if (!$username || !$password) return false;
        $stmt = $this->pdo->prepare("SELECT `id`, `password` FROM `users` WHERE username = :username");
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        $entry = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$entry) {
            return false;
        }
        $hash = $entry['password'];
        $passwordOk = password_verify($password, $hash);
        if (!$passwordOk) {
            return false;
        }
        $this->ensureSession();
        $_SESSION['adminUserId'] = $entry['id'];
        session_regenerate_id(true);
        return true;
    }

    public function isLoggedIn(): bool
    {
        $this->ensureSession();
        return !empty($_SESSION['adminUserId']);
    }

    public function ensureLoggedIn(): void
    {
        $loggedIn = $this->isLoggedIn();
        if (empty($loggedIn)) {
            header('Location: index.php?' . http_build_query(['route' => 'admin/login']));
            die();
        }
    }

    public function logout()
    {
        $this->ensureLoggedIn();
        unset($_SESSION['adminUserId']);
        session_destroy();

    }


}