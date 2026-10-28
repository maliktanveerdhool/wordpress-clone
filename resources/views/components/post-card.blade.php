@props(['post'])

<article class="group flex flex-col">
    <a href="{{ route('posts.show', $post) }}" class="relative block overflow-hidden rounded-2xl bg-stone-100">
        <img src="{{ $post->featured_image_url }}"
             alt="{{ $post->title }}"
             loading="lazy"
             class="aspect-[16/10] w-full object-cover transition duration-500 ease-out group-hover:scale-[1.03]">
        <div class="absolute inset-0 bg-gradient-to-t from-ink/30 via-transparent to-transparent opacity-0 transition duration-500 group-hover:opacity-100"></div>
    </a>

    <div class="flex flex-1 flex-col pt-4">
        <div class="flex flex-wrap items-center gap-x-3 gap-y-2">
            <x-category-pill :category="$post->category" />
            <span class="text-xs text-stone-500">{{ $post->published_at?->format('M j, Y') }}</span>
            <span class="text-stone-300">&middot;</span>
            <span class="text-xs text-stone-500">{{ $post->reading_time }} min read</span>
        </div>

        <h3 class="mt-3 line-clamp-3 font-serif text-2xl leading-snug tracking-tight text-ink">
            <a href="{{ route('posts.show', $post) }}" class="transition hover:text-indigo-700">
                {{ $post->title }}
            </a>
        </h3>

        <p class="mt-2 line-clamp-2 text-sm leading-relaxed text-stone-600">
            {{ $post->display_excerpt }}
        </p>

        <div class="mt-auto flex items-center gap-2.5 pt-4">
            <x-avatar :name="$post->author->name" size="size-7" text="text-[10px]" />
            <span class="text-xs font-medium text-stone-700">{{ $post->author->name }}</span>
        </div>
    </div>
</article>
