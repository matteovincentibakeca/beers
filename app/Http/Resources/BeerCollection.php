<?php

namespace App\Http\Resources;

use App\Http\Requests\BeerRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BeerCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $beerRequest = new BeerRequest($request);

        return [
            'data' => $this->collection,
            'links' => [
                'self' => $this->getSelfLink($beerRequest),
                'next' => $this->getNextLink($beerRequest),
                'prev' => $this->getPrevLink($beerRequest),
            ],
        ];
    }

    private function getSelfLink(BeerRequest $request): ?string
    {
        return route('api.beers', ['page' => $request->getPage()]);
    }

    private function getPrevLink(BeerRequest $request): ?string
    {
        if ($request->getPage() - 1 <= 0) {
            return null;
        }

        return route('api.beers', ['page' => $request->getPage() - 1]);
    }

    private function getNextLink(BeerRequest $request): ?string
    {
        return route('api.beers', ['page' => $request->getPage() + 1]);
    }
}
