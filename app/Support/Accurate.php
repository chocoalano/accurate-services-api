<?php

namespace App\Support;

use Illuminate\Support\Facades\Log;

class Accurate
{
    private string $publicBaseUrl;
    private string $privateBaseUrl;
    private string $token;
    private string $secretKey;

    public function __construct()
    {
        $this->publicBaseUrl = config('app.accurate_public_url', 'https://public.accurate.id/accurate');
        $this->privateBaseUrl = config('app.accurate_private_url', 'https://account.accurate.id');
        $this->token = config('app.token_accurate');
        $this->secretKey = config('app.signature_accurate');
    }

    /**
     * Get current timestamp for signature
     */
    private function getTimestamp(): string
    {
        return now()->format('d/m/Y H:i:s');
    }

    /**
     * Generate HMAC SHA256 signature
     */
    private function signature(string $timestamp): string
    {
        return hash_hmac('sha256', $timestamp, $this->secretKey);
    }

    /**
     * Send GET request using cURL
     */
    public function get(bool $isPublic, string $url, array $headers = [], array $query = []): mixed
    {
        return $this->sendRequest($isPublic, 'GET', $url, $query, $headers);
    }

    /**
     * Send POST request using cURL
     */
    public function post(bool $isPublic, string $url, array $data = [], array $headers = []): mixed
    {
        return $this->sendRequest($isPublic, 'POST', $url, $data, $headers);
    }

    /**
     * Send PUT request using cURL
     */
    public function put(bool $isPublic, string $url, array $data = [], array $headers = []): mixed
    {
        return $this->sendRequest($isPublic, 'PUT', $url, $data, $headers);
    }

    /**
     * Send DELETE request using cURL
     */
    public function delete(bool $isPublic, string $url, array $data = [], array $headers = []): mixed
    {
        return $this->sendRequest($isPublic, 'DELETE', $url, $data, $headers);
    }

    /**
     * Main cURL handler
     */
    private function sendRequest(bool $isPublic, string $method, string $url, array $data = [], array $headers = []): mixed
    {
        $curl = curl_init();

        $timestamp = $this->getTimestamp();
        $signature = $this->signature($timestamp);

        // Default Headers
        $defaultHeaders = [
            'Accept: application/json',
            'Content-Type: application/json',
            'X-Api-Timestamp: ' . $timestamp,
            'X-Api-Signature: ' . $signature,
            'Authorization: Bearer ' . $this->token,
        ];

        // Merge Custom Headers
        $allHeaders = array_merge($defaultHeaders, $headers);

        $baseUrl = $isPublic ? $this->publicBaseUrl : $this->privateBaseUrl;

        $finalUrl = $baseUrl . '/api/' . ltrim($url, '/');
        if ($method === 'GET' && !empty($data)) {
            $finalUrl .= '?' . http_build_query($data);
        }

        curl_setopt_array($curl, [
            CURLOPT_URL => $finalUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $allHeaders,
            CURLOPT_TIMEOUT => 30,
        ]);

        if (in_array($method, ['POST', 'PUT', 'DELETE'])) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error = curl_error($curl);

        curl_close($curl);

        if ($error) {
            Log::error("cURL Error: " . $error);
            return [
                'success' => false,
                'status' => $httpCode,
                'error' => $error,
            ];
        }

        $decodedResponse = json_decode($response, true);
        if ($httpCode >= 400) {
            Log::error("HTTP Error [$httpCode]: " . $response);
            return [
                'success' => false,
                'status' => $httpCode,
                'error' => $decodedResponse,
            ];
        }
        return [
            'success' => true,
            'status' => $httpCode,
            'data' => $decodedResponse,
        ];
    }
}
