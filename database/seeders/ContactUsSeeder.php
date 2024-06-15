<?php

namespace Database\Seeders;

use App\Models\ContactUs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactUs::create([
            'name' => 'test',
            'email' => 'anything@gmail.com',
            'phone' => '0955632536',
            'message' => 'nice project ',
        ]);
    }
}
