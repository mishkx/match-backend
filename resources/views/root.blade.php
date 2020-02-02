<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>
<div id="root"></div>
<script src="/static/js/bundle.js"></script>
<script src="/static/js/main.chunk.js"></script>
{{--<link rel="stylesheet" href="{{ \App\Helpers::asset('main.css') }}">--}}
{{--<script src="{{ \App\Helpers::asset('runtime-main.js') }}"></script>--}}
{{--<script src="{{ \App\Helpers::asset('main.js') }}"></script>--}}
</body>
</html>
