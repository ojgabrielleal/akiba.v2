<?php

namespace App\Traits\Logged;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

trait ProvideAuthenticateUser
{
    public function ProvideAuthenticateUser()
    {
        if (!Auth::check()) {
            return null;
        }

        $user = User::with('permissions')->find(Auth::id());
        $user->setRelation('permissions', $user->permissions->pluck('permission'));

        return $user;
    }
}