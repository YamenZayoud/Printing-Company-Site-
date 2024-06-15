<?php

namespace Database\Seeders;

use App\Models\State;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'f_name' => 'abd',
            'l_name' => 'oyoun',
            'company_name' => 'gt media',
            'email' => 'abd@gmail.com',
            'phone' => '0955686568',
            'password' => 'password',
            'display_name' => 'abdulrouf',
        ]);
        $user;
        UserAddress::create([
            'user_id' => User::where('email', $user->email)->first()->id,
            'state_id' => State::first()->id,
            'address' => '',
            'zip_code' => '',
        ]);
        UserImage::create([
            'user_id' => User::where('email', $user->email)->first()->id,
            'image' => '',
        ]);
    }
}
