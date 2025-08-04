<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Traits\Logged\ProvideAuthenticateUser;
use App\Traits\Response\ProvideException;

use App\Models\Post;

class PostsController extends Controller
{
    use ProvideAuthenticateUser, ProvideException;

    public function getPosts()
    {
        try {
            $authenticateUser = $this->ProvideAuthenticateUser();
            $query = Post::orderBy('created_at', 'desc')->with('user');

            // Check if user logged is not administrator, if user logged is administrator, return all results
            if(!$authenticateUser->permissions->contains('administrator')){
                $query->where('user_id', $authenticateUser->id);     
            }

            // Execute query
            $posts = $query->get();

            // Status color from posts
            $status = [
                "published"=>"#0091ff",
                "review"=>"#00a859",
                "revision"=>"#f69700"
            ];

            // Insert personalized keys before return;
            $posts->transform(function($post) use ($authenticateUser, $status){
                $post->editable = $authenticateUser->permissions->contains('administrator') ? true : false;
                $post->status_color = $status[$post->status];
                return $post;
            });

            return $posts;

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
