<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $stats = [
            'published' => Post::published()->count(),
            'drafts' => Post::draft()->count(),
            'pending_comments' => Comment::pending()->count(),
            'comments' => Comment::count(),
            'views' => (int) Post::sum('views'),
            'categories' => Category::count(),
        ];

        $recentPosts = Post::with(['author', 'category'])
            ->latest('updated_at')
            ->take(5)
            ->get();

        $recentComments = Comment::with('post')
            ->latest()
            ->take(5)
            ->get();

        $topPosts = Post::published()
            ->orderByDesc('views')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentPosts', 'recentComments', 'topPosts'));
    }
}
