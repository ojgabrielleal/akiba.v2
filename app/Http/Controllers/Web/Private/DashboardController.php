<?php

namespace App\Http\Controllers\Web\Private;

use App\Http\Controllers\Controller;

use Inertia\Inertia;

use App\Traits\FlashMessageTrait;

use App\Models\Activity;
use App\Models\Post;
use App\Models\Task;
use App\Models\Calendar;

class DashboardController extends Controller
{
    use FlashMessageTrait;

    private $render = 'private/Dashboard';

    public function indexActivities()
    {
        return Activity::valid()
            ->with(['author', 'confirmations.confirmer'])
            ->limit(10)
            ->get();
    }

    public function indexTasks()
    {
        return Task::active()
            ->incompleted()
            ->mine()
            ->with(['responsible'])
            ->get();
    }

    public function indexPublications()
    {
        return Post::active()
            ->published()
            ->latest()
            ->with(['author'])
            ->paginate(10);
    }

    public function indexCalendar()
    {
        return Calendar::active()
            ->with(['activity', 'responsible'])
            ->get();
    }

    public function confirmActivityParticipant(Activity $activity)
    {
        $activity->confirmations()->create([
            'user_id' => request()->user()->id
        ]);

        return $this->flashMessage('save');
    }

    public function markTaskCompleted(Task $task)
    {
        $task->update([
            'is_completed' => true,
        ]);

        return $this->flashMessage('save');
    }

    public function render()
    {
        return Inertia::render($this->render, [
            'activities' => $this->indexActivities(),
            'tasks' => $this->indexTasks(),
            'publications' => $this->indexPublications(),
            'calendar' => $this->indexCalendar()
        ]);
    }
}
