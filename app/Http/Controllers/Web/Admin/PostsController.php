<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Post;

class PostsController extends Controller
{
    public function getPosts()
    {
        try {
            return Post::orderBy('created_at', 'desc')->get()->load([
                'user',
            ]);
        } catch (\Throwable $e) {
            return $this->ProvideException($e);
        }
    }


    public function render()
    {
        return inertia('admin/Posts', [
            "posts" => $this->getPosts()
        ]);
    }
}
