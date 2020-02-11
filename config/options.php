<?php

return [
    /*
     * Время кеширования, в минутах.
     */
    'cache' => [
        'time' => env('OPTION_CACHE_TIME', 60),
    ],

    /*
     * Доступные сервисы для авторизации. Формат: service1,service2
     */
    'oauth' => [
        'services' => env('OAUTH_SERVICES', ''),
    ],

    'match' => [
        /*
         * Количество совпадений, которые будут загружаться за один запрос.
         */
        'limit' => env('MATCH_ITEMS_LIMIT', 20),

        /*
         * Количество дней, в течение которых пользователь будет отображаться в поиске
         * после его последней активности.
         */
        'userPresenceDays' => env('MATCH_USER_PRESENCE_DAYS', 30),

        /*
         * Количество дней, после окончания которых пользователи могут снова оценивать друг друга
         * после того, как один из пользователей оценил другого негативно.
         */
        'renewalPeriod' => env('MATCH_RENEWAL_PERIOD', 365),

        /*
         * Количество дней, после окончания которых пользователи могут снова оценивать друг друга
         * после того, как один из пользователей оценил другого негативно.
         */
        'recommendationItemsLimit' => env('MATCH_RECOMMENDATION_ITEMS_LIMIT', 10),
    ],

    'chat' => [
        /*
         * Количество чатов, которые будут загружаться за один запрос.
         */
        'threads' => [
            'limit' => env('CHAT_THREADS_LIMIT', 20),
        ],

        /*
         * Количество сообщений, которые будут загружаться за один запрос.
         */
        'messages' => [
            'limit' => env('CHAT_MESSAGES_LIMIT', 50),
        ],
    ],

    'assets' => [
        'directory' => '/build',
        'file' => '/asset-manifest.json',
    ],

    'faker' => env('APP_FAKER', false),

    'locales' => [
        'en',
        'ru',
    ],
];
