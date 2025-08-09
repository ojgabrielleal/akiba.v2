<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use App\Traits\Response\ProvideException;
use App\Traits\Response\ProvideSuccess;
use App\Traits\Upload\HandlesImageUpload;

use App\Models\Post;
use App\Models\PostReference;
use App\Models\PostCategory;

class PostsController extends Controller
{
    use HandlesImageUpload, ProvideSuccess, ProvideException;

public function getPosts()
{
    try {
        $user = request()->user();
        $query = Post::with('user');

        if (!$user->permissions_keys->contains('administrator')) {
            $query->where('user_id', $user->id);
        }

        $posts = $query->paginate(10);

        return $posts;
    } catch (\Throwable $e) {
        return $this->provideException($e);
    }
}

    public function getPost($postSlug)
    {
        try {
            return optional(Post::where('slug', $postSlug)->with(['references', 'categories'])->first())->makeHidden(['styles']);
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function updatePost(Request $request, $postSlug)
    {
        try {
            $request->validate([
                'first_category' => 'not_in:#',
                'second_category' => 'not_in:#'
            ]);

            $post = Post::where('slug', $postSlug)->with(['references', 'categories'])->first();
            
            if($request->filled('first_category') && $request->filled('second_category')){
                $first_category_id = $post->categories[0]->id;
                $second_category_id = $post->categories[1]->id;
                
                $first_category = PostCategory::where('id', $first_category_id)->first();
                $second_category = PostCategory::where('id', $second_category_id)->first();
                
                $first_category->update([
                    'category_name' => $request->input('first_category') 
                ]);

                $second_category->update([
                    'category_name' => $request->input('second_category')
                ]);
            }

            if($request->filled('first_reference_name') && $request->filled('first_reference_url') && $request->filled('second_reference_name') && $request->filled('second_font_url')){
                $fist_reference_id = $post->references[0]->id;
                $second_reference_id = $post->references[1]->id;

                $first_reference = PostReference::where('id', $fist_reference_id)->first();
                $second_reference = PostReference::where('id', $fist_reference_id)->first();

                $first_reference->update([
                    'name' => $request->input('first_reference_name'),
                    'url' => $request->input('first_reference_url'),
                ]);

                $second_reference->update([
                    'name' => $request->input('second_reference_name'),
                    'url' => $request->input('second_reference_url'),
                ]);
            }
                
            $slug = Str::slug($request->input('title'));
            $image = $request->hasFile('image') ? $this->uploadImage('posts', $request->file('image')) : $post->image;
            $cover= $request->hasFile('cover') ? $this->uploadImage('posts', $request->file('cover')) : $post->cover;

            $post->update([
                'slug' => $slug,
                'title' => $request->filled('title') ? $request->input('title') : $post->title,
                'content'=> $request->filled('content') ? $request->input('content') : $post->content,
                'image' => $image,
                'cover' => $cover,
            ]);

            $this->ProvideSuccess('update');
            return redirect()->route('render.painel.materias', ['postSlug' => $slug]);
        } catch (\Throwable $e) {
            return $this->provideException($e);
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
