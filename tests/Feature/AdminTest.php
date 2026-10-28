<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\Setting;
use App\Models\User;

beforeEach(function () {
    $this->seed();
});

function adminUser(): User
{
    return User::where('email', 'admin@example.com')->firstOrFail();
}

test('guests are redirected to the login page', function () {
    $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
});

test('non admin users cannot access the dashboard', function () {
    $user = User::factory()->create(['is_admin' => false]);

    $this->actingAs($user)
        ->get(route('admin.dashboard'))
        ->assertForbidden();
});

test('an admin can log in', function () {
    $this->post(route('login'), [
        'email' => 'admin@example.com',
        'password' => 'password',
    ])->assertRedirect(route('admin.dashboard'));

    $this->assertAuthenticatedAs(adminUser());
});

test('an admin can create a post', function () {
    $admin = adminUser();

    $this->actingAs($admin)
        ->post(route('admin.posts.store'), [
            'title' => 'A brand new post',
            'excerpt' => 'A short summary.',
            'body' => 'The body of the post.',
            'status' => 'published',
            'published_at' => now()->format('Y-m-d H:i:s'),
        ])
        ->assertRedirect(route('admin.posts.index'));

    $post = Post::where('title', 'A brand new post')->firstOrFail();

    expect($post->status)->toBe('published')
        ->and($post->slug)->toBe('a-brand-new-post')
        ->and($post->user_id)->toBe($admin->id);
});

test('an admin can approve a pending comment', function () {
    $comment = Comment::pending()->firstOrFail();

    $this->actingAs(adminUser())
        ->patch(route('admin.comments.update', $comment))
        ->assertRedirect();

    expect($comment->fresh()->is_approved)->toBeTrue();
});

test('an admin can update the site settings', function () {
    $this->actingAs(adminUser())
        ->put(route('admin.settings.update'), [
            'site_title' => 'Updated Title',
            'tagline' => 'A new tagline',
            'description' => 'Updated description',
            'footer_text' => 'Updated footer',
        ])
        ->assertRedirect(route('admin.settings.edit'));

    expect(Setting::get('site_title'))->toBe('Updated Title');
});
