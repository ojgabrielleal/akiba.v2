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
            $query = Review::orderBy('created_at', 'desc');
            $reviews = $query->paginate(10);

            $reviews->getCollection()->transform(function ($post) {
                $data = $post->toArray();
                $data['editable'] = true;
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

                $query = Review::with(['reviews' => function ($q) use ($user) {
                    $q->when(!$user->permissions_keys->contains('administrator'), function ($q) use ($user) {
                        $q->where('user_id', $user->id);
                    })
                        ->orderByRaw('CASE WHEN user_id = ? THEN 0 ELSE 1 END', [$user->id])
                        ->with('user');
                }]);
                $query->where('slug', $reviewSlug);
                $review = $query->first();

                // --- The check goes here ---
                if ($review) {
                    $userLoggedExists = $review->reviews->contains('user_id', $user->id);
                    if (!$userLoggedExists) {
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

            $review = Review::create([
                'slug' => Str::slug($request->input('title')),
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
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function render($reviewSlug = null)
    {
        return inertia('admin/Reviews', [
            "publications" => $this->getReviews(),
            "publication" => $this->getReview($reviewSlug,),
        ]);
    }
}
