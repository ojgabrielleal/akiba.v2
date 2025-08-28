<?php

namespace App\Traits\Response;

use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

trait ProvideSuccess
{
    public function provideSuccess(string $action): Response|RedirectResponse
    {
        $messages = [
            'save'=> ['type' => 'success', 'message' => 'Conteúdo salvo! (≧◡≦)/'],
            'load'=> ['type' => 'info', 'message' => 'Carregado, senpai~ (＾▽＾)'],
            'update' => ['type' => 'success', 'message' => 'Opa conteúdo novo~ (๑˃ᴗ˂)'],
            'delete' => ['type' => 'warning', 'message' => 'Shineeee~! Deletado! (╯✧▽✧)╯'],
        ];

        $default_message = ['type' => 'info', 'message' => 'Funcionou! Sugoi~ (＠＾◡＾)'];
        $data = $messages[$action] ?? $default_message;
        return back(303)->with('flash', [
            'type' => $data['type'],
            'message' => $data['message'],
        ]);
    }
}
