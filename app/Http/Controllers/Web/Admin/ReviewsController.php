<?php

namespace App\Http\Controllers\web\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use Inertia\Inertia;

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

    public function getReview($slug)
    {
        try {
            if ($slug) {
                $user = request()->user();

                $query = Review::with('reviews.user');
                $query->where('slug', $slug);
                $review = $query->first();

                $userReview  = $review->reviews->contains('user_id', $user->id);

                // Add placeholder object in array reviews with user logged;
                if (!$userReview) {
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
                'title' => 'required',
                'sinopse' => 'required',
                'image' => 'required|image|max:2048',
                'cover' => 'required|image|max:2048',
                'content' => 'required'
            ], [
                "title.required" => "Nome do anime",
                "title.required" => "Sinopse do anime",
                "image.required" => "Imagem em destaque",
                "cover.required" => "Capa do anime",
                "content.required" => "Escreva sobre o anime",
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

    public function updateReview(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required',
                'sinopse' => 'required',
                'content' => 'required'
            ], [
                "title.required" => "Nome do anime",
                "title.required" => "Sinopse do anime",
                "content.required" => "Escreva sobre o anime",
            ]);

            $review = Review::where('id', $id)->first();
            $content = ReviewContent::where('id', $request->content_id)->first();

            $slug = $request->input('title') !== $review->title ? Str::slug($request->input('title')) : $review->slug;
            $image = $request->hasFile('image') ? $this->uploadImage('reviews', $request->file('image'), 'public', $review->image) : $review->image;
            $cover = $request->hasFile('cover') ? $this->uploadImage('reviews', $request->file('cover'), 'public', $review->cover) : $review->cover;
            $title = $request->input('title') !== $review->title ? $request->input('title') : $review->title;
            $sinopse = $request->input('sinopse') !== $review->sinopse ? $request->input('sinopse') : $review->sinopse;

            $review->update([
                'slug' => $slug,
                'title' => $title,
                'sinopse' => $sinopse,
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

            $this->ProvideSuccess('update');
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function render($slug = null)
    {
        return Inertia::render('admin/Reviews', [
            "publications" => $this->getReviews(),
            "publication" => $this->getReview($slug),
        ]);
    }
}
