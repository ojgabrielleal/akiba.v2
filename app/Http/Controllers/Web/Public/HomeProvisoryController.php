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
use App\Services\RadioAPIService;

class HomeProvisoryController extends Controller
{
    use ProvideException;

    protected $radio;

    public function __construct(RadioAPIService $radio)
    {
        $this->radio = $radio;
    }

    public function createListenerRequest(Request $request)
    {
        try {
            $selected_musics = $request->input('music');
            if (empty($selected_musics)) {
                throw new \InvalidArgumentException('Nenhuma música foi selecionada.');
            }

            // Tratamento do nome da música
            $selected_music = $selected_musics[0];
            $music_string = $selected_music['name'];
            $music_string = preg_replace('/^\d+\s*:\s*/', '', $music_string);

            // Extrai o nome do artista da música
            $explode = explode(' by ', $music_string);
            $music_name = preg_replace('/\s*\(.*?\)\s*/', '', trim($explode[0], '"'));
            $artist_name = '';

            if (isset($explode[1])) {
                $artist_name = preg_replace('/\s*\(.*?\)\s*/', '', trim($explode[1], '"'));
            }

            // Dados do listener
            $listener = $request->input('listener');
            $listener_ip = $request->ip();
            $address = $request->input('address');
            $message = $request->input('message');

            // Dados da música
            $production = preg_replace('/\s*\(.*?\)\s*/', '', trim($request->input('anime.title')));
            $type = $selected_music['type'] ?? 'anime';
            $image = $request->input('anime.image');

            // Atualiza total de pedidos no onair ativo
            $onair = Onair::where('is_live', true)->first();
            if ($onair) {
                $onair->update([
                    'song_request_count' => $onair->song_request_count + 1,
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
                    'song_request_count' => 1,
                ]);
            } else {
                $musicObj->update([
                    'song_request_count' => $musicObj->song_request_count + 1,
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

            return back(303);
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function getOnair()
    {
        try{
            $radio = $this->radio->getMetadata();
            $musica = $radio['musica_atual'] ?? null;
            $capa = $radio['capa_musica'] ?? null;

            $onair = Onair::with('program.user')->where('is_live', true)->firstOrFail();
            $onair->musica = [
                'musica_atual' => $musica,
                'capa_musica' => $capa
            ];

            return $onair;
        }  catch (\Throwable $e) {
            return null;
        }
    }

    public function render()
    {
        return Inertia::render('public/HomeProvisory', [
            'onair' => $this->getOnair()
        ]);
    }
}
