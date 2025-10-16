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
    public function provideException(Throwable $e): Response|RedirectResponse|\Illuminate\Http\JsonResponse
    {
        // Log detalhado
        Log::error('[LaravelException] ' . get_class($e) . ': ' . $e->getMessage(), [
            'exception' => $e,
            'trace' => $e->getTraceAsString(),
        ]);

        // Mensagens resumidas com anime
        $messages = [
            ModelNotFoundException::class => [
                '👀 Nada aqui… estilo dungeon de *Konosuba*.',
                'Hmm… não achei nada, tipo biblioteca de *K-On!* 📚🎶'
            ],
            QueryException::class => [
                '⚡ Ops… problema resolvemos depois, estilo reset do Subaru em *Re:Zero* 🌀',
                'Algo deu errado… calma, tipo Yuno em *Mirai Nikki* 😏📓'
            ],
            AuthenticationException::class => [
                '🔒 Precisa entrar primeiro, como esconderijo da guilda em *Konosuba*.',
                'Faça login antes, tipo clubinho em *K-On!* 🎸💕'
            ],
            AuthorizationException::class => [
                'Hmm… você não pode acessar, tipo área proibida em *Demon Slayer* 🗡️',
                'Área restrita… deixa comigo! 😎'
            ],
            NotFoundHttpException::class => [
                '🚪 Página sumiu… segredinho estilo *Mirai Nikki*.',
                'Nada aqui… stealth missão em *Konosuba* 🥷'
            ],
            MethodNotAllowedHttpException::class => [
                'Não dá pra fazer assim… combo secreto de *Demon Slayer* 🔥🦋',
                'Ação inválida… tipo plano da Yuno 😏📓'
            ],
            HttpException::class => [
                '🌐 Problema na rede… espera um pouco, loop do Subaru em *Re:Zero* 🌀',
                'Algo estranho… resolvemos juntos, aula de música em *K-On!* 🎶'
            ],
            ThrottleRequestsException::class => [
                '🐢 Devagar… cooldown da Megumin ⚡',
                'Muito rápido! Espera um pouco, guilda descansando 😌'
            ],
            FileNotFoundException::class => [
                'Hmm… não achei, tipo tesouro em *Konosuba* 🥷',
                'Sumiu… vamos procurar depois, diário da Yuno 😏📓'
            ],
            BindingResolutionException::class => [
                'Perdeu nos bastidores… resolvemos juntos, guilda 😎',
                'Não achei… só a gente, banda em *K-On!* 🎸'
            ],
            RuntimeException::class => [
                '💥 Bug… consertamos em segredo, reset do Subaru em *Re:Zero* 🌀',
            ],
            LogicException::class => [
                'Algo estranho… cuidamos disso, missão guilda em *Konosuba* 😏',
            ],
        ];

        // Mensagem padrão
        $defaultMessage = app()->environment('production')
            ? '💥 Erro estranho… tenta de novo depois, loop do Subaru em *Re:Zero* 🌀😉'
            : $e->getMessage();

        $exceptionClass = get_class($e);

        // Escolhe mensagem randômica ou padrão
        if (!empty($messages[$exceptionClass])) {
            $message = $messages[$exceptionClass][array_rand($messages[$exceptionClass])];
        } else {
            $message = $defaultMessage;
        }

        // Define status HTTP
        $status = match (true) {
            $e instanceof ModelNotFoundException => 404,
            $e instanceof ValidationException => 422,
            $e instanceof AuthenticationException => 401,
            $e instanceof AuthorizationException => 403,
            $e instanceof NotFoundHttpException => 404,
            $e instanceof MethodNotAllowedHttpException => 405,
            $e instanceof ThrottleRequestsException => 429,
            $e instanceof RuntimeException, $e instanceof LogicException => 500,
            default => 500,
        };

        // Tratamento especial para ValidationException
        if ($e instanceof ValidationException) {
            $errors = collect($e->errors())->flatMap(function ($messages, $field) {
                return array_map(function ($msg) use ($field) {
                    return "O campo&nbsp;<strong class='font-bold uppercase italic'>{$msg}</strong>&nbsp;é obrigatório, ok? 😉";
                }, $messages);
            })->toArray();
        } else {
            $errors = $message;
        }

        if (request()->wantsJson()) {
            return response()->json([
                'type' => 'warning',
                'message' => $errors
            ], $status);
        }

        // Para web tradicional
        return back(303)->with('flash', [
            'type' => 'warning',
            'message' => $errors,
        ]);
    }
}
