<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Interfaces\BeerRepositoryInterface;
use App\Models\Beer;
use Illuminate\Support\Collection;

class BeerRepository implements BeerRepositoryInterface
{
    public function __construct()
    {
    }

    public function paginate(int $page = 1): Collection
    {
        try {
            return \Http::get("https://api.punkapi.com/v2/beers", [
                'page' => $page
            ])->collect()->map(fn ($response) => new Beer(
                $response['id'],
                $response['name']
            ));
        } catch (\Exception $exception) {
            dd($exception);
        }
    }
}
