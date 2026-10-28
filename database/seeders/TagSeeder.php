<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'laravel', 'php', 'tailwind', 'javascript', 'tools',
            'productivity', 'writing', 'typography', 'craft', 'slow-web',
            'ai', 'remote-work', 'design', 'travel',
        ];

        foreach ($tags as $tag) {
            Tag::query()->updateOrCreate(
                ['slug' => Str::slug($tag)],
                ['name' => $tag]
            );
        }
    }
}
