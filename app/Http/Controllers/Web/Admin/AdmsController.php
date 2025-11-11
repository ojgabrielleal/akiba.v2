<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\AlreadyExistsException;

use Inertia\Inertia;

use App\Traits\Response\ProvideExceptionTrait;
use App\Traits\Response\ProvideSuccessTrait;

use App\Models\User;
use App\Models\UserPermission;

class AdmsController extends Controller
{
    use ProvideSuccessTrait, ProvideExceptionTrait;

    public function listUsers()
    {
        try{
            $users = User::where('is_active', true)->get();

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
            return $this->provideException($e);
        }
    }

    public function getUser($id)
    {
        try{
            return User::where('id', $id)->firstOrFail();
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function createUser(Request $request)
    {
        try{
            $request->validate([
                'username' => 'required',
                'password' => 'required',
                'name' => 'required',
                'nickname' => 'required',
                'gender' => 'required',
                'permission' => 'required'
            ], [
                'username.required' => 'Login',
                'password.required' => 'Senha',
                'name.required' => 'Nome',
                'nickname.required' => 'Apelido',
                'gender.required' => 'Gênero',
                'permission.required' => "Cargo principal"
            ]);

            $exists = User::where('username', $request->input('username'))->exists();
            if($exists) throw new AlreadyExistsException();

            $user = User::create([
                'slug' => Str::slug($request->input('nickname')),
                'username' => $request->input('username'),
                'password' => Hash::make($request->input('password')),
                'name' => $request->input('name'),
                'nickname' => $request->input('nickname'),
                'avatar' => $request->input('gender') === "male" ? "/img/default/defaultAvatarMale.webp" : "/img/default/defaultAvatarFemale.webp",
                'gender' => $request->input('gender')
            ]);

            UserPermission::create([
                'user_id' => $user->id,
                'permission' => $request->input('permission')
            ]);

            return $this->provideSuccess('save');
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function updateUserPassword(Request $request, $id)
    {
        try{
            $request->validate([
                'password' => 'required'
            ], [
                'password.required' => "Nova senha"
            ]);

            $user = User::where('id', $id)->firstOrFail();
            $user->update([
                'password' => Hash::make($request->input('password'))
            ]);

            return $this->provideSuccess('save');
        }catch(\Throwable $e){
            return $this->provideException($e);
        }
    }

    public function updateUserPermissions(Request $request, $id)
    {
        try{
            $permissions = $request->input('permissions_keys', []);
            UserPermission::where('user_id', $id)->whereNotIn('permission', $permissions)->delete();

            foreach($permissions as $item){
                UserPermission::create([
                    'user_id' => $id,
                    'permission' => $item,
                ]);
            }

            return $this->provideSuccess('save');
        }catch(\Throwable $e){
            return $this->provideException($e);
        }
    }

    public function deativateUser($id)
    {
        try{
            User::where('id', $id)->update([
                'is_active' => false
            ]);

            return $this->provideSuccess('deactivate');
        }catch(\Throwable $e){
            return $this->provideException($e);
        }
    }

    public function render()
    {
        return Inertia::render('admin/Adms', [
            'users' => $this->listUsers(),
        ]);
    }
}
