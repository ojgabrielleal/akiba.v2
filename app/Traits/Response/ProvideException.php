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

        // Mensagens randômicas por tipo de exceção
        $messages = [
            ModelNotFoundException::class => [
                '👀 Nada aqui… ou será que está escondido de propósito?',
                'Hmm… não achei nada, você realmente procurou direito? 📚'
            ],
            QueryException::class => [
                '⚡ Ops… algo deu errado, mas quem se importa, né?',
                'Algo falhou… calma, ninguém ia notar mesmo 😏'
            ],
            AuthenticationException::class => [
                '🔒 Precisa entrar primeiro… mas é só um detalhe, né?',
                'Faça login antes… como se isso fosse realmente importante 🎸'
            ],
            AuthorizationException::class => [
                'Hmm… você não pode acessar isso… surpresa!',
                'Área restrita… mas você tentou, né? 😎'
            ],
            NotFoundHttpException::class => [
                '🚪 Página sumiu… ou talvez nunca existiu.',
                'Nada aqui… tenta de novo, quem sabe aparece 🥷'
            ],
            MethodNotAllowedHttpException::class => [
                'Não dá pra fazer assim… mas continue tentando 🔥',
                'Ação inválida… não era mesmo pra funcionar 😏'
            ],
            HttpException::class => [
                '🌐 Problema na rede… mas relaxa, ninguém percebeu 🌀',
                'Algo estranho… vamos fingir que não aconteceu 🎶'
            ],
            ThrottleRequestsException::class => [
                '🐢 Devagar… todo mundo precisa de um descanso ⚡',
                'Muito rápido! Espera um pouco, ninguém está correndo 😌'
            ],
            FileNotFoundException::class => [
                'Hmm… não achei, talvez esteja brincando de esconde-esconde 🥷',
                'Sumiu… olha de novo, deve estar por aí 😏'
            ],
            BindingResolutionException::class => [
                'Perdeu nos bastidores… mas a vida continua 😎',
                'Não achei… quem se importa mesmo 🎸'
            ],
            RuntimeException::class => [
                '💥 Bug… mas ninguém vai notar, relaxa 🌀',
            ],
            LogicException::class => [
                'Algo estranho… mas vamos fingir que está tudo normal 😏',
            ],
        ];

        $exceptionClass = get_class($e);

        // Prioriza mensagem personalizada, depois anime message, depois padrão
        $message = $e->getMessage(); // Mensagem personalizada
        if (empty($message)) {
            if (!empty($messages[$exceptionClass])) {
                $message = $messages[$exceptionClass][array_rand($messages[$exceptionClass])];
            } else {
                $message = app()->environment('production')
                    ? '💥 Erro estranho… tenta de novo depois… ou não, vai que dá certo sozinho 😉'
                    : 'Erro desconhecido: ' . $exceptionClass;
            }
        }

        // Status HTTP
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

        // Tratamento especial ValidationException
        if ($e instanceof ValidationException) {
            $errors = collect($e->errors())->flatMap(function ($messages, $field) {
                return array_map(function ($msg) use ($field) {
                    $fieldName = ucfirst(str_replace('_', ' ', $field));
                    return "O campo&nbsp;<strong class='font-bold uppercase italic'>{$msg}</strong>&nbsp;é obrigatório 😉";
                }, $messages);
            })->toArray();
        } else {
            $errors = $message;
        }

        // Resposta JSON
        if (request()->wantsJson()) {
            return response()->json([
                'type' => 'warning',
                'message' => $errors
            ], $status);
        }

        // Web tradicional
        return back(303)->with('flash', [
            'type' => 'warning',
            'message' => $errors,
        ]);
    }
}
