@props(['categories', 'popular', 'tags'])

<aside class="space-y-6">
    <section class="rounded-2xl border border-stone-200 bg-white p-6">
        <div class="flex items-center gap-3">
            <span class="grid size-11 place-items-center rounded-xl bg-indigo-600 font-serif text-xl text-white">W</span>
            <div>
                <p class="text-sm font-semibold text-ink">{{ $siteTitle }}</p>
                <p class="text-xs text-stone-500">{{ $siteTagline }}</p>
            </div>
        </div>
        <p class="mt-4 text-sm leading-relaxed text-stone-600">
            {{ $siteDescription ?: 'A place for thoughtful writing about technology, design, culture and the craft of making things.' }}
        </p>
        <form action="{{ route('search') }}" method="GET" class="mt-5">
            <label for="sidebar-search" class="sr-only">Search posts</label>
            <div class="flex gap-2">
                <input id="sidebar-search" type="search" name="q" placeholder="Search posts…"
                       class="min-w-0 flex-1 rounded-lg border border-stone-200 bg-paper px-3 py-2 text-sm placeholder:text-stone-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
                <button type="submit" class="rounded-lg bg-ink px-3.5 py-2 text-sm font-medium text-white transition hover:bg-stone-800">
                    Go
                </button>
            </div>
        </form>
    </section>

    <section class="rounded-2xl border border-stone-200 bg-white p-6">
        <h2 class="text-[11px] font-semibold uppercase tracking-[0.18em] text-stone-500">Categories</h2>
        <ul class="mt-4 space-y-1">
            @foreach ($categories as $category)
                <li>
                    <a href="{{ route('categories.show', $category) }}"
                       class="group flex items-center justify-between rounded-lg px-2.5 py-2 text-sm text-stone-600 transition hover:bg-stone-50 hover:text-ink">
                        <span class="flex items-center gap-2.5">
                            <span class="size-1.5 rounded-full {{ match ($category->color) {
                                'rose' => 'bg-rose-500',
                                'amber' => 'bg-amber-500',
                                'emerald' => 'bg-emerald-500',
                                'sky' => 'bg-sky-500',
                                'violet' => 'bg-violet-500',
                                default => 'bg-indigo-500',
                            } }}"></span>
                            {{ $category->name }}
                        </span>
                        <span class="rounded-full bg-stone-100 px-2 py-0.5 text-[11px] font-medium text-stone-500">{{ $category->posts_count }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </section>

    @if ($popular->isNotEmpty())
        <section class="rounded-2xl border border-stone-200 bg-white p-6">
            <h2 class="text-[11px] font-semibold uppercase tracking-[0.18em] text-stone-500">Most read</h2>
            <ol class="mt-4 space-y-4">
                @foreach ($popular as $index => $popularPost)
                    <li class="flex gap-3">
                        <span class="font-serif text-xl leading-none text-stone-300">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <div>
                            <a href="{{ route('posts.show', $popularPost) }}" class="text-sm font-medium leading-snug text-ink transition hover:text-indigo-700">
                                {{ $popularPost->title }}
                            </a>
                            <p class="mt-1 text-[11px] text-stone-500">{{ number_format($popularPost->views) }} views</p>
                        </div>
                    </li>
                @endforeach
            </ol>
        </section>
    @endif

    @if ($tags->isNotEmpty())
        <section class="rounded-2xl border border-stone-200 bg-white p-6">
            <h2 class="text-[11px] font-semibold uppercase tracking-[0.18em] text-stone-500">Tags</h2>
            <div class="mt-4 flex flex-wrap gap-2">
                @foreach ($tags as $tag)
                    <a href="{{ route('tags.show', $tag) }}"
                       class="rounded-full border border-stone-200 px-3 py-1 text-xs text-stone-600 transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-700">
                        #{{ $tag->name }}
                    </a>
                @endforeach
            </div>
        </section>
    @endif
</aside>
