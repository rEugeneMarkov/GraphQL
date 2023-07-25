<?php

namespace Tests;

trait SendGraphQLRequest
{
    public function sendGraphQLRequest($query, $baseUrl = 'http://localhost')
    {
        $ch = curl_init($baseUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'X-APP-ENV: ' . $_ENV['APP_ENV'],
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['query' => $query]));
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}
