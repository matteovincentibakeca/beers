<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiLoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        if (\Auth::check()) {
            return $this->getSuccessResponse();
        }

        if (\Auth::attempt($request->validated())) {
            return $this->getSuccessResponse();
        }

        return response()->json(['error' => 'Authentication failed']);
    }

    private function getSuccessResponse(): JsonResponse {
        return response()->json([
            'success' => 'ok',
            'messages' => 'User is authenticated',
            'data' => [
                'token' => \Auth::user()?->createToken('api-token-name')->plainTextToken
            ]
        ]);
    }
}
