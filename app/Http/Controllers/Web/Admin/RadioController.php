<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\ListenerMonth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
use App\Models\ListenerRequest;

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
            return ProgramSchedule::orderBy('created_at', 'desc')->with('show.user')->get();
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function getShows()
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
            return Show::where('id', $id)->with(['schedules', 'user'])->firstOrFail();
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

            $user = request()->user();
            $userId = $request->input('user_id') ? $request->input('user_id') : $user->id;

            $showExist = Show::where('name', $request->input('name'))->exists();
            if ($showExist) {
                return $this->provideSuccess('exists');
            }

            $showCreate = Show::create([
                'user_id' => $userId,
                'slug' => Str::slug($request->input('name')),
                'name' => $request->input('name'),
                'image' => $this->uploadImage('shows', $request->file('image'), 'public'),
                'is_all' => $request->input('is_all'),
                'has_schedule' => $request->input('has_schedule')
            ]);

            if($showCreate){
                if ($request->input('has_schedule')) {
                    foreach ($request->input('schedules') as $schedule) {
                        $scheduleCreate = ProgramSchedule::create([
                            'show_id' => $showCreate->id,
                            'day' => $schedule['day'],
                            'time' => $schedule['time'],
                        ]);
                        if(!$scheduleCreate->wasRecentlyCreated) throw new \Exception('Não foi possível criar o horário do programa');
                    }
                }
            }else{
                throw new \Exception('Não foi possível criar o programa');
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

            $userId = $request->input('user_id') ? $request->input('user_id') : $show->user_id;
            $slug = $request->input('name') !== $show->name ? Str::slug($request->input('name')) : $show->slug;
            $name = $request->input('name') !== $show->name ? $request->input('name') : $show->name;
            $image = $request->hasFile('image') ? $this->uploadImage('shows', $request->file('image'), 'public', $show->image) : $show->image;
            $is_all = $request->input('is_all') !== $show->is_all ? $request->input('is_all') : $show->is_all;

            $showUpdate = $show->update([
                'user_id' => $userId,
                'slug' => $slug,
                'name' => $name,
                'image' => $image,
                'is_all' => $is_all,
                'has_schedule' => $request->input('has_schedule')
            ]);

            if($showUpdate){
                if ($request->input('has_schedule')) {
                    $delete = ProgramSchedule::where('show_id', $show->id)->delete();
                    if($delete === false){
                        throw new \Exception('Não foi possível atualizar os horários do programa');
                    }
    
                    foreach ($request->input('schedules') as $schedule) {
                        $scheduleCreate = ProgramSchedule::create([
                            'show_id' => $show->id,
                            'day' => $schedule['day'],
                            'time' => $schedule['time'],
                        ]);
                        if(!$scheduleCreate->wasRecentlyCreated) throw new \Exception('Não foi possível criar o horário do programa');
                    }
                }
            }else{
                throw new \Exception('Não foi possível atualizar o programa');
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
            $showDeactivate = $show->update([
                'is_active' => false
            ]);
            if($showDeactivate === 0) throw new \Exception('Não foi possível desativar o programa');

            $scheduleRemove = ProgramSchedule::where('show_id', $show->id)->delete();
            if(!$scheduleRemove) throw new \Exception('Não foi possível deletar os horários do programa');

            return $this->provideSuccess('update');
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
            $music = Music::where('id', $id)->firstOrFail();

            $image = $this->uploadImage('musics/ranking', $request->file('image_ranking'), 'public', $music->image_ranking ?? null);
            $updateRanking = $music->update([
                'image_ranking' => $image,
            ]);
            if ($updateRanking === 0) throw new \Exception('Não foi possível atualizar a imagem da música');

            return $this->provideSuccess('save');
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function setRankingMusic()
    {
        try {
            $updateRanking = Music::where('is_ranking', true)->update([
                'is_ranking' => false
            ]);
            if ($updateRanking === 0) throw new \Exception('Não foi possível resetar o ranking de músicas');

            $music = Music::orderBy('listener_request_total', 'desc')->limit(10)->get();
            if($music->isEmpty()) throw new \Exception('Não há músicas para definir o ranking');

            foreach ($music as $music) {
                $musicUpdate = $music->update([
                    'is_ranking' => true
                ]);
                if ($musicUpdate === 0) throw new \Exception('Não foi possível atualizar o ranking da música');
            }

            return $this->provideSuccess('save');
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function getListenerMonthRegistered()
    {
        try {
            return ListenerMonth::where('id', 1)->firstOrFail();
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function getListenerMonthFound()
    {
        try {
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();

            $listenerFound = ListenerRequest::select('listener', 'address', DB::raw('COUNT(*) as total'));
            $listenerFound->where('status', 'attended');
            $listenerFound->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
            $listenerFound->groupBy('listener', 'address');
            $listenerFound->orderByDesc('total');
            $listenerFound = $listenerFound->first();

            if (!$listenerFound) {
                return null;
            }

            $onairRelated = ListenerRequest::where('listener', $listenerFound->listener);
            $onairRelated->where('address', $listenerFound->address);
            $onairRelated->where('status', 'attended');
            $onairRelated->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
            $onairRelated->select('onair_id', DB::raw('COUNT(*) as total'));
            $onairRelated->groupBy('onair_id');
            $onairRelated->orderByDesc('total');
            $onairRelated = $onairRelated->first();

            if ($onairRelated && $onairRelated->onair_id) {
                $onairRelated->load('onair.program');
                $listenerFound->onair = $onairRelated->onair;
            } else {
                $listenerFound->onair = null;
            }

            return $listenerFound;
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function createListenerMonth(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image',
            ], [    
                'image.required' => 'Imagem do ranking'
            ]);

            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();

            $listenerFound = ListenerRequest::select('listener', 'address', DB::raw('COUNT(*) as total'));
            $listenerFound->where('status', 'attended');
            $listenerFound->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
            $listenerFound->groupBy('listener', 'address');
            $listenerFound->orderByDesc('total');
            $listenerFound = $listenerFound->first();
            
            if (!$listenerFound) {
                return null;
            }
            
            $onairRelated = ListenerRequest::where('listener', $listenerFound->listener);
            $onairRelated->where('address', $listenerFound->address);
            $onairRelated->where('status', 'attended');
            $onairRelated->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
            $onairRelated->select('onair_id', DB::raw('COUNT(*) as total'));
            $onairRelated->groupBy('onair_id');
            $onairRelated->orderByDesc('total');
            $onairRelated = $onairRelated->first();
            
            if ($onairRelated && $onairRelated->onair_id) {
                $onairRelated->load('onair.program');
                $listenerFound->onair = $onairRelated->onair;
            } else {
                $listenerFound->onair = null;
            }
                        
            $verifyExist = ListenerMonth::exists();

            if ($verifyExist) {
                $listenerMonth = ListenerMonth::where('id', 1)->first();
                $image = $this->uploadImage('listener-month', $request->file('image'), 'public', $listenerMonth->image ?? null);

                $updateListenerMonth = $listenerMonth->update([
                    'image' => $image,
                    'listener' => $listenerFound->listener,
                    'address' => $listenerFound->address,
                    'favorite_show' => $listenerFound->onair ? $listenerFound->onair->program->name : null,
                    'requests_total' => $listenerFound->total,
                ]);
                if ($updateListenerMonth === 0) throw new \Exception('Não foi possível atualizar o ouvinte do mês');

                return $this->provideSuccess('update');
            } else {
                DB::statement('ALTER TABLE listener_month AUTO_INCREMENT = 1');

                $image = $this->uploadImage('listener-month', $request->file('image'), 'public');
                $createListenerMonth = ListenerMonth::create([
                    'image' => $image,
                    'listener' => $listenerFound->listener,
                    'address' => $listenerFound->address,
                    'favorite_show' => $listenerFound->onair ? $listenerFound->onair->program->name : null,
                    'requests_total' => $listenerFound->total,
                ]);
                if (!$createListenerMonth->wasRecentlyCreated) throw new \Exception('Não foi possível criar o ouvinte do mês');

                return $this->provideSuccess('save');
            }
        } catch (\Throwable $e) {
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
            "listener_month_registered" => $this->getListenerMonthRegistered(),
            'listener_month_found' => $this->getListenerMonthFound(),
        ]);
    }
}
