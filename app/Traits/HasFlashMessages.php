<?php

namespace App\Traits;
use Inertia\Inertia;

trait HasFlashMessages
{
    public function flashMessage(string $action)
    {
        $messages = [
            'save' => [
                'icon' => '🥳',
                'message' => 'Salvo, querido! Que feito, hein?'
            ],
            'update' => [
                'icon' => '🫡',
                'message' => 'Atualizado! Ficou maravi..., impecável.'
            ],
            'delete' => [
                'icon' => '☠️',
                'message' => 'Apagado! Já tava fazendo hora extra'
            ],
            'deactivate' => [
                'icon' => '😴',
                'message' => 'Desativado! Bora dormir também.'
            ],
            'activate' => [
                'icon' => '🥱',
                'message' => 'Ativado! Saudades, confesso.'
            ],
            'complete' => [
                'icon' => '🎯',
                'message' => 'Completado! Finalmente, né.'
            ],
            'participate' => [
                'icon' => '🙋',
                'message' => 'Participando! Corajoso, você é!'
            ],
            'start' => [
                'icon' => '🚀',
                'message' => 'Iniciado! Se não explodir...'
            ],
            'finish' => [
                'icon' => '🎊',
                'message' => 'Finalizado! Nossa, que demora, hein?'
            ],
        ];

        $base = $messages[$action];
        $final = $base['message'];

        return redirect()->back()->withInput()->with('flash', [
            'icon' => $base['icon'],
            'message' => $final,
        ]);
    }
}
