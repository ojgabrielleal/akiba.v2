<?php

namespace App\Http\Controllers\Web\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Traits\FlashMessageTrait;
use App\Services\Process\ImageService;

use App\Models\Post;

class PostsController extends Controller
{
    use FlashMessageTrait;

    private ImageService $image;
    private $render = 'private/Posts';

    public function __construct(ImageService $image)
    {
        $this->image = $image;
    }

    public function indexPosts()
    {
        return Post::with('author')->paginate(10);
    }

    public function showPost(Post $post)
    {
        return Inertia::render($this->render, [
            'publication' => $post->load('categories', 'references', 'author')
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
            'image' => $this->image->store('posts', $request->file('image')),
            'cover' => $this->image->store('posts', $request->file('cover')),
        ]);

        foreach($request->input('references') as $reference) {
            $post->references()->create([
                'name' => $reference['name'],
                'url' => $reference['url'],
            ]);
        }

        foreach($request->input('categories') as $category){
            $post->categories()->create([
                'name' => $category,
            ]);
        }

        return $this->flashMessage('save');
    }

    public function updatePost(Request $request, Post $post)
    {
        $post->fill([
            'title' => $request->input('title', $post->title),
            'content' => $request->input('content', $post->content),
            'image' => $this->image->store('posts', $request->file('image'), 'public', $post->image),
            'cover' => $this->image->store('posts', $request->file('cover'), 'public', $post->cover),
        ]);

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
            "publications" => $this->indexPosts(),
        ]);
    }
}
