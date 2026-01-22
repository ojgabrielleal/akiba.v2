<?php

namespace App\Http\Controllers\Web\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Traits\FlashMessageTrait;
use App\Services\Process\ImageService;

use App\Models\User;

class ProfileController extends Controller
{
    use FlashMessageTrait;

    private ImageService $image;
    private $render = 'private/Profile';

    public function __construct(ImageService $image)
    {
        $this->image = $image;
    }

    public function updateProfile(Request $request, User $user)
    {
        $user->fill([
            'avatar' =>  $this->image->store('users', $request->file('avatar'), 'public', $user->avatar),
            'name' => $request->input('name', $user->name),
            'nickname' => $request->input('nickname', $user->nickname),
            'gender' => $request->input('gender', $user->gender),
            'birthday' => $request->input('birthday', $user->birthday),
            'city' => $request->input('city', $user->city),
            'state' => $request->input('state', $user->state),
            'country' => $request->input('country', $user->country),
            'bibliography' => $request->input('bibliography', $user->bibliography),
        ]);

        if ($user->isDirty()) {
            $user->save();
        }

        if ($request->filled('socials')) {
            foreach ($request->input('socials') as $social) {
                $user->socials()->where('id', $social['id'])->update([
                    'name' => $social['name'],
                    'url' => $social['url']
                ]);
            }
        }

        if ($request->input('preferences')) {
            foreach ($request->input('preferences') as $preference) {
                $user->likes()->where('id', $preference['id'])->update([
                    'category' => $preference['category'],
                    'content' => $preference['content']
                ]);
            }
        }

        return $this->flashMessage('update');
    }

    public function render(User $user)
    {
        return Inertia::render($this->render, [
            'profile' => $user->load('socials', 'likes')
        ]);
    }
}
