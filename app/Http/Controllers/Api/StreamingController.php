<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StreamingController extends Controller
{
    public function index(Request $request)
    {
        $url = 'http://cast.radioamc.com.br/api-json/Vkc1d2FrMHdNVUpRVkRBOStS';

        $response = file_get_contents($url); // simples e direto

        if (!$response) {
            return response()->json(['error' => 'Sem resposta da API'], 500);
        }

        return response($response, 200)
            ->header('Content-Type', 'application/json');
    }
}