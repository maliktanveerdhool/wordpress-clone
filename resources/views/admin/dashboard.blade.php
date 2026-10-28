@extends('layouts.admin')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('content')
    <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-indigo-600">{{ now()->format('l, F j') }}</p>
            <h2 class="mt-1 font-serif text-3xl tracking-tight text-ink">Welcome back, {{ auth()->user()->name }}</h2>
            <p class="mt-1 text-sm text-stone-500">Here is what is happening on {{ $siteTitle }} today.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.comments.index', ['filter' => 'pending']) }}"
               class="rounded-lg border border-stone-200 bg-white px-4 py-2 text-sm font-medium text-stone-700 transition hover:border-stone-300">
                Moderate comments
            </a>
            <a href="{{ route('admin.posts.create') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-ink px-4 py-2 text-sm font-medium text-white transition hover:bg-stone-800">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                New post
            </a>
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @php
            $cards = [
                ['label' => 'Published posts', 'value' => number_format($stats['published']), 'hint' => $stats['drafts'].' '.\Illuminate\Support\Str::plural('draft', $stats['drafts']).' waiting', 'tone' => 'indigo'],
                ['label' => 'Total views', 'value' => number_format($stats['views']), 'hint' => 'Across all published posts', 'tone' => 'emerald'],
                ['label' => 'Comments', 'value' => number_format($stats['comments']), 'hint' => $stats['pending_comments'].' pending review', 'tone' => 'amber'],
                ['label' => 'Categories', 'value' => number_format($stats['categories']), 'hint' => 'Organising your content', 'tone' => 'violet'],
            ];
        @endphp

        @foreach ($cards as $card)
            <div class="rounded-2xl border border-stone-200 bg-white p-5">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-medium text-stone-500">{{ $card['label'] }}</p>
                    <span class="size-2 rounded-full {{ match ($card['tone']) {
                        'emerald' => 'bg-emerald-500',
                        'amber' => 'bg-amber-500',
                        'violet' => 'bg-violet-500',
                        default => 'bg-indigo-500',
                    } }}"></span>
                </div>
                <p class="mt-3 font-serif text-4xl tracking-tight text-ink">{{ $card['value'] }}</p>
                <p class="mt-1 text-xs text-stone-500">{{ $card['hint'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-3">
        <section class="rounded-2xl border border-stone-200 bg-white xl:col-span-2">
            <div class="flex items-center justify-between border-b border-stone-100 px-5 py-4">
                <h3 class="text-sm font-semibold text-ink">Recently updated</h3>
                <a href="{{ route('admin.posts.index') }}" class="text-xs font-medium text-indigo-600 transition hover:text-indigo-800">
                    All posts &rarr;
                </a>
            </div>

            <div class="divide-y divide-stone-100">
                @forelse ($recentPosts as $post)
                    <div class="flex items-center gap-3 px-5 py-3.5">
                        <img src="{{ $post->featured_image_url }}" alt="" class="size-10 shrink-0 rounded-lg object-cover">
                        <div class="min-w-0 flex-1">
                            <a href="{{ route('admin.posts.edit', $post) }}" class="block truncate text-sm font-medium text-ink transition hover:text-indigo-700">
                                {{ $post->title }}
                            </a>
                            <p class="mt-0.5 truncate text-xs text-stone-500">
                                {{ $post->category?->name ?? 'Uncategorised' }} &middot; {{ $post->updated_at->diffForHumans() }}
                            </p>
                        </div>
                        <span class="shrink-0 rounded-full px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide {{ $post->status === 'published' ? 'bg-emerald-50 text-emerald-700' : 'bg-stone-100 text-stone-600' }}">
                            {{ $post->status }}
                        </span>
                    </div>
                @empty
                    <p class="px-5 py-8 text-center text-sm text-stone-500">No posts yet.</p>
                @endforelse
            </div>
        </section>

        <section class="rounded-2xl border border-stone-200 bg-white">
            <div class="flex items-center justify-between border-b border-stone-100 px-5 py-4">
                <h3 class="text-sm font-semibold text-ink">Latest comments</h3>
                <a href="{{ route('admin.comments.index') }}" class="text-xs font-medium text-indigo-600 transition hover:text-indigo-800">
                    All &rarr;
                </a>
            </div>

            <div class="divide-y divide-stone-100">
                @forelse ($recentComments as $comment)
                    <div class="px-5 py-3.5">
                        <div class="flex items-center gap-2">
                            <x-avatar :name="$comment->author_name" size="size-6" text="text-[9px]" />
                            <p class="text-xs font-semibold text-ink">{{ $comment->author_name }}</p>
                            @unless ($comment->is_approved)
                                <span class="rounded-full bg-amber-50 px-2 py-0.5 text-[10px] font-semibold text-amber-700">Pending</span>
                            @endunless
                        </div>
                        <p class="mt-1.5 line-clamp-2 text-xs leading-relaxed text-stone-600">{{ $comment->body }}</p>
                        <p class="mt-1 truncate text-[11px] text-stone-400">on {{ $comment->post->title }}</p>
                    </div>
                @empty
                    <p class="px-5 py-8 text-center text-sm text-stone-500">No comments yet.</p>
                @endforelse
            </div>
        </section>
    </div>

    <section class="mt-6 rounded-2xl border border-stone-200 bg-white">
        <div class="border-b border-stone-100 px-5 py-4">
            <h3 class="text-sm font-semibold text-ink">Most viewed posts</h3>
        </div>
        <div class="divide-y divide-stone-100">
            @forelse ($topPosts as $index => $post)
                <div class="flex items-center gap-4 px-5 py-3">
                    <span class="w-6 font-serif text-lg text-stone-300">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <a href="{{ route('admin.posts.edit', $post) }}" class="min-w-0 flex-1 truncate text-sm font-medium text-ink transition hover:text-indigo-700">
                        {{ $post->title }}
                    </a>
                    <span class="text-xs tabular-nums text-stone-500">{{ number_format($post->views) }} views</span>
                </div>
            @empty
                <p class="px-5 py-8 text-center text-sm text-stone-500">Nothing published yet.</p>
            @endforelse
        </div>
    </section>
@endsection
