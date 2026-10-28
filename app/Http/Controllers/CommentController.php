<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post): RedirectResponse
    {
        abort_unless($post->status === 'published', 404);

        $validated = $request->validate([
            'author_name' => ['required', 'string', 'max:80'],
            'author_email' => ['required', 'email', 'max:120'],
            'body' => ['required', 'string', 'min:3', 'max:2000'],
            'parent_id' => ['nullable', 'integer', 'exists:comments,id'],
        ]);

        $post->comments()->create([
            'parent_id' => $validated['parent_id'] ?? null,
            'author_name' => $validated['author_name'],
            'author_email' => $validated['author_email'],
            'body' => $validated['body'],
            'is_approved' => true,
        ]);

        return redirect()
            ->route('posts.show', $post)
            ->with('status', 'Thanks! Your comment has been posted.');
    }
}
