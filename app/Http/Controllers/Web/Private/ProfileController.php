<?php

namespace App\Http\Controllers\Web\Private;

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

    public function getUser($slug)
    {
        try{
            if($slug){
                $authenticated = request()->user();

                
                if ($authenticated->permissions_keys->intersect(['administrator', 'dev'])->isNotEmpty()) {
                    return User::where('slug', $slug)->firstOrFail();
                }

                return $authenticated;
            }
        }catch(\Throwable $e){
            return $this->provideException($e);
        }
    }

    public function updateUser(Request $request, $id)
    {
        try{
            $request->validate([
                'name' => 'required',
                'nickname' => 'required',
                'gender' => 'required',
                'birthday' => 'required',
                'city' => 'required',
                'state' => 'required', 
                'country' => 'required',
                'bibliography' => 'required',
            ], [
                'name.required' => "Nome",
                'nickname.required' => "Apelido",
                'gender.required' => "Gênero",
                'birthday' => 'Data de nascimento',
                'city' => 'Cidade',
                'state' => 'Estado',
                'country' => 'País',
                'bibliography' => 'Bibliografia'
            ]);

            $user = User::where('id', $id)->firstOrFail();
            $user->update([
                'slug' =>  $request->input('nickname') !== $user->nickname ? Str::slug($request->input('nickname')) : $user->slug,
                'avatar' => $request->hasFile('avatar') ? $this->uploadImage('users', $request->file('avatar'), 'public', $user->avatar) : $user->avatar,
                'name' => $request->input('name', $user->name),
                'nickname' => $request->input('nickname', $user->nickname),
                'gender' => $request->input('gender', $user->gender),
                'birthday' => $request->input('birthday', $user->birthday),
                'city' => $request->input('city', $user->city),
                'state' => $request->input('state', $user->state),
                'country' => $request->input('country', $user->country),
                'bibliography' => $request->input('bibliography', $user->bibliography),
            ]);

            // Links externos
            $externalLinks = $request->input('external_links', []);
            if($externalLinks){
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
            }

            // Gostos
            $likes = $request->input('likes', []);
            if($likes){
                foreach($likes as $item){
                    UserLike::where('id', $item['id'])->update([
                        'category' => $item['category'],
                        'content' => $item['content']
                    ]);
                }
            }
        
            return $this->provideSuccess('update');
        }catch(\Throwable $e){
            return $this->provideException($e);
        }
    }

    public function render($slug = null)
    {
        return Inertia::render('admin/Profile', [
            'profile' => $this->getUser($slug)
        ]);
    }
}
