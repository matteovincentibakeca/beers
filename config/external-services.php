<?php

return [
    'services' => [
        'beer_service' => [
            'api_endpoints' => [
                'get' => env('API_BEER', 'https://api.punkapi.com/v2/beers')
            ]
        ]
    ]
];
