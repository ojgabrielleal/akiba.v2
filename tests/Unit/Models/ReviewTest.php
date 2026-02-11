<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\ReviewContent;
use App\Models\Review;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests from Review model relationships.
     */
    public function testReviewsRelationshipReturnsReviewContents(): void
    {
        $user = User::factory()->create();

        $reviews = ReviewContent::factory()
            ->for($user, 'author');

        $review = Review::factory()
            ->has($reviews, 'reviews')
            ->create();

        $this->assertContainsOnlyInstancesOf(
            ReviewContent::class,
            $review->reviews
        );
    }

    /**
     * Tests from Post model mutators.
     */
    public function testTitleMutatorSetsSlugCorrectly(): void
    {
        $user = User::factory()->create();

        $reviews = ReviewContent::factory()
            ->for($user, 'author');

        $review = Review::factory()
            ->has($reviews, 'reviews')
            ->create([
                'title' => 'Sample Review Title'
            ]);

        $this->assertEquals('sample-review-title', $review->slug);
    }
}
