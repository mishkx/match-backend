<?php

return [
    'cache' => [
        'time' => env('OPTION_CACHE_TIME', 60),
    ],
    'oauth' => [
        'services' => env('OAUTH_SERVICES', ''),
    ],
];
