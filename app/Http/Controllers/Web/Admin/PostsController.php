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
            if ($slug) {
                $query = Post::where('slug', $slug);
                $query->with(['references', 'categories']);
                return $query->first();
            }
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function updatePost(Request $request, $slug)
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
                "status.required" => "<b><i>Status</b></i> é obrigatório",
                "title.required" => "<b><i>Título</b></i> é obrigatório",
                "content.required" => "<b><i>Escreva sua matéria</b></i> é obrigatório",
                "image.required" => "<b><i>Imagem em destaque</b></i> é obrigatório",
                "cover.required" => "<b><i>Capa da matéria</b></i> é obrigatório",
                "first_reference_name.required" => "<b><i>Nome</b></i> para o site da primeira fonte de pesquisa é obrigatório",
                "first_reference_url.required" => "<b><i>URL</b></i> para o site da primeira fonte de pesquisa é obrigatório",
                "first_category.required" => "<b><i>Primeira tag</b></i> é obrigatório",
                "second_category.required" => "<b><i>Segunda tag</b></i> é obrigatório",
            ]);
            
            $post = Post::where('slug', $slug)->with(['references', 'categories'])->first();

            if ($request->filled('first_category') && $request->filled('second_category')) {
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

            if ($request->filled('first_reference_name') && $request->filled('first_reference_url') && $request->filled('second_reference_name') && $request->filled('second_font_url')) {
                $first_reference_id = $post->references[0]->id;
                $second_reference_id = $post->references[1]->id;

                $first_reference = PostReference::where('id', $first_reference_id)->first();
                $second_reference = PostReference::where('id', $second_reference_id)->first();

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
            $cover = $request->hasFile('cover') ? $this->uploadImage('posts', $request->file('cover')) : $post->cover;

            $post->update([
                'slug' =>  Str::slug($request->input('title')),
                'title' => $request->filled('title') ? $request->input('title') : $post->title,
                'content' => $request->filled('content') ? $request->input('content') : $post->content,
                'image' => $image,
                'cover' => $cover,
            ]);

            $this->ProvideSuccess('update');
            return redirect()->route('render.painel.materias', ['slug' => $slug]);
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
                "status.required" => "<b><i>Status</b></i> é obrigatório",
                "title.required" => "<b><i>Título</b></i> é obrigatório",
                "content.required" => "<b><i>Escreva sua matéria</b></i> é obrigatório",
                "image.required" => "<b><i>Imagem em destaque</b></i> é obrigatório",
                "cover.required" => "<b><i>Capa da matéria</b></i> é obrigatório",
                "first_reference_name.required" => "<b><i>Nome</b></i> para o site da primeira fonte de pesquisa é obrigatório",
                "first_reference_url.required" => "<b><i>URL</b></i> para o site da primeira fonte de pesquisa é obrigatório",
                "first_category.required" => "<b><i>Primeira tag</b></i> é obrigatório",
                "second_category.required" => "<b><i>Segunda tag</b></i> é obrigatório",
            ]);

            $slug = Str::slug($request->input('title'));

            $post = Post::create([
                'user_id' => $request->user()->id,
                'slug' => $slug,
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'status' => $request->input('status'),
                'image' => $this->uploadImage('posts', $request->file('image')),
                'cover' => $this->uploadImage('posts', $request->file('cover')),
            ]);

            PostReference::create([
                'post_id' => $post->id,
                'name' => $request->input('first_reference_name'),
                'url' => $request->input('first_reference_url'),
            ]);

            PostReference::create([
                'post_id' => $post->id,
                'name' => $request->input('second_reference_name'),
                'url' => $request->input('second_reference_url'),
            ]);

            PostCategory::create([
                'post_id' => $post->id,
                'category_name' => $request->input('first_category')
            ]);

            PostCategory::create([
                'post_id' => $post->id,
                'category_name' => $request->input('second_category')
            ]);

            $this->ProvideSuccess('save');
            return redirect()->route('render.painel.materias', ['slug' => $slug]);
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
