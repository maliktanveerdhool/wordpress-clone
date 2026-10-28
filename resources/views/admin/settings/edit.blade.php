@extends('layouts.admin')

@section('title', 'Settings')
@section('heading', 'Settings')

@section('content')
    <div class="mb-6">
        <h2 class="font-serif text-3xl tracking-tight text-ink">Settings</h2>
        <p class="mt-1 text-sm text-stone-500">The name, tagline and copy used across the site.</p>
    </div>

    <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_320px]">
        <form action="{{ route('admin.settings.update') }}" method="POST" class="rounded-2xl border border-stone-200 bg-white p-6">
            @csrf
            @method('PUT')

            <div class="space-y-5">
                <div>
                    <label for="site_title" class="block text-xs font-medium text-stone-700">Site title</label>
                    <input id="site_title" name="site_title" type="text" value="{{ old('site_title', $settings['site_title']) }}" required
                           class="mt-1.5 w-full rounded-lg border border-stone-200 bg-paper px-3 py-2.5 text-sm focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
                    @error('site_title')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="tagline" class="block text-xs font-medium text-stone-700">Tagline</label>
                    <input id="tagline" name="tagline" type="text" value="{{ old('tagline', $settings['tagline']) }}"
                           class="mt-1.5 w-full rounded-lg border border-stone-200 bg-paper px-3 py-2.5 text-sm focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
                    @error('tagline')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="description" class="block text-xs font-medium text-stone-700">Description</label>
                    <textarea id="description" name="description" rows="3"
                              class="mt-1.5 w-full rounded-lg border border-stone-200 bg-paper px-3 py-2.5 text-sm focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">{{ old('description', $settings['description']) }}</textarea>
                    <p class="mt-1.5 text-[11px] text-stone-500">Used in the sidebar, footer and meta description.</p>
                    @error('description')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="footer_text" class="block text-xs font-medium text-stone-700">Footer text</label>
                    <input id="footer_text" name="footer_text" type="text" value="{{ old('footer_text', $settings['footer_text']) }}"
                           class="mt-1.5 w-full rounded-lg border border-stone-200 bg-paper px-3 py-2.5 text-sm focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
                    @error('footer_text')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end border-t border-stone-100 pt-5">
                <button type="submit" class="rounded-lg bg-ink px-5 py-2 text-sm font-medium text-white transition hover:bg-stone-800">
                    Save settings
                </button>
            </div>
        </form>

        <div class="space-y-5">
            <div class="rounded-2xl border border-stone-200 bg-white p-5">
                <h3 class="text-sm font-semibold text-ink">Site preview</h3>
                <div class="mt-3 rounded-xl border border-stone-200 bg-paper p-4">
                    <div class="flex items-center gap-2.5">
                        <span class="grid size-8 place-items-center rounded-lg bg-indigo-600 font-serif text-lg text-white">W</span>
                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold text-ink">{{ $settings['site_title'] }}</p>
                            <p class="truncate text-[11px] text-stone-500">{{ $settings['tagline'] }}</p>
                        </div>
                    </div>
                    <p class="mt-3 line-clamp-3 text-xs leading-relaxed text-stone-600">
                        {{ $settings['description'] ?: 'Add a description to tell readers what this site is about.' }}
                    </p>
                </div>
            </div>

            <div class="rounded-2xl border border-stone-200 bg-white p-5">
                <h3 class="text-sm font-semibold text-ink">Environment</h3>
                <dl class="mt-3 space-y-2 text-xs">
                    <div class="flex items-center justify-between">
                        <dt class="text-stone-500">Laravel</dt>
                        <dd class="font-mono text-stone-700">{{ Illuminate\Foundation\Application::VERSION }}</dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="text-stone-500">PHP</dt>
                        <dd class="font-mono text-stone-700">{{ PHP_VERSION }}</dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="text-stone-500">Environment</dt>
                        <dd class="font-mono text-stone-700">{{ app()->environment() }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
@endsection
