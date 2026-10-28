<div class="bg-ink text-stone-300">
    <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-2 text-[11px] tracking-wide sm:px-6 lg:px-8">
        <div class="flex items-center gap-3">
            <span class="hidden font-medium uppercase tracking-[0.18em] text-stone-400 sm:inline">
                {{ now()->format('l, F j, Y') }}
            </span>
            <span class="hidden h-3 w-px bg-white/15 sm:block"></span>
            <span class="truncate text-stone-400">{{ $siteTagline }}</span>
        </div>

        <div class="flex items-center gap-4">
            <a href="{{ route('search') }}" class="hidden items-center gap-1.5 text-stone-400 transition hover:text-white sm:flex">
                <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                Search
            </a>
            @auth
                <a href="{{ route('admin.dashboard') }}" class="font-medium text-white transition hover:text-indigo-300">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="font-medium text-white transition hover:text-indigo-300">
                    Log in
                </a>
            @endauth
        </div>
    </div>
</div>

<header class="sticky top-0 z-40 border-b border-stone-200/80 bg-paper/90 backdrop-blur">
    <div class="mx-auto flex max-w-6xl items-center justify-between gap-6 px-4 py-4 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="group flex shrink-0 items-center gap-3">
            <span class="grid size-10 place-items-center rounded-xl bg-indigo-600 font-serif text-2xl leading-none text-white shadow-sm shadow-indigo-600/30 transition group-hover:bg-indigo-700">
                W
            </span>
            <span class="flex flex-col">
                <span class="whitespace-nowrap font-serif text-2xl leading-none tracking-tight text-ink">{{ $siteTitle }}</span>
                <span class="mt-1 hidden whitespace-nowrap text-[11px] uppercase tracking-[0.18em] text-stone-500 sm:block">
                    {{ $siteTagline }}
                </span>
            </span>
        </a>

        <nav class="hidden items-center gap-0.5 lg:flex">
            <a href="{{ route('home') }}"
               class="rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs('home') ? 'bg-stone-900/5 text-ink' : 'text-stone-600 hover:bg-stone-900/5 hover:text-ink' }}">
                Home
            </a>
            @foreach ($navCategories->take(4) as $navCategory)
                <a href="{{ route('categories.show', $navCategory) }}"
                   class="rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs('categories.show') && request()->route('category')?->is($navCategory) ? 'bg-stone-900/5 text-ink' : 'text-stone-600 hover:bg-stone-900/5 hover:text-ink' }}">
                    {{ $navCategory->name }}
                </a>
            @endforeach
            @foreach ($navPages as $navPage)
                <a href="{{ route('pages.show', $navPage) }}"
                   class="rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs('pages.show') && request()->route('page')?->is($navPage) ? 'bg-stone-900/5 text-ink' : 'text-stone-600 hover:bg-stone-900/5 hover:text-ink' }}">
                    {{ $navPage->title }}
                </a>
            @endforeach
        </nav>

        <div class="flex items-center gap-2">
            <form action="{{ route('search') }}" method="GET" class="hidden items-center lg:flex">
                <label for="header-search" class="sr-only">Search posts</label>
                <div class="relative">
                    <svg class="pointer-events-none absolute left-3 top-1/2 size-4 -translate-y-1/2 text-stone-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <input id="header-search" type="search" name="q" value="{{ request()->routeIs('search') ? request('q') : '' }}"
                           placeholder="Search the site…"
                           class="w-40 rounded-full border border-stone-200 bg-white py-2 pl-9 pr-3 text-sm text-ink placeholder:text-stone-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
                </div>
            </form>

            @auth
                <a href="{{ route('admin.posts.create') }}"
                   class="hidden whitespace-nowrap rounded-full bg-ink px-4 py-2 text-sm font-medium text-white transition hover:bg-stone-800 xl:inline-flex">
                    New post
                </a>
            @endauth

            <details class="group relative lg:hidden">
                <summary class="grid size-10 cursor-pointer list-none place-items-center rounded-lg border border-stone-200 bg-white text-stone-700 transition hover:border-stone-300 [&::-webkit-details-marker]:hidden">
                    <svg class="size-5 group-open:hidden" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <svg class="hidden size-5 group-open:block" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                    <span class="sr-only">Toggle navigation</span>
                </summary>

                <div class="absolute right-0 z-50 mt-2 w-64 rounded-2xl border border-stone-200 bg-white p-3 shadow-xl shadow-stone-900/5">
                    <form action="{{ route('search') }}" method="GET" class="mb-2">
                        <input type="search" name="q" value="{{ request()->routeIs('search') ? request('q') : '' }}"
                               placeholder="Search the site…"
                               class="w-full rounded-lg border border-stone-200 bg-paper px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
                    </form>
                    <div class="flex flex-col">
                        <a href="{{ route('home') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-stone-700 hover:bg-stone-50">Home</a>
                        @foreach ($navCategories as $navCategory)
                            <a href="{{ route('categories.show', $navCategory) }}" class="rounded-lg px-3 py-2 text-sm text-stone-600 hover:bg-stone-50">
                                {{ $navCategory->name }}
                            </a>
                        @endforeach
                        @foreach ($navPages as $navPage)
                            <a href="{{ route('pages.show', $navPage) }}" class="rounded-lg px-3 py-2 text-sm text-stone-600 hover:bg-stone-50">
                                {{ $navPage->title }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </details>
        </div>
    </div>
</header>
