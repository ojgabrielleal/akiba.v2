<?php

namespace App\Traits;

trait HandleLaravelSuccess
{
    public function HandleLaravelSuccess(string $action): string
    {
        return match ($action) {
            'save' => 'Yatta~! Salvo! (≧◡≦)/',
            'read'   => 'Carregado, senpai~ (＾▽＾)',
            'update' => 'Editado com carinho~ (๑˃ᴗ˂)',
            'delete' => 'Shineeee~! Deletado! (╯✧▽✧)╯',
            default => 'Funcionou! Sugoi~ (＠＾◡＾)',
        };
    }
}