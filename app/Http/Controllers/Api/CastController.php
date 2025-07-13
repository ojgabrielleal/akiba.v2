<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CastController extends Controller
{
    public function data(Request $request)
    {
        $url = 'http://cast.radioamc.com.br/api-json/Vkc1d2FrMHdNVUpRVkRBOStS';

        $response = file_get_contents($url); // simples e direto

        if (!$response) {
            return response()->json(['error' => 'No response from streaming audio api'], 500);
        }

        return response($response, 200)
            ->header('Content-Type', 'application/json');
    }
}