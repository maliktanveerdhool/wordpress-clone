<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request): View
    {
        $filter = $request->string('filter')->toString() ?: 'all';

        $comments = Comment::query()
            ->with(['post', 'parent'])
            ->when($filter === 'pending', fn ($query) => $query->pending())
            ->when($filter === 'approved', fn ($query) => $query->approved())
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.comments.index', [
            'comments' => $comments,
            'filter' => $filter,
            'counts' => [
                'all' => Comment::count(),
                'pending' => Comment::pending()->count(),
                'approved' => Comment::approved()->count(),
            ],
        ]);
    }

    public function update(Request $request, Comment $comment): RedirectResponse
    {
        $comment->update(['is_approved' => ! $comment->is_approved]);

        return back()->with('status', $comment->is_approved ? 'Comment approved.' : 'Comment moved to pending.');
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        $comment->delete();

        return back()->with('status', 'Comment deleted.');
    }
}
