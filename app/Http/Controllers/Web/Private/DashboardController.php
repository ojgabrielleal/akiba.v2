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
                    'responsible' => ['id', 'nickname'],
                    'confirmations' => ['id', 'activity_id', 'confirmer_id'],
                    'confirmations.confirmer' => ['id']
                ],
                'filters' => [
                    'or' => [
                        ['allows_confirmations', '<', now()],
                    ]
                ]
            ]),
            'tasks' => $tasks->list([
                'filters' => ['is_active' => true, 'is_completed' => false]
            ]),
            'publications' => $publications->list([
                'filters' => [
                    'is_active' => true,
                ],
                'relations' => [
                    'author' => ['id', 'nickname']
                ]
            ]),
            'calendar' => $calendar->list([
                'filters' => [
                    'is_active' => true, 
                ],
                'relations' => [
                    'activity' => ['id', 'title'],
                    'responsible' => ['id', 'nickname'], 
                ]
            ]),
        ]);
    }
}
