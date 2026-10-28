<?php

use App\Models\Comment;
use App\Models\Post;

beforeEach(function () {
    $this->seed();
});

test('the home page lists published posts and hides drafts', function () {
    $published = Post::published()->firstOrFail();
    $draft = Post::draft()->firstOrFail();

    $this->get('/')
        ->assertOk()
        ->assertSee($published->title)
        ->assertDontSee($draft->title);
});

test('a published post can be viewed and its view count increases', function () {
    $post = Post::published()->firstOrFail();
    $views = $post->views;

    $this->get(route('posts.show', $post))
        ->assertOk()
        ->assertSee($post->title);

    expect($post->fresh()->views)->toBe($views + 1);
});

test('draft posts are not publicly accessible', function () {
    $draft = Post::draft()->firstOrFail();

    $this->get(route('posts.show', $draft))->assertNotFound();
});

test('category and tag archives list matching posts', function () {
    $post = Post::published()->whereNotNull('category_id')->firstOrFail();

    $this->get(route('categories.show', $post->category))
        ->assertOk()
        ->assertSee($post->title);

    $tag = $post->tags()->firstOrFail();

    $this->get(route('tags.show', $tag))
        ->assertOk()
        ->assertSee($post->title);
});

test('search returns posts matching the query', function () {
    $post = Post::published()->firstOrFail();

    $this->get(route('search', ['q' => 'Laravel']))
        ->assertOk()
        ->assertSee('Results for');
});

test('a reader can leave a comment', function () {
    $post = Post::published()->firstOrFail();

    $this->post(route('comments.store', $post), [
        'author_name' => 'Jane Reader',
        'author_email' => 'jane@example.com',
        'body' => 'A thoughtful comment about the article.',
    ])->assertRedirect(route('posts.show', $post));

    expect(Comment::where('author_email', 'jane@example.com')->exists())->toBeTrue();
});

test('a comment requires a valid email address', function () {
    $post = Post::published()->firstOrFail();

    $this->post(route('comments.store', $post), [
        'author_name' => 'Jane Reader',
        'author_email' => 'not-an-email',
        'body' => 'A thoughtful comment about the article.',
    ])->assertSessionHasErrors('author_email');
});

test('static pages are publicly accessible', function () {
    $this->get(route('pages.show', 'about'))
        ->assertOk()
        ->assertSee('About');
});
