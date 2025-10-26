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
        Log::error('[LaravelException] ' . get_class($e) . ': ' . $e->getMessage());

        // Mensagens randômicas por tipo de exceção
        $messages = [
            ModelNotFoundException::class => [
                '👀 Nada aqui… ou está se escondendo só pra ver se você desiste?',
                'Hmm… não achei nada. Mas talvez o universo quisesse testar sua paciência 📚'
            ],
            QueryException::class => [
                '⚡ Ops… algo deu errado. Não se preocupe, drama gratuito incluído.',
                'Algo falhou… mas calma, ninguém ia notar mesmo 😏'
            ],
            AuthenticationException::class => [
                '🔒 Precisa entrar primeiro… é só um detalhe burocrático, nada sério.',
                'Faça login antes… como se isso fosse realmente assustador 🎸'
            ],
            AuthorizationException::class => [
                'Você não tem permissão para esta ação. Não leve para o lado pessoal, é só o sistema 😒',
                'Hmm… você não pode acessar isso… surpresa! O mistério aumenta.',
                'Área restrita… mas olha, pelo menos tentou 😎'
            ],
            NotFoundHttpException::class => [
                '🚪 Página sumiu… ou talvez seja só mágica digital.',
                'Nada aqui… tenta de novo, quem sabe o site colabora 🥷'
            ],
            MethodNotAllowedHttpException::class => [
                'Não dá pra fazer assim… continue tentando, a esperança é grátis 🔥',
                'Ação inválida… não era mesmo pra funcionar 😏'
            ],
            HttpException::class => [
                '🌐 Problema na rede… relaxa, o caos é parte do charme 🌀',
                'Algo estranho… mas vamos fingir que não aconteceu 🎶'
            ],
            ThrottleRequestsException::class => [
                '🐢 Devagar… até o sistema precisa de café ⚡',
                'Muito rápido! Respira, ninguém está competindo 😌'
            ],
            FileNotFoundException::class => [
                'Hmm… não achei, talvez esteja fazendo cosplay de ninja 🥷',
                'Sumiu… olha de novo, deve estar rindo de você 😏'
            ],
            BindingResolutionException::class => [
                'Perdeu nos bastidores… mas pelo menos o show continua 😎',
                'Não achei… quem liga mesmo? 🎸'
            ],
            RuntimeException::class => [
                '💥 Bug… mas ninguém vai notar, o mundo segue 🌀',
            ],
            LogicException::class => [
                'Algo estranho… mas vamos fingir que está tudo sob controle 😏',
            ],
        ];
        $exceptionClass = get_class($e);

        // Prioriza mensagem personalizada, depois padrão
        $message = $e->getMessage(); // Mensagem personalizada
        if (empty($message)) {
            if (!empty($messages[$exceptionClass])) {
                $message = $messages[$exceptionClass][array_rand($messages[$exceptionClass])];
            } else {
                $message = app()->environment('production') ? '💥 Erro estranho… tenta de novo depois… ou finge que nunca aconteceu 😉' : '⚠️ Erro desconhecido: ' . $exceptionClass . ' — mas relaxa, isso é só dev mode 😎';            
            }
        }

        // Tratamento especial ValidationException
        if ($e instanceof ValidationException) {
            $errors = collect($e->errors())->flatMap(function ($messages) {
                return array_map(function ($msg) {
                    return "O campo&nbsp;<strong class='font-bold uppercase italic'>{$msg}</strong>&nbsp;é obrigatório 😉";
                }, $messages);
            })->toArray();
        } else {
            $errors = $message;
        }

        return back(303)->with('flash', [
            'type' => 'warning',
            'message' => $errors,
        ]);
    }
}
