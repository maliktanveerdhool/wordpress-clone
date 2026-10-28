@extends('layouts.app')

@section('title', ($query !== '' ? 'Search: '.$query : 'Search').' — '.$siteTitle)

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14">
        <header class="border-b border-stone-200 pb-8">
            <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-indigo-600">Search</p>
            <h1 class="mt-2 font-serif text-4xl tracking-tight text-ink sm:text-5xl">
                {{ $query !== '' ? 'Results for “'.$query.'”' : 'Find something to read' }}
            </h1>

            <form action="{{ route('search') }}" method="GET" class="mt-6 flex max-w-xl gap-2">
                <label for="search-q" class="sr-only">Search posts</label>
                <input id="search-q" type="search" name="q" value="{{ $query }}" autofocus
                       placeholder="Search posts, topics, ideas…"
                       class="min-w-0 flex-1 rounded-lg border border-stone-200 bg-white px-4 py-2.5 text-sm placeholder:text-stone-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
                <button type="submit" class="rounded-lg bg-ink px-5 py-2.5 text-sm font-medium text-white transition hover:bg-stone-800">
                    Search
                </button>
            </form>

            @if ($query !== '')
                <p class="mt-4 text-sm text-stone-600">
                    {{ $posts->total() }} {{ Str::plural('post', $posts->total()) }} found.
                    <a href="{{ route('search') }}" class="ml-1 font-medium text-indigo-700 hover:underline">Clear search</a>
                </p>
            @endif
        </header>

        @if ($posts->isEmpty())
            <div class="mt-10 rounded-2xl border border-dashed border-stone-300 bg-white p-10 text-center">
                <p class="font-serif text-2xl text-ink">No matching posts</p>
                <p class="mt-2 text-sm text-stone-600">Try a different keyword, or browse the latest stories from the home page.</p>
                <a href="{{ route('home') }}" class="mt-5 inline-flex rounded-full bg-ink px-5 py-2.5 text-sm font-medium text-white transition hover:bg-stone-800">
                    Back to home
                </a>
            </div>
        @else
            <div class="mt-10 grid gap-x-8 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($posts as $post)
                    <x-post-card :post="$post" />
                @endforeach
            </div>

            <div class="mt-12">{{ $posts->links() }}</div>
        @endif
    </div>
@endsection
