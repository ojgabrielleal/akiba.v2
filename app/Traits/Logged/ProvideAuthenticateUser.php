<?php

namespace App\Traits\Logged;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

trait ProvideAuthenticateUser
{
    public function provideAuthenticateUser()
    {
        if (!Auth::check()) {
            return null;
        }

        $user = User::with('permissions')->find(Auth::id());
        $user->setRelation('permissions', $user->permissions_keys->pluck('permission'));

        return $user;
    }
}