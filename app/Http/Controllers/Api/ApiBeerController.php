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
        $beerRequest = new BeerRequest($request);
        $page = $beerRequest->getPage();

        try {
            return \response()->json([
                'success' => true,
                'message' => 'OK',
                'data' => \Cache::remember("beers:$page", now()->addMinutes(15), function () use ($beerRequest) {
                    return new BeerCollection($this->service->getPaginatedBeerList($beerRequest));
                }),
            ]);
        } catch (\Exception $exception) {
            return \response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
