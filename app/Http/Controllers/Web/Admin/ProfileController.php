<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use Inertia\Inertia;

use App\Traits\Response\ProvideException;
use App\Traits\Response\ProvideSuccess;
use App\Traits\Upload\HandlesImageUpload;

use App\Models\User;
use App\Models\UserExternalLink;
use App\Models\UserLike;

class ProfileController extends Controller
{
    use HandlesImageUpload, ProvideSuccess, ProvideException;

    public function getProfile($slug)
    {
        try{
            if($slug){
                $logged = request()->user();

                if ($logged->permissions_keys->intersect(['administrator', 'dev'])->isNotEmpty()) {
                    return User::where('slug', $slug)->firstOrFail();
                }

                return $logged;
            }
        }catch(\Throwable $e){
            return $this->provideException($e);
        }
    }

    public function updateProfile(Request $request, $id)
    {
        try{
            $request->validate([
                'name' => 'required',
                'nickname' => 'required',
                'gender' => 'required',
                'birthday' => 'required',
                'email' => 'required',
                'city' => 'required',
                'state' => 'required', 
                'country' => 'required',
                'bibliography' => 'required',
            ], [
                'name.required' => "Nome",
                'nickname.required' => "Apelido",
                'gender.required' => "Gênero",
                'birthday' => 'Data de nascimento',
                'email' => 'Email',
                'city' => 'Cidade',
                'state' => 'Estado',
                'country' => 'País',
                'bibliography' => 'Bibliografia'
            ]);

            $profile = User::where('id', $id)->firstOrFail();
            $profile->update([
                'slug' =>  $request->input('nickname') !== $profile->nickname ? Str::slug($request->input('nickname')) : $profile->slug,
                'avatar' => $request->hasFile('avatar') ? $this->uploadImage('users', $request->file('avatar'), 'public', $profile->avatar) : $profile->avatar,
                'name' => $request->input('name', $profile->name),
                'nickname' => $request->input('nickname', $profile->nickname),
                'gender' => $request->input('gender', $profile->gender),
                'birthday' => $request->input('birthday', $profile->birthday),
                'email' => $request->input('email', $profile->email),
                'city' => $request->input('city', $profile->city),
                'state' => $request->input('state', $profile->state),
                'country' => $request->input('country', $profile->country),
                'bibliography' => $request->input('bibliography', $profile->bibliography),
            ]);

            // Links externos
            $externalLinks = $request->input('external_links', []);
            $externalLinksExisting = collect($externalLinks)->pluck('id')->filter()->toArray();
            
            UserExternalLink::where('user_id', $id)->whereNotIn('id', $externalLinksExisting)->delete();

            foreach($externalLinks as $item){
                if(isset($item['id'])){
                    UserExternalLink::where('id', $item['id'])->update([
                        'name' => $item['name'],
                        'url' => $item['url'],
                    ]);
                }else{
                    UserExternalLink::create([
                        'user_id' => $id,
                        'name' => $item['name'],
                        'url' => $item['url'],
                    ]);
                }
            }

            // Gostos
            $likes = $request->input('likes', []);
            foreach($likes as $item){
                UserLike::where('id', $item['id'])->update([
                    'category' => $item['category'],
                    'content' => $item['content']
                ]);
            }

            return $this->provideSuccess('update');
        }catch(\Throwable $e){
            return $this->provideException($e);
        }
    }

    public function render($slug = null)
    {
        return Inertia::render('admin/Profile', [
            'profile' => $this->getProfile($slug)
        ]);
    }
}
