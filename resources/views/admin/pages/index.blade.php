@extends('layouts.admin')

@section('title', 'Pages')
@section('heading', 'Pages')

@section('content')
    <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="font-serif text-3xl tracking-tight text-ink">Pages</h2>
            <p class="mt-1 text-sm text-stone-500">Static content that lives outside the blog feed.</p>
        </div>
        <a href="{{ route('admin.pages.create') }}"
           class="inline-flex items-center gap-2 rounded-lg bg-ink px-4 py-2 text-sm font-medium text-white transition hover:bg-stone-800">
            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Add page
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-stone-200 bg-white">
        @if ($pages->isEmpty())
            <div class="px-6 py-16 text-center">
                <p class="font-serif text-2xl text-ink">No pages yet</p>
                <p class="mt-2 text-sm text-stone-500">Create an About or Contact page to get started.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-stone-100 text-left">
                    <thead class="bg-stone-50/60">
                        <tr class="text-[11px] uppercase tracking-wider text-stone-500">
                            <th class="px-4 py-3 font-semibold">Title</th>
                            <th class="px-4 py-3 font-semibold">Status</th>
                            <th class="hidden px-4 py-3 font-semibold md:table-cell">Author</th>
                            <th class="hidden px-4 py-3 font-semibold sm:table-cell">Updated</th>
                            <th class="px-4 py-3 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @foreach ($pages as $page)
                            <tr class="transition hover:bg-stone-50/60">
                                <td class="px-4 py-3">
                                    <a href="{{ route('admin.pages.edit', $page) }}" class="text-sm font-medium text-ink transition hover:text-indigo-700">
                                        {{ $page->title }}
                                    </a>
                                    <p class="mt-0.5 text-xs text-stone-500">/pages/{{ $page->slug }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="rounded-full px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide {{ $page->status === 'published' ? 'bg-emerald-50 text-emerald-700' : 'bg-stone-100 text-stone-600' }}">
                                        {{ $page->status }}
                                    </span>
                                </td>
                                <td class="hidden px-4 py-3 text-sm text-stone-600 md:table-cell">{{ $page->author->name }}</td>
                                <td class="hidden px-4 py-3 text-xs text-stone-500 sm:table-cell">{{ $page->updated_at->format('M j, Y') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('pages.show', $page) }}" target="_blank"
                                           class="rounded-lg px-2.5 py-1.5 text-xs font-medium text-stone-600 transition hover:bg-stone-100">
                                            View
                                        </a>
                                        <a href="{{ route('admin.pages.edit', $page) }}"
                                           class="rounded-lg px-2.5 py-1.5 text-xs font-medium text-stone-600 transition hover:bg-indigo-50 hover:text-indigo-600">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.pages.destroy', $page) }}" method="POST"
                                              onsubmit="return confirm('Delete “{{ addslashes($page->title) }}”?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg px-2.5 py-1.5 text-xs font-medium text-rose-600 transition hover:bg-rose-50">
                                                Delete
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
                {{ $pages->links() }}
            </div>
        @endif
    </div>
@endsection
