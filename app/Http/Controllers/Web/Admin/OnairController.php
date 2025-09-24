<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Inertia\Inertia;

use App\Traits\Response\ProvideException;
use App\Traits\Response\ProvideSuccess;

use App\Models\Show;
use App\Models\Autodj;
use App\Models\Music;
use App\Models\Onair;
use App\Models\ListenerRequest;

class OnairController extends Controller
{
    use ProvideSuccess, ProvideException;

    public function getShows()
    {
        try {
            $user = request()->user();

            $query = Show::orderBy('created_at', 'desc');
            $query->with('user');
            $query->where('user_id', $user->id);
            $query->orWhere('category', 'all');
            $shows = $query->get();

            return $shows;
        } catch (\Throwable $e) {
            $this->provideException($e);
        }
    }

    public function getListenerRequests()
    {
        try {
            $onair = Onair::where('is_live', true)->first();

            $query = ListenerRequest::orderBy('created_at', 'desc');
            $query->with(['onair', 'musics']);
            $query->where('onair_id', $onair->id);
            $requests = $query->get();

            return $requests;
        } catch (\Throwable $e) {
            $this->provideException($e);
        }
    }

    public function createListenerRequest(Request $request)
    {
        try {
            $request->validate([
                'onair_id' => 'required',
                'music_id' => 'required',
                'listener' => 'required',
                'address' => 'required',
                'message' => 'required',
            ], [
                "onair_id.required" => "<b><i>Como gostaria de ser chamado</b></i> é obrigatório",
                "address.required" => "<b><i>Endereço</b></i> é obrigatório",
                "message.required" => "<b><i>Mensagem</b></i> é obrigatório",
            ]);

            $onair = Onair::where('is_live', true)->first();
            $onair->increment('listener_request_total');

            $music = Music::where('id', $request->input('music_id'))->first();
            $music->increment('listener_request_total');

            ListenerRequest::create([
                'onair_id' => $onair->id,
                'music_id' => $request->input('music_id'),
                'listener' => $request->input('listener'),
                'address' => $request->input('address'),
                'message' => $request->input('message'),
                'status' => "new"
            ]);

            return response('', 200);
        } catch (\Throwable $e) {
            $this->provideException($e);
        }
    }

    public function setListenerRequestsStatus($status)
    {
        try {
            $onair = Onair::where('is_live', true)->first();

            if ($onair) {
                $onair->update([
                    'listener_request_status' => $status
                ]);
            }

            return response('', 200);
        } catch (\Throwable $e) {
            $this->provideException($e);
        }
    }

    public function createMusic(Request $request)
    {
        try {
            $request->validate([
                'production' => 'required',
                'singer' => 'required',
                'music' => 'required'
            ], [
                'production.required' => '<b><i>Nome do anime</b></i> é obrigatório',
                'singer.required' => '<b><i>Nome da banda ou cantor(a)</b></i> é obrigatório',
                'music.required' => '<b><i>Nome da música</b></i> é obrigatório',
            ]);

            $music = Music::create([
                'production' => $request->input('production'),
                'singer' => $request->input('singer'),
                'music' => $request->input('music')
            ]);

            return response()->json($music, 200);
        } catch (\Throwable $e) {
            $this->provideException($e);
        }
    }

    public function setStartBroadcast($show)
    {
        try {
            $user = request()->user();
            $show = Show::where('id', $show)->first();

            if($show->category === 'all'){
                if($show->user_id !== $user->id){
                    $show->update([
                        'user_id' => $user->id
                    ]);
                }
            }

            Onair::where('is_live', true)->update([
                'is_live' => false,
                'listener_request_status' => false
            ]);

            $show->onair()->create([
                'listener_request_status' => true
            ]);

            return response('', 200);
        } catch (\Throwable $e) {
            $this->provideException($e);
        }
    }

    public function setEndBroadcast()
    {
        try {
            $autodj = Autodj::where('is_default', true)->first();

            Onair::where('is_live', true)->update([
                'is_live' => false,
                'listener_request_status' => false
            ]);

            $autodj->onair()->create([]);
        } catch (\Throwable $e) {
            $this->provideException($e);
        }
    }

    public function render()
    {
        return Inertia::render('admin/Posts', [
            "shows" => $this->getShows(),
            "listenerRequests" => $this->getListenerRequests(),
        ]);
    }
}
