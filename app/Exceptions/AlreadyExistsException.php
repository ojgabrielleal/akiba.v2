<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AlreadyExistsException extends Exception
{
    protected $message = 'This contents exists.';
    protected $code = 409; // Conflict

    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'error' => $this->getMessage(),
        ], $this->getCode());
    }
}
