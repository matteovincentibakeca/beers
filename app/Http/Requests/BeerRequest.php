<?php

namespace App\Http\Requests;

class BeerRequest
{
    public function __construct(private readonly \Illuminate\Http\Request $request)
    {
    }

    public function getPage(): int
    {
        $page = (int) $this->request->get('page', 1);

        if ($page <= 0) {
            $page = 1;
        }

        return $page;
    }
}
