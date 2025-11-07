<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RadioController extends Controller
{
    public function stream()
    {
        $streamUrl = env('RADIO_URL_STREAM');
        
        if (!$streamUrl) {
            Log::error("RADIO_URL_STREAM not configured.");
            return response()->json(['error' => 'Stream URL not configured.'], 500);
        }

        return redirect()->away($streamUrl);
    }
}
