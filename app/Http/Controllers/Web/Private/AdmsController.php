<?php

namespace App\Http\Controllers\Web\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Traits\FlashMessageTrait;

use App\Services\Domain\UserService;

class AdmsController extends Controller
{
    use FlashMessageTrait;

    public function updateUserPassword(Request $request, $userId)
    {
        $userService = new UserService();
        $userService->updatePassword($userId, $request->input('password'));

        return $this->flashMessage('save');
    }

    public function updateUserRoles(Request $request, $userId)
    {
        $userService = new UserService();
        $userService->updateRoles($userId, $request->input('roles'));

        return $this->flashMessage('save');
    }

    public function createUser(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'name' => 'required',
            'nickname' => 'required',
            'gender' => 'required',
            'role' => 'required'
        ]);

        $userService = new UserService();
        $userService->create($request->all());

        return $this->flashMessage('save');
    }

    public function disableUser($userId)
    {
        $userService = new UserService();
        $userService->disable($userId);

        return $this->flashMessage('deactivate');
    }

    public function render()
    {
        $user = new UserService();

        return Inertia::render('admin/Adms', [
            'users' => $user->list([
                'filters' => ['is_active' => true],
                'fields' => ['id', 'slug', 'username', 'name', 'nickname']
            ]),
        ]);
    }
}
