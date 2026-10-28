<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $comments = [
            [
                'post' => 'quiet-craft-personal-website',
                'name' => 'Maya Chen',
                'email' => 'maya@example.com',
                'days' => 1,
                'body' => 'The line about a site being a place rather than a profile is going to stay with me. I rebuilt mine last year and the hardest part was exactly this — deciding what did not belong.',
            ],
            [
                'post' => 'quiet-craft-personal-website',
                'name' => 'Tom Alvarez',
                'email' => 'tom@example.com',
                'days' => 1,
                'body' => 'Started with one page that answers three questions. Two hours later it was live. Best advice I have read all month.',
                'reply' => [
                    'name' => 'Alex Morgan',
                    'email' => 'admin@example.com',
                    'body' => 'That is the whole trick — the first page teaches you what the second one should be.',
                ],
            ],
            [
                'post' => 'laravel-feels-like-cheating',
                'name' => 'Daniel Osei',
                'email' => 'daniel@example.com',
                'days' => 3,
                'body' => 'The point about restraint is underrated. Laravel will happily let you build a cathedral for a lemonade stand.',
            ],
            [
                'post' => 'field-guide-web-typography',
                'name' => 'Sofia Marchetti',
                'email' => 'sofia@example.com',
                'days' => 6,
                'body' => 'Measure before size. I have been saying this for years and nobody listens. Lovely piece.',
            ],
            [
                'post' => 'slow-travel-fast-trains-japan',
                'name' => 'Kenji Watanabe',
                'email' => 'kenji@example.com',
                'days' => 12,
                'body' => 'As someone who lives in Kanazawa, I am glad you found the gardens worth the slow morning. Come back in winter.',
            ],
            [
                'post' => 'what-ai-changed-workflow',
                'name' => 'Rebecca Lin',
                'email' => 'rebecca@example.com',
                'days' => 20,
                'body' => 'The intern with no memory of yesterday is a perfect description. I have started keeping a short context file for every project and it helps enormously.',
            ],
            [
                'post' => 'what-ai-changed-workflow',
                'name' => 'Anonymous Reader',
                'email' => 'reader@example.com',
                'days' => 4,
                'approved' => false,
                'body' => 'Not sure I agree that the thinking got more important. Feels like the opposite is happening in a lot of teams. Would be curious how you would measure that.',
            ],
            [
                'post' => 'how-to-read-more',
                'name' => 'Hannah Brooks',
                'email' => 'hannah@example.com',
                'days' => 15,
                'body' => 'Permission to abandon a book was the thing that unlocked reading for me. Fifty pages, then decide. No guilt.',
            ],
            [
                'post' => 'notes-from-a-week-offline',
                'name' => 'Luis Ferreira',
                'email' => 'luis@example.com',
                'days' => 9,
                'body' => 'The defaults line is the one. I turned off every notification except messages from actual humans three months ago and have not missed a thing.',
            ],
        ];

        foreach ($comments as $data) {
            $post = Post::query()->where('slug', $data['post'])->first();

            if (! $post) {
                continue;
            }

            $comment = Comment::query()->updateOrCreate(
                [
                    'post_id' => $post->id,
                    'author_email' => $data['email'],
                    'body' => $data['body'],
                ],
                [
                    'author_name' => $data['name'],
                    'is_approved' => $data['approved'] ?? true,
                    'created_at' => now()->subDays($data['days']),
                    'updated_at' => now()->subDays($data['days']),
                ]
            );

            if (isset($data['reply'])) {
                Comment::query()->updateOrCreate(
                    [
                        'post_id' => $post->id,
                        'parent_id' => $comment->id,
                        'author_email' => $data['reply']['email'],
                        'body' => $data['reply']['body'],
                    ],
                    [
                        'author_name' => $data['reply']['name'],
                        'is_approved' => true,
                        'created_at' => now()->subHours(6),
                        'updated_at' => now()->subHours(6),
                    ]
                );
            }
        }
    }
}
