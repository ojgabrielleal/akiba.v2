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
                'Nani?! Não achei nada aqui, senpai… 😱💨 (＠_＠;)',
                'Hmm… não tem nada por aqui, senpai! 👀🐾 (*・_・)ﾉ'
            ],
            QueryException::class => [
                'Uwaa~ deu um probleminha! 🤯✨ (≧д≦) Mas não se preocupe!',
                'Ops! Algo estranho aconteceu… 👻💦 (>_<) O mascote tá cuidando disso!'
            ],
            AuthenticationException::class => [
                'Faz login primeiro, onegai~ 🔑💛 ( •̀ ω •́ )✧',
                'Senpai, você precisa entrar! 🚪💦 (；・∀・) Vamos lá juntos!'
            ],
            AuthorizationException::class => [
                'Yamete! Você não pode acessar isso, senpai… 😵❌ (￣ヘ￣;)',
                'Hmm… essa área é secreta! 🤫🔒 (・_・;) Melhor tentar outro lugar!'
            ],
            NotFoundHttpException::class => [
                'Eeeh?! Essa página sumiu… 🌫️💨 (；・∀・) Tenta outro caminho!',
                'Hmm… nada encontrado aqui! 🧐🍃 (＠_＠;) Será que foi levada pelo vento?'
            ],
            MethodNotAllowedHttpException::class => [
                'Ops… não dá pra fazer assim, senpai! 🚫😳 (╬ Ò﹏Ó) Vamos tentar outro jeito!',
                'Hmm… essa ação não funciona desse jeito! 🔄💦 (・_・;) Mas vai dar certo!'
            ],
            HttpException::class => [
                'Ai… deu ruim na rede! 🌐💥 (´･ω･`) Respira fundo, senpai!',
                'Hmm… algo estranho aconteceu… 😵💦 (＞人＜;) Mas não se preocupe!'
            ],
            ThrottleRequestsException::class => [
                'Calma aí, senpai! 🐢💨 (≧д≦ヾ Muito rápido não dá…',
                'Ops! Você está indo rápido demais! 😳🌪️ (>_<) Devagarzinho que dá certo!'
            ],
            FileNotFoundException::class => [
                'Hmm… não achei esse item… ❌👀 (´・д・`) Será que sumiu?',
                'Ops! Algo sumiu, senpai! 💨🍃 (・_・;) Vamos procurar juntos!'
            ],
            BindingResolutionException::class => [
                'Uwaa~ algo se perdeu nos bastidores! 🐾🤯 (≡^∇^≡)',
                'Hmm… não achei, senpai! 🧩✨ (・_・;) Parece que sumiu!'
            ],
            RuntimeException::class => [
                'Yabai! Bugou tudo… 💥💦 (╯°□°）╯︵ ┻━┻ Mas vamos consertar!'
            ],
            LogicException::class => [
                'Ai… algo estranho aconteceu… 😖💦 (╯°□°）╯︵ ┻━┻ Mas tudo vai ficar bem!'
            ],
        ];


        // Mensagem padrão
        $defaultMessage = app()->environment('production')
            ? 'Erro estranho… tenta novamente depois~ (＞人＜;) Mas não desanima, senpai!'
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
                    return "Nyaa~ O campo {$msg}, senpai~ (＠_＠;)✨ Verifica rapidinho, onegai~ 🐾";
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
