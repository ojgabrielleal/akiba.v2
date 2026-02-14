<?php

namespace App\Http\Controllers\Web\Private;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

use App\Traits\HasFlashMessages;

use App\Models\Activity;
use App\Models\Post;
use App\Models\Task;
use App\Models\Calendar;

use App\Http\Resources\Web\Private\Dashboard\ActivityIndexResource;
use App\Http\Resources\Web\Private\Dashboard\TaskIndexResource;
use App\Http\Resources\Web\Private\Dashboard\PostIndexResource;
use App\Http\Resources\Web\Private\Dashboard\CalendarIndexResource;

class DashboardController extends Controller
{
    use HasFlashMessages;

    private $render = 'private/Dashboard';

    public function indexActivities()
    {
        return ActivityIndexResource::collection(
            Activity::valid()
                ->with(['author', 'confirmations.confirmer'])
                ->limit(10)
                ->get()
        );
    }

    public function indexTasks()
    {
        return TaskIndexResource::collection(
            Task::active()
                ->incompleted()
                ->mine()
                ->with(['responsible'])
                ->get()
        );
    }

    public function indexPosts()
    {
        return PostIndexResource::collection(
            Post::active()
                ->published()
                ->latest()
                ->with(['author'])
                ->paginate(10)
        );
    }

    public function indexCalendar()
    {
        return CalendarIndexResource::collection(
            Calendar::active()
                ->with(['activity', 'responsible'])
                ->get()
        );
    }

    public function confirmActivityParticipant(Activity $activity)
    {
        $activity->confirmations()->create([
            'user_id' => request()->user()->id
        ]);

        return $this->flashMessage('confirmActivity');
    }

    public function markTaskCompleted(Task $task)
    {
        $task->update([
            'is_completed' => true,
        ]);

        return $this->flashMessage('taskCompleted');
    }

    public function render()
    {
        return Inertia::render($this->render, [
            'activities' => $this->indexActivities(),
            'tasks' => $this->indexTasks(),
            'posts' => $this->indexPosts(),
            'calendar' => $this->indexCalendar()
        ]);
    }
}
