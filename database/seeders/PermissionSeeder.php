<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create([
            'uuid' => Str::uuid(),
            'name' => 'Admin Management',
            'guard_name' => 'Admin',
        ]);

        Permission::create([
            'uuid' => Str::uuid(),
            'name' => 'User Management',
            'guard_name' => 'Admin',

        ]);

        Permission::create([
            'uuid' => Str::uuid(),
            'name' => 'Quotes Management',
            'guard_name' => 'Admin',

        ]);


    }
}
