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
        $user = User::factory()->create();
        
        $content = ReviewContent::factory()
            ->for($user, 'author');

        Review::factory()
            ->has($content, 'contents')
            ->create();
    }
}
