@if (session('status'))
    <div class="pointer-events-none fixed inset-x-0 bottom-6 z-50 flex justify-center px-4">
        <div class="pointer-events-auto flex items-center gap-3 rounded-full border border-emerald-200 bg-white px-5 py-3 text-sm font-medium text-stone-700 shadow-xl shadow-stone-900/10">
            <span class="grid size-6 place-items-center rounded-full bg-emerald-100 text-emerald-700">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
            </span>
            {{ session('status') }}
        </div>
    </div>
@endif

@if ($errors->any())
    <div class="pointer-events-none fixed inset-x-0 bottom-6 z-50 flex justify-center px-4">
        <div class="pointer-events-auto flex items-start gap-3 rounded-2xl border border-rose-200 bg-white px-5 py-3 text-sm text-stone-700 shadow-xl shadow-stone-900/10">
            <span class="mt-0.5 grid size-6 shrink-0 place-items-center rounded-full bg-rose-100 text-rose-700">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008M12 3.75 2.25 20.25h19.5L12 3.75Z" />
                </svg>
            </span>
            <div>
                <p class="font-semibold">Please fix the following:</p>
                <ul class="mt-1 list-inside list-disc text-stone-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif
