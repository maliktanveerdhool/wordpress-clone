@extends('layouts.admin')

@section('title', $category->exists ? 'Edit category' : 'New category')
@section('heading', $category->exists ? 'Edit category' : 'New category')

@section('content')
    <div class="mx-auto max-w-2xl">
        <div class="mb-6">
            <h2 class="font-serif text-3xl tracking-tight text-ink">{{ $category->exists ? 'Edit category' : 'New category' }}</h2>
            <p class="mt-1 text-sm text-stone-500">Categories help readers find related posts.</p>
        </div>

        <form action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
              method="POST" class="rounded-2xl border border-stone-200 bg-white p-6">
            @csrf
            @if ($category->exists)
                @method('PUT')
            @endif

            <div class="space-y-5">
                <div>
                    <label for="name" class="block text-xs font-medium text-stone-700">Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $category->name) }}" required
                           placeholder="e.g. Technology"
                           class="mt-1.5 w-full rounded-lg border border-stone-200 bg-paper px-3 py-2.5 text-sm placeholder:text-stone-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
                    @error('name')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="slug" class="block text-xs font-medium text-stone-700">Slug</label>
                    <div class="mt-1.5 flex items-center gap-2">
                        <span class="text-xs text-stone-400">/categories/</span>
                        <input id="slug" name="slug" type="text" value="{{ old('slug', $category->slug) }}"
                               placeholder="auto-generated"
                               class="min-w-0 flex-1 rounded-lg border border-stone-200 bg-paper px-3 py-2 text-sm placeholder:text-stone-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
                    </div>
                    @error('slug')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="description" class="block text-xs font-medium text-stone-700">Description</label>
                    <textarea id="description" name="description" rows="3"
                              placeholder="A sentence or two about what belongs in this category."
                              class="mt-1.5 w-full rounded-lg border border-stone-200 bg-paper px-3 py-2.5 text-sm placeholder:text-stone-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">{{ old('description', $category->description) }}</textarea>
                    @error('description')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="color" class="block text-xs font-medium text-stone-700">Accent colour</label>
                    <select id="color" name="color"
                            class="mt-1.5 w-full rounded-lg border border-stone-200 bg-paper px-3 py-2.5 text-sm focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
                        @foreach (['indigo' => 'Indigo', 'rose' => 'Rose', 'amber' => 'Amber', 'emerald' => 'Emerald', 'sky' => 'Sky', 'violet' => 'Violet'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('color', $category->color) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('color')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-between border-t border-stone-100 pt-5">
                <a href="{{ route('admin.categories.index') }}" class="text-sm font-medium text-stone-600 transition hover:text-ink">Cancel</a>
                <button type="submit" class="rounded-lg bg-ink px-5 py-2 text-sm font-medium text-white transition hover:bg-stone-800">
                    {{ $category->exists ? 'Save changes' : 'Create category' }}
                </button>
            </div>
        </form>
    </div>
@endsection
