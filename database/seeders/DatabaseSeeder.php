<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Rating;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(ContactUsSeeder::class);
        $this->call(StateSeeder::class);
        $this->call(UserSeeder::class);
       // $this->call(TagSeeder::class);
       // $this->call(RatingSeeder::class);

        $this->call(PermissionSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(SettingSeeder::class);
    }
}
