<?php

namespace App\Http\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface BeerRepositoryInterface
{
    public function paginate(int $page = 1): Collection;
}
