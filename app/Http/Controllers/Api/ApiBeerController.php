<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BeerRequest;
use App\Http\Resources\BeerCollection;
use App\Http\Services\Interfaces\BeerServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ApiBeerController extends Controller
{
    private const CACHE_DURATION = 1;

    /**
     * @param BeerServiceInterface $service
     */
    public function __construct(private readonly BeerServiceInterface $service)
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(BeerRequest $beerRequest): \Illuminate\Http\JsonResponse
    {
        try {
            return \response()->json([
                'success' => true,
                'message' => 'OK',
                'data' => new BeerCollection($this->getData($beerRequest->getPage(), $beerRequest), $beerRequest),
            ]);
        } catch (\Exception $exception) {
            return \response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
                500
            ]);
        }
    }

    /**
     * @param int $page
     * @param BeerRequest $beerRequest
     * @return mixed
     */
    private function getData(int $page, BeerRequest $beerRequest): Collection
    {
        return \Cache::remember("beers:$page", now()->addMinutes(self::CACHE_DURATION), function () use ($beerRequest) {
            return $this->service->getPaginatedBeerList($beerRequest);
        });
    }
}
