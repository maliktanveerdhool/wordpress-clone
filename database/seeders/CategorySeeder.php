<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Technology',
                'slug' => 'technology',
                'description' => 'Tools, frameworks and the small decisions that shape how software feels.',
                'color' => 'indigo',
            ],
            [
                'name' => 'Design',
                'slug' => 'design',
                'description' => 'Typography, layout and the discipline of leaving things out.',
                'color' => 'rose',
            ],
            [
                'name' => 'Culture',
                'slug' => 'culture',
                'description' => 'How we work, what we read and why any of it matters.',
                'color' => 'amber',
            ],
            [
                'name' => 'Travel',
                'slug' => 'travel',
                'description' => 'Slow journeys, unfamiliar streets and notes from elsewhere.',
                'color' => 'emerald',
            ],
        ];

        foreach ($categories as $category) {
            Category::query()->updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
