<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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

    public function setVerifyOnair()
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

    public function getShows()
    {
        try {
            $user = request()->user();

            $query = Show::orderBy('created_at', 'desc');
            $query->with('user');
            $query->where('is_active', true);
            $query->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)->orWhere('is_all', true);
            });
            $shows = $query->get();

            return $shows;
        } catch (\Throwable $e) {
            $this->provideException($e);
        }
    }

    public function getListenerRequests()
    {
        try {
            $onair = Onair::where('is_live', true)->firstOrFail();

            if ($onair) {
                $query = ListenerRequest::orderBy('created_at', 'desc');
                $query->with(['onair', 'music']);
                $query->where('onair_id', $onair->id);
                $requests = $query->get();

                return $requests;
            }
        } catch (\Throwable $e) {
            $this->provideException($e);
        }
    }

    public function setToAttendedListenerRequest($id)
    {
        try {
            $request = ListenerRequest::where('id', $id)->first();

            $listenerRequestUpdate = $request->update([
                'status' => 'attended'
            ]);
            if($listenerRequestUpdate === 0) throw new \Exception('Não foi possível marcar o pedido como atendido');

            return $this->provideSuccess('listener_request_attended');
        } catch (\Throwable $e) {
            $this->provideException($e);
        }
    }

    public function setListenerRequestsStatus()
    {
        try {
            $onair = Onair::where('is_live', true)->firstOrFail();

            if ($onair) {
                $onairUpdate = $onair->update([
                    'listener_request_status' => !$onair->listener_request_status
                ]);
                if ($onairUpdate === 0) throw new \Exception('Não foi possível atualizar o status da caixa de pedidos');

                if ($onair->listener_request_status) {
                    return $this->provideSuccess('listener_request_open');
                } else {
                    return $this->provideSuccess('listener_request_close');
                }
            }else{
                throw new \Exception('Nenhum programa no ar para atualizar o status da caixa de pedidos');
            }
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

            $listenerUpdate = $listener->update([
                'status' => 'canceled'
            ]);
            if($listenerUpdate === 0) throw new \Exception('Não foi possível cancelar o pedido');
            
            $musicUpdate = $music->update([
                'listener_request_total' => $music->listener_request_total - 1
            ]);
            if($musicUpdate === 0) throw new \Exception('Não foi possível remover uma visualização da música pedida');

            $onairUpdate = $onair->update([
                'listener_request_total' => $onair->listener_request_total - 1
            ]);
            if($onairUpdate === 0) throw new \Exception('Não foi possível remover uma solicitação de pedido do contador geral do programa');

            return $this->provideSuccess('listener_request_canceled');
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
                    $showUpdate = $show->update([
                        'user_id' => $user->id
                    ]);
                    if ($showUpdate === 0) throw new \Exception('Não foi possível atualizar o dono do programa disponível para todos');
                }
            }

            $onairUpdate = Onair::where('is_live', true)->update([
                'is_live' => false,
                'listener_request_status' => false,
            ]);
            if($onairUpdate === 0) throw new \Exception('Não foi possível verificar se já existe um programa no ar e finalizar ele');

            $onairCreate = $show->onair()->create([
                'phrase' => $request->input('phrase'),
                'image' => $request->input('image'),
                'listener_request_status' => true,
                'category' => 'live'
            ]);
            if(!$onairCreate->wasRecentlyCreated) throw new \Exception('Não foi possível iniciar o programa');

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

    public function setEndBroadcast()
    {
        try {
            $onair = Onair::where('is_live', true)->firstOrFail();
            $autodj = Autodj::where('is_default', true)->with('phrases')->firstOrFail();
            $requests = ListenerRequest::where('status', 'new')->where('onair_id', $onair->id)->exists();
            
            if($requests) throw new \Exception('Para encerrar o programa, todos os pedidos devem ser atendidos ou cancelados');
            
            $onairUpdate = $onair->update([
                'is_live' => false,
                'listener_request_status' => false
            ]);
            if($onairUpdate === 0) throw new \Exception('Não foi possível encerrar o programa');

            $phrase = $autodj->phrases->random();
            $autoDJCreate = $autodj->onair()->create([
                'category' => 'auto',
                'phrase' => $phrase->phrase,
                'image' => $phrase->image,
            ]);
            if(!$autoDJCreate->wasRecentlyCreated) throw new \Exception('Não foi possível iniciar o AutoDJ');

            return $this->provideSuccess('end_broadcast');
        } catch (\Throwable $e) {
            $this->provideException($e);
        }
    }

    public function render()
    {
        return Inertia::render('admin/Broadcast', [
            "verify" => $this->setVerifyOnair(),
            "shows" => $this->getShows(),
            "requests" => $this->getListenerRequests(),
        ]);
    }
}
