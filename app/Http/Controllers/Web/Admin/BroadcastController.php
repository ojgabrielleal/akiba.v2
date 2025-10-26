<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use Inertia\Inertia;

use App\Traits\Response\ProvideException;
use App\Traits\Response\ProvideSuccess;

use App\Models\Show;
use App\Models\Autodj;
use App\Models\Onair;
use App\Models\ListenerRequest;
use App\Models\Music;

class BroadcastController extends Controller
{
    use ProvideSuccess, ProvideException;

    public function setCheckOnair()
    {
        try {
            $user = request()->user();
            $onair = Onair::where('is_live', true)->firstOrFail();

            $response = [
                'onair' => false,
                'streamer'  => null,
                'listener_request' => null,
            ];

            if ($onair) {
                $show = Show::where('id', $onair->program_id)->firstOrFail();

                if ($onair->program_type === "App\Models\Autodj") {
                    $response['onair'] = false;
                    $response['streamer'] = false;
                    $response['listener_request'] = false;
                }

                if ($onair->program_type === "App\Models\Show") {
                    $response['onair'] = true;
                    $response['streamer'] = $show->user_id === $user->id;
                    $response['listener_request'] = $onair->listener_request_status;
                }
            }

            return $response;
        } catch (\Throwable $e) {
            $this->provideException($e);
        }
    }

    public function listShows()
    {
        try {
            $user = request()->user();

            $query = Show::orderBy('created_at', 'desc');
            $query->with('user');
            $query->where('is_active', true);
            $query->where(function ($q) use ($user) { $q->where('user_id', $user->id)->orWhere('is_all', true); });
            $shows = $query->get();

            return $shows;
        } catch (\Throwable $e) {
            $this->provideException($e);
        }
    }

    public function listListenersRequests()
    {
        try {
            $onair = Onair::where('is_live', true)->firstOrFail();

            $query = ListenerRequest::orderBy('created_at', 'desc');
            $query->with(['onair', 'music']);
            $query->where('onair_id', $onair->id);
            $requests = $query->get();

            return $requests;
        } catch (\Throwable $e) {
            $this->provideException($e);
        }
    }


    public function setGrantedListenerRequest($id)
    {
        try {
            $request = ListenerRequest::where('id', $id)->firstOrFail();
            $request->update([
                'status' => 'granted'
            ]);

            return $this->provideSuccess('listener_request_granted');
        } catch (\Throwable $e) {
            $this->provideException($e);
        }
    }
    
    public function setCancelListenerRequest($id)
    {
        try {
            $listener = ListenerRequest::where('id', $id)->with(['onair', 'music'])->firstOrFail();
            $music = Music::where('id', $listener->music_id)->firstOrFail();
            $onair = Onair::where('id', $listener->onair_id)->firstOrFail();

            $listener->update([
                'status' => 'canceled'
            ]);
            
            $music->update([
                'listener_request_total' => $music->listener_request_total - 1
            ]);

            $onair->update([
                'listener_request_total' => $onair->listener_request_total - 1
            ]);

            return $this->provideSuccess('listener_request_canceled');
        } catch (\Throwable $e) {
            $this->provideException($e);
        }
    }

    public function setChangeListenerRequestsStatus()
    {
        try {
            $onair = Onair::where('is_live', true)->firstOrFail();
            $onair->update([
                'listener_request_status' => !$onair->listener_request_status
            ]);

            if ($onair->listener_request_status) {
                return $this->provideSuccess('listener_request_open');
            } else {
                return $this->provideSuccess('listener_request_close');
            }
        } catch (\Throwable $e) {
            $this->provideException($e);
        }
    }


    public function setStartBroadcast(Request $request)
    {
        try {
            $request->validate([
                'show' => 'required',
                'phrase' => 'required',
                'image' => 'required',
            ], [
                'show.required' => "Escolha um programa para começar",
                'phrase.required' => "Qual é a frase para esse programa",
                'image.required' => "Escolha um icone",
            ]);

            $user = request()->user();
            $show = Show::where('id', $request->input('show'))->firstOrFail();

            if ($show->is_all) {
                if ($show->user_id !== $user->id) {
                    $show->update([
                        'user_id' => $user->id
                    ]);
                }
            }

            Onair::where('is_live', true)->update([
                'is_live' => false,
                'listener_request_status' => false,
            ]);

            $show->onair()->create([
                'phrase' => $request->input('phrase'),
                'image' => $request->input('image'),
                'listener_request_status' => true,
                'category' => 'live'
            ]);

            if(env('APP_ENV') === "production"){
                $webhook_discord = env('URL_DISCORD_WEBHOOK');
                $payload = [
                    'content' => "@everyone @here Oi meus amores! Só estou passando para avisar que" . ($user->gender === "male" ? " O DJ " : " A DJ ") . $user->nickname . " está no ar agora com o programa " . $show->name . "! Vem ouvir em https://akiba.com.br"          
                ];
                Http::post($webhook_discord, $payload);
            } 

            return $this->provideSuccess('start_broadcast');
        } catch (\Throwable $e) {
            $this->provideException($e);
        }
    }

    public function setFinishBroadcast()
    {
        try {
            $onair = Onair::where('is_live', true)->firstOrFail();
            $autodj = Autodj::where('is_default', true)->with('phrases')->firstOrFail();
            $requests = ListenerRequest::where('status', 'new')->where('onair_id', $onair->id)->exists();
            
            if($requests) throw new \Exception('Para encerrar o programa, todos os pedidos devem ser atendidos ou cancelados');
    
            $onair->update([
                'is_live' => false,
                'listener_request_status' => false
            ]);

            $phrase = $autodj->phrases->random();
            $autodj->onair()->create([
                'category' => 'auto',
                'phrase' => $phrase->phrase,
                'image' => $phrase->image,
            ]);

            return $this->provideSuccess('end_broadcast');
        } catch (\Throwable $e) {
            $this->provideException($e);
        }
    }

    public function render()
    {
        return Inertia::render('admin/Broadcast', [
            "shows" => $this->listShows(),
            "requests" => $this->listListenersRequests(),
            "verify" => $this->setCheckOnair(),
        ]);
    }
}
