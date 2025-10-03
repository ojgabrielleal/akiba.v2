<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Inertia\Inertia;

use App\Traits\Response\ProvideException;
use App\Traits\Response\ProvideSuccess;

use App\Models\Show;
use App\Models\Autodj;
use App\Models\Onair;
use App\Models\ListenerRequest;

class BroadcastController extends Controller
{
    use ProvideSuccess, ProvideException;

    public function setVerifyOnair()
    {
        try {
            $user = request()->user();
            $onair = Onair::where('is_live', true)->first();

            $response = [
                'onair' => false,
                'streamer'  => null,
                'listener_request' => null,
            ];

            if ($onair) {
                $show = Show::where('id', $onair->program_id)->first();

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
                $q->where('user_id', $user->id)
                    ->orWhere('is_all', true);
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
            $onair = Onair::where('is_live', true)->first();

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

    public function setToMeetListenerRequest($id)
    {
        try {
            $request = ListenerRequest::where('id', $id)->first();
            $request->update([
                'status' => 'finished'
            ]);

            return back(303);
        } catch (\Throwable $e) {
            $this->provideException($e);
        }
    }

    public function setListenerRequestsStatus()
    {
        try {
            $onair = Onair::where('is_live', true)->first();

            if ($onair) {
                $onair->update([
                    'listener_request_status' => !$onair->listener_request_status
                ]);
            }

            if ($onair->listener_request_status) {
                $this->ProvideSuccess('save', 'Opa, meu bem... já estou avisando que seus pedidos estão chegando! Se prepara!');
            } else {
                $this->ProvideSuccess('save', 'Sério!!!! Aconteceu algo? As pessoas querem fazer pedidos... Ou será que o programa tá acabando? #refletindo');
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
                'phrase.required' => "<b><i>Qual é a frase para esse programa</b></i> é obrigatório",
                'image.required' => "<b><i>Escolha um icone</b></i> é obrigatório",
            ]);

            $user = request()->user();
            $show = Show::where('id', $request->input('show'))->first();

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

            $this->ProvideSuccess('save', 'Ei! Seu programa começou e os ouvintes querem ouvir sua voz! Se solta faz seu show!');
        } catch (\Throwable $e) {
            $this->provideException($e);
        }
    }

    public function setEndBroadcast()
    {
        try {
            $autodj = Autodj::where('is_default', true)->with('phrases')->first();

            Onair::where('is_live', true)->update([
                'is_live' => false,
                'listener_request_status' => false
            ]);

            ListenerRequest::truncate();

            $randomPhrase = $autodj->phrases->random();

            $autodj->onair()->create([
                'category' => 'autodj',
                'phrase' => $randomPhrase->phrase,
                'image' => $randomPhrase->image,
            ]);

            $this->ProvideSuccess('save', 'Um ótimo programa como sempre! Me deixou ansiosa para a próxima vez!');
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
