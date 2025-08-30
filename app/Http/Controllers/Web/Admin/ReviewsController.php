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
            $query = Review::orderBy('created_at', 'desc');
            $reviews = $query->paginate(10);

            $reviews->getCollection()->transform(function($post){
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
        try{
            if($reviewSlug){
                $query = Review::with('reviews.user');
                $query->where('slug', $reviewSlug);
                return $query->first();
            }
        }catch(\Throwable $e){
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
