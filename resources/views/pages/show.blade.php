@extends('layouts.app')

@section('title', $page->title.' — '.$siteTitle)
@section('meta_description', str($page->body)->stripTags()->limit(150))

@section('content')
    <article class="mx-auto max-w-3xl px-4 pt-10 sm:px-6 lg:pt-14">
        <nav class="flex items-center gap-2 text-xs text-stone-500" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="transition hover:text-indigo-700">Home</a>
            <span class="text-stone-300">/</span>
            <span class="text-stone-400">{{ $page->title }}</span>
        </nav>

        <header class="mt-6 border-b border-stone-200 pb-8">
            <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-indigo-600">Page</p>
            <h1 class="mt-2 font-serif text-4xl leading-tight tracking-tight text-ink sm:text-5xl">{{ $page->title }}</h1>
            <p class="mt-3 text-xs text-stone-500">
                Last updated {{ $page->updated_at->format('F j, Y') }}
            </p>
        </header>

        <div class="prose-post mt-8">
            {!! str($page->body)->markdown() !!}
        </div>

        <div class="mt-12 flex items-center justify-between border-t border-stone-200 pt-6 text-sm">
            <a href="{{ route('home') }}" class="font-medium text-stone-600 transition hover:text-indigo-700">&larr; Back to home</a>
            <a href="{{ route('search') }}" class="font-medium text-stone-600 transition hover:text-indigo-700">Search the site</a>
        </div>
    </article>
@endsection
