<?php 

namespace App\Services\External;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StreamingService
{
    public function metadata()
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

            return $response->json();
        } catch (\Throwable $e) {
            Log::error('Radio API error: ' . $e->getMessage());
            return null;
        }
    }
}
