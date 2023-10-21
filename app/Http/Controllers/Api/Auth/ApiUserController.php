<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiUserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => 'ok',
            'messages' => 'The user',
            'data' => [
                'user' => Auth::user(),
            ],
        ]);
    }
}
