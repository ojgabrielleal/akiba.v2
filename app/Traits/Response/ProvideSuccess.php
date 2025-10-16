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
                'message' => '💾 Salvo! Tá seguro como os planos da Yuno em *Mirai Nikki* 😏📓'
            ],
            'load' => [
                'type' => 'info',
                'message' => '📂 Carregado! Rápido como Subaru em *Re:Zero* 💨❄️'
            ],
            'update' => [
                'type' => 'success',
                'message' => '⚡ Atualizado! Mais organizado que a guilda em *Konosuba* 😂🎯'
            ],
            'delete' => [
                'type' => 'warning',
                'message' => '🗑️ Apagado! Cuidado, tipo Tanjiro esquecendo a espada em *Demon Slayer* 😅🗡️'
            ],
            'error' => [
                'type' => 'error',
                'message' => '🙀 Erro! Antes que a Akiyama do *K-On!* reclame 🎸🎶'
            ],
            'exists' => [
                'type' => 'info',
                'message' => '👀 Já existe, reative na lixeira! Tá só deitadinho como Kazuma de *Konosuba* 😂💤'
            ],
            'deactivate' => [
                'type' => 'info',
                'message' => '🌙 Desativado… reative depois como Nezuko em *Demon Slayer* 🔥🦋'
            ],
            'activate' => [
                'type' => 'success',
                'message' => '☀️ Ativado! Brilha como a magia da Megumin em *Konosuba* 💥✨'
            ],
            'listener_request_open' => [
                'type' => 'success',
                'message' => '📢 Pedido aberto! Esperando fãs como no show da Ho Kago Tea Time em *K-On!* 🌀👊'
            ],
            'listener_request_close' => [
                'type' => 'info',
                'message' => '🔒 Pedido fechado! Hora de focar, como Subaru em *Re:Zero* 🛡️❄️'
            ],
            'start_broadcast' => [
                'type' => 'success',
                'message' => '📡 Programa iniciado! Brilha como Kirito em *SAO* 🌟⚔️'
            ],
            'end_broadcast' => [
                'type' => 'info',
                'message' => '📡 Programa encerrado! Final como *AoT*, sem palavras 🌟⚔️'
            ],
            'end_broadcast_listener_request' => [
                'type' => 'warning',
                'message' => '⛔ Lembre-se de atender ou cancelar pedidos, ou Yuno vem pegar você! 🎧💬'
            ],
        ];

        $default_message = [
            'type' => 'info',
            'message' => '✨ Oi! Tudo certo, mais organizado que a guilda de *Konosuba* 😂🎯'
        ];

        $baseData = $messages[$action] ?? $default_message;

        $finalMessage = $message ?? $baseData['message'];

        return back(303)->with('flash', [
            'type' => $baseData['type'],
            'message' => $finalMessage,
        ]);
    }
}
