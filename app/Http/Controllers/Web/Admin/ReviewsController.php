<?php

namespace App\Http\Controllers\web\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Traits\Response\ProvideException;
use App\Traits\Response\ProvideSuccess;
use App\Traits\Upload\HandlesImageUpload;

use App\Models\Review;
use App\Models\ReviewContent;

class ReviewsController extends Controller
{
    use HandlesImageUpload, ProvideSuccess, ProvideException;

    public function getReviews()
    {
        try {
            return Review::paginate(10);
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function getReview($reviewSlug, $userId)
    {
        try{
            $review = Review::where('slug', $reviewSlug)->first();
            $content = ReviewContent::where('user_id', $userId)->pluck('content')->implode(' ');

            return array_merge($review->toArray(), [
                'content' => $content
            ]);
        }catch(\Throwable $e){
            return $this->provideException($e);
        }
    }

    public function render($reviewSlug = null, $userId = null)
    {
        return inertia('admin/Reviews', [
            "reviews" => $this->getReviews(),
            "review" => $this->getReview($reviewSlug, $userId),
        ]);
    }
}
