<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ \App\Helpers::asset('main.css') }}">
</head>
<body>
<style>
    #root, body, html {
        height: 100%;
        width: 100%;
        padding: 0;
        margin: 0;
        overflow: hidden;
    }
</style>
<div id="root"></div>
<script src="{{ \App\Helpers::asset('runtime-main.js') }}"></script>
<script src="{{ \App\Helpers::asset('main.js') }}"></script>
</body>
</html>
