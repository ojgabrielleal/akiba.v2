<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\ListenerMonth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Exceptions\AlreadyExistsException;

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

    public function listStreamers()
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

    public function listProgramsSchedules()
    {
        try {
            return ProgramSchedule::orderBy('created_at', 'desc')->with('show.user')->get();
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function listShows()
    {
        try {
            return Show::orderBy('created_at', 'desc')->with(['user', 'schedules'])->where('is_active', true)->get();
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function getShow($id)
    {
        try {
            if($id){
                return Show::where('id', $id)->with(['schedules', 'user'])->firstOrFail();
            }
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
                'name.required' => 'Programa',
                'image.required' => 'Logo do programa',
            ]);

            $authenticated = request()->user();

            $exist = Show::where('name', $request->input('name'))->exists();
            if ($exist) throw new AlreadyExistsException();
            
            $create = Show::create([
                'user_id' => $request->input('user_id') ? $request->input('user_id') : $authenticated->id,
                'slug' => Str::slug($request->input('name')),
                'name' => $request->input('name'),
                'image' => $this->uploadImage('shows', $request->file('image'), 'public'),
                'is_all' => $request->input('is_all'),
                'has_schedule' => $request->input('has_schedule')
            ]);

            if($create->wasRecentlyCreated){
                if ($request->input('has_schedule')) {
                    foreach ($request->input('schedules') as $schedule) {
                        ProgramSchedule::create([
                            'show_id' => $create->id,
                            'day' => $schedule['day'],
                            'time' => $schedule['time'],
                        ]);
                    }
                }
            }

            return $this->provideSuccess('save');
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
                'name.required' => 'Programa',
            ]);

            $show = Show::where('id', $id)->firstOrFail();
            $show->update([
                'user_id' => $request->input('user_id') ? $request->input('user_id') : $show->user_id,
                'slug' => $request->input('name') !== $show->name ? Str::slug($request->input('name')) : $show->slug,
                'name' => $request->input('name', $show->name),
                'image' => $request->hasFile('image') ? $this->uploadImage('shows', $request->file('image'), 'public', $show->image) : $show->image,
                'is_all' => $request->input('is_all', $show->is_all),
                'has_schedule' => $request->input('has_schedule', $show->has_schedule),
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
            
            return $this->provideSuccess('update');
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function deactivateShow($id)
    {
        try {
            $show = Show::where('id', $id)->firstOrFail();
            $show->update([
                'is_active' => false
            ]);
            ProgramSchedule::where('show_id', $show->id)->delete();

            return $this->provideSuccess('update');
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function getListenerMonthRegistered()
    {
        try {
            return ListenerMonth::where('id', 1)->first();
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function getListenerMonthFound()
    {
        try {
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();

            $query = DB::table('listeners_requests');
            $query->where('status', 'granted');
            $query->join('onair', 'listeners_requests.onair_id', '=', 'onair.id');
            $query->join('shows', 'onair.program_id', '=', 'shows.id');
            $query->whereBetween('listeners_requests.created_at', [$startOfMonth, $endOfMonth]);
            $query->select('listener', 'listeners_requests.address', 'shows.name as favorite_show', DB::raw('COUNT(*) as total'));
            $query->groupBy('listener', 'listeners_requests.address', 'shows.name');
            $query->orderByDesc('total');
            $listener = $query->first();

            return $listener;
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function listRankingMusics()
    {
        try {
            return Music::orderBy('listener_request_total', 'desc')->limit(3)->get();
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function setRankingMusic()
    {
        try {
            Music::where('is_ranking', true)->update([
                'is_ranking' => false,
            ]);

            $musics = Music::orderBy('listener_request_total', 'desc')->limit(10)->get();
            foreach ($musics as $music) {
                $music->update([
                    'is_ranking' => true
                ]);
            }

            return $this->provideSuccess('save');
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function createListenerMonth(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required',
            ], [    
                'image.required' => 'Imagem do ranking'
            ]);
                        
            $exist = ListenerMonth::exists();
            $found = $this->getListenerMonthFound();

            if ($exist) {
                $listenerMonth = ListenerMonth::where('id', 1)->firstOrFail();
                $listenerMonth->update([
                    'image' => $this->uploadImage('listener-month', $request->file('image'), 'public', $listenerMonth->image ?? null),
                    'listener' => $found->listener,
                    'address' => $found->address,
                    'favorite_show' => $found->favorite_show,
                    'requests_total' => $found->total,
                ]);

                return $this->provideSuccess('update');
            } else {
                DB::statement('ALTER TABLE listener_month AUTO_INCREMENT = 1');
                ListenerMonth::create([
                    'image' => $this->uploadImage('listener-month', $request->file('image'), 'public'),
                    'listener' => $found->listener,
                    'address' => $found->address,
                    'favorite_show' => $found->favorite_show,
                    'requests_total' => $found->total,
                ]);

                return $this->provideSuccess('save');
            }
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function updateRankingMusicImage(Request $request, $id)
    {
        try {
            $music = Music::where('id', $id)->firstOrFail();
            $music->update([
                'image_ranking' => $this->uploadImage('musics/ranking', $request->file('image_ranking'), 'public', $music->image_ranking ?? null),
            ]);

            return $this->provideSuccess('save');
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function render()
    {
        return Inertia::render('admin/Radio', [
            "shows" => $this->listShows(),
            "streamers" => $this->listStreamers(),
            "programSchedule" => $this->listProgramsSchedules(),
            "rankingMusics" => $this->listRankingMusics(),
            "listenerMonthRegistered" => $this->getListenerMonthRegistered(),
            'listenerMonthFound' => $this->getListenerMonthFound(),
        ]);
    }
}
