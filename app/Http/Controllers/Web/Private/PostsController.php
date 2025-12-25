<?php

namespace App\Http\Controllers\Web\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Traits\FlashMessageTrait;

use App\Services\Domain\PostService;

class PostsController extends Controller
{
    use FlashMessageTrait;

    public function createPost(Request $request)
    {
        $request->validate([
            "status" => 'required',
            "title" => 'required',
            "content" => 'required',
            'image' => 'required',
            'cover' => 'required',
            'first_reference_name' => 'required',
            'first_reference_url' => 'required',
            'second_reference_name' => 'required',
            'second_reference_url' => 'required',
            'first_category' => 'required',
            'second_category' => 'required',
        ]);

        $postService = new PostService();
        $postCreate = $postService->create($request->all());

        if($postCreate) return $this->flashMessage('save');
    }

    public function updatePost(Request $request, $postId)
    {
        $request->validate([
            "status" => 'required',
            "title" => 'required',
            "content" => 'required',
            'first_reference_name' => 'required',
            'first_reference_url' => 'required',
            'second_reference_name' => 'required',
            'second_reference_url' => 'required',
            'first_category' => 'required',
            'second_category' => 'required',
        ]);

        $postService = new PostService();
        $postUpdate = $postService->update($postId, $request->all());

        if($postUpdate) return $this->flashMessage('update');
    }

    public function render($postSlug = null)
    {
        $postService = new PostService();

        return Inertia::render('admin/Posts', [
            "publications" => $postService->list(),
            "publication" => $postService->get($postSlug)
        ]);
    }
}
