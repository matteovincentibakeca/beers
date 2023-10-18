<?php

namespace App\Http\Services;

use App\Http\Repositories\Interfaces\BeerRepositoryInterface;
use App\Http\Requests\BeerRequest;
use App\Http\Services\Interfaces\BeerServiceInterface;
use Illuminate\Support\Collection;

class BeerService implements BeerServiceInterface
{
    public function __construct(protected readonly BeerRepositoryInterface $repository)
    {
    }

    public function getPaginatedBeerList(BeerRequest $request): Collection
    {
        return $this->repository->paginate($request->getPage());
    }
}
