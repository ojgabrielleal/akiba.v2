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
                'message' => 'Oi… acabei de salvar tudo pra você. Tá tudo certinho agora, só entre nós'
            ],
            'load' => [
                'type' => 'info',
                'message' => 'Tudo carregado direitinho… espero que esteja exatamente do jeitinho que você queria, só a gente sabe disso.'
            ],
            'update' => [
                'type' => 'success',
                'message' => 'Oi de novo… atualizei tudo rapidinho, agora está funcionando bem, fica tranquilo'
            ],
            'delete' => [
                'type' => 'warning',
                'message' => 'Ei… apaguei como você pediu. Espero que não tenha sido por engano...'
            ],
            'error' => [
                'type' => 'error',
                'message' => 'Oi… deu um probleminha. Tenta de novo, a gente resolve juntos, tá?'
            ],
        ];

        $default_message = [
            'type' => 'info',
            'message' => 'Oi! Tudo certo, funcionou direitinho'
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
