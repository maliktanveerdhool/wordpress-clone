<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', $siteTitle ?? config('app.name'))</title>
        <meta name="description" content="@yield('meta_description', $siteDescription ?? '')">

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex min-h-screen flex-col bg-paper font-sans text-ink antialiased">
        <a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded-lg focus:bg-white focus:px-4 focus:py-2 focus:text-sm focus:shadow-lg">
            Skip to content
        </a>

        @include('partials.site-header')

        <main id="main" class="flex-1">
            @yield('content')
        </main>

        @include('partials.site-footer')
        @include('partials.flash')

        @stack('scripts')
    </body>
</html>
