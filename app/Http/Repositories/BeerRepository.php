<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Interfaces\BeerRepositoryInterface;
use App\Models\Beer;
use Illuminate\Support\Collection;

class BeerRepository implements BeerRepositoryInterface
{
    private readonly array $endpoints;

    public function __construct()
    {
        $this->endpoints = config('external-services.services.beer_service.api_endpoints');
    }

    public function paginate(int $page = 1): Collection
    {
        if (!$this->endpoints['get']) {
            throw new \RuntimeException('The endpoint get is not defined');
        }

        try {
            return \Http::get($this->endpoints['get'], ['page' => $page])->collect()->map($this->mapResponse());
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    /**
     * @return \Closure
     */
    private function mapResponse(): \Closure
    {
        return static fn($response) => new Beer(
            $response['id'],
            $response['name']
        );
    }
}
