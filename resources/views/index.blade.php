<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="api-base-url" content="{{ url('api/v1') }}">
    @vite('resources/css/app.css')
    @vite(['resources/js/app.js'])
    <title>Breitling League</title>

</head>

<body>
    @auth
        <div id="app"></div>
    @endauth

    @guest
        @yield('auth')
    @endguest
</body>

</html>
