<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Dashboard') — {{ $siteTitle }} Admin</title>
        <meta name="robots" content="noindex">

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-stone-100 font-sans text-ink antialiased">
        <div class="lg:flex">
            @include('partials.admin.sidebar')

            <div class="flex min-h-screen flex-1 flex-col">
                <header class="sticky top-0 z-30 border-b border-stone-200 bg-white/90 backdrop-blur">
                    <div class="flex items-center justify-between gap-4 px-4 py-3.5 sm:px-6 lg:px-8">
                        <div class="flex items-center gap-3">
                            <h1 class="text-sm font-semibold text-ink">@yield('heading', 'Dashboard')</h1>
                            <span class="hidden rounded-full bg-stone-100 px-2.5 py-0.5 text-[11px] font-medium text-stone-500 sm:inline">
                                Admin
                            </span>
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('home') }}" target="_blank"
                               class="hidden items-center gap-1.5 rounded-lg border border-stone-200 bg-white px-3 py-1.5 text-xs font-medium text-stone-600 transition hover:border-stone-300 hover:text-ink sm:inline-flex">
                                <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                </svg>
                                View site
                            </a>

                            <div class="flex items-center gap-2.5 rounded-lg border border-stone-200 bg-white py-1 pl-1 pr-3">
                                <x-avatar :name="auth()->user()->name" size="size-7" text="text-[10px]" />
                                <div class="hidden leading-tight sm:block">
                                    <p class="text-xs font-semibold text-ink">{{ auth()->user()->name }}</p>
                                    <p class="text-[10px] text-stone-500">Administrator</p>
                                </div>
                            </div>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="grid size-9 place-items-center rounded-lg border border-stone-200 bg-white text-stone-500 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-600"
                                        title="Log out">
                                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                    </svg>
                                    <span class="sr-only">Log out</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </header>

                <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
                    @yield('content')
                </main>
            </div>
        </div>

        @include('partials.flash')
    </body>
</html>
