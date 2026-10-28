<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::query()->where('email', 'admin@example.com')->firstOrFail();

        $pages = [
            [
                'slug' => 'about',
                'title' => 'About',
                'body' => <<<'MD'
                ## A small publication about making things

                **WordPress Testings** started as a place to keep notes — about code, type, travel and the strange business of paying attention. It is written by a small group of people who like slow software and long walks.

                We publish a few times a month. Nothing is sponsored, nothing is rushed, and everything is written by a human who had to think about it first.

                ### What you will find here

                - Essays on the craft of building for the web
                - Practical notes on Laravel, Tailwind and the tools around them
                - Field reports from places that reward a slower pace

                > The web is at its best when it feels like a place, not a feed.

                If something here is useful to you, that is enough. If you want to reply, every post has a comment box and we read all of them.
                MD,
            ],
            [
                'slug' => 'contact',
                'title' => 'Contact',
                'body' => <<<'MD'
                ## Say hello

                We like email. Real, thoughtful, occasionally long email.

                - **General enquiries:** hello@wordpress-testings.test
                - **Pitches and submissions:** editor@wordpress-testings.test
                - **Corrections:** always welcome, always published

                We aim to reply within a few working days. If you are writing about a specific post, mentioning the title helps.

                ### Elsewhere

                You can also leave a comment directly on any article — we moderate lightly and approve quickly.
                MD,
            ],
        ];

        foreach ($pages as $page) {
            Page::query()->updateOrCreate(
                ['slug' => $page['slug']],
                $page + ['user_id' => $admin->id, 'status' => 'published']
            );
        }
    }
}
