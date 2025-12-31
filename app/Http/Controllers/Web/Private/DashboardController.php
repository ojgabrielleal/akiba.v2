<?php

namespace App\Http\Controllers\Web\Private;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

use App\Traits\FlashMessageTrait;

use App\Services\Domain\ActivityService;
use App\Services\Domain\TaskService;
use App\Services\Domain\PostService;
use App\Services\Domain\CalendarService;

class DashboardController extends Controller
{
    use FlashMessageTrait;

    public function createActivityConfirmation($activityId)
    {
        $logged = request()->user();

        $activity = new ActivityService();
        $activity->createConfirmation($logged, $activityId);

        return $this->flashMessage('save');
    }

    public function setTaskCompleted($taskId)
    {
        $task = new TaskService();
        $task->markAsCompleted($taskId);

        return $this->flashMessage('save');
    }

    public function render()
    {
        $activities = new ActivityService();
        $tasks = new TaskService();
        $publications = new PostService();
        $calendar = new CalendarService();

        return Inertia::render('private/Dashboard', [
            'activities' => $activities->list([
                'limit' => 6,
                'relations' => [
                    'responsible' => ['nickname'],
                    'confirmations.confirmer' => ['id']
                ]
            ]),
            'tasks' => $tasks->list(),
            'calendar' => $calendar->list(),
            'publications' => $publications->list(),
        ]);
    }
}
