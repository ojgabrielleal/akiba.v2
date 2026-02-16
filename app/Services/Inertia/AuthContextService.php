<?php

namespace App\Services\Inertia;

use Illuminate\Support\Facades\Auth;
use App\Traits\ResolvesUserLogged;

class AuthContextService
{
    use ResolvesUserLogged;

    public function data()
    {
        if(!Auth::check()) {
            return null;
        }

        return [
            'user' => $this->userContext(),
            'navbar' => $this->navbarContext(),
        ];
    }

    protected function getUser()
    {
        return $this->getUserLogged();
    }

    protected function userContext()
    {
        $user = $this->getUser();

        return [
            'uuid' => $user['uuid'],
            'nickname' => $user['nickname'],
            'avatar' => $user['avatar'],
        ];
    }

    protected function navbarContext()
    {
        $navbarItems = collect([
            ['name' => 'Dashboard', 'icon' => '/svg/default/dashboard.svg', 'permission' => 'access.page.dashboard', 'address' => '/painel/dashboard'],
            ['name' => 'Materias', 'icon' => '/svg/default/materials.svg', 'permission' => 'access.page.posts', 'address' => '/painel/materias'],
            ['name' => 'Locução', 'icon' => '/svg/default/broadcast.svg', 'permission' => 'access.page.broadcast', 'address' => '/painel/locucao'],
            ['name' => 'Rádio', 'icon' => '/svg/default/radio.svg', 'permission' => 'access.page.radio', 'address' => '/painel/radio'],
            ['name' => 'Podcasts', 'icon' => '/svg/default/podcasts.svg', 'permission' => 'access.page.podcasts', 'address' => '/painel/podcasts'],
            ['name' => 'Marketing', 'icon' => '/svg/default/marketing.svg', 'permission' => 'access.page.marketing', 'address' => '/painel/marketing'],
            ['name' => 'Mídias', 'icon' => '/svg/default/media.svg', 'permission' => 'access.page.media', 'address' => '/painel/medias'],
            ['name' => 'Administração', 'icon' => '/svg/default/adms.svg', 'permission' => 'access.page.administrations', 'address' => '/painel/adms'],
            ['name' => 'Logs', 'icon' => '/svg/default/logs.svg', 'permission' => 'access.page.logs', 'address' => '/painel/logs'],
            ['name' => 'Avisos', 'icon' => '/svg/default/alerts.svg', 'permission' => 'access.page.warnings', 'address' => '/painel/alerts'],
        ]);

        $user = $this->getUser();

        return $navbarItems->filter(function ($item) use ($user) {
            return $user['permissions']->contains($item['permission']);
        })->values();
    }
}
