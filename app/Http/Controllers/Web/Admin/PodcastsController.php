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

use App\Models\Podcast;

class PodcastsController extends Controller
{
    use HandlesImageUpload, ProvideSuccess, ProvideException;

    public function getPodcasts()
    {
        try{
            return Podcast::where('is_active', true)->paginate(10);
        }catch(\Throwable $e){
            $this->provideException($e);
        }
    }

    public function getPodcast($slug)
    {
        try{
            return Podcast::where('slug', $slug)->with('user')->first();
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

            $verifyExist = Podcast::where('season', $request->input('season'))->where('episode', $request->input('episode'))->exists();

            if($verifyExist){
                return $this->provideSuccess('exists');
            }

            $user = request()->user();
            $create = Podcast::create([
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

            if($create === false){
                throw new \Exception('Não foi possível criar o podcast');
            }

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

            $podcast = Podcast::where('id', $id)->first();

            $slug = $request->input('title') !== $podcast->title ? Str::slug($request->input('title')) : $podcast->slug;
            $image = $request->hasFile('image') ? $this->uploadImage('podcasts', $request->file('image'), 'public', $podcast->image) : $podcast->image;
            $season = $request->input('season') !== $podcast->season ? $request->input('season') : $podcast->season;
            $episode = $request->input('episode') !== $podcast->episode ? $request->input('episode') : $podcast->episode;
            $title = $request->input('title') !== $podcast->title ? $request->input('title') : $podcast->title;
            $summary = $request->input('summary') !== $podcast->summary ? $request->input('summary') : $podcast->summary;
            $description = $request->input('description') !== $podcast->description ? $request->input('description') : $podcast->description;
            $audio = $request->input('audio') !== $podcast->audio ? $request->input('audio') : $podcast->audio;

            $podcast->update([  
                'slug' => $slug,
                'image' => $image,
                'season' => $season,
                'episode' => $episode,
                'title' => $title, 
                'summary' => $summary,
                'description' => $description,
                'audio' => $audio,
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
            'podcasts' => $this->getPodcasts(),
            'podcast' => $this->getPodcast($slug)
        ]);
    }
}
