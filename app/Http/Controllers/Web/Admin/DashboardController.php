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

class DashboardController extends Controller
{
    use HandlesLaravelExceptions;
    use HandleLaravelSuccess;

    public function getAlerts()
    {
        try {
            return Alert::all()->load([
                'author',
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
                'message' => $this->HandleLaravelSuccess('create'),
            ]);
        } catch (\Throwable  $e) {
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
        ]);
    }
}
