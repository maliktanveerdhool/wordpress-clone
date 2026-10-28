@extends('layouts.admin')

@section('title', 'Categories')
@section('heading', 'Categories')

@section('content')
    <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="font-serif text-3xl tracking-tight text-ink">Categories</h2>
            <p class="mt-1 text-sm text-stone-500">Group posts into the sections readers browse.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}"
           class="inline-flex items-center gap-2 rounded-lg bg-ink px-4 py-2 text-sm font-medium text-white transition hover:bg-stone-800">
            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Add category
        </a>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        @forelse ($categories as $category)
            <div class="flex flex-col rounded-2xl border border-stone-200 bg-white p-5">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <span class="grid size-10 place-items-center rounded-xl text-sm font-semibold {{ $category->color_classes }}">
                            {{ $category->initials }}
                        </span>
                        <div>
                            <h3 class="text-sm font-semibold text-ink">{{ $category->name }}</h3>
                            <p class="text-xs text-stone-500">/categories/{{ $category->slug }}</p>
                        </div>
                    </div>
                    <span class="rounded-full bg-stone-100 px-2.5 py-1 text-[11px] font-medium text-stone-600">
                        {{ $category->posts_count }} {{ Str::plural('post', $category->posts_count) }}
                    </span>
                </div>

                <p class="mt-3 flex-1 text-sm leading-relaxed text-stone-600">
                    {{ $category->description ?: 'No description yet.' }}
                </p>

                <div class="mt-4 flex items-center justify-between border-t border-stone-100 pt-3">
                    <a href="{{ route('categories.show', $category) }}" target="_blank"
                       class="text-xs font-medium text-stone-500 transition hover:text-ink">
                        View archive &rarr;
                    </a>
                    <div class="flex items-center gap-1">
                        <a href="{{ route('admin.categories.edit', $category) }}"
                           class="rounded-lg px-2.5 py-1.5 text-xs font-medium text-stone-600 transition hover:bg-stone-100">
                            Edit
                        </a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                              onsubmit="return confirm('Delete “{{ addslashes($category->name) }}”? Posts will become uncategorised.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-lg px-2.5 py-1.5 text-xs font-medium text-rose-600 transition hover:bg-rose-50">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="rounded-2xl border border-dashed border-stone-300 bg-white p-10 text-center sm:col-span-2 xl:col-span-3">
                <p class="font-serif text-2xl text-ink">No categories yet</p>
                <p class="mt-2 text-sm text-stone-500">Create your first category to organise the blog.</p>
            </div>
        @endforelse
    </div>
@endsection
