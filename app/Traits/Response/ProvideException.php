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

        // Mensagens randômicas por exceção
        $messages = [
            ModelNotFoundException::class => [
                'Parece que não tem nada por aqui… só entre quando quiser procurar comigo.',
                'Hmm… não achei nada. Esse cantinho é só nosso, volta depois sem ninguém por perto.'
            ],
            QueryException::class => [
                'Ops… algo não deu certo, mas é melhor a gente ver isso a sós.',
                'Deu um probleminha, mas não se preocupe… deixa quietinho até podermos conferir juntos.'
            ],
            AuthenticationException::class => [
                'Ei, você precisa entrar primeiro… é segredo nosso, hein.',
                'Antes de continuar, faça login. Só assim a gente pode continuar juntos.'
            ],
            AuthorizationException::class => [
                'Hmm… você não pode acessar isso. Melhor deixar pra lá.',
                'Essa área não é pra todo mundo… me deixa!.'
            ],
            NotFoundHttpException::class => [
                'Essa página sumiu… só volte quando ninguém estiver olhando.',
                'Nada encontrado aqui… é melhor vir sozinho da próxima vez.'
            ],
            MethodNotAllowedHttpException::class => [
                'Não dá pra fazer desse jeito… vamos tentar quando estiver só nós dois.',
                'Essa ação não funciona assim… deixa pra tentar depois em segredo.'
            ],
            HttpException::class => [
                'A rede deu um problema… é melhor esperar um pouco antes de tentar de novo.',
                'Algo estranho aconteceu… vamos resolver só nós dois, sem pressa.'
            ],
            ThrottleRequestsException::class => [
                'Devagar… você está indo rápido demais. Melhor esperar um pouco.',
                'Muito rápido! Espera um pouco e depois continuamos juntas.'
            ],
            FileNotFoundException::class => [
                'Hmm… não achei o que você procura. Só volte quando estiver sozinho.',
                'Algo sumiu… vamos procurar juntis quando ninguém estiver por perto.'
            ],
            BindingResolutionException::class => [
                'Algo se perdeu nos bastidores… melhor ver isso a sós.',
                'Não consegui encontrar isso… só a gente vai resolver, ok?'
            ],
            RuntimeException::class => [
                'Deu um bug… vamos consertar sem ninguém por perto.',
            ],
            LogicException::class => [
                'Algo estranho aconteceu… deixa só a gente cuidar disso por enquanto.',
            ],
        ];


        // Mensagem padrão
        $defaultMessage = app()->environment('production')
            ? 'Parece que deu um erro estranho… tenta de novo depois, só nós dois saberemos disso. Não desanima, tá?'
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

        // Mensagem padrão para todas as exceções
        $errors = $message;

        // Tratamento especial para ValidationException
        if ($e instanceof ValidationException) {
            $errors = collect($e->errors())->flatMap(function ($messages, $field) {
                return array_map(function ($msg) use ($field) {
                    return "'Hmm… eu não vou repetir! {$msg} ";
                }, $messages);
            })->toArray();
        }

        if (request()->wantsJson()) {
            return response()->json([
                'type' => 'warning',
                'message' => $errors
            ], $status);
        }

        // Para web tradicional, sempre redireciona com 303
        return back(303)->with('flash', [
            'type' => 'warning',
            'message' => $errors,
        ]);
    }
}
