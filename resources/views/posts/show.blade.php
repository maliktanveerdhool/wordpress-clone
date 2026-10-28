@extends('layouts.app')

@section('title', $post->title.' — '.$siteTitle)
@section('meta_description', $post->display_excerpt)

@section('content')
    <article class="mx-auto max-w-3xl px-4 pt-10 sm:px-6 lg:pt-14">
        <nav class="flex flex-wrap items-center gap-2 text-xs text-stone-500" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="transition hover:text-indigo-700">Home</a>
            <span class="text-stone-300">/</span>
            @if ($post->category)
                <a href="{{ route('categories.show', $post->category) }}" class="transition hover:text-indigo-700">
                    {{ $post->category->name }}
                </a>
                <span class="text-stone-300">/</span>
            @endif
            <span class="truncate text-stone-400">{{ $post->title }}</span>
        </nav>

        <header class="mt-6">
            <div class="flex flex-wrap items-center gap-3">
                <x-category-pill :category="$post->category" />
                <span class="text-xs text-stone-500">{{ $post->published_at?->format('F j, Y') }}</span>
                <span class="text-stone-300">&middot;</span>
                <span class="text-xs text-stone-500">{{ $post->reading_time }} min read</span>
            </div>

            <h1 class="mt-4 font-serif text-4xl leading-[1.08] tracking-tight text-ink sm:text-5xl">
                {{ $post->title }}
            </h1>

            <p class="mt-4 text-lg leading-relaxed text-stone-600">
                {{ $post->display_excerpt }}
            </p>

            <div class="mt-7 flex items-center gap-3 border-y border-stone-200 py-4">
                <x-avatar :name="$post->author->name" size="size-10" />
                <div class="flex-1">
                    <p class="text-sm font-semibold text-ink">{{ $post->author->name }}</p>
                    <p class="text-xs text-stone-500">{{ $post->author->bio ?: 'Staff writer' }}</p>
                </div>
                <div class="hidden items-center gap-2 text-xs text-stone-500 sm:flex">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    {{ number_format($post->views) }} views
                </div>
            </div>
        </header>
    </article>

    <div class="mx-auto mt-8 max-w-4xl px-4 sm:px-6">
        <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}"
             class="aspect-[16/9] w-full rounded-2xl object-cover shadow-lg shadow-stone-900/5">
    </div>

    <div class="mx-auto max-w-3xl px-4 sm:px-6">
        <div class="prose-post mt-10">
            {!! str($post->body)->markdown() !!}
        </div>

        @if ($post->tags->isNotEmpty())
            <div class="mt-10 flex flex-wrap items-center gap-2 border-t border-stone-200 pt-6">
                <span class="text-[11px] font-semibold uppercase tracking-[0.18em] text-stone-500">Tagged</span>
                @foreach ($post->tags as $tag)
                    <a href="{{ route('tags.show', $tag) }}"
                       class="rounded-full border border-stone-200 bg-white px-3 py-1 text-xs text-stone-600 transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-700">
                        #{{ $tag->name }}
                    </a>
                @endforeach
            </div>
        @endif

        <section class="mt-12 rounded-2xl border border-stone-200 bg-white p-6 sm:p-8">
            <div class="flex items-start gap-4">
                <x-avatar :name="$post->author->name" size="size-14" text="text-base" />
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-stone-500">Written by</p>
                    <h2 class="mt-1 font-serif text-2xl text-ink">{{ $post->author->name }}</h2>
                    <p class="mt-2 text-sm leading-relaxed text-stone-600">
                        {{ $post->author->bio ?: 'Writes about the things worth slowing down for.' }}
                    </p>
                    <p class="mt-3 text-xs text-stone-500">
                        {{ $post->author->posts()->where('status', 'published')->count() }} published posts
                    </p>
                </div>
            </div>
        </section>

        <section id="comments" class="mt-14 scroll-mt-24">
            <div class="flex items-end justify-between gap-4 border-b border-stone-200 pb-4">
                <h2 class="font-serif text-3xl tracking-tight text-ink">
                    Comments
                    <span class="ml-1 align-middle text-sm font-sans font-medium text-stone-400">{{ $comments->count() }}</span>
                </h2>
            </div>

            <div class="mt-6 space-y-6">
                @forelse ($comments as $comment)
                    <article class="rounded-2xl border border-stone-200 bg-white p-5">
                        <div class="flex items-center gap-3">
                            <x-avatar :name="$comment->author_name" size="size-9" />
                            <div>
                                <p class="text-sm font-semibold text-ink">{{ $comment->author_name }}</p>
                                <p class="text-xs text-stone-500">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <p class="mt-3 whitespace-pre-line text-sm leading-relaxed text-stone-700">{{ $comment->body }}</p>

                        @foreach ($comment->replies as $reply)
                            <div class="mt-4 rounded-xl border border-stone-100 bg-paper p-4">
                                <div class="flex items-center gap-2.5">
                                    <x-avatar :name="$reply->author_name" size="size-7" text="text-[10px]" />
                                    <p class="text-xs font-semibold text-ink">{{ $reply->author_name }}</p>
                                    <p class="text-[11px] text-stone-500">{{ $reply->created_at->diffForHumans() }}</p>
                                </div>
                                <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-stone-700">{{ $reply->body }}</p>
                            </div>
                        @endforeach
                    </article>
                @empty
                    <p class="rounded-2xl border border-dashed border-stone-300 bg-white p-6 text-center text-sm text-stone-500">
                        No comments yet. Start the conversation below.
                    </p>
                @endforelse
            </div>

            <div class="mt-8 rounded-2xl border border-stone-200 bg-white p-6 sm:p-8">
                <h3 class="font-serif text-2xl text-ink">Leave a comment</h3>
                <p class="mt-1 text-sm text-stone-500">Your email address will not be published.</p>

                <form action="{{ route('comments.store', $post) }}" method="POST" class="mt-6 grid gap-4 sm:grid-cols-2">
                    @csrf
                    <div>
                        <label for="author_name" class="block text-xs font-medium text-stone-700">Name</label>
                        <input id="author_name" name="author_name" type="text" value="{{ old('author_name') }}" required
                               class="mt-1.5 w-full rounded-lg border border-stone-200 bg-paper px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
                    </div>
                    <div>
                        <label for="author_email" class="block text-xs font-medium text-stone-700">Email</label>
                        <input id="author_email" name="author_email" type="email" value="{{ old('author_email') }}" required
                               class="mt-1.5 w-full rounded-lg border border-stone-200 bg-paper px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="body" class="block text-xs font-medium text-stone-700">Comment</label>
                        <textarea id="body" name="body" rows="4" required
                                  class="mt-1.5 w-full rounded-lg border border-stone-200 bg-paper px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">{{ old('body') }}</textarea>
                    </div>
                    <div class="sm:col-span-2">
                        <button type="submit" class="rounded-full bg-ink px-5 py-2.5 text-sm font-medium text-white transition hover:bg-stone-800">
                            Post comment
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>

    @if ($related->isNotEmpty())
        <section class="mx-auto mt-16 max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="border-t border-stone-200 pt-8">
                <h2 class="font-serif text-3xl tracking-tight text-ink">Keep reading</h2>
                <div class="mt-8 grid gap-x-8 gap-y-10 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($related as $relatedPost)
                        <x-post-card :post="$relatedPost" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection