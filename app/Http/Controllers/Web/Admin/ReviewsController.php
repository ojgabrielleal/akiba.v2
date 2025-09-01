<?php

namespace App\Http\Controllers\web\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
            $user = request()->user();

            $query = Review::orderBy('created_at', 'desc');
            $query->with('reviews');
            $reviews = $query->paginate(10);

            $reviews->getCollection()->transform(function ($review) use ($user) {
                $data = $review->toArray();
                $data['editable'] = true;
                $data['styles'] = [
                    'bg' => $review->reviews->contains('user_id', $user->id) ? 'var(--color-purple-mystic)' : 'var(--color-blue-skywave)',
                ];
                return $data;
            });

            return $reviews;
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function getReview($reviewSlug)
    {
        try {
            if ($reviewSlug) {
                $user = request()->user();

                $query = Review::with('reviews.user');
                $query->where('slug', $reviewSlug);
                $review = $query->first();

                $userReview  = $review->reviews->contains('user_id', $user->id);

                // Add placeholder object in array reviews with user logged;
                if (!$userReview ) {
                    $placeholder = (object) [
                        'user_id' => $user->id,
                        'user' => (object) [
                            'id' => $user->id,
                            'nickname' => $user->nickname,
                        ],
                        'content' => 'Escreva seu review...'
                    ];
                    $review->reviews->prepend($placeholder);
                }

                return $review;
            }
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function createReview(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'sinopse' => 'required|string',
                'content' => 'required|string',
                'image' => 'required|image|mimes:jpg,jpeg,png,webp',
                'cover' => 'required|image|mimes:jpg,jpeg,png,webp',
            ]);

            $slug = Str::slug($request->input('title'));
            $review = Review::create([
                'slug' => $slug,
                'title' => $request->input('title'),
                'sinopse' => $request->input('sinopse'),
                'image' => $this->uploadImage('reviews', $request->file('image')),
                'cover' => $this->uploadImage('reviews', $request->file('cover')),
            ]);

            ReviewContent::create([
                'user_id' => $request->user()->id,
                'review_id' => $review->id,
                'content' => $request->input('content')
            ]);

            $this->ProvideSuccess('save');
            return redirect()->route('render.painel.reviews', ['reviewSlug' => $slug]);
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function updateReview(Request $request, $reviewSlug)
    {
        try {
            $review = Review::where('slug', $reviewSlug)->first();
            $content = ReviewContent::where('id', $request->content_id)->first();

            $slug = Str::slug($request->input('title'));
            $image = $request->hasFile('image') ? $this->uploadImage('posts', $request->file('image')) : $review->image;
            $cover = $request->hasFile('cover') ? $this->uploadImage('posts', $request->file('cover')) : $review->cover;

            $review->update([
                'slug' => Str::slug($request->input('title')),
                'title' => $request->input('title') ? $request->input('title') : $review->title,
                'sinopse' => $request->input('sinopse') ? $request->input('sinopse') : $review->sinopse,
                'image' => $image,
                'cover' => $cover,
            ]);

            if ($content) {
                $content->update([
                    'content' => $request->input('content')
                ]);
            } else {
                ReviewContent::create([
                    'user_id' => $request->user()->id,
                    'review_id' => $review->id,
                    'content' => $request->input('content')
                ]);
            }

            $this->ProvideSuccess('save');
            return redirect()->route('render.painel.reviews', ['reviewSlug' => $slug]);
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function render($reviewSlug = null)
    {
        return inertia('admin/Reviews', [
            "publications" => $this->getReviews(),
            "publication" => $this->getReview($reviewSlug),
        ]);
    }
}
