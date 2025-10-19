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
            $query->when(!$user->permissions_keys->contains('administrator'), function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
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
            return Post::where('slug', $slug)->with(['references', 'categories'])->firstOrFail();
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

            if ($request->filled('first_category') && $request->filled('second_category')) {
                $firstCategoryId = $post->categories[0]->id;
                $secondCategoryId = $post->categories[1]->id;

                $first_category = PostCategory::where('id', $firstCategoryId)->firstOrFail();
                $second_category = PostCategory::where('id', $secondCategoryId)->firstOrFail();

                $firstCategoryUpdate = $first_category->update([
                    'category_name' => $request->input('first_category')
                ]);
                if ($firstCategoryUpdate === 0) throw new \Exception('Não foi possível atualizar a primeira tag');

                $secondCategoryUpdate = $second_category->update([
                    'category_name' => $request->input('second_category')
                ]);
                if ($secondCategoryUpdate === 0) throw new \Exception('Não foi possível atualizar a segunda tag');
            }

            if ($request->filled('first_reference_name') && $request->filled('first_reference_url') && $request->filled('second_reference_name') && $request->filled('second_reference_url')) {
                $firstReferenceId = $post->references[0]->id;
                $secondReferenceId = $post->references[1]->id;

                $firstReference = PostReference::where('id', $firstReferenceId)->firstOrFail();
                $secondReference = PostReference::where('id', $secondReferenceId)->firstOrFail();

                $firstReferenceUpdate = $firstReference->update([
                    'name' => $request->input('first_reference_name'),
                    'url' => $request->input('first_reference_url'),
                ]);
                if ($firstReferenceUpdate === 0) throw new \Exception('Não foi possível atualizar a primeira referência');

                $secondReferenceUpdate = $secondReference->update([
                    'name' => $request->input('second_reference_name'),
                    'url' => $request->input('second_reference_url'),
                ]);
                if ($secondReferenceUpdate === 0) throw new \Exception('Não foi possível atualizar a segunda referência');
            }

            $slug = $request->input('title') !== $post->title ? Str::slug($request->input('title')) : $post->slug;
            $image = $request->hasFile('image') ? $this->uploadImage('posts', $request->file('image'), 'public', $post->image) : $post->image;
            $cover = $request->hasFile('cover') ? $this->uploadImage('posts', $request->file('cover'), 'public', $post->cover) : $post->cover;
            $title = $request->input('title') !== $post->title ? $request->input('title') : $post->title;
            $content = $request->input('content') !== $post->content ? $request->input('content') : $post->content;

            $postUpdate = $post->update([
                'slug' =>  $slug,
                'title' => $title,
                'content' => $content,
                'image' => $image,
                'cover' => $cover,
            ]);
            if ($postUpdate === 0) throw new \Exception('Não foi possível atualizar a matéria');

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

            $postCreate = Post::create([
                'user_id' => $request->user()->id,
                'slug' => Str::slug($request->input('title')),
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'status' => $request->input('status'),
                'image' => $this->uploadImage('posts', $request->file('image')),
                'cover' => $this->uploadImage('posts', $request->file('cover')),
            ]);
            if (!$postCreate) throw new \Exception('Não foi possível criar a matéria');

            $firstReferenceCreate = PostReference::create([
                'post_id' => $postCreate->id,
                'name' => $request->input('first_reference_name'),
                'url' => $request->input('first_reference_url'),
            ]);
            if(!$firstReferenceCreate) throw new \Exception('Não foi possível criar a primeira referência');

            $secondReferenceCreate = PostReference::create([
                'post_id' => $postCreate->id,
                'name' => $request->input('second_reference_name'),
                'url' => $request->input('second_reference_url'),
            ]);
            if(!$secondReferenceCreate) throw new \Exception('Não foi possível criar a segunda referência');

            $firstCategoryCreate = PostCategory::create([
                'post_id' => $postCreate->id,
                'category_name' => $request->input('first_category')
            ]);
            if(!$firstCategoryCreate) throw new \Exception('Não foi possível criar a primeira categoria');

            $secondCategoryCreate = PostCategory::create([
                'post_id' => $postCreate->id,
                'category_name' => $request->input('second_category')
            ]);
            if(!$secondCategoryCreate) throw new \Exception('Não foi possível criar a segunda categoria');

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
