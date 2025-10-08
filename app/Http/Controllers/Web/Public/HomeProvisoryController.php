<?php

namespace App\Http\Controllers\Web\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Inertia\Inertia;

use App\Traits\Response\ProvideException;
use App\Traits\Response\ProvideSuccess;

use App\Models\Onair;
use App\Models\Music;
use App\Models\ListenerRequest;

class HomeProvisoryController extends Controller
{
    use ProvideException, ProvideSuccess;

    public function createListenerRequest(Request $request)
    {
        try {
            // Tratamento da música e artista
            $music_string = $request->input('music.name');
            $explode = explode(' by ', $music_string);
            $music_name = preg_replace('/\s*\(.*?\)\s*/', '', trim($explode[0], '"'));
            $artist_name = preg_replace('/\s*\(.*?\)\s*/', '', trim($explode[1], '"'));

            // Dados do listener
            $listener = $request->input('listener');
            $listener_ip = $request->ip();
            $address = $request->input('address');
            $message = $request->input('message');

            // Dados da música
            $production = $request->input('anime.title');
            $type = $request->input('music.type', 'anime');
            $image = $request->input('anime.image');

            // Atualiza total de pedidos no onair ativo
            $onair = Onair::where('is_live', true)->first();
            if ($onair) {
                $onair->update([
                    'listener_request_total' => $onair->listener_request_total + 1,
                ]);
            }

            // Verifica se a música já existe
            $musicObj = Music::where('music', $music_name)->first();

            if (!$musicObj) {
                $musicObj = Music::create([
                    'production' => $production,
                    'type' => $type,
                    'artist' => $artist_name,
                    'music' => $music_name,
                    'image' => $image,
                    'listener_request_total' => 1,
                ]);
            } else {
                $musicObj->update([
                    'listener_request_total' => $musicObj->listener_request_total + 1,
                ]);
            }

            // Cria o pedido do listener
            ListenerRequest::create([
                'onair_id' => $onair->id,
                'music_id' => $musicObj->id,
                'listener' => $listener,
                'address' => $address,
                'listener_ip' => $listener_ip,
                'message' => $message,
            ]);

            return $this->provideSuccess('save');
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function render()
    {
        return Inertia::render('public/HomeProvisory');
    }
}
