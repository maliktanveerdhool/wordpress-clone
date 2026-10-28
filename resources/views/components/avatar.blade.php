@props(['name' => '?', 'size' => 'size-9', 'text' => 'text-xs'])

@php
    $palettes = [
        'bg-indigo-100 text-indigo-700',
        'bg-rose-100 text-rose-700',
        'bg-amber-100 text-amber-800',
        'bg-emerald-100 text-emerald-700',
        'bg-sky-100 text-sky-700',
        'bg-violet-100 text-violet-700',
        'bg-teal-100 text-teal-700',
    ];

    $tone = $palettes[abs(crc32($name)) % count($palettes)];

    $initials = collect(preg_split('/\s+/', trim($name)))
        ->filter()
        ->map(fn ($word) => mb_substr($word, 0, 1))
        ->take(2)
        ->implode('');
@endphp

<span {{ $attributes->merge(['class' => "inline-grid shrink-0 place-items-center rounded-full font-semibold uppercase tracking-wide {$size} {$text} {$tone}"]) }}>
    {{ $initials }}
</span>
