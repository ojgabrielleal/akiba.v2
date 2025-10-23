<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use Inertia\Inertia;

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

            $query = Post::orderBy('created_at', 'desc');
            $query->with('user');
            $query->when(!$user->permissions_keys->contains('administrator'), function ($q) use ($user) { $q->where('user_id', $user->id); });
            $posts = $query->paginate(10);

            function resolvePostAppareace($post)
            {
                $status = [
                    "published" => "var(--color-blue-skywave)",
                    "sketch" => "var(--color-green-forest)",
                    "revision" => "var(--color-orange-amber)"
                ];

                return [
                    "bg" => $status[$post->status] ?? 'var(--color-blue-skywave)'
                ];
            }

            $posts->getCollection()->transform(function ($post) use ($user) {
                $data = $post->toArray();
                $data['styles'] = resolvePostAppareace($post);
                $data['editable'] = $user->permissions_keys->contains('administrator') || $post->user_id == $user->id;
                return $data;
            });

            return $posts;
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function getPost($slug)
    {
        try {
            if($slug){
                return Post::where('slug', $slug)->with(['references', 'categories'])->firstOrFail();
            }
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function updatePost(Request $request, $id)
    {
        try {
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
            ], [
                "status.required" => "Status",
                "title.required" => "Título",
                "content.required" => "Escreva sua matéria",
                "first_reference_name.required" => "Nome para o site da primeira fonte de pesquisa",
                "first_reference_url.required" => "URL para o site da primeira fonte de pesquisa",
                "first_category.required" => "Primeira tag",
                "second_category.required" => "Segunda tag",
            ]);

            $post = Post::where('id', $id)->with(['references', 'categories'])->firstOrFail();
            $post->update([
                'slug' =>  $request->input('title') !== $post->title ? Str::slug($request->input('title')) : $post->slug,
                'title' => $request->input('title', $post->title),
                'content' => $request->input('content', $post->content),
                'image' => $request->hasFile('image') ? $this->uploadImage('posts', $request->file('image'), 'public', $post->image) : $post->image,
                'cover' => $request->hasFile('cover') ? $this->uploadImage('posts', $request->file('cover'), 'public', $post->cover) : $post->cover,
            ]);

            $first_category = PostCategory::where('id', $post->categories[0]->id)->firstOrFail();
            $second_category = PostCategory::where('id',$post->categories[1]->id)->firstOrFail();
            $firstReference = PostReference::where('id', $post->references[0]->id)->firstOrFail();
            $secondReference = PostReference::where('id', $post->references[1]->id)->firstOrFail();

            $first_category->update([
                'category_name' => $request->input('first_category', $first_category->category_name)
            ]);
            $second_category->update([
                'category_name' => $request->input('second_category', $second_category->category_name)
            ]);
            $firstReference->update([
                'name' => $request->input('first_reference_name', $firstReference->name),
                'url' => $request->input('first_reference_url', $firstReference->url)
            ]);
            $secondReference->update([
                'name' => $request->input('second_reference_name', $secondReference->name),
                'url' => $request->input('second_reference_url', $secondReference->url)
            ]);


            return $this->provideSuccess('update');
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function createPost(Request $request)
    {
        try {
            $request->validate([
                "status" => 'required',
                "title" => 'required',
                "content" => 'required',
                'image' => 'required|image|max:2048',
                'cover' => 'required|image|max:2048',
                'first_reference_name' => 'required',
                'first_reference_url' => 'required',
                'second_reference_name' => 'required',
                'second_reference_url' => 'required',
                'first_category' => 'required',
                'second_category' => 'required',
            ], [
                "status.required" => "Status",
                "title.required" => "Título",
                "content.required" => "Escreva sua matéria",
                "image.required" => "Imagem em destaque",
                "cover.required" => "Capa da matéria",
                "first_reference_name.required" => "Nome para o site da primeira fonte de pesquisa",
                "first_reference_url.required" => "URL para o site da primeira fonte de pesquisa",
                "first_category.required" => "Primeira tag",
                "second_category.required" => "Segunda tag",
            ]);

            $create = Post::create([
                'user_id' => $request->user()->id,
                'slug' => Str::slug($request->input('title')),
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'status' => $request->input('status'),
                'image' => $this->uploadImage('posts', $request->file('image')),
                'cover' => $this->uploadImage('posts', $request->file('cover')),
            ]);

            PostReference::create([
                'post_id' => $create->id,
                'name' => $request->input('first_reference_name'),
                'url' => $request->input('first_reference_url'),
            ]);

            PostReference::create([
                'post_id' => $create->id,
                'name' => $request->input('second_reference_name'),
                'url' => $request->input('second_reference_url'),
            ]);

            PostCategory::create([
                'post_id' => $create->id,
                'category_name' => $request->input('first_category')
            ]);

            PostCategory::create([
                'post_id' => $create->id,
                'category_name' => $request->input('second_category')
            ]);

            return $this->provideSuccess('save');
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function render($slug = null)
    {
        return Inertia::render('admin/Posts', [
            "publications" => $this->getPosts(),
            "publication" => $this->getPost($slug)
        ]);
    }
}
