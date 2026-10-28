<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        $posts = Post::query()
            ->with(['author', 'category'])
            ->withCount('comments')
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where('title', 'like', '%'.$request->string('q').'%');
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest('updated_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.posts.index', [
            'posts' => $posts,
            'counts' => [
                'all' => Post::count(),
                'published' => Post::where('status', 'published')->count(),
                'draft' => Post::draft()->count(),
            ],
        ]);
    }

    public function create(): View
    {
        return view('admin.posts.form', [
            'post' => new Post(['status' => 'draft', 'published_at' => now()]),
            'categories' => Category::orderBy('name')->get(),
            'tags' => Tag::orderBy('name')->get(),
            'selectedTags' => [],
        ]);
    }

    public function store(PostRequest $request): RedirectResponse
    {
        $post = Post::create($this->payload($request) + [
            'user_id' => $request->user()->id,
        ]);

        $post->tags()->sync($request->input('tags', []));

        return redirect()
            ->route('admin.posts.index')
            ->with('status', 'Post created successfully.');
    }

    public function edit(Post $post): View
    {
        return view('admin.posts.form', [
            'post' => $post,
            'categories' => Category::orderBy('name')->get(),
            'tags' => Tag::orderBy('name')->get(),
            'selectedTags' => $post->tags()->pluck('tags.id')->all(),
        ]);
    }

    public function update(PostRequest $request, Post $post): RedirectResponse
    {
        $post->update($this->payload($request));
        $post->tags()->sync($request->input('tags', []));

        return redirect()
            ->route('admin.posts.index')
            ->with('status', 'Post updated successfully.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('status', 'Post deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function payload(PostRequest $request): array
    {
        $validated = $request->validated();

        $payload = [
            'title' => $validated['title'],
            'slug' => $validated['slug'] ?? null,
            'category_id' => $validated['category_id'] ?? null,
            'excerpt' => $validated['excerpt'] ?? null,
            'body' => $validated['body'],
            'status' => $validated['status'],
            'is_featured' => $request->boolean('is_featured'),
            'published_at' => $validated['published_at'] ?? null,
        ];

        if ($payload['status'] === 'published' && blank($payload['published_at'])) {
            $payload['published_at'] = now();
        }

        if ($request->hasFile('image')) {
            $payload['featured_image'] = $this->storeImage($request->file('image'));
        }

        return $payload;
    }

    private function storeImage(UploadedFile $file): string
    {
        $directory = public_path('uploads/posts');

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $name = Str::random(20).'.'.$file->getClientOriginalExtension();
        $file->move($directory, $name);

        return 'uploads/posts/'.$name;
    }
}
