<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Alex Morgan',
                'password' => 'password',
                'is_admin' => true,
                'bio' => 'Editor-in-chief. Writes about the web, slow software and the craft of making things by hand.',
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'priya@example.com'],
            [
                'name' => 'Priya Raman',
                'password' => 'password',
                'is_admin' => true,
                'bio' => 'Designer and occasional essayist. Interested in typography, restraint and the space between things.',
            ]
        );
    }
}
