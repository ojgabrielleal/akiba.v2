<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\AlreadyExistsException;

use Inertia\Inertia;

use App\Traits\Response\ProvideGenericExceptionTrait;
use App\Traits\Response\ProvideSuccessTrait;

use App\Models\User;
use App\Models\Role;

class AdmsController extends Controller
{
    use ProvideSuccessTrait;

    public function listUsers()
    {
        try{
            $query = User::where('is_active', true);
            $query->with('role');
            $user = $query->get();

            $map = $user->map(function($item){
                return [
                    'id' => $item->id,
                    'username' => $item->username,
                    'name' => $item->name,
                    'nickname' => $item->nickname,
                    'avatar' => $item->avatar,
                ];
            });

            return $map;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getUser($id)
    {
        try{
            $query = User::where('id', $id);
            $query->with(['userPreference', 'userSocial', 'role']);
            $user = $query->firstOrFail();

            return [
                'id' => $user->id,
                'username' => $user->username,
                'name' => $user->name,
                'nickname' => $user->nickname,
                'avatar' => $user->avatar,
            ];
        } catch (\Throwable $e) {
            throw $e;
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

            if($user){
                UserPermission::create([
                    'user_id' => $user->id,
                    'permission' => $request->input('permission')
                ]);
            }

            return $this->provideSuccess('save');
        } catch (\Throwable $e) {
            return $this->provideGenericException($e);
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
            return $this->provideGenericException($e);
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
            return $this->provideGenericException($e);
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
            return $this->provideGenericException($e);
        }
    }

    public function render()
    {
        return Inertia::render('admin/Adms', [
            'users' => $this->listUsers(),
        ]);
    }
}
