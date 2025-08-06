<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Inertia\Inertia;

use App\Traits\Logged\ProvideAuthenticateUser;
use App\Traits\Response\ProvideException;
use App\Traits\Response\ProvideSuccess;

use App\Models\Alert;
use App\Models\AlertSignature;
use App\Models\Task;
use App\Models\Post;
use App\Models\Calendar;

class DashboardController extends Controller
{
    use ProvideAuthenticateUser, ProvideException, ProvideSuccess;

    public function getAlerts()
    {
        try {
            $user = request()->user();

            return Alert::limit(6)
                ->whereDoesntHave('signatures', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->with(['user', 'signatures' => function ($query) {
                    $query->limit(4)->with('user');
                }])
                ->get();
        } catch (\Throwable $e) {
            return $this->ProvideException($e);
        }
    }
    
    public function createAlertSignature(Request $request, $alertId)
    {
        try {
            $alert = Alert::find($alertId);
            $user = $request->user();

            AlertSignature::create([
                'user_id' => $user->id,
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
            $user = request()->user();

            return Task::where('user_id', $user->id)
                ->where('completed', false)
                ->with('user')
                ->get();
        }catch( \Throwable $e) {
            return $this->ProvideException($e);
        }
    }

    public function finishingTask($taskId)
    {
       try{
            $task = Task::findOrFail($taskId);

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
            $user = request()->user();

            return Post::limit(5)
                ->with('user')
                ->where('status', 'published')
                ->get();
        } catch (\Throwable $e) {
            return $this->ProvideException($e);
        }
    }

    public function getCalendar()
    {
        $calendar = Calendar::with('user')
            ->orderBy('hour')
            ->get();

        return $calendar->groupBy('day');
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
