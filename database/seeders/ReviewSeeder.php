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
        $adminContent = ReviewContent::factory()
            ->for(User::find(1), 'author');

        $userContent = ReviewContent::factory()
            ->for(User::factory()->create(), 'author');

        Review::factory()
            ->has($adminContent, 'reviews')
            ->create();
            
        Review::factory()
            ->has($userContent, 'reviews')
            ->create();
    }
}
