@extends('layouts.admin')

@section('title', $post->exists ? 'Edit post' : 'New post')
@section('heading', $post->exists ? 'Edit post' : 'New post')

@section('content')
    <form action="{{ $post->exists ? route('admin.posts.update', $post) : route('admin.posts.store') }}"
          method="POST" enctype="multipart/form-data">
        @csrf
        @if ($post->exists)
            @method('PUT')
        @endif

        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="font-serif text-3xl tracking-tight text-ink">{{ $post->exists ? 'Edit post' : 'Write a new post' }}</h2>
                <p class="mt-1 text-sm text-stone-500">
                    {{ $post->exists ? 'Last updated '.$post->updated_at->diffForHumans() : 'Draft it now, publish it when it is ready.' }}
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.posts.index') }}"
                   class="rounded-lg border border-stone-200 bg-white px-4 py-2 text-sm font-medium text-stone-600 transition hover:border-stone-300 hover:text-ink">
                    Cancel
                </a>
                @if ($post->exists && $post->status === 'published')
                    <a href="{{ route('posts.show', $post) }}" target="_blank"
                       class="rounded-lg border border-stone-200 bg-white px-4 py-2 text-sm font-medium text-stone-600 transition hover:border-stone-300 hover:text-ink">
                        View post
                    </a>
                @endif
                <button type="submit" class="rounded-lg bg-ink px-5 py-2 text-sm font-medium text-white transition hover:bg-stone-800">
                    {{ $post->exists ? 'Update post' : 'Save post' }}
                </button>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_340px]">
            <div class="space-y-5">
                <div class="rounded-2xl border border-stone-200 bg-white p-5">
                    <label for="title" class="block text-xs font-medium text-stone-700">Title</label>
                    <input id="title" name="title" type="text" value="{{ old('title', $post->title) }}" required
                           placeholder="An unforgettable headline…"
                           class="mt-1.5 w-full rounded-lg border border-stone-200 bg-paper px-3.5 py-2.5 text-lg font-medium placeholder:text-stone-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
                    @error('title')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror

                    <div class="mt-4">
                        <label for="slug" class="block text-xs font-medium text-stone-700">Slug</label>
                        <div class="mt-1.5 flex items-center gap-2">
                            <span class="text-xs text-stone-400">/posts/</span>
                            <input id="slug" name="slug" type="text" value="{{ old('slug', $post->slug) }}"
                                   placeholder="auto-generated-from-title"
                                   class="min-w-0 flex-1 rounded-lg border border-stone-200 bg-paper px-3 py-2 text-sm placeholder:text-stone-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
                        </div>
                        @error('slug')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="rounded-2xl border border-stone-200 bg-white p-5">
                    <label for="excerpt" class="block text-xs font-medium text-stone-700">Excerpt</label>
                    <textarea id="excerpt" name="excerpt" rows="2"
                              placeholder="A short summary shown on the blog index and in search results."
                              class="mt-1.5 w-full rounded-lg border border-stone-200 bg-paper px-3.5 py-2.5 text-sm placeholder:text-stone-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">{{ old('excerpt', $post->excerpt) }}</textarea>
                    <p class="mt-1.5 text-[11px] text-stone-500">Leave blank to generate one from the post body.</p>
                    @error('excerpt')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div class="rounded-2xl border border-stone-200 bg-white p-5">
                    <div class="flex items-center justify-between">
                        <label for="body" class="block text-xs font-medium text-stone-700">Content</label>
                        <span class="text-[11px] text-stone-400">Markdown supported</span>
                    </div>
                    <textarea id="body" name="body" rows="18" required
                              placeholder="Start writing…"
                              class="mt-1.5 w-full rounded-lg border border-stone-200 bg-paper px-3.5 py-2.5 font-mono text-[13px] leading-relaxed placeholder:text-stone-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">{{ old('body', $post->body) }}</textarea>
                    @error('body')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="space-y-5">
                <div class="rounded-2xl border border-stone-200 bg-white p-5">
                    <h3 class="text-sm font-semibold text-ink">Publish</h3>

                    <div class="mt-4 space-y-4">
                        <div>
                            <label for="status" class="block text-xs font-medium text-stone-700">Status</label>
                            <select id="status" name="status"
                                    class="mt-1.5 w-full rounded-lg border border-stone-200 bg-paper px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
                                <option value="draft" @selected(old('status', $post->status) === 'draft')>Draft</option>
                                <option value="published" @selected(old('status', $post->status) === 'published')>Published</option>
                            </select>
                        </div>

                        <div>
                            <label for="published_at" class="block text-xs font-medium text-stone-700">Publish date</label>
                            <input id="published_at" name="published_at" type="datetime-local"
                                   value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i') ?? now()->format('Y-m-d\TH:i')) }}"
                                   class="mt-1.5 w-full rounded-lg border border-stone-200 bg-paper px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
                            @error('published_at')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>

                        <label class="flex items-start gap-2.5 rounded-lg bg-stone-50 p-3">
                            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $post->is_featured))
                                   class="mt-0.5 size-4 rounded border-stone-300 text-indigo-600 focus:ring-indigo-500">
                            <span>
                                <span class="block text-xs font-medium text-stone-700">Feature this post</span>
                                <span class="block text-[11px] text-stone-500">Show it in the hero on the home page.</span>
                            </span>
                        </label>
                    </div>
                </div>

                <div class="rounded-2xl border border-stone-200 bg-white p-5">
                    <label for="category_id" class="block text-sm font-semibold text-ink">Category</label>
                    <select id="category_id" name="category_id"
                            class="mt-3 w-full rounded-lg border border-stone-200 bg-paper px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
                        <option value="">Uncategorised</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected((int) old('category_id', $post->category_id) === $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div class="rounded-2xl border border-stone-200 bg-white p-5">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-ink">Tags</h3>
                        <a href="{{ route('admin.tags.index') }}" class="text-[11px] font-medium text-indigo-600 hover:text-indigo-800">Manage</a>
                    </div>
                    <div class="mt-3 max-h-52 space-y-1.5 overflow-y-auto pr-1">
                        @forelse ($tags as $tag)
                            <label class="flex items-center gap-2.5 rounded-lg px-2 py-1.5 text-sm text-stone-700 transition hover:bg-stone-50">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                       @checked(in_array($tag->id, old('tags', $selectedTags))) 
                                       class="size-4 rounded border-stone-300 text-indigo-600 focus:ring-indigo-500">
                                {{ $tag->name }}
                            </label>
                        @empty
                            <p class="text-xs text-stone-500">No tags yet. Create some first.</p>
                        @endforelse
                    </div>
                    @error('tags')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div class="rounded-2xl border border-stone-200 bg-white p-5">
                    <h3 class="text-sm font-semibold text-ink">Featured image</h3>

                    @if ($post->featured_image)
                        <img src="{{ $post->featured_image_url }}" alt="" class="mt-3 aspect-[16/10] w-full rounded-lg object-cover">
                    @endif

                    <label for="image" class="mt-3 flex cursor-pointer flex-col items-center justify-center rounded-lg border border-dashed border-stone-300 bg-paper px-4 py-6 text-center transition hover:border-indigo-300 hover:bg-indigo-50/40">
                        <svg class="size-6 text-stone-400" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                        <span class="mt-2 text-xs font-medium text-stone-600">Upload an image</span>
                        <span class="mt-0.5 text-[11px] text-stone-400">JPG, PNG or WebP up to 4 MB</span>
                        <input id="image" name="image" type="file" accept="image/*" class="sr-only">
                    </label>
                    @error('image')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                @if ($post->exists)
                    <div class="rounded-2xl border border-rose-200 bg-rose-50/60 p-5">
                        <h3 class="text-sm font-semibold text-rose-800">Danger zone</h3>
                        <p class="mt-1 text-xs text-rose-700/80">Deleting a post also removes its comments.</p>
                    </div>
                @endif
            </div>
        </div>
    </form>

    @if ($post->exists)
        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST"
              onsubmit="return confirm('Delete “{{ addslashes($post->title) }}”? This cannot be undone.')"
              class="mt-3 flex justify-end">
            @csrf
            @method('DELETE')
            <button type="submit" class="rounded-lg border border-rose-200 bg-white px-4 py-2 text-sm font-medium text-rose-600 transition hover:bg-rose-50">
                Delete post
            </button>
        </form>
    @endif
@endsection
