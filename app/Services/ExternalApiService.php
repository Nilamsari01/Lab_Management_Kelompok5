<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\ConnectionException;

class ExternalApiService
{
    protected string $baseUrl;
    protected array $headers = [];
    protected int $timeout = 30;
    protected int $retries = 3;

    public function __construct()
    {
        $this->baseUrl = config('services.external_api.base_url', 'https://api.example.com');
    }

    /**
     * Set custom base URL
     */
    public function setBaseUrl(string $url): self
    {
        $this->baseUrl = $url;
        return $this;
    }

    /**
     * Set custom headers
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * Add authorization header
     */
    public function withToken(string $token): self
    {
        $this->headers['Authorization'] = "Bearer {$token}";
        return $this;
    }

    /**
     * Make GET request
     */
    public function get(string $endpoint, array $query = []): array
    {
        try {
            $response = Http::withHeaders($this->headers)
                ->timeout($this->timeout)
                ->retry($this->retries, 100)
                ->get("{$this->baseUrl}/{$endpoint}", $query);

            return $this->handleResponse($response);
        } catch (ConnectionException $e) {
            return $this->handleError("Connection error: {$e->getMessage()}");
        }
    }

    /**
     * Make POST request
     */
    public function post(string $endpoint, array $data = []): array
    {
        try {
            $response = Http::withHeaders($this->headers)
                ->timeout($this->timeout)
                ->retry($this->retries, 100)
                ->post("{$this->baseUrl}/{$endpoint}", $data);

            return $this->handleResponse($response);
        } catch (ConnectionException $e) {
            return $this->handleError("Connection error: {$e->getMessage()}");
        }
    }

    /**
     * Make PUT request
     */
    public function put(string $endpoint, array $data = []): array
    {
        try {
            $response = Http::withHeaders($this->headers)
                ->timeout($this->timeout)
                ->retry($this->retries, 100)
                ->put("{$this->baseUrl}/{$endpoint}", $data);

            return $this->handleResponse($response);
        } catch (ConnectionException $e) {
            return $this->handleError("Connection error: {$e->getMessage()}");
        }
    }

    /**
     * Make DELETE request
     */
    public function delete(string $endpoint): array
    {
        try {
            $response = Http::withHeaders($this->headers)
                ->timeout($this->timeout)
                ->retry($this->retries, 100)
                ->delete("{$this->baseUrl}/{$endpoint}");

            return $this->handleResponse($response);
        } catch (ConnectionException $e) {
            return $this->handleError("Connection error: {$e->getMessage()}");
        }
    }

    /**
     * Handle response
     */
    protected function handleResponse(Response $response): array
    {
        if ($response->successful()) {
            return [
                'success' => true,
                'data' => $response->json(),
                'status' => $response->status()
            ];
        }

        return [
            'success' => false,
            'error' => $response->json('message', 'Unknown error'),
            'status' => $response->status()
        ];
    }

    /**
     * Handle errors
     */
    protected function handleError(string $message): array
    {
        \Log::error("External API Error: {$message}");
        
        return [
            'success' => false,
            'error' => $message,
            'status' => 0
        ];
    }
}
