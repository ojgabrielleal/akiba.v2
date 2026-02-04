<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\ReviewContent;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {               
        $content = ReviewContent::factory()
            ->for(User::factory()->create(), 'author');

        Review::factory()
            ->has($content, 'contents')
            ->create();
    }
}
