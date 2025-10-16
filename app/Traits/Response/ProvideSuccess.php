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
                'message' => '💾 Salvo! Como se alguém fosse bagunçar agora…'
            ],
            'load' => [
                'type' => 'info',
                'message' => '📂 Carregado! Surpresa, tudo ainda está aqui.'
            ],
            'update' => [
                'type' => 'success',
                'message' => '⚡ Atualizado! Porque mudar as coisas de lugar sempre ajuda… certo?'
            ],
            'delete' => [
                'type' => 'warning',
                'message' => '🗑️ Apagado! Adeus, dados… ou será que voltam?'
            ],
            'error' => [
                'type' => 'error',
                'message' => '🙀 Erro! Como se isso fosse inesperado…'
            ],
            'exists' => [
                'type' => 'info',
                'message' => '👀 Já existe… alguém está tentando ser original?'
            ],
            'deactivate' => [
                'type' => 'info',
                'message' => '🌙 Desativado… mas vai que alguém realmente se importa.'
            ],
            'activate' => [
                'type' => 'success',
                'message' => '☀️ Ativado! Agora tudo está... ativo.'
            ],
            'listener_request_attended' => [
                'type' => 'success',
                'message' => '🎧 Pedido marcado como atendido! Uau, grande coisa.'
            ],
            'listener_request_canceled' => [
                'type' => 'info',
                'message' => '❌ Pedido cancelado! Porque desistir é sempre uma opção.'
            ],
            'listener_request_open' => [
                'type' => 'success',
                'message' => '📢 Pedidos abertos! Segura essa empolgação se você tiver…'
            ],
            'listener_request_close' => [
                'type' => 'info',
                'message' => '🔒 Pedidos fechados! Hora de fingir foco para acabar tudo…'
            ],
            'start_broadcast' => [
                'type' => 'success',
                'message' => '📡 Programa iniciado! Como se alguém estivesse esperando…'
            ],
            'end_broadcast' => [
                'type' => 'info',
                'message' => '📡 Programa encerrado! Que espetáculo, hein?'
            ],
        ];

        $default_message = [
            'type' => 'info',
            'message' => '✨ Oi! Tudo certo… ou pelo menos parece que está organizado 😂🎯'
        ];

        $baseData = $messages[$action] ?? $default_message;

        $finalMessage = $message ?? $baseData['message'];

        return back(303)->with('flash', [
            'type' => $baseData['type'],
            'message' => $finalMessage,
        ]);
    }
}
