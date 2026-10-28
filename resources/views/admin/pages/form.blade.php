@extends('layouts.admin')

@section('title', $page->exists ? 'Edit page' : 'New page')
@section('heading', $page->exists ? 'Edit page' : 'New page')

@section('content')
    <form action="{{ $page->exists ? route('admin.pages.update', $page) : route('admin.pages.store') }}" method="POST">
        @csrf
        @if ($page->exists)
            @method('PUT')
        @endif

        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="font-serif text-3xl tracking-tight text-ink">{{ $page->exists ? 'Edit page' : 'New page' }}</h2>
                <p class="mt-1 text-sm text-stone-500">Static pages appear in the site navigation.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.pages.index') }}"
                   class="rounded-lg border border-stone-200 bg-white px-4 py-2 text-sm font-medium text-stone-600 transition hover:border-stone-300 hover:text-ink">
                    Cancel
                </a>
                <button type="submit" class="rounded-lg bg-ink px-5 py-2 text-sm font-medium text-white transition hover:bg-stone-800">
                    {{ $page->exists ? 'Update page' : 'Save page' }}
                </button>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_340px]">
            <div class="space-y-5">
                <div class="rounded-2xl border border-stone-200 bg-white p-5">
                    <label for="title" class="block text-xs font-medium text-stone-700">Title</label>
                    <input id="title" name="title" type="text" value="{{ old('title', $page->title) }}" required
                           placeholder="About us"
                           class="mt-1.5 w-full rounded-lg border border-stone-200 bg-paper px-3.5 py-2.5 text-lg font-medium placeholder:text-stone-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
                    @error('title')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror

                    <div class="mt-4">
                        <label for="slug" class="block text-xs font-medium text-stone-700">Slug</label>
                        <div class="mt-1.5 flex items-center gap-2">
                            <span class="text-xs text-stone-400">/pages/</span>
                            <input id="slug" name="slug" type="text" value="{{ old('slug', $page->slug) }}"
                                   placeholder="auto-generated"
                                   class="min-w-0 flex-1 rounded-lg border border-stone-200 bg-paper px-3 py-2 text-sm placeholder:text-stone-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
                        </div>
                        @error('slug')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="rounded-2xl border border-stone-200 bg-white p-5">
                    <div class="flex items-center justify-between">
                        <label for="body" class="block text-xs font-medium text-stone-700">Content</label>
                        <span class="text-[11px] text-stone-400">Markdown supported</span>
                    </div>
                    <textarea id="body" name="body" rows="18" required
                              class="mt-1.5 w-full rounded-lg border border-stone-200 bg-paper px-3.5 py-2.5 font-mono text-[13px] leading-relaxed placeholder:text-stone-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">{{ old('body', $page->body) }}</textarea>
                    @error('body')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="space-y-5">
                <div class="rounded-2xl border border-stone-200 bg-white p-5">
                    <h3 class="text-sm font-semibold text-ink">Publish</h3>
                    <div class="mt-4">
                        <label for="status" class="block text-xs font-medium text-stone-700">Status</label>
                        <select id="status" name="status"
                                class="mt-1.5 w-full rounded-lg border border-stone-200 bg-paper px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
                            <option value="draft" @selected(old('status', $page->status) === 'draft')>Draft</option>
                            <option value="published" @selected(old('status', $page->status) === 'published')>Published</option>
                        </select>
                    </div>
                    @if ($page->exists)
                        <p class="mt-4 text-[11px] text-stone-500">Last updated {{ $page->updated_at->diffForHumans() }}</p>
                    @endif
                </div>
            </div>
        </div>
    </form>

    @if ($page->exists)
        <form action="{{ route('admin.pages.destroy', $page) }}" method="POST"
              onsubmit="return confirm('Delete “{{ addslashes($page->title) }}”?')"
              class="mt-3 flex justify-end">
            @csrf
            @method('DELETE')
            <button type="submit" class="rounded-lg border border-rose-200 bg-white px-4 py-2 text-sm font-medium text-rose-600 transition hover:bg-rose-50">
                Delete page
            </button>
        </form>
    @endif
@endsection
