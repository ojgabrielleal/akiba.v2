<?php

namespace App\Http\Controllers\Web\Private\Administrator;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

use App\Services\Controllers\UserService;

class AdministratorController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function render()
    {
        return Inertia::render('admin/Adms', [
            'users' => $this->userService->list(
                ['is_active' => true],
                ['fields' => ['id', 'slug', 'username', 'name', 'nickname']]
            ),
        ]);
    }
}
