<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Onair;

class CastController extends Controller
{
    public function metadata()
    {
        try {
            $onair = Onair::with('program.user')->where('is_live', true)->first();
            
            if (!$onair) {
                return response()->json(['error' => 'No active onair'], 404);
            }

            $url = env('URL_STREAM_METADATA');
            $streamResponse = @file_get_contents($url);
            
            if (!$streamResponse) {
                Log::warning("No response from streaming audio API");
                $streamData = null;
            } else {
                $streamData = json_decode($streamResponse, true);
            }

            return response()->json([
                'onair' => [
                    'program' => [
                        'name' => $onair->program->name,
                        'image' => $onair->program->image,
                    ],
                    'user' => [
                        'nickname' => $onair->program->user->nickname,
                        'gender' => $onair->program->user->gender,
                        'avatar' => $onair->program->user->avatar,
                    ],
                    'listener_request_status' => $onair->listener_request_status,
                    'category' => $onair->category,
                    'phrase' => $onair->phrase,
                    'image' => $onair->image,
                ],
                'stream' => $streamData
            ]);
        } catch (\Throwable $e) {
            Log::error($e);
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function stream()
    {
        return redirect(env('URL_STREAM'));
    }
}
