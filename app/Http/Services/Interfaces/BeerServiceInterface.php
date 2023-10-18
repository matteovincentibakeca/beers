<?php

namespace App\Http\Services\Interfaces;

use App\Http\Requests\BeerRequest;
use Illuminate\Support\Collection;

interface BeerServiceInterface
{
    public function getPaginatedBeerList(BeerRequest $request): Collection;
}
