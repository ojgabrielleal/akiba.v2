<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Inertia\Inertia;

use App\Traits\Response\ProvideException;
use App\Traits\Response\ProvideSuccess;

use App\Models\User;

class AdmsController extends Controller
{
    use ProvideSuccess, ProvideException;

    public function listUsers()
    {
        try{
            $users = User::all();

            function highestRole($collect, $gender){
                $weightPermissions = [
                    "dev" => 10,
                    "administrator" => 5,
                    "streamer" => 4,
                    "writer" => 3,
                    "podcaster" => 2,
                    "social" => 1
                ];

                $translate = [
                    "dev" => $gender === "male" ? "Desenvolvedor" : "Desenvolvedora",
                    "administrator" => $gender === "male" ? "Administrador" : "Administradora",
                    "streamer" => $gender === "male" ? "Locutor" : "Locutora",
                    "writer" => "Colunista",
                    "podcaster" => "Podcaster",
                    "social" => "Social Media"
                ];

                return $translate[collect($collect)->sortByDesc(fn($perm) => $weightPermissions[$perm] ?? 0)[0]];
            }

            $users->transform(function($user){
                $data = $user->toArray();
                $data['highest_role'] = highestRole($user->permissions_keys, $user->gender);
                return $data;
            });

            return $users;
        } catch (\Throwable $e) {
            $this->provideException($e);
        }
    }

    public function render()
    {
        return Inertia::render('admin/Adms', [
            'users' => $this->listUsers()
        ]);
    }
}
