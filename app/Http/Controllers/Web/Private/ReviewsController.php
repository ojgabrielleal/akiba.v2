<?php

namespace App\Http\Controllers\Web\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Traits\FlashMessageTrait;
use App\Services\Process\ImageService;

use App\Models\Review;

class ReviewsController extends Controller
{
    use FlashMessageTrait;

    private ImageService $image;
    private $render = 'private/Reviews';

    public function __construct(ImageService $image)
    {
        $this->image = $image;
    }

    public function indexReviews()
    {
        return Review::with('contents')->get();
    }

    public function showReview(Review $review)
    {
        return Inertia::render($this->render, [
            'publication' => $review->load('contents'),
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
        return Inertia::render('admin/Reviews', [
            "publications" => $this->indexReviews(),
        ]);
    }
}
