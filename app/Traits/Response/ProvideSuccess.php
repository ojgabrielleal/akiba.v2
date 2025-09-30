<?php

namespace App\Traits\Response;

use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

trait ProvideSuccess
{
    public function provideSuccess(string $action, ?string $message = null): Response|RedirectResponse
    {
        $messages = [
            'save' => [
                'type' => 'success',
                'message' => 'Yatta! (≧◡≦) Consegui salvar tudinho direitinho pra você, senpai~ pode ficar tranquilo agora ✨'
            ],
            'load' => [
                'type' => 'info',
                'message' => 'Prontinho! (＾▽＾)/ Já carreguei tudo direitinho, espero que esteja do jeitinho que você queria ♪'
            ],
            'update' => [
                'type' => 'success',
                'message' => 'Hehe~ (๑˃ᴗ˂)ﻭ Atualizei rapidinho e deixei tudo novinho em folha! Ficou bem melhor agora, não acha?'
            ],
            'delete' => [
                'type' => 'warning',
                'message' => 'Shineee! (╯✧▽✧)╯✨ Deletei como você pediu, mas cuidado senpai… não vá se arrepender depois hein~'
            ],
            'error' => [
                'type' => 'error',
                'message' => 'Eeeh?! Σ(°△°|||) Alguma coisa deu errado… gomen nasai! Tenta de novo que eu prometo caprichar >_<'
            ],
        ];

        $default_message = [
            'type' => 'info',
            'message' => 'Funcionou direitinho! (＠＾◡＾) Eu sabia que ia dar certo, hehe~ sugoi, né?'
        ];

        $baseData = $messages[$action] ?? $default_message;

        // Se uma mensagem personalizada for passada, use-a. Caso contrário, use a mensagem padrão da ação.
        $finalMessage = $message ?? $baseData['message'];

        return back(303)->with('flash', [
            'type' => $baseData['type'],
            'message' => $finalMessage,
        ]);
    }
}
