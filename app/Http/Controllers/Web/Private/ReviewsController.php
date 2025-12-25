<?php

namespace App\Http\Controllers\Web\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Traits\FlashMessageTrait;

use App\Services\Domain\ReviewService;

class ReviewsController extends Controller
{
    use FlashMessageTrait;

    public function createReview(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'sinopse' => 'required',
            'image' => 'required',
            'cover' => 'required',
            'content' => 'required'
        ]);

        $authenticated = request()->user();

        $reviewService = new ReviewService();
        $reviewCreate = $reviewService->create($authenticated, $request->all());

        if($reviewCreate) return $this->flashMessage('save');
    }

    public function updateReview(Request $request, $reviewId)
    {
        $request->validate([
            'title' => 'required',
            'sinopse' => 'required',
            'content' => 'required'
        ]);

        $reviewService = new ReviewService();
        $reviewUpdate = $reviewService->update($reviewId, $request->all());

        if($reviewUpdate) return $this->flashMessage('save');
    }

    public function render($reviewSlug = null)
    {
        $reviewService = new ReviewService();

        return Inertia::render('admin/Reviews', [
            "publications" => $reviewService->list(),
            "publication" => $reviewService->get($reviewSlug),
        ]);
    }
}
