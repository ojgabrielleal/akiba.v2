<?php

namespace App\Http\Controllers\Web\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Traits\FlashMessageTrait;

use App\Models\User;

class AdmsController extends Controller
{
    use FlashMessageTrait;

    private $render = 'admin/Adms';

    public function indexUsers()
    {
        return User::active()
            ->with(['roles'])
            ->get();
    }

    public function createUser(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required',
            'name' => 'required',
            'nickname' => 'required',
            'gender' => 'required',
            'roles' => 'required'
        ]);

        $avatar = null;
        if ($request->input('gender') === 'male') {
            $avatar = '/img/default/defaultAvatarMale.webp';
        } else {
            $avatar = '/img/default/defaultAvatarFemale.webp';
        }

        User::create([
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'name' => $request->input('name'),
            'avatar' => $avatar,
            'nickname' => $request->input('nickname'),
            'gender' => $request->input('gender'),
        ])->roles()->attach($request->input('roles'));

        return $this->flashMessage('save');
    }

    public function deactivateUser(User $user)
    {
        $user->update([
            'is_active' => false,
        ]);

        return $this->flashMessage('deactivate');
    }

    public function changeUserPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $user->update([
            'password' => $request->input('password'),
        ]);

        return $this->flashMessage('save');
    }

    /*
    *TODO: Verify method to change roles if needed
    */
    public function changeUserRoles(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'required|array',
        ]);

        $user->roles()->sync($request->input('roles'));
        return $this->flashMessage('save');
    }

    public function render()
    {
        return Inertia::render($this->render, [
            'users' => $this->indexUsers()
        ]);
    }
}
