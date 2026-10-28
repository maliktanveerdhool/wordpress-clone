@extends('layouts.admin')

@section('title', 'Tags')
@section('heading', 'Tags')

@section('content')
    <div class="mb-6">
        <h2 class="font-serif text-3xl tracking-tight text-ink">Tags</h2>
        <p class="mt-1 text-sm text-stone-500">Fine-grained topics that cut across categories.</p>
    </div>

    <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_320px]">
        <div class="rounded-2xl border border-stone-200 bg-white">
            <div class="border-b border-stone-100 px-5 py-4">
                <h3 class="text-sm font-semibold text-ink">All tags</h3>
            </div>

            <div class="flex flex-wrap gap-2 p-5">
                @forelse ($tags as $tag)
                    <span class="group inline-flex items-center gap-2 rounded-full border border-stone-200 bg-paper py-1.5 pl-3 pr-1.5 text-sm text-stone-700">
                        #{{ $tag->name }}
                        <span class="rounded-full bg-stone-200/70 px-2 py-0.5 text-[10px] font-medium text-stone-600">{{ $tag->posts_count }}</span>
                        <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST"
                              onsubmit="return confirm('Delete the tag “{{ addslashes($tag->name) }}”?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="grid size-5 place-items-center rounded-full text-stone-400 transition hover:bg-rose-100 hover:text-rose-600"
                                    title="Delete tag">
                                <svg class="size-3" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </form>
                    </span>
                @empty
                    <p class="py-6 text-center text-sm text-stone-500">No tags yet — add one on the right.</p>
                @endforelse
            </div>
        </div>

        <div class="rounded-2xl border border-stone-200 bg-white p-5">
            <h3 class="text-sm font-semibold text-ink">Add a tag</h3>
            <form action="{{ route('admin.tags.store') }}" method="POST" class="mt-4">
                @csrf
                <label for="name" class="block text-xs font-medium text-stone-700">Tag name</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required
                       placeholder="e.g. laravel"
                       class="mt-1.5 w-full rounded-lg border border-stone-200 bg-paper px-3 py-2 text-sm placeholder:text-stone-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
                @error('name')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror

                <button type="submit" class="mt-4 w-full rounded-lg bg-ink px-4 py-2 text-sm font-medium text-white transition hover:bg-stone-800">
                    Add tag
                </button>
            </form>
        </div>
    </div>
@endsection
