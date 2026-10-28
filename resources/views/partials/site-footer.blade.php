<footer class="mt-20 border-t border-stone-200 bg-white">
    <div class="mx-auto grid max-w-6xl gap-10 px-4 py-14 sm:px-6 lg:grid-cols-4 lg:px-8">
        <div class="lg:col-span-2">
            <div class="flex items-center gap-3">
                <span class="grid size-9 place-items-center rounded-lg bg-indigo-600 font-serif text-xl leading-none text-white">W</span>
                <span class="font-serif text-xl text-ink">{{ $siteTitle }}</span>
            </div>
            <p class="mt-4 max-w-sm text-sm leading-relaxed text-stone-600">
                {{ $siteDescription ?: 'A WordPress-style publishing site built with Laravel — posts, categories, tags, comments and a full admin dashboard.' }}
            </p>
            <p class="mt-4 text-xs text-stone-500">{{ $footerText ?: 'Proudly powered by Laravel and Tailwind CSS.' }}</p>
        </div>

        <div>
            <h2 class="text-[11px] font-semibold uppercase tracking-[0.18em] text-stone-500">Categories</h2>
            <ul class="mt-4 space-y-2.5">
                @foreach ($navCategories->take(5) as $navCategory)
                    <li>
                        <a href="{{ route('categories.show', $navCategory) }}" class="group flex items-center justify-between text-sm text-stone-600 transition hover:text-indigo-700">
                            <span>{{ $navCategory->name }}</span>
                            <span class="text-xs text-stone-400">{{ $navCategory->posts_count }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div>
            <h2 class="text-[11px] font-semibold uppercase tracking-[0.18em] text-stone-500">Pages</h2>
            <ul class="mt-4 space-y-2.5">
                @foreach ($navPages as $navPage)
                    <li>
                        <a href="{{ route('pages.show', $navPage) }}" class="text-sm text-stone-600 transition hover:text-indigo-700">
                            {{ $navPage->title }}
                        </a>
                    </li>
                @endforeach
                <li>
                    <a href="{{ route('search') }}" class="text-sm text-stone-600 transition hover:text-indigo-700">Search</a>
                </li>
                <li>
                    <a href="{{ route('login') }}" class="text-sm text-stone-600 transition hover:text-indigo-700">Admin login</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="border-t border-stone-100">
        <div class="mx-auto flex max-w-6xl flex-col gap-2 px-4 py-5 text-xs text-stone-500 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <p>&copy; {{ now()->year }} {{ $siteTitle }}. All rights reserved.</p>
            <p class="flex items-center gap-1.5">
                <span class="inline-block size-1.5 rounded-full bg-emerald-500"></span>
                Built with Laravel {{ Illuminate\Foundation\Application::VERSION }}
            </p>
        </div>
    </div>
</footer>
