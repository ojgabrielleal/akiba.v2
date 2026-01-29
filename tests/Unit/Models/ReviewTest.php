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

    public function testContentsRelationshipReturnsReviewContents(): void
    {
        $user = User::factory()->create();

        $content = ReviewContent::factory()
            ->for($user, 'author');

        $review = Review::factory()
            ->has($content, 'contents')
            ->create();

        $this->assertContainsOnlyInstancesOf(
            ReviewContent::class, 
            $review->contents
        );
    }
}
