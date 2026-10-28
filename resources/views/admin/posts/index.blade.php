@extends('layouts.admin')

@section('title', 'Posts')
@section('heading', 'Posts')

@section('content')
    <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="font-serif text-3xl tracking-tight text-ink">Posts</h2>
            <p class="mt-1 text-sm text-stone-500">Write, publish and manage everything on the blog.</p>
        </div>
        <a href="{{ route('admin.posts.create') }}"
           class="inline-flex items-center gap-2 rounded-lg bg-ink px-4 py-2 text-sm font-medium text-white transition hover:bg-stone-800">
            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Add new
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-stone-200 bg-white">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-stone-100 px-4 py-3">
            <div class="flex items-center gap-1">
                @foreach ([
                    'all' => ['label' => 'All', 'count' => $counts['all']],
                    'published' => ['label' => 'Published', 'count' => $counts['published']],
                    'draft' => ['label' => 'Drafts', 'count' => $counts['draft']],
                ] as $key => $tab)
                    <a href="{{ route('admin.posts.index', array_filter(['status' => $key === 'all' ? null : $key, 'q' => request('q')])) }}"
                       class="rounded-lg px-3 py-1.5 text-xs font-medium transition {{ (request('status', 'all') ?: 'all') === $key ? 'bg-stone-900 text-white' : 'text-stone-600 hover:bg-stone-100' }}">
                        {{ $tab['label'] }}
                        <span class="ml-1 {{ (request('status', 'all') ?: 'all') === $key ? 'text-white/60' : 'text-stone-400' }}">{{ $tab['count'] }}</span>
                    </a>
                @endforeach
            </div>

            <form action="{{ route('admin.posts.index') }}" method="GET" class="flex items-center gap-2">
                @if (request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <label for="post-search" class="sr-only">Search posts</label>
                <input id="post-search" type="search" name="q" value="{{ request('q') }}" placeholder="Search posts…"
                       class="w-48 rounded-lg border border-stone-200 bg-paper px-3 py-1.5 text-xs placeholder:text-stone-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
                <button type="submit" class="rounded-lg border border-stone-200 px-3 py-1.5 text-xs font-medium text-stone-600 transition hover:border-stone-300">
                    Search
                </button>
            </form>
        </div>

        @if ($posts->isEmpty())
            <div class="px-6 py-16 text-center">
                <p class="font-serif text-2xl text-ink">No posts found</p>
                <p class="mt-2 text-sm text-stone-500">Try a different search, or write your first post.</p>
                <a href="{{ route('admin.posts.create') }}" class="mt-5 inline-flex rounded-lg bg-ink px-4 py-2 text-sm font-medium text-white transition hover:bg-stone-800">
                    Write a post
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-stone-100 text-left">
                    <thead class="bg-stone-50/60">
                        <tr class="text-[11px] uppercase tracking-wider text-stone-500">
                            <th class="px-4 py-3 font-semibold">Title</th>
                            <th class="px-4 py-3 font-semibold">Status</th>
                            <th class="hidden px-4 py-3 font-semibold md:table-cell">Category</th>
                            <th class="hidden px-4 py-3 font-semibold lg:table-cell">Author</th>
                            <th class="hidden px-4 py-3 font-semibold sm:table-cell">Comments</th>
                            <th class="hidden px-4 py-3 font-semibold lg:table-cell">Date</th>
                            <th class="px-4 py-3 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @foreach ($posts as $post)
                            <tr class="group transition hover:bg-stone-50/60">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $post->featured_image_url }}" alt="" class="hidden size-11 rounded-lg object-cover sm:block">
                                        <div class="min-w-0">
                                            <a href="{{ route('admin.posts.edit', $post) }}" class="block max-w-xs truncate text-sm font-medium text-ink transition hover:text-indigo-700">
                                                {{ $post->title }}
                                            </a>
                                            <p class="mt-0.5 max-w-xs truncate text-xs text-stone-500">{{ $post->display_excerpt }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="rounded-full px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide {{ $post->status === 'published' ? 'bg-emerald-50 text-emerald-700' : 'bg-stone-100 text-stone-600' }}">
                                        {{ $post->status }}
                                    </span>
                                </td>
                                <td class="hidden px-4 py-3 text-sm text-stone-600 md:table-cell">
                                    {{ $post->category?->name ?? '—' }}
                                </td>
                                <td class="hidden px-4 py-3 text-sm text-stone-600 lg:table-cell">
                                    {{ $post->author->name }}
                                </td>
                                <td class="hidden px-4 py-3 text-sm text-stone-600 sm:table-cell">
                                    {{ $post->comments_count }}
                                </td>
                                <td class="hidden px-4 py-3 text-xs text-stone-500 lg:table-cell">
                                    {{ ($post->published_at ?? $post->updated_at)->format('M j, Y') }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('posts.show', $post) }}" target="_blank"
                                           class="grid size-8 place-items-center rounded-lg text-stone-400 transition hover:bg-stone-100 hover:text-ink" title="View">
                                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.posts.edit', $post) }}"
                                           class="grid size-8 place-items-center rounded-lg text-stone-400 transition hover:bg-indigo-50 hover:text-indigo-600" title="Edit">
                                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST"
                                              onsubmit="return confirm('Delete “{{ addslashes($post->title) }}”? This cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="grid size-8 place-items-center rounded-lg text-stone-400 transition hover:bg-rose-50 hover:text-rose-600" title="Delete">
                                                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="border-t border-stone-100 px-4 py-3">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
@endsection
