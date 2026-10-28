<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'site_title' => 'WordPress Testings',
            'tagline' => 'Just another WordPress site',
            'description' => 'A WordPress-style publishing site built with Laravel: posts, categories, tags, comments and a full admin dashboard.',
            'footer_text' => 'Proudly powered by Laravel and Tailwind CSS.',
        ];

        foreach ($settings as $key => $value) {
            Setting::put($key, $value);
        }
    }
}
