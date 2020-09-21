<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel Vue App</title>
        <link href="{{ URL::asset('/css/app.css') }}" rel="stylesheet"/>

    </head>
    <body>
        <div id="app">
            <div class="container">
                <nav>
                    <router-link to="/shop">Shop</router-link>
                    <router-link to="/orders">Orders</router-link>
                    <router-link to="/process">Process Orders</router-link>
                </nav>
                <router-view></router-view>
            </div>
        </div>
        <script src="{{ asset('js/app.js') }}" defer></script>

    </body>
</html>