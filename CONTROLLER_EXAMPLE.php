<?php

namespace App\Http\Controllers;

use App\Services\ExternalApiService;
use Illuminate\Http\JsonResponse;

class ExternalApiExampleController extends Controller
{
    protected ExternalApiService $apiService;

    public function __construct(ExternalApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * Contoh: GET request ke external API
     */
    public function fetchUsers(): JsonResponse
    {
        $result = $this->apiService
            ->withToken(env('EXTERNAL_API_KEY'))
            ->get('users');

        if (!$result['success']) {
            return response()->json([
                'error' => $result['error']
            ], $result['status'] ?: 500);
        }

        return response()->json($result['data']);
    }

    /**
     * Contoh: POST request ke external API
     */
    public function createUser(array $data): JsonResponse
    {
        $result = $this->apiService
            ->withToken(env('EXTERNAL_API_KEY'))
            ->post('users', $data);

        if (!$result['success']) {
            return response()->json([
                'error' => $result['error']
            ], $result['status'] ?: 500);
        }

        return response()->json([
            'message' => 'User created successfully',
            'data' => $result['data']
        ], 201);
    }

    /**
     * Contoh: UPDATE request ke external API
     */
    public function updateUser(int $id, array $data): JsonResponse
    {
        $result = $this->apiService
            ->withToken(env('EXTERNAL_API_KEY'))
            ->put("users/{$id}", $data);

        if (!$result['success']) {
            return response()->json([
                'error' => $result['error']
            ], $result['status'] ?: 500);
        }

        return response()->json([
            'message' => 'User updated successfully',
            'data' => $result['data']
        ]);
    }

    /**
     * Contoh: DELETE request ke external API
     */
    public function deleteUser(int $id): JsonResponse
    {
        $result = $this->apiService
            ->withToken(env('EXTERNAL_API_KEY'))
            ->delete("users/{$id}");

        if (!$result['success']) {
            return response()->json([
                'error' => $result['error']
            ], $result['status'] ?: 500);
        }

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }
}
