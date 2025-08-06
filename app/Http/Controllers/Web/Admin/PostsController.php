<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Traits\Response\ProvideException;

use App\Models\Post;

class PostsController extends Controller
{
    use ProvideException;

    public function getPosts()
    {
        try {
            $user = request()->user();
            $query = Post::orderBy('created_at', 'desc')->with('user');

            // Check if user logged is not administrator, if user logged is administrator, return all results
            if(!$user->permissions_keys->contains('administrator')){
                $query->where('user_id', $user->id);     
            }

            // Execute query
            $posts = $query->get();

            return $posts;
        } catch (\Throwable $e) {
            return $this->ProvideException($e);
        }
    }

    public function getPost($postSlug)
    {
        try {
            return optional(Post::where('slug', $postSlug)->with(['references', 'categories'])->first())->makeHidden(['styles']);
        } catch (\Throwable $e) {
            return $this->ProvideException($e);
        }
    }

    public function render($postSlug = null)
    {
        return inertia('admin/Posts', [
            "posts" => $this->getPosts(),
            "post" => $this->getPost($postSlug)
        ]);
    }
}
