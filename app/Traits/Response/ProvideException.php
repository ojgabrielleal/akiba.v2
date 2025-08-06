<?php

namespace App\Traits\Response;

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
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use RuntimeException;
use LogicException;

trait ProvideException
{
    public function provideException(Throwable $e): Response|RedirectResponse
    {
        Log::error('[LaravelException] ' . get_class($e) . ': ' . $e->getMessage(), [
            'exception' => $e,
            'trace' => $e->getTraceAsString(),
        ]);

        $message = match (true) {
            $e instanceof ModelNotFoundException => 'Nani?! Nada por aqui~ (＠_＠;)',
            $e instanceof ValidationException => 'Campos errados, senpai! (＞︿＜)',
            $e instanceof QueryException => 'Uwaa~ deu bug nos bastidores! (×_×;)',
            $e instanceof AuthenticationException => 'Faz login primeiro, onegai~ ( •̀ ω •́ )✧',
            $e instanceof AuthorizationException => 'Yamete! Acesso negado~ (￣ヘ￣;)',
            $e instanceof NotFoundHttpException => 'Eeeh? Página sumiu! (；・∀・)',
            $e instanceof MethodNotAllowedHttpException => 'Técnica errada, senpai~ (╬ Ò﹏Ó)',
            $e instanceof HttpException => 'Rede bugou... tenta dps~ (´･ω･`)',
            $e instanceof ThrottleRequestsException => 'Calma aí! Rápido demais~ (≧д≦ヾ)',
            $e instanceof FileNotFoundException => 'Item não achado... (´・д・`)',
            $e instanceof BindingResolutionException => 'Poketto no sistema... (≡^∇^≡)',
            $e instanceof RuntimeException,  $e instanceof LogicException => 'Yabai! Bugou tudo~ (╯°□°）╯︵ ┻━┻',
            default => app()->environment('production') ? 'Erro estranho... tenta dps~ (＞人＜;)' : $e->getMessage(),
        };

        return back(303)->with('flash', [
            'type' => 'error',
            'message' => $message,
        ]);
    }
}
