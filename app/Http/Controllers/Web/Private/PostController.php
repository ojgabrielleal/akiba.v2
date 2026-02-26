<?php

namespace App\Http\Controllers\Web\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Post;

use App\Http\Resources\PostIndexResource;
use App\Http\Resources\PostShowResource;

use App\Services\Process\ImageProcessService;

use App\Traits\HasFlashMessages;
use App\Traits\ResolvesUserLogged;

class PostController extends Controller
{
    use HasFlashMessages, ResolvesUserLogged;

    private ImageProcessService $image;
    private $render = 'private/Post';

    public function __construct(ImageProcessService $image)
    {
        $this->image = $image;
    }

    public function indexPosts()
    {
        /**
         * TODO: Refactor when implementing policies, move permission logic into the policy. 
         */
        $user = $this->getUserLogged();
        $canListOwn = $user['permissions']->contains('name', 'post.list.own');

        if ($canListOwn) {
            return PostIndexResource::collection(
                Post::mine()
                    ->with('author')
                    ->latest()
                    ->paginate(10)
            );
        }

        return PostIndexResource::collection(
            Post::with('author')
                ->latest()
                ->paginate(10)
        );
    }

    public function showPost(Post $post)
    {

        return Inertia::render($this->render, [
            'post' => new PostShowResource(
                $post->load('categories', 'references', 'author')
            ),
            "posts" => $this->indexPosts(),
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

        foreach ($request->input('categories') as $category) {
            $post->categories()->create([
                'name' => $category['name'],
            ]);
        }

        foreach ($request->input('references') as $reference) {
            $post->references()->create([
                'name' => $reference['name'],
                'url' => $reference['url'],
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

        if ($post->isDirty()) {
            $post->save();
        }

        foreach ($request->input('categories') as $category) {
            $post->categories()->where('uuid', $category['uuid'])->update([
                'name' => $category['name'],
            ]);
        }

        foreach ($request->input('references') as $reference) {
            $post->references()->where('uuid', $reference['uuid'])->update([
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
