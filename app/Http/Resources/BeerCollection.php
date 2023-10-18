<?php

namespace App\Http\Resources;

use App\Http\Requests\BeerRequest;
use App\Http\Services\Interfaces\BeerServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BeerCollection extends ResourceCollection
{
    public function __construct($resource, protected readonly BeerRequest $beerRequest)
    {
        parent::__construct($resource);
    }


    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'links' => [
                'self' => $this->getSelfLink(),
                'next' => $this->getNextLink(),
                'prev' => $this->getPrevLink(),
            ],
        ];
    }

    private function getSelfLink(): ?string
    {
        return route('api.beers', [
            'page' => $this->beerRequest->getPage()
        ]);
    }

    private function getPrevLink(): ?string
    {
        $prevPage = $this->beerRequest->getPage() - 1;
        return $prevPage <= 0 ? null : route('api.beers', ['page' => $prevPage]);
    }

    private function getNextLink(): ?string
    {
        $nextPage = $this->beerRequest->getPage() + 1;

        if ($this->resource->count() === 0) {
            return null;
        }

        return route('api.beers', ['page' => $nextPage]);
    }
}
