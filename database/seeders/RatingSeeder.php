<?php

namespace Database\Seeders;

use App\Models\Rating;
use App\Models\State;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //changeWhenProductAdd change all State to Product

        $products = State::select('id')->get();
        //
        foreach ($products as $product) {
            Rating::create([
                'user_id' => User::first()->id,
                'product_id' => $product->id,
                'rating' => random_int(1, 10)
            ]);
        }
        //
    }
}
