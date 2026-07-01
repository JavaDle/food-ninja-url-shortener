<?php

namespace Database\Seeders;

use App\Models\Link;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
        ]);

        User::factory(10)->create()->each(function ($user) {
            Link::factory()->count(20)->create([
                'user_id' => $user->id,
            ])->each(function ($link) use ($user) {
                Visit::factory()->count(20)->create([
                    'link_id' => $link->id,
                ]);
            });
        });
    }
}
