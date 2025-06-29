<?php

namespace App\Traits;

use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Container\BindingResolutionException;
use RuntimeException;
use LogicException;

trait HandlesLaravelExceptions
{
    public function handleLaravelException(Throwable $e): string
    {
        Log::error('[LaravelException] '.get_class($e).': '.$e->getMessage(), [
            'exception' => $e,
            'trace' => $e->getTraceAsString(),
        ]);

        if ($e instanceof ModelNotFoundException) {
            return 'Nani?! Nada por aqui~ (＠_＠;)';
        }

        if ($e instanceof ValidationException) {
            return 'Campos errados, senpai! (＞︿＜)';
        }

        if ($e instanceof QueryException) {
            return 'Uwaa~ deu bug nos bastidores! (×_×;)';
        }

        if ($e instanceof AuthenticationException) {
            return 'Faz login primeiro, onegai~ ( •̀ ω •́ )✧';
        }

        if ($e instanceof AuthorizationException) {
            return 'Yamete! Acesso negado~ (￣ヘ￣;)';
        }

        if ($e instanceof NotFoundHttpException) {
            return 'Eeeh? Página sumiu! (；・∀・)';
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            return 'Técnica errada, senpai~ (╬ Ò﹏Ó)';
        }

        if ($e instanceof HttpException) {
            return 'Rede bugou... tenta dps~ (´･ω･`)';
        }

        if ($e instanceof ThrottleRequestsException) {
            return 'Calma aí! Rápido demais~ (≧д≦ヾ)';
        }

        if ($e instanceof FileNotFoundException) {
            return 'Item não achado... (´・д・`)';
        }

        if ($e instanceof BindingResolutionException) {
            return 'Poketto no sistema... (≡^∇^≡)';
        }

        if ($e instanceof RuntimeException || $e instanceof LogicException) {
            return 'Yabai! Bugou tudo~ (╯°□°）╯︵ ┻━┻';
        }

        // Fallback genérico
        return app()->environment('production')
            ? 'Erro estranho... tenta dps~ (＞人＜;)'
            : $e->getMessage();
        }

}
