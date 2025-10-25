<?php

namespace App\Traits\Response;

trait ProvideSuccess
{
    public function provideSuccess(string $action)
    {
        $messages = [
            'save' => [
                'type' => 'success',
                'message' => '💾 Salvo! Olha só, até que deu certo sem drama dessa vez 😎'
            ],
            'load' => [
                'type' => 'info',
                'message' => '📂 Carregado! Que milagre nada explodiu no processo 🔧'
            ],
            'update' => [
                'type' => 'success',
                'message' => '⚡ Atualizado! Pequeno toque de perfeição… ou quase isso 😉'
            ],
            'delete' => [
                'type' => 'warning',
                'message' => '🗑️ Apagado! Às vezes começar do zero é melhor que quebrar a cabeça 🤷‍♂️'
            ],
            'error' => [
                'type' => 'error',
                'message' => '🙀 Erro! Parece que o universo quis apimentar seu dia 🔥'
            ],
            'exists' => [
                'type' => 'info',
                'message' => '👀 Isso já existe! Dois corpos não podem ocupar o mesmo lugar, reative na lixeira 😏'
            ],
            'deactivate' => [
                'type' => 'info',
                'message' => '🌙 Desativado! Foi dormir, mas promete voltar… ou não 😴'
            ],
            'activate' => [
                'type' => 'success',
                'message' => '☀️ Ativado! Preparado pra brilhar… e causar umas confusões ✨'
            ],
            'listener_request_attended' => [
                'type' => 'success',
                'message' => '🎧 Pedido atendido! Sem drama, o que já é um pequeno milagre moderno 😌'
            ],
            'listener_request_canceled' => [
                'type' => 'info',
                'message' => '❌ Pedido cancelado! Melhor isso do que fingir que ia dar certo, né? 😏'
            ],
            'listener_request_open' => [
                'type' => 'success',
                'message' => '📢 Pedidos abertos! Prepare-se para a avalanche… e tente não se perder 😅'
            ],
            'listener_request_close' => [
                'type' => 'info',
                'message' => '🔒 Pedidos fechados! Até o bom senso precisa tirar férias de vez em quando 😉'
            ],
            'start_broadcast' => [
                'type' => 'success',
                'message' => '📡 Programa iniciado! Vamos torcer para tudo sair do jeito certo… ou quase 😎'
            ],
            'end_broadcast' => [
                'type' => 'info',
                'message' => '📡 Programa encerrado! E a gente finge que tudo saiu do jeito certo 😏'
            ],
            'vote' => [
                'type' => 'success',
                'message' => '🗳️ Voto computado! Seu poder de decisão foi registrado… e ninguém explodiu, ufa 😎'
            ],
        ];

        $default_message = [
            'type' => 'info',
            'message' => '✨ Oi! Tudo certo… ou pelo menos fingimos muito bem que está organizado 😂🎯'
        ];

        $base = $messages[$action] ?? $default_message;
        $final = $base['message'];

        return back(303)->with('flash', [
            'type' => $base['type'],
            'message' => $final,
        ]);
    }
}
