<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="api-base-url" content="{{ url('api/v1') }}">
    @vite('resources/css/app.css')
    <title>Lightshelf</title>
    @if (!Request::is('login') && !Request::is('register'))
        @vite(['resources/js/app.js'])
    @endif

</head>

    <body>

        @auth
            @if (Request::path() !== 'edit-password')
                <div id="app"></div>
            @else
                @yield('auth')
            @endif
        @endauth

        @guest
            @if (Request::is('login') || Request::is('register'))
                @yield('auth')
            @else
                @yield('landing')
            @endif
        @endguest

    </body>

</html>
