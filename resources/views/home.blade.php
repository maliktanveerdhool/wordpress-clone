@extends('layouts.app')

@section('title', $siteTitle.' — '.$siteTagline)
@section('meta_description', $siteDescription)

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14">
        @if ($featured)
            <section class="relative overflow-hidden rounded-3xl bg-ink text-white shadow-xl shadow-stone-900/10">
                <img src="{{ $featured->featured_image_url }}" alt="{{ $featured->title }}"
                     class="absolute inset-0 size-full object-cover opacity-80">
                <div class="absolute inset-0 bg-gradient-to-tr from-ink via-ink/75 to-ink/25"></div>

                <div class="relative flex min-h-[26rem] flex-col justify-end p-6 sm:min-h-[30rem] sm:p-10 lg:max-w-3xl lg:p-12">
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="rounded-full bg-white/15 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-white backdrop-blur">
                            Featured
                        </span>
                        @if ($featured->category)
                            <span class="text-[11px] font-semibold uppercase tracking-[0.18em] text-stone-300">
                                {{ $featured->category->name }}
                            </span>
                        @endif
                    </div>

                    <h1 class="mt-5 font-serif text-4xl leading-[1.1] tracking-tight sm:text-5xl">
                        <a href="{{ route('posts.show', $featured) }}" class="transition hover:text-indigo-200">
                            {{ $featured->title }}
                        </a>
                    </h1>

                    <p class="mt-4 max-w-xl text-sm leading-relaxed text-stone-300 sm:text-base">
                        {{ $featured->display_excerpt }}
                    </p>

                    <div class="mt-7 flex flex-wrap items-center gap-3 text-xs text-stone-300">
                        <x-avatar :name="$featured->author->name" size="size-8" text="text-[10px]" class="ring-2 ring-white/20" />
                        <span class="font-medium text-white">{{ $featured->author->name }}</span>
                        <span class="text-stone-500">/</span>
                        <span>{{ $featured->published_at?->format('F j, Y') }}</span>
                        <span class="text-stone-500">/</span>
                        <span>{{ $featured->reading_time }} min read</span>
                    </div>
                </div>
            </section>
        @endif

        <div class="mt-14 grid gap-12 lg:grid-cols-[minmax(0,1fr)_320px]">
            <section>
                <div class="flex items-end justify-between gap-4 border-b border-stone-200 pb-4">
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-indigo-600">The latest</p>
                        <h2 class="mt-1 font-serif text-3xl tracking-tight text-ink">Fresh from the press</h2>
                    </div>
                    <a href="{{ route('search') }}" class="hidden text-sm font-medium text-stone-600 transition hover:text-indigo-700 sm:inline-flex">
                        Browse all posts &rarr;
                    </a>
                </div>

                @if ($posts->isEmpty())
                    <div class="mt-8 rounded-2xl border border-dashed border-stone-300 bg-white p-10 text-center">
                        <p class="font-serif text-2xl text-ink">Nothing published yet</p>
                        <p class="mt-2 text-sm text-stone-600">Check back soon — new stories are on the way.</p>
                    </div>
                @else
                    <div class="mt-8 grid gap-x-8 gap-y-12 sm:grid-cols-2">
                        @foreach ($posts as $post)
                            <x-post-card :post="$post" />
                        @endforeach
                    </div>

                    <div class="mt-12">
                        {{ $posts->links() }}
                    </div>
                @endif
            </section>

            @include('partials.sidebar', compact('categories', 'popular', 'tags'))
        </div>
    </div>
@endsection
