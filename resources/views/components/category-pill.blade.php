@props(['category' => null])

@if ($category)
    <a href="{{ route('categories.show', $category) }}"
       class="inline-flex items-center rounded-full px-2.5 py-1 text-[11px] font-semibold uppercase tracking-[0.12em] ring-1 {{ $category->color_classes }} transition hover:brightness-95">
        {{ $category->name }}
    </a>
@endif
