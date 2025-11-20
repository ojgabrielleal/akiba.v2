<?php

namespace Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\ReviewContent;
use App\Models\Review;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    public function testContainsReviewContentsOnReturn(): void
    {
        $user = User::factory()->create();
        $review = Review::factory()->create();

        ReviewContent::factory()->for($user)->create([
            'review_id' => $review->id,
        ]);

        $this->assertInstanceOf(ReviewContent::class, $review->reviewContent->first());
    }
}
