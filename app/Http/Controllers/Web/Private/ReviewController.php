<?php

namespace App\Http\Controllers\Web\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Review;

use App\Http\Resources\ReviewIndexResource;
use App\Http\Resources\ReviewShowResource;

use App\Services\Process\ImageProcessService;
use App\Traits\HasFlashMessages;

class ReviewController extends Controller
{
    use HasFlashMessages;

    private ImageProcessService $image;
    private $render = 'private/Review';

    public function __construct(ImageProcessService $image)
    {
        $this->image = $image;
    }

    public function indexReviews()
    {
        return ReviewIndexResource::collection(
            Review::with('reviews')->paginate(10)
        );
    }

    public function showReview(Review $review)
    {
        return Inertia::render($this->render, [
            "reviews" => $this->indexReviews(),
            'review' => new ReviewShowResource(
                $review->load('reviews.author')
            ),
        ]);
    }

    public function createReview(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'sinopse' => 'required',
            'image' => 'required',
            'cover' => 'required',
            'review' => 'required'
        ]);

        $review = Review::create([
            'title' => $request->input('title'),
            'sinopse' => $request->input('sinopse'),
            'image' => $this->image->store('reviews', $request->file('image'), 'public'),
            'cover' => $this->image->store('reviews', $request->file('cover'), 'public'),
        ]);

        $review->reviews()->create([
            'user_id' => request()->user()->id,
            'content' => $request->input('review.content'),
        ]);

        return $this->flashMessage('save');
    }

    public function updateReview(Request $request, Review $review)
    {
        $review->fill([
            'title' => $request->input('title'),
            'sinopse' => $request->input('sinopse'),
            'image' => $this->image->store('reviews', $request->file('image'), 'public', $review->image),
            'cover' => $this->image->store('reviews', $request->file('cover'), 'public', $review->cover),
        ]);

        if ($review->isDirty()) {
            $review->save();
        }

        $review->reviews()->updateOrCreate(
            ['uuid' => $request->input('review.uuid')],
            [
                'user_id' => $request->user()->id,
                'content' => $request->input('review.content'),
            ]
        );

        return $this->flashMessage('update');
    }

    public function render()
    {
        return Inertia::render($this->render, [
            "reviews" => $this->indexReviews(),
        ]);
    }
}
