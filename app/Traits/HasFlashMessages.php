<?php

namespace App\Traits;

trait HasFlashMessages
{
    public function flashMessage(string $action)
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
            'deactivate' => [
                'type' => 'info',
                'message' => '🌙 Desativado! Foi dormir, mas promete voltar… ou não 😴'
            ],
            'activate' => [
                'type' => 'success',
                'message' => '☀️ Ativado! Preparado pra brilhar… e causar umas confusões ✨'
            ],
            'songRequestPlayed' => [
                'type' => 'success',
                'message' => '🎧 Pedido atendido! Sem drama, o que já é um pequeno milagre moderno 😌'
            ],
            'listener_request_canceled' => [
                'type' => 'info',
                'message' => '❌ Pedido cancelado! Melhor isso do que fingir que ia dar certo, né? 😏'
            ],
            'songRequestOpen' => [
                'type' => 'success',
                'message' => '📢 Pedidos abertos! Prepare-se para a avalanche… e tente não se perder 😅'
            ],
            'songRequestClose' => [
                'type' => 'info',
                'message' => '🔒 Pedidos fechados! Até o bom senso precisa tirar férias de vez em quando 😉'
            ],
            'startBroadcast' => [
                'type' => 'success',
                'message' => '📡 Programa iniciado! Vamos torcer para tudo sair do jeito certo… ou quase 😎'
            ],
            'finishBroadcast' => [
                'type' => 'info',
                'message' => '📡 Programa encerrado! E a gente finge que tudo saiu do jeito certo 😏'
            ],
            'vote' => [
                'type' => 'success',
                'message' => '🗳️ Voto computado! Seu poder de decisão foi registrado… e ninguém explodiu, ufa 😎'
            ],
            'confirmActivity' => [
                'type' => 'success',
                'message' => 'Presença marcada! Não se esquece, tá? 😬 Tá tudo registrado… até sua alma! 😇📌'
            ],
            'taskCompleted' => [
                'type' => 'success',
                'message' => 'Tarefa feita! ✅ Vou avisar a chefia… mesmo que estejam no mundo dos sonhos 🌙😎'
            ]
        ];

        $default_message = [
            'type' => 'info',
            'message' => '✨ Oi! Tudo certo… ou pelo menos fingimos muito bem que está organizado 😂🎯'
        ];

        $base = $messages[$action] ?? $default_message;
        $final = $base['message'];

        return redirect()->back()->withInput()->with('flash', [
            'type' => $base['type'],
            'message' => $final,
        ]);
    }
}
