<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use Inertia\Inertia;

use App\Traits\Upload\HandlesImageUpload;
use App\Traits\Response\ProvideException;
use App\Traits\Response\ProvideSuccess;

use App\Models\User;
use App\Models\Show;
use App\Models\ProgramSchedule;

class RadioController extends Controller
{
    use HandlesImageUpload, ProvideSuccess, ProvideException;

    public function getStreamers()
    {
        try {
            $users = User::all();
            $streamers = $users->filter(function ($user) {
                return array_intersect(['streamer', 'administrator'], $user->permissions_keys->toArray() ?? []);
            });

            return $streamers->values()->toArray();
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function createShow(Request $request)
    {
        try {
            Log::info($request);
            $request->validate([
                'name' => 'required',
                'image' => 'required|image',
            ], [
                'name.required' => '<b><i>Programa</b></i> é obrigatório',
                'image.required' => '<b><i>Logo do programa</b></i> é obrigatório',
            ]);

            $user = request()->user();
            $streamer = $request->input('streamer') ? $request->input('streamer') : $user->id;

            $show = Show::create([
                'user_id' => $streamer,
                'slug' => Str::slug($request->input('name')),
                'name' => $request->input('name'),
                'image' => $this->uploadImage('shows', $request->file('image'), 'public'),
                'is_all' => $request->input('is_all')
            ]);

            if ($request->input('schedule_fixed')) {
                if ($show) {
                    foreach ($request->input('schedules') as $schedule) {
                        ProgramSchedule::create([
                            'show_id' => $show->id,
                            'day' => $schedule['day'],
                            'time' => $schedule['time'],
                        ]);
                    }
                }
            }

            $this->ProvideSuccess('save');
            return redirect()->route('render.painel.radio');
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function render()
    {
        return Inertia::render('admin/Radio', [
            "streamers" => $this->getStreamers(),
        ]);
    }
}
