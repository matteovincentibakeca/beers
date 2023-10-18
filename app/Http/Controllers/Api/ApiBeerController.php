<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BeerRequest;
use App\Http\Resources\BeerCollection;
use App\Http\Services\Interfaces\BeerServiceInterface;
use Illuminate\Http\Request;

class ApiBeerController extends Controller
{
    public function __construct(private readonly BeerServiceInterface $service)
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json(
            new BeerCollection(
                $this->service->getPaginatedBeerList(
                    new BeerRequest($request)
                )
            )
        );
    }
}
