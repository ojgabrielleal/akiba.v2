<?php

namespace App\Http\Controllers\Web\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

use App\Traits\HasFlashMessages;
use App\Services\Process\ImageService;

use App\Models\Post;

class PostsController extends Controller
{
    use HasFlashMessages;

    private ImageService $image;
    private $render = 'private/Posts';

    public function __construct(ImageService $image)
    {
        $this->image = $image;
    }

    public function indexPosts()
    {
        /**
         * TODO: Refactor when implementing policies, move permission logic into the policy. 
         */
        $user = request()->user()->load('roles.permissions');
        $canPermission = $user->roles->flatMap(fn($role) => $role->permissions)->contains('name', 'post.list');

        if($canPermission){
            return Post::with('author')->latest()->paginate(10);
        }else{
            return Post::mine()->with('author')->latest()->paginate(10);
        }
    }

    public function showPost(Post $post)
    {
        return Inertia::render($this->render, [
            'publication' => $post->load('categories', 'references', 'author'),
            "publications" => $this->indexPosts()
        ]);
    }

    public function createPost(Request $request)
    {
        $request->validate([
            "status" => 'required',
            "title" => 'required',
            "content" => 'required',
            'image' => 'required',
            'cover' => 'required',
            'references' => 'required',
            'categories' => 'required',
        ]);

        $post = Post::create([
            'user_id' => request()->user()->id,
            'status' => $request->input('status'),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'image' => $this->image->store('posts', $request->file('image'), 'public'),
            'cover' => $this->image->store('posts', $request->file('cover'), 'public'),
        ]);

        foreach($request->input('references') as $reference) {
            $post->references()->create([
                'name' => $reference['name'],
                'url' => $reference['url'],
            ]);
        }

        foreach($request->input('categories') as $category){
            $post->categories()->create([
                'name' => $category['name'],
            ]);
        }

        return $this->flashMessage('save');
    }

    public function updatePost(Request $request, Post $post)
    {        
        $post->fill([
            'status' => $request->input('status', $post->status),
            'title' => $request->input('title', $post->title),
            'content' => $request->input('content', $post->content),
            'image' => $this->image->store('posts', $request->file('image'), 'public', $post->image),
            'cover' => $this->image->store('posts', $request->file('cover'), 'public', $post->cover),
        ]);

        if($post->isDirty()){
            $post->save();
        }

        foreach($request->input('categories') as $category) {
            $post->categories()->where('id', $category['id'] )->update([
                'name' => $category['name'],
            ]);
        }

        foreach($request->input('references') as $reference) {
            $post->references()->where('id', $reference['id'])->update([
                'name' => $reference['name'],
                'url' => $reference['url'],
            ]);
        }

        return $this->flashMessage('update');
    }

    public function render()
    {
        return Inertia::render($this->render, [
            "posts" => $this->indexPosts(),
        ]);
    }
}
