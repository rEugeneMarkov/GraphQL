<?php

namespace Tests;

use App\Services\AuthService;

trait SendGraphQLRequest
{
    private function sendGraphQLRequest($query, $baseUrl = 'http://localhost', $authToken = '')
    {
        $ch = curl_init($baseUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'X-APP-ENV: testing',
            'Authorization: Bearer ' . $authToken,
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['query' => $query]));
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    private function getAuthToken($email, $password)
    {
        try {
            $authService = AuthService::getInstance();

            $loginData = [
                'email' => $email,
                'password' => $password,
            ];

            $token = $authService->loginUser($loginData);

            return $token;
        } catch (\Exception $e) {
            return null;
        }
    }
}
