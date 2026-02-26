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
        $user = User::find(1);

        $reviewForUserAdmin = ReviewContent::factory()
            ->for($user, 'author')
            ->count(5);

        $reviewsForAnotherUsers = ReviewContent::factory()
            ->for(User::factory()->create(), 'author')
            ->count(5);

        Review::factory()
            ->has($reviewForUserAdmin, 'reviews')
            ->create();
            
        Review::factory()
            ->has($reviewsForAnotherUsers, 'reviews')
            ->create();
    }
}
