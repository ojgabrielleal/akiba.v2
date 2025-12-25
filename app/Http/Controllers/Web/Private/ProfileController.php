<?php

namespace App\Http\Controllers\Web\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Traits\FlashMessageTrait;

use App\Services\Domain\UserService;

class ProfileController extends Controller
{
    use FlashMessageTrait;

    public function updateProfile(Request $request, $profileId)
    {
        $request->validate([
            'name' => 'required',
            'nickname' => 'required',
            'gender' => 'required',
            'birthday' => 'required',
            'city' => 'required',
            'state' => 'required', 
            'country' => 'required',
            'bibliography' => 'required',
        ]);

        $userService = new UserService();
        $userUpdate = $userService->update($profileId, $request->all());    

        if($userUpdate) return $this->flashMessage('update');
    }

    public function render($profileSlug = null)
    {
        $userService = new UserService();

        return Inertia::render('admin/Profile', [
            'profile' => $userService->get($profileSlug)
        ]);
    }
}
