<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'key' => 'Home Promo',
            'value' => null,
            'description' => null,
        ]);

        Setting::create([
            'key' => 'About Us',
            'value' => null,
            'description' => null,
        ]);

        Setting::create([
            'key' => '2 work days',
            'value' => '0.9',
            'description' => '$ work $ days $',
        ]);
        Setting::create([
            'key' => '3 - 4 work days',
            'value' => '0.5',
            'description' => '$ work $ days $',
        ]);
        Setting::create([
            'key' => '5 - 7 work days',
            'value' => '0',
            'description' => '$ work $ days $',
        ]);
    }
}
