@extends('layouts.app')

@section('title', '#'.$tag->name.' — '.$siteTitle)
@section('meta_description', 'Posts tagged '.$tag->name)

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14">
        <nav class="flex items-center gap-2 text-xs text-stone-500" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="transition hover:text-indigo-700">Home</a>
            <span class="text-stone-300">/</span>
            <span class="text-stone-400">Tag</span>
        </nav>

        <header class="mt-6 border-b border-stone-200 pb-8">
            <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-indigo-600">Tagged</p>
            <h1 class="mt-2 font-serif text-4xl tracking-tight text-ink sm:text-5xl">#{{ $tag->name }}</h1>
            <p class="mt-3 text-sm text-stone-600">
                {{ $posts->total() }} {{ Str::plural('post', $posts->total()) }} with this tag.
            </p>
        </header>

        @if ($posts->isEmpty())
            <p class="mt-10 rounded-2xl border border-dashed border-stone-300 bg-white p-10 text-center text-sm text-stone-500">
                No posts with this tag yet.
            </p>
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
