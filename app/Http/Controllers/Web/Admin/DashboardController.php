<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Inertia\Inertia;

use App\Traits\Response\ProvideException;
use App\Traits\Response\ProvideSuccess;

use App\Models\Alert;
use App\Models\AlertSignature;
use App\Models\Task;
use App\Models\Post;
use App\Models\Calendar;

class DashboardController extends Controller
{
    use ProvideException, ProvideSuccess;

    public function getAlerts()
    {
        try {
            return Alert::with([
                'user',
                'signatures' => function ($query) {
                    $query->limit(4)->with('user');
                },
            ])->get();
        } catch (\Throwable $e) {
            return $this->ProvideException($e);
        }
    }

    public function createAlertSignature(Request $request, $alertIdentifier)
    {
        try {
            $alert = Alert::findOrFail($alertIdentifier);

            AlertSignature::create([
                'user_id' => $request->user()->id,
                'alert_id' => $alert->id,
            ]);

            return $this->ProvideSuccess('save');

        } catch (\Throwable  $e) {
            return $this->ProvideException($e);
        }
    }

    public function getTasks()
    {
        try {
            return Task::all()->load([
                'user'
            ]);
        }catch( \Throwable $e) {
            return $this->ProvideException($e);
        }
    }

    public function finishingTask(Request $request, $taskIdentifier)
    {
       try{
            $task = Task::findOrFail($taskIdentifier);

            $task->update([
                'completed' => true,
            ]);

            return $this->ProvideSuccess('save');
       }catch(\Throwable $e) {
            return $this->ProvideException($e);
        }
    }

    public function getLastsPosts()
    {
        try {
            return Post::orderBy('created_at', 'desc')->take(5)->get()->load([
                'user',
            ]);
        } catch (\Throwable $e) {
            return $this->ProvideException($e);
        }
    }

    public function getCalendar()
    {
        $calendar = Calendar::with('user')->orderBy('hour')->get();
        $grouped = $calendar->groupBy('day');

        return $grouped;
    }

    public function render()
    {
        return Inertia::render('admin/Dashboard', [
            'alerts' => $this->getAlerts(),
            'tasks' => $this->getTasks(),
            'posts' => $this->getLastsPosts(),
            'calendar' => $this->getCalendar(),
        ]);
    }
}
