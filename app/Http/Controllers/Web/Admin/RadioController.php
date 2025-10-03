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
use App\Models\Music;

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

    public function getProgramSchedule()
    {
        try {
            $query = ProgramSchedule::orderBy('created_at', 'desc');
            $query->with('show.user');
            return $query->get();
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function getShows()
    {
        try {
            return Show::orderBy('created_at', 'desc')->with(['user', 'schedules'])->get();
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function getShow($id)
    {
        try {
            return Show::where('id', $id)->with(['schedules', 'user'])->first();
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function createShow(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'image' => 'required|image',
            ], [
                'name.required' => '<b><i>Programa</b></i> é obrigatório',
                'image.required' => '<b><i>Logo do programa</b></i> é obrigatório',
            ]);

            $user = request()->user();
            $user_id = $request->input('streamer') ? $request->input('streamer') : $user->id;

            $show = Show::create([
                'user_id' => $user_id,
                'slug' => Str::slug($request->input('name')),
                'name' => $request->input('name'),
                'image' => $this->uploadImage('shows', $request->file('image'), 'public'),
                'is_all' => $request->input('is_all'),
                'has_schedule' => $request->input('has_schedule')
            ]);

            if ($request->input('has_schedule')) {
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
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function updateShow(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
            ], [
                'name.required' => '<b><i>Programa</b></i> é obrigatório',
            ]);

            $show = Show::where('id', $id)->first();

            $user_id = $request->input('user_id') ? $request->input('user_id') : $show->user_id;
            $slug = $request->input('name') !== $show->name ? Str::slug($request->input('name')) : $show->slug;
            $name = $request->input('name') !== $show->name ? $request->input('name') : $show->name;
            $image = $request->hasFile('image') ? $this->uploadImage('shows', $request->file('image'), 'public', $show->image) : $show->image;
            $is_all = $request->input('is_all') !== $show->is_all ? $request->input('is_all') : $show->is_all;

            $show->update([
                'user_id' => $user_id,
                'slug' => $slug,
                'name' => $name,
                'image' => $image,
                'is_all' => $is_all,
                'has_schedule' => $request->input('has_schedule')
            ]);

            if ($request->input('has_schedule')) {
                ProgramSchedule::where('show_id', $show->id)->delete();
                foreach ($request->input('schedules') as $schedule) {
                    ProgramSchedule::create([
                        'show_id' => $show->id,
                        'day' => $schedule['day'],
                        'time' => $schedule['time'],
                    ]);
                }
            }

            $this->ProvideSuccess('update');
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function deactivateShow($id)
    {
        try {
            $show = Show::where('id', $id)->first();
            $show->update([
                'is_active' => false
            ]);

            ProgramSchedule::where('show_id', $show->id)->delete();

            $this->ProvideSuccess('update');
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function getRankingMusics()
    {
        try {
            return Music::orderBy('listener_request_total', 'desc')->limit(3)->get();
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function updateRankingMusicImage(Request $request, $id)
    {
        try {
            $music = Music::where('id', $id)->first();

            $image = $this->uploadImage('musics/ranking', $request->file('image_ranking'), 'public', $music->image_ranking ?? null);
            $music->update([
                'image_ranking' => $image,
            ]);

            $this->ProvideSuccess('save');
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function setRankingMusic()
    {
        try {
            Music::where('is_ranking', true)->update([
                'is_ranking' => false
            ]);

            $music = Music::orderBy('listener_request_total', 'desc')->limit(10)->get();

            foreach ($music as $music) {
                $music->update([
                    'is_ranking' => true
                ]);
            }

            $this->ProvideSuccess('save');
        }catch(\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function render()
    {
        return Inertia::render('admin/Radio', [
            "shows" => $this->getShows(),
            "streamers" => $this->getStreamers(),
            "program_schedule" => $this->getProgramSchedule(),
            "ranking_musics" => $this->getRankingMusics(),
        ]);
    }
}
