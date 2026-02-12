<?php

namespace App\Traits;

trait HasFlashMessages
{
    public function flashMessage(string $action)
    {
        $messages = [
            'save' => [
                'icon' => '🥳',
                'message' => 'Salvo! Tá guardado com carinho.'
            ],
            'update' => [
                'icon' => '🫡',
                'message' => 'Atualizado! De cara nova.'
            ],
            'delete' => [
                'icon' => '☠️',
                'message' => 'Apagado! Nunca mais veremos.'
            ],
            'deactivate' => [
                'icon' => '😴',
                'message' => 'Desativado! Foi tirar um cochilo.'
            ],
            'activate' => [
                'icon' => '🥱',
                'message' => 'Ativado! A lenda está de volta.'
            ],
        ];

        $default_message = [
            'icon' => '🔔',
            'message' => 'Alguma coisa aconteceu!'
        ];

        $base = $messages[$action] ?? $default_message;
        $final = $base['message'];

        return redirect()->back()->withInput()->with('flash', [
            'type' => $base['type'],
            'message' => $final,
        ]);
    }
}
