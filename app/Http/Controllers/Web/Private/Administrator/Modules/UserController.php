<?php

namespace App\Http\Controllers\Web\Private\Administrator;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\Exceptions\AlreadyExistsException;
use App\Traits\Response\FlashMessageTrait;
use App\Models\User;

class UserController extends Controller
{
    use FlashMessageTrait;

    public function updatePassword(Request $request, $userId)
    {

        $user = User::findOrFail($userId);
        $user->update([
            'password' => Hash::make($request->input('password'))
        ]);

        return $this->flashMessage('save');
    }

    public function updateRoles(Request $request, $userId)
    {
        $request->validate([
            'roles' => 'required'
        ]);

        $user = User::findOrFail($userId);
        $user->roles()->sync($request->input('roles'));

        return $this->flashMessage('save');
    }

    public function create(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'name' => 'required',
            'nickname' => 'required',
            'gender' => 'required',
            'role' => 'required'
        ]);

        $existUser = User::where('username', $request->input('username'))->exists();
        if ($existUser) {
            throw new AlreadyExistsException();
        }

        $user = User::create([
            'slug' => Str::slug($request->input('nickname')),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'name' => $request->input('name'),
            'nickname' => $request->input('nickname'),
            'avatar' => $request->input('gender') === "male" ? "/img/default/defaultAvatarMale.webp" : "/img/default/defaultAvatarFemale.webp",
            'gender' => $request->input('gender')
        ]);
        $user->roles()->attach($request->input('roles'));

        return $this->flashMessage('save');
    }

    public function disable($userId)
    {
        $user = User::findOrFail($userId);
        $user->update([
            'is_active' => false
        ]);

        return $this->flashMessage('deactivate');
    }
}
