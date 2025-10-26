<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Log;

use Inertia\Inertia;

use App\Traits\Response\ProvideException;
use App\Traits\Response\ProvideSuccess;
use App\Traits\Upload\HandlesImageUpload;

use App\Models\Podcast;

class PodcastsController extends Controller
{
    use HandlesImageUpload, ProvideSuccess, ProvideException;

    public function permissions()
    {
        try{
            $user = request()->user();

            return [
                'edit' => $user->permissions_keys->contains('administrator')
            ];
        }catch(\Throwable $e){
            $this->provideException($e);
        }
    }

    public function listPodcasts()
    {
        try{
            return Podcast::where('is_active', true)->orderBy('created_at', 'desc')->paginate(10);
        }catch(\Throwable $e){
            $this->provideException($e);
        }
    }

    public function getPodcast($slug)
    {
        try{
            if($slug){
                return Podcast::where('slug', $slug)->with('user')->firstOrFail();
            }
        }catch(\Throwable $e){
            $this->provideException($e);
        }
    }

    public function createPodcast(Request $request)
    {
        try{
            $request->validate([
                'image' => 'required',
                'season' => 'required',
                'episode' => 'required',
                'title' => 'required',
                'summary' => 'required',
                'description' => 'required',
                'audio' => 'required'
            ], [
                'image.required' => 'Capa do podcast',
                'season.required' => 'Season',
                'episode.required' => 'Episode',
                'title.required' => 'Título do episódio',
                'summary.required' => 'Resumo do episódio',
                'description.required' => 'Escreva sobre o episódio',
                'audio.required' => 'URL Embeded do Spotify do episódio'
            ]);

            $user = request()->user();
        
            $exists = Podcast::where('season', $request->input('season'))->where('episode', $request->input('episode'))->exists();
            if($exists) return $this->provideSuccess('exists');

            Podcast::create([
                'user_id' => $user->id,
                'slug' => Str::slug($request->input('title')),
                'image' => $this->uploadImage('podcasts', $request->file('image')),
                'season' => $request->input('season'),
                'episode' => $request->input('episode'),
                'title' => $request->input('title'), 
                'summary' => $request->input('summary'), 
                'description' => $request->input('description'),
                'audio' => $request->input('audio')
            ]);

            return $this->provideSuccess('save');
        }catch(\Throwable $e){
            $this->provideException($e);
        }
    }

    public function updatePodcast(Request $request, $id)
    {
        try{
            $request->validate([
                'season' => 'required',
                'episode' => 'required',
                'title' => 'required',
                'summary' => 'required',
                'description' => 'required',
                'audio' => 'required'
            ], [
                'season.required' => 'Season',
                'episode.required' => 'Episode',
                'title.required' => 'Título do episódio',
                'summary.required' => 'Resumo do episódio',
                'description.required' => 'Escreva sobre o episódio',
                'audio.required' => 'URL Embeded do Spotify do episódio'
            ]);

            $podcast = Podcast::where('id', $id)->firstOrFail();
            $podcast->update([  
                'slug' => $request->input('title') !== $podcast->title ? Str::slug($request->input('title')) : $podcast->slug,
                'image' => $request->hasFile('image') ? $this->uploadImage('podcasts', $request->file('image'), 'public', $podcast->image) : $podcast->image,
                'season' => $request->input('season', $podcast->season),
                'episode' => $request->input('episode', $podcast->episode),
                'title' => $request->input('title', $podcast->title),
                'summary' => $request->input('summary', $podcast->summary),
                'description' => $request->input('description', $podcast->description),
                'audio' => $request->input('audio', $podcast->audio),
            ]);

            return $this->provideSuccess('update');
        }catch(\Throwable $e){
            $this->provideException($e);
        }
    }

    public function deactivatePodcast($id)
    {
        try{
            $podcast = Podcast::where('id', $id)->firstOrFail(); 
            $podcast->update([
                'is_active' => false,
            ]);

            return $this->provideSuccess('deactivate'); 
        }
        catch(\Throwable $e){
            return $this->provideException($e);
        }
    }

    public function render($slug = null)
    {
        return Inertia::render('admin/Podcasts', [
            'permissions' => $this->permissions(),
            'podcasts' => $this->listPodcasts(),
            'podcast' => $this->getPodcast($slug)
        ]);
    }
}
