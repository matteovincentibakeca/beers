<?php

namespace App\Http\Requests;

class BeerRequest
{
    public function __construct(private readonly \Illuminate\Http\Request $request)
    {
    }

    public function getPage(): int
    {
        return (int) $this->request->get('page', 1);
    }
}
