<?php 

namespace App\Services\External;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StreamingService
{
    public function data()
    {
        try {
            $url = config('services.radio.metadata');
            $response = Http::timeout(5)->withOptions([
                'verify' => false,
            ])->get($url);
            
            if ($response->failed()) {
                Log::warning('Radio API returned error status');
                return null;
            }

            $data = $response->json();

            return [
                'status' => $data['status'] === 'Ligado' ? 'Online' : 'Offline',
                'listeners' => $data['ouvintes_conectados'],
                'bitrate' => $data['plano_bitrate']
            ];
        } catch (\Throwable $e) {
            Log::error('Radio API error: ' . $e->getMessage());
            return null;
        }
    }
}
