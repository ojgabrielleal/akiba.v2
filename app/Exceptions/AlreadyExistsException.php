<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AlreadyExistsException extends Exception
{
    protected $message = 'This content exists in the database but is deactivated.';
    protected $code = 409; // Conflict

    public function render(Request $request): JsonResponse
    {
        back(303)->with('flash', [
            'type' => 'warning',
            'message' => 'O que você quer já existe… mas tá tirando uma soneca 😴💤, acorda ele na lixeira! 😏⚡',
        ]);

        return response()->json([
            'error' => $this->getMessage(),
        ], $this->getCode());
    }
}
