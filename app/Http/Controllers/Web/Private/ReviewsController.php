<?php

namespace App\Http\Controllers\Web\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Traits\HasFlashMessages;
use App\Services\Process\ImageService;

use App\Models\Review;

use function PHPSTORM_META\map;

class ReviewsController extends Controller
{
    use HasFlashMessages;

    private ImageService $image;
    private $render = 'private/Reviews';

    public function __construct(ImageService $image)
    {
        $this->image = $image;
    }

    public function indexReviews()
    {
        return Review::with('reviews')->paginate(10);
    }

    public function showReview(Review $review)
    {
        $review = $review->load('reviews.author');

        $response = [ 
            'id' => $review->id,
            'slug' => $review->slug,
            'title' => $review->title,
            'sinopse' => $review->sinopse,
            'image' => $review->image,
            'cover' => $review->cover, 
            'authors' => $review->reviews.map(fn($item)=>[
                'slug' => $item->author->slug,
                'nickname' => $item->author->nickname,
                'review_id' => $item->id,
            ]),
        ];

        return Inertia::render($this->render, [
            "reviews" => $this->indexReviews(),
            'review' => $response,
        ]);
    }

    public function createReview(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'sinopse' => 'required',
            'image' => 'required',
            'cover' => 'required',
            'content' => 'required'
        ]);

        $review = Review::create([
            'title' => $request->input('title'),
            'sinopse' => $request->input('sinopse'),
            'image' => $this->image->store('reviews', $request->file('image'), 'public'),
            'cover' => $this->image->store('reviews', $request->file('cover'), 'public'),
        ]);
       
        $review->reviews()->create([
            'user_id' => request()->user()->id,
            'content' => $request->input('content'),
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

        if($review->isDirty()) {
            $review->save();

            $review->reviews()->update([
                'content' => $request->input('content'),
            ]);
        }

        return $this->flashMessage('update');
    }

    public function render()
    {
        return Inertia::render($this->render, [
            "reviews" => $this->indexReviews(),
        ]);
    }
}
