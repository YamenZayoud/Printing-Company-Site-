<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Admin::create([
            'name' => 'samir',
            'email' => 'samir@gmail.com',
            'password' => 'password',
        ]);

        $admin->givePermissionTo(['User Management','Admin Management','Quotes Management']);
    }
}