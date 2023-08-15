<?php

namespace App\Services;

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService
{
    private string $key;
    private string $issuer = 'your_issuer';
    public static ?self $instance = null;

    public function __construct()
    {
        $this->key = $_ENV['APP_KEY'];
    }

    public static function getInstance(): self
    {
        if (!self::$instance) {
            self::$instance = new AuthService();
        }
        return self::$instance;
    }

    public function createToken($userId): string
    {
        $payload = [
            'iss' => $this->issuer,
            'sub' => $userId,
            'iat' => time(),
            'exp' => time() + 3600,
        ];

        return JWT::encode($payload, $this->key, 'HS256');
    }

    public function validateToken($token): bool
    {
        try {
            JWT::decode($token, new Key($this->key, 'HS256'));
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function registerUser($data): string
    {
        $existingUser = User::where('email', '=', $data['email'])->get();
        if ($existingUser) {
            throw new \Exception('User already exists');
        }
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $user = User::create($data);

        return $this->createToken($user->id);
    }

    public function loginUser($data): string
    {
        $user = User::where('email', '=', $data['email'])->get();
        if (empty($user)) {
            throw new \Exception('User dont exists');
        }
        if (!password_verify($data['password'], $user[0]['password'])) {
            throw new \Exception('Incorrect password');
        }
        return $this->createToken($user[0]['id']);
    }

    public function checkAuthentication(): void
    {
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        $token = str_replace('Bearer ', '', $authHeader);

        if (!$this->validateToken($token)) {
            throw new \Exception('Unauthorized');
        }
    }
}
