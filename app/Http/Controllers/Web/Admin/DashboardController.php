<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Inertia\Inertia;

use App\Traits\HandlesLaravelExceptions;
use App\Traits\HandleLaravelSuccess;

use App\Models\Alert;
use App\Models\AlertSignature;
use App\Models\Task;
use Illuminate\Container\Attributes\Log;

class DashboardController extends Controller
{
    use HandlesLaravelExceptions;
    use HandleLaravelSuccess;

    public function getAlerts()
    {
        try {
            return Alert::all()->load([
                'user',
                'signatures.user',
            ]);
        } catch (\Throwable  $e) {
            return redirect()->back()->with('flash', [
                'type' => 'error',
                'message' => $this->handleLaravelException($e),
            ]);
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

            return redirect()->back()->with('flash', [
                'type' => 'success',
                'message' => $this->HandleLaravelSuccess('save'),
            ]);
        } catch (\Throwable  $e) {
            return redirect()->back()->with('flash', [
                'type' => 'error',
                'message' => $this->handleLaravelException($e),
            ]);
        }
    }

    public function getTasks()
    {
        try {
            return Task::all()->load([
                'user'
            ]);
        }catch( \Throwable $e) {
            return redirect()->back()->with('flash', [
                'type' => 'error',
                'message' => $this->handleLaravelException($e),
            ]);
        }
    }

    public function finishingTask(Request $request, $taskIdentifier)
    {
       try{
            $task = Task::findOrFail($taskIdentifier);

            $task->update([
                'completed' => true,
            ]);

            return redirect()->back()->with('flash', [
                'type' => 'success',
                'message' => $this->HandleLaravelSuccess('save'),
            ]);
       }catch(\Throwable $e) {
            return redirect()->back()->with('flash', [
                'type' => 'error',
                'message' => $this->handleLaravelException($e),
            ]);
        }
    }

    public function render()
    {
        return Inertia::render('Admin/Dashboard', [
            'alerts' => $this->getAlerts(),
            'tasks' => $this->getTasks(),
        ]);
    }
}
