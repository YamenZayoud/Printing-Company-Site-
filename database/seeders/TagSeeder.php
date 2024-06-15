<?php

namespace Database\Seeders;

use App\Models\ProductTag;
use App\Models\State;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tag = Tag::create([
            'name' => 'good'
        ]);
        $tag2 = Tag::create([
            'name' => 'perfect'
        ]);


        ProductTag::create([
            'product_id' => State::first()->id,
            'tag_id' => $tag->id
        ]);

        ProductTag::create([
            'product_id' => State::first()->id,
            'tag_id' => $tag2->id
        ]);

    }
}
