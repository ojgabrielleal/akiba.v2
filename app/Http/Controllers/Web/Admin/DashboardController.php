<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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
            $user = request()->user();

            $query = Alert::limit(6);
            $query->orderBy('created_at', 'desc');
            $query->whereDoesntHave('signatures', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
            $query->with(['user', 'signatures' => function ($query) {
                $query->limit(4)->with('user');
            }]);
            $alerts = $query->get();

            $alerts = $alerts->map(function ($alert) use ($user) {
                $data = $alert->toArray();
                $data['actions'] = [
                    'confirm' => $user->id === $alert->user->id
                ];
                return $data;
            });

            return $alerts;
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function createAlertSignature(Request $request, $id)
    {
        try {
            $user = $request->user();
            $alert = Alert::firstOrFail($id);

            $createAlertSignature = AlertSignature::create([
                'user_id' => $user->id,
                'alert_id' => $alert->id,
            ]);
            if(!$createAlertSignature->wasRecentlyCreated) throw new \Exception('Não foi possível confirmar sua visualização no aviso');

            return $this->provideSuccess('save');
        } catch (\Throwable  $e) {
            return $this->provideException($e);
        }
    }

    public function getTasks()
    {
        try {
            $user = request()->user();

            $query = Task::orderBy('created_at', 'desc');
            $query->where('user_id', $user->id);
            $query->with('user');
            $query->where('completed', 0);
            $query->where('user_id', $user->id);
            $tasks = $query->get();

            function resolveTaskAppearance($task)
            {
                $deadline = Carbon::parse($task->deadline);
                $now = Carbon::now();

                $style = [
                    "bg" => "var(--color-blue-skywave)",
                    "bg_date" => [
                        "title" => "var(--color-blue-indigo)",
                        "title_text_color" => "var(--color-neutral-aurora)",
                        "date" => "var(--color-neutral-aurora)",
                        "date_text_color" => "var(--color-blue-indigo)"
                    ]
                ];

                if ($deadline->greaterThan($now) && $deadline->lessThanOrEqualTo($now->copy()->addDays(7))) {
                    $style = [
                        "bg" => "var(--color-orange-amber)",
                        "bg_date" => [
                            "title" => "var(--color-red-crimson)",
                            "date" => "var(--color-blue-indigo)",
                            "date_text_color" => "var(--color-orange-amber)"
                        ]
                    ];
                }

                return $style;
            }

            function resolveTaskDueSoon($task)
            {
                $deadline = Carbon::parse($task->deadline);
                $now = Carbon::now();

                return $deadline->greaterThan($now) && $deadline->lessThanOrEqualTo($now->copy()->addDays(7));
            }

            $tasks = $tasks->map(function ($task) {
                $data = $task->toArray();
                $data['styles'] = resolveTaskAppearance($task);
                $data['due_soon'] = resolveTaskDueSoon($task);
                $data['deadline'] = $task->deadline->format('d/m');
                return $data;
            });

            return $tasks;
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function setTaskCompleted($id)
    {
        try {
            $task = Task::where('id', $id)->firstOrFail();
            
            $taskUpdate = $task->update([
                'completed' => true,
            ]);
            if($taskUpdate === 0) throw new \Exception('Não foi possível concluir a tarefa');
            
            return $this->provideSuccess('save');
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function getLastsPosts()
    {
        try {
            $user = request()->user();

            $query = Post::orderBy('created_at', 'desc');
            $query->where('status', 'published');
            $query->with('user');
            $posts = $query->paginate(5);

            $posts->getCollection()->transform(function ($post) use ($user) {
                $data = $post->toArray();
                $data['styles'] = [
                    'bg' => 'var(--color-blue-skywave)'
                ];
                $data['editable'] = $user->permissions_keys->contains('administrator') || $post->user_id == $user->id;
                return $data;
            });

            return $posts;
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function getCalendar()
    {
        try {
            $query = Calendar::with('user');
            $query->orderBy('hour');
            $calendar = $query->get();

            return $calendar;
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function render()
    {
        return Inertia::render('admin/Dashboard', [
            'alerts' => $this->getAlerts(),
            'tasks' => $this->getTasks(),
            'publications' => $this->getLastsPosts(),
            'calendar' => $this->getCalendar(),
        ]);
    }
}
