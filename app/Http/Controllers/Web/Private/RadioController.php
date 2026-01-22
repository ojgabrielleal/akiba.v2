<?php

namespace App\Http\Controllers\Web\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Traits\FlashMessageTrait;
use App\Services\Process\ImageService;

use App\Models\Program;
use App\Models\Music;
use App\Models\ProgramSchedule;
use App\Models\ListenerMonth;

class RadioController extends Controller
{
    use FlashMessageTrait;

    private ImageService $image;
    private $render = 'private/Radio';

    public function __construct(ImageService $image)
    {
        $this->image = $image;
    }

    public function indexPrograms()
    {
        return Program::with(['host', 'schedules'])
            ->active()
            ->get();
    }

    public function indexSchedules()
    {
        return ProgramSchedule::with('program')
            ->get();
    }

    public function indexMusicRanking()
    {
        return Music::ranking()
            ->orderBy('song_request_count', 'desc')
            ->limit(3)
            ->get();
    }

    public function indexListenerMonth()
    {
        return ListenerMonth::first();
    }

    public function showListenerMonthFound()
    {
        $found = ListenerMonth::mostActiveListenerOfCurrentMonth();

        return Inertia::render($this->render, [
            'listenerMonthFound' => $found,
        ]);
    }

    public function showProgram(Program $program)
    {
        return Inertia::render($this->render, [
            'program' => $program->load('host', 'schedules'),
        ]);
    }

    public function updateMusicRanking(Request $request, Music $music)
    {
        $music->update([
            'image_ranking' => $this->image->store('musics/ranking', $request->file('image_ranking'), 'public', $music->image_ranking),
        ]);

        return $this->flashMessage('update');
    }

    public function createListenerMonth(Request $request)
    {
        $request->validate([
            'image' => 'required',
        ]);

        $found = ListenerMonth::mostActiveListenerOfCurrentMonth();
        ListenerMonth::updateOrCreate(['id' => 1], [
            'image' => $this->image->store('listener-month', $request->file('image'), 'public'),
            'listener' => $found->listener,
            'address' => $found->address,
            'favorite_program' => $found->favorite_program,
            'requests_count' => $found->count,
        ]);
        
        return $this->flashMessage('save');
    }

    public function createProgram(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:programs,name',
            'image' => 'required',
        ]);

        $program = Program::create([
            'user_id' => request()->user()->id,
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'image' => $this->image->store('shows', $request->input('image'), 'public'),
            'allow_all' => $request->input('allow_all', false),
        ]);

        if($request->has('schedules')) {
            foreach($request->input('schedules') as $schedule) {
                $program->schedules()->create([
                    'day' => $schedule['day'],
                    'time' => $schedule['time'],
                ]);
            }
        }

        return $this->flashMessage('save');
    }

    public function updateProgram(Request $request, Program $program)
    {
        $program->fill([
            'name' => $request->input('name', $program->name),
            'image' => $this->image->store('shows', $request->input('image'), 'public', $program->image),
            'allows_all' => $request->input('allow_all', $program->allows_all),
        ]);

        if($program->isDirty()) {
            $program->save();
        }

        if($request->has('schedules')){
            foreach($request->input('schedules') as $schedule) {
                $program->schedules()->where('id', $schedule['id'])->update([
                    'day' => $schedule['day'],
                    'time' => $schedule['time'],
                ]);
            }
        }

        return $this->flashMessage('update');
    }

    public function deactivateProgram(Program $program)
    {
        $program->update([
            'is_active' => false
        ]);

        return $this->flashMessage('deactivate');
    }

    public function generateMusicRanking()
    {
        Music::ranking()->update([
            'in_ranking' => false
        ]);

        $music = Music::orderBy('song_request_count', 'desc')->limit(10)->get();
        $music->each(function ($music) {
            $music->update(['in_ranking' => true]);
        });

        return $this->flashMessage('save');
    }

    public function render()
    {
        return Inertia::render($this->render, [
            "programs" => $this->indexPrograms(),
            "schedules" => $this->indexSchedules(),
            "musicRanking" => $this->indexMusicRanking(),
            "listenerMonth" => $this->indexListenerMonth(),
        ]);
    }
}
