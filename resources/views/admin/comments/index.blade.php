@extends('layouts.admin')

@section('title', 'Comments')
@section('heading', 'Comments')

@section('content')
    <div class="mb-6">
        <h2 class="font-serif text-3xl tracking-tight text-ink">Comments</h2>
        <p class="mt-1 text-sm text-stone-500">Approve, unapprove or remove what readers are saying.</p>
    </div>

    <div class="rounded-2xl border border-stone-200 bg-white">
        <div class="flex flex-wrap items-center gap-1 border-b border-stone-100 px-4 py-3">
            @foreach ([
                'all' => ['label' => 'All', 'count' => $counts['all']],
                'pending' => ['label' => 'Pending', 'count' => $counts['pending']],
                'approved' => ['label' => 'Approved', 'count' => $counts['approved']],
            ] as $key => $tab)
                <a href="{{ route('admin.comments.index', ['filter' => $key]) }}"
                   class="rounded-lg px-3 py-1.5 text-xs font-medium transition {{ $filter === $key ? 'bg-stone-900 text-white' : 'text-stone-600 hover:bg-stone-100' }}">
                    {{ $tab['label'] }}
                    <span class="ml-1 {{ $filter === $key ? 'text-white/60' : 'text-stone-400' }}">{{ $tab['count'] }}</span>
                </a>
            @endforeach
        </div>

        <div class="divide-y divide-stone-100">
            @forelse ($comments as $comment)
                <article class="flex flex-col gap-3 px-5 py-4 sm:flex-row">
                    <x-avatar :name="$comment->author_name" size="size-10 shrink-0" />

                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-x-2 gap-y-1">
                            <p class="text-sm font-semibold text-ink">{{ $comment->author_name }}</p>
                            <p class="text-xs text-stone-400">{{ $comment->author_email }}</p>
                            <span class="text-stone-300">&middot;</span>
                            <p class="text-xs text-stone-500">{{ $comment->created_at->diffForHumans() }}</p>
                            @if ($comment->is_approved)
                                <span class="rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] font-semibold text-emerald-700">Approved</span>
                            @else
                                <span class="rounded-full bg-amber-50 px-2 py-0.5 text-[10px] font-semibold text-amber-700">Pending</span>
                            @endif
                        </div>

                        <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-stone-700">{{ $comment->body }}</p>

                        <p class="mt-2 text-xs text-stone-500">
                            On
                            <a href="{{ route('posts.show', $comment->post) }}" target="_blank" class="font-medium text-indigo-600 hover:text-indigo-800">
                                {{ $comment->post->title }}
                            </a>
                            @if ($comment->parent)
                                <span class="text-stone-400">· reply to {{ $comment->parent->author_name }}</span>
                            @endif
                        </p>
                    </div>

                    <div class="flex shrink-0 items-start gap-1 sm:flex-col">
                        <form action="{{ route('admin.comments.update', $comment) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="rounded-lg px-3 py-1.5 text-xs font-medium transition {{ $comment->is_approved ? 'text-stone-600 hover:bg-stone-100' : 'bg-emerald-600 text-white hover:bg-emerald-700' }}">
                                {{ $comment->is_approved ? 'Unapprove' : 'Approve' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST"
                              onsubmit="return confirm('Delete this comment?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-lg px-3 py-1.5 text-xs font-medium text-rose-600 transition hover:bg-rose-50">
                                Delete
                            </button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="px-6 py-16 text-center">
                    <p class="font-serif text-2xl text-ink">No comments here</p>
                    <p class="mt-2 text-sm text-stone-500">Nothing to moderate right now.</p>
                </div>
            @endforelse
        </div>

        @if ($comments->hasPages())
            <div class="border-t border-stone-100 px-4 py-3">
                {{ $comments->links() }}
            </div>
        @endif
    </div>
@endsection
