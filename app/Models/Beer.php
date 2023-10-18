<?php

namespace App\Models;

class Beer
{
    public function __construct(
        public readonly int $id,
        public readonly string $name
    )
    {
    }
}
